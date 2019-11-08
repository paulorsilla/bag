<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Sinonimia.
 * @ORM\Entity(repositoryClass="Bag\Repository\TipoBag")
 * @ORM\Table(name="tipo_bag")
 */
class TipoBag extends AbstractEntity {

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
     * @ORM\Column(name="abreviatura", type="string")
     */
    protected $abreviatura;
    
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getAbreviatura() {
        return $this->abreviatura;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function setAbreviatura($abreviatura) {
        $this->abreviatura = $abreviatura;
    }
    
}