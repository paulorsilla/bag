<?php

namespace Bag\Repository;

use Bag\Entity\Especie as EspecieEntity;
use Bag\Entity\Genero as GeneroEntity;

class Especie extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
                ->from(EspecieEntity::class, 'e')
                ->orderby('e.genero','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('e.descricao like :busca');
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
            $row = new EspecieEntity();
        }
        if (!empty($dados['genero'])) {
            $genero = $this->getEntityManager()->find(GeneroEntity::class, $dados['genero']);
            $row->setGenero($genero);
            unset($dados['genero']);
        }

        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        
        return $row;
    }

}