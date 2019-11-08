<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Material.
 * @ORM\Entity(repositoryClass="Bag\Repository\Material")
 * @ORM\Table(name="material")
 */
class Material extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column=(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="cgs", type="string")
     */
    protected $cgs;
    
    /**
     * @ORM\Column(name="bracod", type="string")
     */
    protected $bracod;

    /**
     * @ORM\Column(name="acesso", type="string")
     */
    protected $acesso;
    
    /**
     * @ORM\Column(name="cultivar", type="string")
     */
    protected $cultivar;

    /**
     * @ORM\Column(name="observacao", type="string")
     */
    protected $observacao;
    
    /**
     * @ORM\ManyToOne(targetEntity="Especie")
     * @ORM\JoinColumn(name="especie_id", referencedColumnName="id")
     */
    protected $especie;
    
    /**
     * @ORM\OneToOne(targetEntity="Passaporte", mappedBy="material")
     */
    protected $passaporte;
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Bag", mappedBy="material")
     */
    protected $bag;
    
    /**
     * @ORM\OneToMany(targetEntity="MaterialTipoBag", mappedBy="material")
     */
    protected $tiposBag;
    
    /**
     * @ORM\OneToMany(targetEntity="MaterialCaracteristica", mappedBy="material")
     */
    protected $caracteristicas;
    
    /**
     * @ORM\ManyToOne(targetEntity="Programa")
     * @ORM\JoinColumn(name="programa_id", referencedColumnName="id")
     */
    protected $programa;

 //   protected $imagens;
    
    public function __construct() {
        $this->tiposBag = new ArrayCollection();
        $this->caracteristicas = new ArrayCollection();
       // $this->imagens = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getCgs() {
        return $this->cgs;
    }
    
    public function getBracod() {
        return $this->bracod;
    }
    
    public function getAcesso() {
        return $this->acesso;
    }

    public function getCultivar() {
        return $this->cultivar;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getEspecie() {
        return $this->especie;
    }
    
    public function getTiposBag() {
        return $this->tiposBag;
    }
    
    public function getPassaporte() {
        return $this->passaporte;
    }

    public function getBag() {
        return $this->bag;
    }
    
    public function getCaracteristicas() {
        return $this->caracteristicas;
    }
    
    public function getPrograma() {
        return $this->programa;
    }
    
    public function getCgsAcesso() {
        if (null != $this->passaporte && $this->passaporte->getSinonimia1() != "") {
            return $this->cgs." - ".$this->acesso." - ".$this->passaporte->getSinonimia1().$this->passaporte->getSinonimia2().$this->passaporte->getSinonimia3();
        } else {
            return $this->cgs." - ".$this->acesso;
        }
    }
    
    public function getImagens() {
//        return $this->imagens;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setCgs($cgs) {
        $this->cgs = $cgs;
    }

    public function setBracod($bracod) {
        $this->bracod = $bracod;
    }
    
    public function setAcesso($acesso) {
        $this->acesso = $acesso;
    }

    public function setCultivar($cultivar) {
        $this->cultivar = $cultivar;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setEspecie($especie) {
        $this->especie = $especie;
    }
    
    public function setTiposBag($tiposBag) {
        $this->tiposBag = $tiposBag;
    }
 
    public function setPassaporte($passaporte) {
        $this->passaporte = $passaporte;
    }
    
    public function setBag($bag) {
        $this->bag = $bag;
    }
    
    public function setCaracteristicas($caracteristicas) {
        $this->caracteristicas = $caracteristicas;
    }
    
    public function setPrograma($programa) {
        $this->programa = $programa;
    }
    
    public function setImagens($imagens) {
       // $this->imagens = $imagens;
    }
}