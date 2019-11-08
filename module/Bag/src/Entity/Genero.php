<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Genero.
 * @ORM\Entity(repositoryClass="Bag\Repository\Genero")
 * @ORM\Table(name="genero")
 */
class Genero extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Especie", mappedBy="genero")
     */
    protected $especies;
    
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;
    
    public function __construct() {
        $this->especies = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getEspecies() {
        return $this->especies;
    }

    public function getDescricao() {
        return $this->descricao;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setEspecies($especies) {
        $this->especies = $especies;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}