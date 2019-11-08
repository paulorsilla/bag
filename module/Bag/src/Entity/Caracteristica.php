<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Característica.
 * @ORM\Entity(repositoryClass="Bag\Repository\Caracteristica")
 * @ORM\Table(name="caracteristica")
 */
class Caracteristica extends AbstractEntity {

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
     * @ORM\Column(name="nome_curto", type="string")
     */
    protected $nomeCurto;
    
    /**
     * @ORM\Column(name="ordem", type="integer")
     */
    protected $ordem;
    
    /**
     * @ORM\Column(name="rotina", type="boolean")
     */
    protected $rotina;
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getNomeCurto() {
        return $this->nomeCurto;
    }

    public function getOrdem() {
        return $this->ordem;
    }

    public function getRotina() {
        return $this->rotina;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setNomeCurto($nomeCurto) {
        $this->nomeCurto = $nomeCurto;
    }

    public function setOrdem($ordem) {
        $this->ordem = $ordem;
    }

    public function setRotina($rotina) {
        $this->rotina = $rotina;
    }
    
}