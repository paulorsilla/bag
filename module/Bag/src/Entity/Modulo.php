<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Módulo.
 * @ORM\Entity(repositoryClass="Bag\Repository\Modulo")
 * @ORM\Table(name="modulo")
 */
class Modulo extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="numero_modulo", type="integer")
     */
    protected $numero;
    
    /**
     * @ORM\Column(name="lados", type="integer")
     */
    protected $lados;
    
    /**
     * @ORM\Column(name="faces", type="integer")
     */
    protected $faces;
    
    /**
     * @ORM\Column(name="niveis", type="integer")
     */
    protected $niveis;
    
    /**
     * @ORM\Column(name="espacos", type="integer")
     */
    protected $espacos;
    
    /**
     * @ORM\OneToMany(targetEntity="Localizacao", mappedBy="modulo")
     */
    protected $localizacoes;
    
    public function __construct() {
        $this->localizacoes = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getLados() {
        return $this->lados;
    }

    public function getFaces() {
        return $this->faces;
    }

    public function getNiveis() {
        return $this->niveis;
    }

    public function getEspacos() {
        return $this->espacos;
    }
    public function getLocalizacoes() {
        return $this->localizacoes;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setLados($lados) {
        $this->lados = $lados;
    }

    public function setFaces($faces) {
        $this->faces = $faces;
    }

    public function setNiveis($niveis) {
        $this->niveis = $niveis;
    }

    public function setEspacos($espacos) {
        $this->espacos = $espacos;
    }

    public function setLocalizacoes($localizacoes) {
        $this->localizacoes = $localizacoes;
    }
    
    
}