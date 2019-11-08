<?php

namespace Bag\Repository;

use Bag\Entity\Caracteristica as CaracteristicaEntity;

class Caracteristica extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(CaracteristicaEntity::class, 'c');
        
        if ( !empty($search['search']) ) {
            $qb->where('c.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
        if ( !empty($search['rotina']) ) {
            $qb->where('c.rotina = 1');
        }
        
        if ( !empty($search['ordem']) ) {
            $qb->orderby('c.ordem', 'ASC');
        } else {
            $qb->orderby('c.descricao','ASC');
        }
       return $qb;
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
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }    
        if ( empty($row)) {
            $row = new CaracteristicaEntity();
        }
        if (!isset($dados[rotina])) {
            $row->setRotina(0);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}