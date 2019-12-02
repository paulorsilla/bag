<?php

namespace Bag\Repository;

use Bag\Entity\ItemRegeneracao as ItemRegeneracaoEntity;
use Bag\Entity\Regeneracao;
use Bag\Entity\Material;

class ItemRegeneracao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from(ItemRegeneracaoEntity::class, 'i')
            ->where('i.regeneracao = :regeneracao')
            ->setParameter('regeneracao', $search['regeneracao']);
        
        if (isset($search['estaca'])) {
            $qb->andWhere('i.estaca = :estaca');
            $qb->setParameter('estaca', $search['estaca']);
        }
        return $qb->getQuery()->getResult();
    }
    
    public function delete($id) {
        if ($id != null) {
            $row = $this->find($id);
        }
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir_ou_editar($dados, $id = null, $regeneracaoId = null) {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        } else {
            $row = new ItemRegeneracaoEntity();
        }
        if (null != $regeneracaoId) {
            $regeneracao = $this->getEntityManager()->find(Regeneracao::class, $regeneracaoId);
            $row->setRegeneracao($regeneracao);
        }
        if (!empty($dados['material'])) {
            
            $material = $this->getEntityManager()->getRepository(Material::class)->findOneBy(['cgs' => $dados['material']]);
            $row->setMaterial($material);
            error_log(".-> ". $material->getAcesso());
            unset($dados['material']);
        }
        
        if (!empty($dados['quantidadePlantada'])) {
            switch($dados['quantidadePlantada']) {
                case "V": $row->setQuantidadePlantada(6); break;
                case "T": $row->setQuantidadePlantada(3);
            }
            unset($dados['quantidadePlantada']);
        }
//        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
    
    
    public function incluir($dados, $regeneracaoId = null) {
        
        if (null != $regeneracaoId) {

              $repoMaterial = $this->getEntityManager()->getRepository(Material::class);

//            $materialCGS = [];
//            $materiais = $this->getEntityManager()->getRepository(Material::class)->findAll();
//            foreach($materiais as $material) {
//                $materialCGS[$material->getCgs]
//            }
              
            $regeneracao = $this->getEntityManager()->find(Regeneracao::class, $regeneracaoId);
            
            foreach($dados as $dado) {
                $row = new ItemRegeneracaoEntity();
                $row->setRegeneracao($regeneracao);
                if (!empty($dado['material'])) {
                    $material = $repoMaterial->findOneBy(['cgs' => $dado['material']]);
                    $row->setMaterial($material);
                }
                unset($dado['material']);

                if (!empty($dado['quantidadePlantada'])) {
                    switch($dado['quantidadePlantada']) {
                        case "V": $row->setQuantidadePlantada(6); break;
                        case "T": $row->setQuantidadePlantada(3);
                    }
                    unset($dado['quantidadePlantada']);
                }
                $row->setData($dado); // setar os dados da model a partir dos dados capturados do formulario
                $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
                unset($row);
            }
            $this->getEntityManager()->flush(); // Confirma a atualizacao
        }
//        return $row;
    }

    
}
