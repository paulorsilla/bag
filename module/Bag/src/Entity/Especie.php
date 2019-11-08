<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Programa.
 * @ORM\Entity(repositoryClass="Bag\Repository\Especie")
 * @ORM\Table(name="especie")
 */
class Especie extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Genero", inversedBy="especies")
     * @ORM\JoinColumn(name="genero_id", referencedColumnName="id")
     */
    protected $genero;
    
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;

    /**
     * @ORM\Column(name="quantidade_minima", type="integer")
     */
    protected $quantidadeMinima;
    
    public function getId() {
        return $this->id;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }
        
    public function getDescricao() {
        return $this->descricao;
    }

    public function getQuantidadeMinima() {
        return $this->quantidadeMinima;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setQuantidadeMinima($quantidadeMinima) {
        $this->quantidadeMinima = $quantidadeMinima;
    }
    
}


