<?php

namespace Bag\Repository;

use Bag\Entity\MaterialTipoBag as MaterialTipoBagEntity;
use Bag\Entity\Material;
use Bag\Entity\TipoBag;

class MaterialTipoBag extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
                ->from(MaterialTipoBagEntity::class, 'm');
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
            $row = new MaterialTipoBagEntity();
        }
        if (null != $materialId) {
            $material = $this->getEntityManager()->find(Material::class, $materialId);
            $row->setMaterial($material);
        }
        if (!empty($dados['tipoBag'])) {
            $tipoBag = $this->getEntityManager()->find(TipoBag::class, $dados['tipoBag']);
            $row->setTipoBag($tipoBag);
            unset($dados['tipoBag']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}