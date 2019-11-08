<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;
/**
 * Classe Pais.
 * @ORM\Entity(repositoryClass="Bag\Repository\Pais")
 * @ORM\Table(name="pais")
 */
class Pais extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;
    
    /**
     * @ORM\OneToMany(targetEntity="Estado", mappedBy="pais")
     */
    protected $estados;
    
    public function __construc() {
        $this->estados = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getEstados() {
        return $this->estados;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setEstados($estados) {
        $this->estados = $estados;
    }
    
}