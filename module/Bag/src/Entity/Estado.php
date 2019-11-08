<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Estado.
 * @ORM\Entity(repositoryClass="Bag\Repository\Estado")
 * @ORM\Table(name="estado")
 */
class Estado extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Pais", inversedBy="estados")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
     */
    protected $pais;
    
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;

    /**
     * @ORM\Column(name="sigla", type="string")
     */
    protected $sigla;

    public function getId() {
        return $this->id;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }
    
}