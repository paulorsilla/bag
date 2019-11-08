<?php

namespace Bag\Repository;

use Bag\Entity\Pedido as PedidoEntity;
use Bag\Entity\Instituicao;

class Pedido extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
                ->from(PedidoEntity::class, 'p')
                ->orderBy('p.id');
        if (!empty($search['requisitante'])) {
            $qb->where('p.requisitante like :requisitante')
                    ->setParameter('requisitante', '%' . $search['requisitante'] . "%");
        }

        if (!empty($search['instituicao'])) {
            $qb->innerJoin('p.instituicao', 'i')
                    ->where('i.razaoSocial like :instituicao')
                    ->setParameter('instituicao', '%' . $search['instituicao'] . "%");
        }
        return $qb;
    }

    public function delete($id = null) {
        if ($id != null) {
            $row = $this->find($id);
        }
        foreach ($row->getItens() as $item) {
            $this->getEntityManager()->remove($item);
        }
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }

    public function incluir_ou_editar($dados, $id = null) {
        $row = null;
        if (!empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }
        if (empty($row)) {
            $row = new PedidoEntity();
            $row->setStatus(1);
        }
        $dataRetirada = null;
        if (!empty($dados['dataRetirada'])) {
            $dataRetirada = \DateTime::createFromFormat("Y-m-d", $dados["dataRetirada"]);
        }
        if (!empty($dados['instituicao'])) {
            $instituicao = $this->getEntityManager()->find(Instituicao::class, $dados['instituicao']);
            $row->setInstituicao($instituicao);
        }
        $row->setDataRetirada($dataRetirada);
        unset($dados['dataRetirada']);
        unset($dados['instituicao']);

        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}
