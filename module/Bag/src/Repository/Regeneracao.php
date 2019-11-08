<?php

namespace Bag\Repository;

use Bag\Entity\Regeneracao as RegeneracaoEntity;
//use Bag\Entity\Caracteristica;
use Bag\Entity\Motivo as MotivoEntity;

class Regeneracao extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
                ->from(RegeneracaoEntity::class, 'r')
                ->orderby('r.dataPlantio','ASC');
        
        if ( !empty($search['search'])){
            $qb->where('r.titulo like :busca');
            $qb->setParameter("busca",'%'.$search['search'].'%');
        }
       return $qb;
    }
    
    public function delete($id) {
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
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }    
        if ( empty($row)) {
            $row = new RegeneracaoEntity();
//            $caracteristicas = $this->getEntityManager()->getRepository(Caracteristica::class)->findBy(['rotina' => '1']);
//            foreach($caracteristicas as $caracteristica) {
//                $row->getCaracteristicas()->add($caracteristica);
//            }
        }
        $dataPlantio = null;
        if(!empty($dados['dataPlantio'])) {
            $dataPlantio = \Datetime::createFromFormat("Y-m-d", $dados['dataPlantio']);
        }
        if (!empty($dados['motivo'])) {
            $row->getMotivos()->clear();
            foreach($dados['motivo'] as $motivoId) {
                $motivo = $this->getEntityManager()->find(MotivoEntity::class, $motivoId);
                $row->getMotivos()->add($motivo);
            }
        }
        $row->setStatus(1);
        $row->setDataPlantio($dataPlantio);
        
        unset($dados['motivo']);
        unset($dados['dataPlantio']);
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
    
    public function altera_status($id, $status)
    {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo
            $row = $this->find($id); // busca o registro para poder alterar o status
        }
        $row->setStatus($status);
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
    }

}