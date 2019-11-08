<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ItemPedido.
 * @ORM\Entity(repositoryClass="Bag\Repository\ItemPedido")
 * @ORM\Table(name="item_pedido")
 */
class ItemPedido extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="quantidade_solicitada", type="integer")
     */
    protected $quantidadeSolicitada;
    
    /**
     * @ORM\Column(name="quantidade_atendida", type="integer")
     */
    protected $quantidadeAtendida;
    
    /**
     * @ORM\Column(name="observacao", type="string")
     */
    protected $observacao;
    
    /**
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $material;

    /**
     * @ORM\ManyToOne(targetEntity="Pedido", inversedBy="itens")
     * @ORM\JoinColumn(name="pedido_id", referencedColumnName="id")
     */
    protected $pedido;

    public function getId() {
        return $this->id;
    }

    public function getQuantidadeSolicitada() {
        return $this->quantidadeSolicitada;
    }

    public function getQuantidadeAtendida() {
        return $this->quantidadeAtendida;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getPedido() {
        return $this->pedido;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setQuantidadeSolicitada($quantidadeSolicitada) {
        $this->quantidadeSolicitada = $quantidadeSolicitada;
    }

    public function setQuantidadeAtendida($quantidadeAtendida) {
        $this->quantidadeAtendida = $quantidadeAtendida;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setPedido($pedido) {
        $this->pedido = $pedido;
    }
}
