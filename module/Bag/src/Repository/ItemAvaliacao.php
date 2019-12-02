<?php

namespace Bag\Repository;

use Bag\Entity\ItemAvaliacao as ItemAvaliacaoEntity;
use Bag\Entity\Avaliacao;
use Bag\Entity\Regeneracao;

class ItemAvaliacao extends AbstractRepository {

    public function getQuery($search = []) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from(ItemAvaliacaoEntity::class, 'i');

        if (isset($search['avaliacao'])) {
            $qb->where('i.avaliacao = :avaliacao');
            $qb->setParameter('avaliacao', $search['avaliacao']);
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
    
    public function atualizar($avaliacao, $valor) {
        $avaliacao->setValor($valor);
        $this->getEntityManager()->persist($avaliacao); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
    }
    
    public function incluir($regeneracaoId, $avaliacaoId) {
        $row = null;
        $regeneracao = $this->getEntityManager()->find(Regeneracao::class, $regeneracaoId);
        $avaliacao = $this->getEntityManager()->find(Avaliacao::class, $avaliacaoId);
        foreach($avaliacao->getCaracteristicas() as $caracteristica) {
            foreach($regeneracao->getItens() as $itemRegeneracao) {
                $row = new ItemAvaliacaoEntity();
                $row->setAvaliacao($avaliacao);
                $row->setCaracteristica($caracteristica);
                $row->setItemRegeneracao($itemRegeneracao);
                $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
            }
        }
        $this->getEntityManager()->flush(); // Confirma a atualizacao
    }
}
