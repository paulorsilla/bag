<?php

namespace Bag\Repository;

use Bag\Entity\Material as MaterialEntity;
use Bag\Entity\Especie as EspecieEntity;
use Bag\Entity\Programa as ProgramaEntity;

class Material extends AbstractRepository {

    public function getQuery($search = [], $combo = false) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
                ->from(MaterialEntity::class, 'm')
                ->leftJoin('m.passaporte', 'p')
                ->orderby('m.cgs', 'ASC');
        if (!empty($search['search'])) {
            $qb->andWhere('m.acesso like :busca');
            $qb->setParameter("busca", '%' . $search['search'] . '%');
        }
        if (!empty($search['cgs'])) {
            $qb->andWhere('m.cgs like :cgs')
                    ->setParameter('cgs', '%' . $search['cgs'] . '%');
        }
        if (!empty($search['acesso'])) {
            $qb->andWhere('m.acesso like :acesso')
                    ->setParameter('acesso', '%' . $search['acesso'] . '%');
        }
        if (!empty($search['origem'])) {
            $qb->andWhere('p.origem like :origem')
                    ->setParameter('origem', '%' . $search['origem'] . '%');
        }
        if (!empty($search['sinonimia'])) {
            $qb->andWhere('p.sinonimia1 like :sinonimia1')
               ->orWhere('p.sinonimia2 like :sinonimia2')
               ->orWhere('p.sinonimia3 like :sinonimia3')
               ->orWhere('p.sinonimia4 like :sinonimia4')
               ->orWhere('p.sinonimia5 like :sinonimia5')
               ->setParameter('sinonimia1', '%' . $search['sinonimia'] . '%')
               ->setParameter('sinonimia2', '%' . $search['sinonimia'] . '%')
               ->setParameter('sinonimia3', '%' . $search['sinonimia'] . '%')
               ->setParameter('sinonimia4', '%' . $search['sinonimia'] . '%')
               ->setParameter('sinonimia5', '%' . $search['sinonimia'] . '%');
        }
        if (!empty($search['localizacao'])) {
            $qb->leftJoin('m.bag', 'b')
                    ->leftJoin('b.localizacao', 'l')
                    ->andWhere('l.localizacao like :localizacao')
                    ->setParameter('localizacao', '%' . $search['localizacao'] . '%');
        }
        if (!$combo) {
            return $qb;
        } else {
            return $qb->getQuery()->getResult();
        }
    }
    
    public function findAll() 
    {
        parent::findAll();
        return $this->findBy([], ['cgs' => 'ASC']);
    }

    public function delete($id) {
        $row = $this->find($id);
        if ($row) {
            foreach($row->getTiposBag() as $tipoBag) {
                $this->getEntityManager()->remove($tipoBag);
            }
            foreach($row->getCaracteristicas() as $caracteristica) {
                $this->getEntityManager()->remove($caracteristica);
            }
            $passaporte = $row->getPassaporte();
            if (null != $passaporte) {
                $this->getEntityManager()->remove($passaporte);
            }
            $bag = $row->getBag();
            if (null != $bag) {
                $this->getEntityManager()->remove($bag);
            }
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }

    public function incluir_ou_editar($dados, $id = null) {
        $row = null;
        if (!empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        }
        if (empty($row)) {
            $row = new MaterialEntity();
        }
        if (!empty($dados['especie'])) {
            $especie = $this->getEntityManager()->find(EspecieEntity::class, $dados['especie']);
            $row->setEspecie($especie);
            unset($dados['especie']);
        }
        if (!empty($dados['programa'])) {
            $programa = $this->getEntityManager()->find(ProgramaEntity::class, $dados['programa']);
            $row->setPrograma($programa);
            unset($dados['programa']);
        }
        unset($dados['multiplicador']);
        unset($dados['peso']);
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}
