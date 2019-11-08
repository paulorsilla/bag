<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe ItemRegeneracao.
 * @ORM\Entity(repositoryClass="Bag\Repository\ItemRegeneracao")
 * @ORM\Table(name="item_regeneracao")
 */
class ItemRegeneracao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="quantidade_plantada", type="integer")
     */
    protected $quantidadePlantada;
    
    /**
     * @ORM\Column(name="origem", type="string")
     */
    protected $origem;
    
    /**
     * @ORM\Column(name="estaca", type="string")
     */
    protected $estaca;

    /**
     * @ORM\ManyToOne(targetEntity="Material")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $material;

    /**
     * @ORM\ManyToOne(targetEntity="Regeneracao", inversedBy="itens")
     * @ORM\JoinColumn(name="regeneracao_id", referencedColumnName="id")
     */
    protected $regeneracao;
   
    /**
     * @ORM\Column(name="anotacao", type="string")
     */
    protected $anotacao;
    
    /**
     * @ORM\OneToMany(targetEntity="ItemRegeneracaoAcao", mappedBy="itemRegeneracao")
     */
    protected $acoes;
    
    /**
     * @ORM\ManyToOne(targetEntity="Programa")
     * @ORM\JoinColumn(name="programa_provisorio_id", referencedColumnName="id")
    */
    protected $programaProvisorio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Programa")
     * @ORM\JoinColumn(name="programa_final_id", referencedColumnName="id")
    */
    protected $programaFinal;
    
    public function __construct() {
        $this->acoes = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getQuantidadePlantada() {
        return $this->quantidadePlantada;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function getEstaca() {
        return $this->estaca;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getRegeneracao() {
        return $this->regeneracao;
    }

    public function getAnotacao() {
        return $this->anotacao;
    }

    public function getAcoes() {
        return $this->acoes;
    }

    public function getProgramaProvisorio() {
        return $this->programaProvisorio;
    }

    public function getProgramaFinal() {
        return $this->programaFinal;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setQuantidadePlantada($quantidadePlantada) {
        $this->quantidadePlantada = $quantidadePlantada;
    }

    public function setOrigem($origem) {
        $this->origem = $origem;
    }

    public function setEstaca($estaca) {
        $this->estaca = $estaca;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setRegeneracao($regeneracao) {
        $this->regeneracao = $regeneracao;
    }

    public function setAnotacao($anotacao) {
        $this->anotacao = $anotacao;
    }

    public function setAcoes($acoes) {
        $this->acoes = $acoes;
    }

    public function setProgramaProvisorio($programaProvisorio) {
        $this->programaProvisorio = $programaProvisorio;
    }

    public function setProgramaFinal($programaFinal) {
        $this->programaFinal = $programaFinal;
    }
}
