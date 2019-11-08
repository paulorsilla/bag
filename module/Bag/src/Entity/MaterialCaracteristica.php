<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe MaterialCaracteristica.
 * @ORM\Entity(repositoryClass="Bag\Repository\MaterialCaracteristica")
 * @ORM\Table(name="material_caracteristica")
 */
class MaterialCaracteristica extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="caracteristicas")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $material;
    
    /**
     * @ORM\ManyToOne(targetEntity="Caracteristica")
     * @ORM\JoinColumn(name="caracteristica_id", referencedColumnName="id")
     */
    protected $caracteristica;
    
    /**
     * @ORM\Column(name="valor", type="string")
     */
    protected $valor;
    
    public function getId() {
        return $this->id;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getCaracteristica() {
        return $this->caracteristica;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setCaracteristica($caracteristica) {
        $this->caracteristica = $caracteristica;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
    
}