<?php

namespace Bag\Repository;

use Bag\Entity\Bag as BagEntity;
use Bag\Entity\Material as MaterialEntity;
use Bag\Entity\Localizacao as LocalizacaoEntity;

class Bag extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('b')
                ->from(BagEntity::class, 'b')
                ->innerJoin('b.material', 'm')
                ->orderby('m.cgs','ASC');

        if (!empty($search['cgs'])) {
            $qb->andWhere('m.cgs like :cgs')
               ->setParameter('cgs', '%' . $search['cgs'] . '%');
        }

        return $qb;
    }

    public function delete($id = null, $materialId = null) {
        if ($id != null) {
            $row = $this->find($id);
        } else if ($materialId != null) {
            $material = $this->getEntityManager()->find(MaterialEntity::class, $materialId);
            $row = $material->getBag();
        }
        if ($row) {
            $localizacao = $row->getLocalizacao();
            $localizacao->setStatus(False);
            $this->getEntityManager()->persist($localizacao);
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }

    public function incluir_ou_editar($dados, $id = null, $materialId = null) {
        $row = null;
        if (!empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }
        if (null != $materialId && null == $row) {
            $material = $this->getEntityManager()->find(MaterialEntity::class, $materialId);
            $row = $material->getBag();
            if (empty($row)) {
                $row = new BagEntity();
                $row->setMaterial($material);
            } else {
                $localizacao = $row->getLocalizacao();
                $localizacao->setStatus(False);
                $this->getEntityManager()->persist($localizacao);
            }
        }
        if (!empty($dados['localizacao'])) {
            $search['localizacao'] = $dados['localizacao'];
            $localizacao = $this->getEntityManager()->getRepository(LocalizacaoEntity::class)->getQuery($search)->getQuery()->getSingleResult();
            $localizacao->setStatus(True);
            $row->setLocalizacao($localizacao);
            $this->getEntityManager()->persist($localizacao); // persiste o model ( preparar o insert / update)
            unset($dados['localizacao']);
        }
        $dataInclusao = null;
        if (!empty($dados['dataInclusao'])) {
            $dataInclusao = \DateTime::createFromFormat("Y-m-d", $dados["dataInclusao"]);
            $row->setDataInclusao($dataInclusao);
        }
        if(!empty($dados['pesoSem'])) {
            $pesoSem = (float) str_replace(["_", ","], ["","."], $dados['pesoSem']);
            $row->setPesoSem($pesoSem);
        }
        if(!empty($dados['pesoTotal'])) {
            $pesoTotal = (float) str_replace(["_", ","], ["","."], $dados['pesoTotal']);
            $row->setPesoTotal($pesoTotal);
        }
        
        unset ($dados['dataInclusao']);
        unset($dados['pesoSem']);
        unset($dados['pesoTotal']);
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }

}
