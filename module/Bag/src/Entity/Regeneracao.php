<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Regeneracao.
 * @ORM\Entity(repositoryClass="Bag\Repository\Regeneracao")
 * @ORM\Table(name="regeneracao")
 */
class Regeneracao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="titulo", type="string")
     */
    protected $titulo;

    /**
     * @ORM\Column(name="data_plantio", type="datetime")
     */
    protected $dataPlantio;
    
    /**
     * @ORM\ManyToMany(targetEntity="Motivo")
     * @ORM\JoinTable(name="motivo_regeneracao",
     *      joinColumns={@ORM\JoinColumn(name="regeneracao_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="motivo_id", referencedColumnName="id")}
     *      )
     */
     protected $motivos;
     
    /**
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;
    
    /**
     * @ORM\OneToMany(targetEntity="ItemRegeneracao", mappedBy="regeneracao")
     */
    protected $itens;
    
    /**
     * @ORM\ManyToOne(targetEntity="Colaborador")
     * @ORM\JoinColumn(name="responsavel_matricula", referencedColumnName="matricula")
     */
    protected $responsavel;
    
    /**
     * @ORM\ManyToMany(targetEntity="Caracteristica")
     * @ORM\JoinTable(name="regeneracao_caracteristica",
     *      joinColumns={@ORM\JoinColumn(name="regeneracao_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="caracteristica_id", referencedColumnName="id")}
     *      )
     */
    protected $caracteristicas;
    
    /**
     * @ORM\Column(name="casa_vegetacao", type="string")
     */
    protected $casaVegetacao;
    
    /**
     * @ORM\Column(name="dias_luz", type="integer")
     */
    protected $diasLuz;
    
    /**
     * @ORM\Column(name="safra", type="string")
     */
    protected $safra;
    
    /**
     * @ORM\Column(name="nome_arquivo", type="string")
     */
    protected $nomeArquivo;
    
    public function __construct() {
        $this->motivos = new ArrayCollection();
        $this->itens = new ArrayCollection();
        $this->caracteristicas = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDataPlantio() {
        return $this->dataPlantio;
    }

    public function getMotivos() {
        return $this->motivos;
    }

    public function getStatus() {
        return $this->status;
    }
    
    public function getItens() {
        return $this->itens;
    }
    
    public function getResponsavel()
    {
        return $this->responsavel;
    }
    
    public function getCaracteristicas()
    {
        return $this->caracteristicas;
    }
    
    public function getCasaVegetacao() {
        return $this->casaVegetacao;
    }

    public function getDiasLuz() {
        return $this->diasLuz;
    }
    
    public function getSafra() {
        return $this->safra;
    }
        
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDataPlantio($dataPlantio) {
        $this->dataPlantio = $dataPlantio;
    }

    public function setMotivos($motivos) {
        $this->motivos = $motivos;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function setItens($itens) {
        $this->itens = $itens;
    }
    
    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }
    
    public function setCaracteristicas($caracteristicas) {
        $this->caracteristicas = $caracteristicas;
    }
    
    public function setCasaVegetacao($casaVegetacao) {
        $this->casaVegetacao = $casaVegetacao;
    }

    public function setDiasLuz($diasLuz) {
        $this->diasLuz = $diasLuz;
    }

    public function setSafra($safra) {
        $this->safra = $safra;
    }
    
    teste123

}