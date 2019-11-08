<?php

namespace Bag\Repository;

use Bag\Entity\ItemRegeneracao as ItemRegeneracaoEntity;
use Bag\Entity\Regeneracao;
use Bag\Entity\Material;

class ItemRegeneracao extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from(ItemRegeneracaoEntity::class, 'i')
            ->where('i.regeneracao = :regeneracao')
            ->setParameter('regeneracao', $search['regeneracao']);
        return $qb->getQuery()->getResult();
    }
    
    public function delete($id) {
        if ($id != null) {
            $row = $this->find($id);
        }
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $id = null, $regeneracaoId = null) {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        } else {
            $row = new ItemRegeneracaoEntity();
        }
        if (null != $regeneracaoId) {
            $regeneracao = $this->getEntityManager()->find(Regeneracao::class, $regeneracaoId);
            $row->setRegeneracao($regeneracao);
        }
        if (!empty($dados['material'])) {
            $material = $this->getEntityManager()->find(Material::class, $dados['material']);
            $row->setMaterial($material);
            unset($dados['material']);
        }
        if (!empty($dados['quantidadePlantada'])) {
            switch($dados['quantidadePlantada']) {
                case "V": $row->setQuantidadePlantada(6); break;
                case "T": $row->setQuantidadePlantada(3);
            }
            unset($dados['quantidadePlantada']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}
