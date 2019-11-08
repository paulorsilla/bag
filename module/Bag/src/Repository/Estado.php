<?php

namespace Bag\Repository;

use Bag\Entity\Estado as EstadoEntity;
use Bag\Entity\Pais as PaisEntity;

class Estado extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
                ->from(EstadoEntity::class, 'e')
                ->orderby('e.descricao', 'ASC');

        if (!empty($search['search'])) {
            $qb->where('e.descricao like :busca');
            $qb->setParameter("busca", '%' . $search['search'] . '%');
        }
        if (!empty($search['pais'])) {
            $qb->where('e.pais = :pais');
            $qb->setParameter('pais', $search['pais']);
        }
        if (!empty($search['combo'])) {
            $combo = [];
            foreach($qb->getQuery()->getResult() as $estado) {
                $combo[] = ["id" => $estado->getSigla(), "descricao" => $estado->getDescricao()];
            }
            return $combo;
        } else {
            return $qb;
        }
    }

    public function delete($id) {
        $row = $this->find($id);
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
            $row = new EstadoEntity();
        }
        if (isset($dados['pais'])) {
            $pais = $this->getEntityManager()->find(PaisEntity::class, $dados['pais']);
            $row->setPais($pais);
            unset($dados['pais']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao

        return $row;
    }

}
