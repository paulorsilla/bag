<?php

namespace Bag\Repository;

use Bag\Entity\ItemRegeneracaoAcao as ItemRegeneracaoAcaoEntity;
use Bag\Entity\ItemRegeneracao;
use Bag\Entity\Acao;

class ItemRegeneracaoAcao extends AbstractRepository {

//    public function getQuery($search = array()) {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//        $qb->select('i')
//            ->from(ItemRegeneracaoAcaoEntity::class, 'i')
//            ->where('i.regeneracao = :regeneracao')
//            ->setParameter('regeneracao', $search['regeneracao']);
//        return $qb->getQuery()->getResult();
//    }
    
    public function delete($id) {
        if ($id != null) {
            $row = $this->find($id);
        }
        if ($row) {
            $this->getEntityManager()->remove($row);
            $this->getEntityManager()->flush();
        }
    }
    
    public function incluir($ItemRegeneracao, $acoes) {
        foreach ($acoes as $acaoId) {
            $acao = $this->getEntityManager()->find(Acao::class, $acaoId);
            if ($acao) {
                $row = new ItemRegeneracaoAcaoEntity();
                $row->setItemRegeneracao($ItemRegeneracao);
                $row->setAcao($acao);
                $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
            }
        }
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return;
    }
}
