<?php

namespace Bag\Repository;

use Bag\Entity\Colaborador as ColaboradorEntity;

class Colaborador extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
                ->from(ColaboradorEntity::class, 'c')
                ->orderby('c.nome', 'ASC');

        if (!empty($search['search'])) {
            $qb->where('c.nome like :busca');
            $qb->setParameter("busca", '%' . $search['search'] . '%');
        }
        return $qb;
    }
}
