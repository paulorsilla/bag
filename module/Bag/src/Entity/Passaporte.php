<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Passaporte.
 * @ORM\Entity(repositoryClass="Bag\Repository\Passaporte")
 * @ORM\Table(name="passaporte")
 */
class Passaporte extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column=(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="origem", type="string")
     */
    protected $origem;
    
    /**
     * @ORM\Column(name="genealogia", type="string")
     */
    protected $genealogia;
    
    /**
     * @ORM\Column(name="genealogia_descritiva", type="string")
     */
    protected $genealogiaDescritiva;

    /**
     * @ORM\Column(name="informacao", type="string")
     */
    protected $informacao;
    
    /**
     * @ORM\Column(name="instituicao", type="string")
     */
    protected $instituicao;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pais")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
     */
    protected $pais;
    
    /**
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */
    protected $estado;
    
    /**
     * @ORM\Column(name="sinonimia1", type="string")
     */
    protected $sinonimia1;

    /**
     * @ORM\Column(name="sinonimia2", type="string")
     */
    protected $sinonimia2;

    /**
     * @ORM\Column(name="sinonimia3", type="string")
     */
    protected $sinonimia3;
    
    /**
     * @ORM\Column(name="sinonimia4", type="string")
     */
    protected $sinonimia4;

    /**
     * @ORM\Column(name="sinonimia5", type="string")
     */
    protected $sinonimia5;
       
    /**
     * @ORM\OneToOne(targetEntity="Material", inversedBy="passaporte")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $material;
    
    /**
     * @ORM\Column(name="estaca", type="string")
     */
    protected $estaca;
    
    public function getId() {
        return $this->id;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function getGenealogia() {
        return $this->genealogia;
    }
    
    public function getGenealogiaDescritiva() {
        return $this->genealogiaDescritiva;
    }

    public function getInformacao() {
        return $this->informacao;
    }

    public function getInstituicao() {
        return $this->instituicao;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getEstado() {
        return $this->estado;
    }
    
    public function getMaterial() {
        return $this->material;
    }
    
    public function getSinonimia1() {
        return $this->sinonimia1;
    }
    
    public function getSinonimia2() {
        return $this->sinonimia2;
    }

    public function getSinonimia3() {
        return $this->sinonimia3;
    }

    public function getSinonimia4() {
        return $this->sinonimia4;
    }

    public function getSinonimia5() {
        return $this->sinonimia5;
    }
    
    public function getSinonimias() {
        return $this->sinonimia1 . " "
                . $this->sinonimia2 . " "
                . $this->sinonimia3 . " "
                . $this->sinonimia4 . " "
                . $this->sinonimia5;
    }
    
    public function getEstaca() {
        return $this->estaca;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setOrigem($origem) {
        $this->origem = $origem;
    }

    public function setGenealogia($genealogia) {
        $this->genealogia = $genealogia;
    }

    public function setGenealogiaDescritiva($genealogiaDescritiva) {
        $this->genealogiaDescritiva = $genealogiaDescritiva;
    }

    public function setInformacao($informacao) {
        $this->informacao = $informacao;
    }
    
    public function setInstituicao($instituicao) {
        $this->instituicao = $instituicao;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
    
    public function setSinonimia1($sinonimia1) {
        $this->sinonimia1 = $sinonimia1;
    }
    
    public function setSinonimia2($sinonimia2) {
        $this->sinonimia2 = $sinonimia2;
    }

    public function setSinonimia3($sinonimia3) {
        $this->sinonimia3 = $sinonimia3;
    }
    
    public function setSinonimia4($sinonimia4) {
        $this->sinonimia4 = $sinonimia4;
    }

    public function setSinonimia5($sinonimia5) {
        $this->sinonimia5 = $sinonimia5;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }
    
    public function setEstaca($estaca) {
        $this->estaca = $estaca;
    }
}