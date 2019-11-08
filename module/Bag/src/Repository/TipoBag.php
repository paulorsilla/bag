<?php

namespace Bag\Repository;

use Bag\Entity\TipoBag as TipoBagEntity;

class TipoBag extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
                ->from(TipoBagEntity::class, 't')
                ->orderby('t.descricao','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('t.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
       
    }
    
    public function delete($id){
        $row = $this->find($id);
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $id = null){
        
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }    
        if ( empty($row)) {
            $row = new TipoBagEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}