<?php

namespace Bag\Repository;

use Bag\Entity\NumeracaoEstaca as NumeracaoEstacaEntity;

class NumeracaoEstaca extends AbstractRepository {

    public function getQuery() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('n')
                ->from(NumeracaoEstacaEntity::class, 'n')
                ->orderby('n.ano','DESC');
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
            $row = new NumeracaoEstacaEntity();
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}