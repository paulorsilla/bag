<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ItemAvaliacao.
 * @ORM\Entity(repositoryClass="Bag\Repository\ItemAvaliacao")
 * @ORM\Table(name="item_avaliacao")
 */
class ItemAvaliacao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Avaliacao", inversedBy="itens")
     * @ORM\JoinColumn(name="avaliacao_id", referencedColumnName="id")
     */
    protected $avaliacao;

    /**
     * @ORM\ManyToOne(targetEntity="Caracteristica")
     * @ORM\JoinColumn(name="caracteristica_id", referencedColumnName="id")
     */
    protected $caracteristica;
    
    /**    
     * @ORM\ManyToOne(targetEntity="ItemRegeneracao")
     * @ORM\JoinColumn(name="item_regeneracao_id", referencedColumnName="id")
    */
    protected $itemRegeneracao;
    
    /**
     * @ORM\Column(name="valor", type="string")
     */
    protected $valor;
    
    public function getId() {
        return $this->id;
    }

    public function getAvaliacao() {
        return $this->avaliacao;
    }

    public function getCaracteristica() {
        return $this->caracteristica;
    }

    public function getItemRegeneracao() {
        return $this->itemRegeneracao;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAvaliacao($avaliacao) {
        $this->avaliacao = $avaliacao;
    }

    public function setCaracteristica($caracteristica) {
        $this->caracteristica = $caracteristica;
    }

    public function setItemRegeneracao($itemRegeneracao) {
        $this->itemRegeneracao = $itemRegeneracao;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
    
}
