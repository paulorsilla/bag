<?php

namespace Bag\Repository;

use Bag\Entity\MaterialCaracteristica as MaterialCaracteristicaEntity;
use Bag\Entity\Material;
use Bag\Entity\Caracteristica;

class MaterialCaracteristica extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
            ->from(MaterialCaracteristicaEntity::class, 'm');
        if (isset($search['material'])) {
            $qb->andWhere('m.material =:material')
               ->setParameter('material', $search['material']);
        }
        if (isset($search['caracteristica'])) {
            $qb->andWhere('m.caracteristica =:caracteristica')
               ->setParameter('caracteristica', $search['caracteristica']);
        }
       return $qb;
    }
    
    public function delete($id) {
        if ($id != null) {
            $row = $this->find($id);
        }
        $materialId = $row->getMaterial()->getId();
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
        return $materialId;
    }
    
    public function incluir_ou_editar($dados, $id = null, $materialId = null){
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        } else {
            $row = new MaterialCaracteristicaEntity();
        }
        if (null != $materialId) {
            $material = $this->getEntityManager()->find(Material::class, $materialId);
            $row->setMaterial($material);
        }
        if (!empty($dados['caracteristica'])) {
            $caracteristica = $this->getEntityManager()->find(Caracteristica::class, $dados['caracteristica']);
            $row->setCaracteristica($caracteristica);
            unset($dados['caracteristica']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}