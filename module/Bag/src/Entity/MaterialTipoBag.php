<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe MaterialTipoBag.
 * @ORM\Entity(repositoryClass="Bag\Repository\MaterialTipoBag")
 * @ORM\Table(name="material_tipo_bag")
 */
class MaterialTipoBag extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="tiposBag")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $material;
    
    /**
     * @ORM\ManyToOne(targetEntity="TipoBag")
     * @ORM\JoinColumn(name="tipo_bag_id", referencedColumnName="id")
     */
    protected $tipoBag;
    
    public function getId() {
        return $this->id;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getTipoBag() {
        return $this->tipoBag;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setTipoBag($tipoBag) {
        $this->tipoBag = $tipoBag;
    }
    
}