<?php

namespace Bag\Repository;

use Bag\Entity\ItemPedido as ItemPedidoEntity;
use Bag\Entity\Pedido;
use Bag\Entity\Material;

class ItemPedido extends AbstractRepository {

    public function getQuery($search = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('i')
            ->from(ItemPedidoEntity::class, 'i')
            ->where('i.pedido = :pedido')
            ->innerJoin('i.material', 'm')
            ->innerJoin('m.bag', 'b')
            ->innerJoin('b.localizacao', 'l')
            ->orderBy('l.localizacao', 'ASC')
            ->setParameter('pedido', $search['pedido']);
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
    
    public function incluir_ou_editar($dados, $id = null, $pedidoId = null) {
        $row = null;
        if ( !empty($id)) { // verifica se foi passado o codigo (se sim, considera edicao)
            $row = $this->find($id); // busca o registro para poder alterar
        } else {
            $row = new ItemPedidoEntity();
        }
        if (null != $pedidoId) {
            $pedido = $this->getEntityManager()->find(Pedido::class, $pedidoId);
            $row->setPedido($pedido);
        }
        if (!empty($dados['material'])) {
            $material = $this->getEntityManager()->find(Material::class, $dados['material']);
            $row->setMaterial($material);
            unset($dados['material']);
        }
        $row->setData($dados); // setar os dados da model a partir dos dados capturados do formulario
        $this->getEntityManager()->persist($row); // persiste o model ( preparar o insert / update)
        $this->getEntityManager()->flush(); // Confirma a atualizacao
        return $row;
    }
}
