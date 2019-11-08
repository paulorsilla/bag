<?php

namespace Bag\Repository;

use Bag\Entity\Avaliacao as AvaliacaoEntity;
use Bag\Entity\Regeneracao as RegeneracaoEntity;
use Bag\Entity\Caracteristica as CaracteristicaEntity;
use User\Entity\User as UserEntity;

class Avaliacao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(AvaliacaoEntity::class, 'a')
                ->orderby('a.dataAvaliacao','ASC');
        
        if ( !empty($search['regeneracao'])){
            $qb->where('a.regeneracao = :regeneracao');
            $qb->setParameter("regeneracao", $search['regeneracao']);
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
    
    public function incluir_ou_editar($dados, $id = null, $idRegeneracao = null) {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }    
        if ( empty($row)) {
            $row = new AvaliacaoEntity();
        }
        if ( null != $idRegeneracao ) {
            $regeneracao = $this->getEntityManager()->find(RegeneracaoEntity::class, $idRegeneracao);
            $row->setRegeneracao($regeneracao);
        }
        if (!empty($dados['responsavel'])) {
            $responsavel = $this->getEntityManager()->find(UserEntity::class, $dados['responsavel']);
            $row->setResponsavel($responsavel);
            unset($dados['responsavel']);
        }
        if(!empty($dados['dataAvaliacao'])) {
            $dataAvaliacao = \DateTime::createFromFormat("Y-m-d", $dados["dataAvaliacao"]);
            $row->setDataAvaliacao($dataAvaliacao);
            unset($dados['dataAvaliacao']);
        }
        if(!empty($dados['caracteristicas'])) {
            foreach($dados['caracteristicas'] as $idCaracteristica) {
                $caracteristica = $this->getEntityManager()->find(CaracteristicaEntity::class, $idCaracteristica);
                if ($caracteristica) {
                    $row->getCaracteristicas()->add($caracteristica);
                }
            }
            unset($dados['caracteristicas']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}