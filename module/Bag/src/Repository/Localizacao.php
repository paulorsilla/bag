<?php

namespace Bag\Repository;

use Bag\Entity\Localizacao as LocalizacaoEntity;

class Localizacao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('l')
                ->from(LocalizacaoEntity::class, 'l')
                ->orderby('l.localizacao','ASC');
        if ( !empty($search['localizacao'])) {
            $qb->where('l.localizacao = :busca');
            $qb->setParameter("busca", $search['localizacao']);
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
            $row = new LocalizacaoEntity();
        }
        if (isset($dados['modulo'])) {
            $row->setModulo($dados['modulo']);
            unset($dados['modulo']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
//        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}