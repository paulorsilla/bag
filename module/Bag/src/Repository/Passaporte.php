<?php

namespace Bag\Repository;

use Bag\Entity\Passaporte as PassaporteEntity;
use Bag\Entity\Pais;
use Bag\Entity\Estado;
use Bag\Entity\Instituicao;
use Bag\Entity\Material;

class Passaporte extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')
                ->from(PassaporteEntity::class, 'p');
       return $qb;
    }
    
    public function delete($id = null, $materialId = null) {
        if ($id != null) {
            $row = $this->find($id);
        } else if($materialId != null) {
            $material = $this->getEntityManager()->find(Material::class, $materialId);
            $row = $material->getPassaporte();
        }
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $id = null, $materialId = null){
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }
        if (null != $materialId && null == $row) {
            $material = $this->getEntityManager()->find(Material::class, $materialId);
            $row = $material->getPassaporte();
        }
        if ( empty($row)) {
            $row = new PassaporteEntity();
        }
        if (!empty($dados['pais'])) {
            $pais = $this->getEntityManager()->find(Pais::class, $dados['pais']);
            $row->setPais($pais);
        } else {
            $row->setPais(null);
        }
        if (!empty($dados['estado']))  {
            $estado = $this->getEntityManager()->find(Estado::class, $dados['estado']);
            $row->setEstado($estado);
        } else {
            $row->setEstado(null);
        }
//        if (!empty($dados['instituicao'])) {
//            $instituicao = $this->getEntityManager()->find(Instituicao::class, $dados['instituicao']);
//            $row->setInstituicao($instituicao->getCodInstituicao());
//        } else {
//            $row->setInstituicao(null);
//        }
        if (null != $materialId) {
            $material = $this->getEntityManager()->find(Material::class, $materialId);
            $row->setMaterial($material);
        }
        unset($dados['pais']);
        unset($dados['estado']);
       // unset($dados['instituicao']);
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}