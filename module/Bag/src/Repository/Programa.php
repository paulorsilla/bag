<?php

namespace Bag\Repository;

use Bag\Entity\Programa as ProgramaEntity;

class Programa extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
                ->from(ProgramaEntity::class, 'p')
                ->orderby('p.descricao','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('p.descricao like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
       
    }
    
//    public function getListParaCombo(){
//        
//        $array = array();
//        $list = $this->findAll();
//        foreach($list  as $row){
//            $array[] = array("id"=>$row->id,"nome"=>$row->descricao);
//        }
//        return $array;
//    }
    
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
            $row = new ProgramaEntity();
        }
        
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}