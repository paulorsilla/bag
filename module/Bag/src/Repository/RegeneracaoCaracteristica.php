<?php

namespace Bag\Repository;

use Bag\Entity\RegeneracaoCaracteristica as RegeneracaoCaracteristicaEntity;
use Bag\Entity\Caracteristica as CaracteristicaEntity;
use Bag\Entity\Regeneracao as RegeneracaoEntity;

class RegeneracaoCaracteristica extends AbstractRepository {
    
    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('r')
                ->from(RegeneracaoCaracteristicaEntity::class, 'r');
        
        if ( (!empty($search['combo'])) && (!empty($search['regeneracao']))) {
            $qb->where('r.regeneracao = :regeneracao')
                ->setParameter('regeneracao', $search['regeneracao']);
                $array = [];
                foreach($qb->getQuery()->getResult()  as $row) {
                    $array[] = ["id" => $row->getCaracteristica()->getId(), "nomeCurto" => $row->getCaracteristica()->getNomeCurto()];
                }
                return $array;
        } else {
            return $qb;
        }
    }

    public function delete($idRegeneracao, $idCaracteristica) {
        if ( ($idRegeneracao != null) && ($idCaracteristica != null)) {
            $row = $this->findOneBy(["regeneracao" => $idRegeneracao, "caracteristica" => $idCaracteristica]);
        }
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function save($dados, $idRegeneracao) {
        if (!empty($dados['caracteristica'])) {
            $repoCaracteristica = $this->getEntityManager()->getRepository(CaracteristicaEntity::class);
            $repoRegeneracao = $this->getEntityManager()->getRepository(RegeneracaoEntity::class);
            foreach($dados['caracteristica'] as $idCaracteristica) {
                $regeneracaoCaracteristica = $this->getEntityManager()->getRepository(RegeneracaoCaracteristicaEntity::class)->findOneBy(["regeneracao" => $idRegeneracao, "caracteristica" => $idCaracteristica]);
                if (null == $regeneracaoCaracteristica) {
                    $caracteristica = $repoCaracteristica->find($idCaracteristica);
                    $regeneracao = $repoRegeneracao->find($idRegeneracao);
                    $row = new RegeneracaoCaracteristicaEntity();
                    $row->setCaracteristica($caracteristica);
                    $row->setRegeneracao($regeneracao);
                    $this->getEntityManager()->persist($row);
                    $this->getEntityManager()->flush();
                }
            }
        }
    }
    
    public function saveOne($idRegeneracao, $idCaracteristica) {
        $regeneracaoCaracteristica = $this->getEntityManager()->getRepository(RegeneracaoCaracteristicaEntity::class)->findOneBy(["regeneracao" => $idRegeneracao, "caracteristica" => $idCaracteristica]);
        if (null == $regeneracaoCaracteristica) {
            $repoCaracteristica = $this->getEntityManager()->getRepository(CaracteristicaEntity::class);
            $repoRegeneracao = $this->getEntityManager()->getRepository(RegeneracaoEntity::class);
            $caracteristica = $repoCaracteristica->find($idCaracteristica);
            $regeneracao = $repoRegeneracao->find($idRegeneracao);
            $row = new RegeneracaoCaracteristicaEntity();
            $row->setCaracteristica($caracteristica);
            $row->setRegeneracao($regeneracao);
            $this->getEntityManager()->persist($row);
            $this->getEntityManager()->flush();
        }
    }
}