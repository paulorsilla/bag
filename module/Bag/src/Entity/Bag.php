<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Sinonimia.
 * @ORM\Entity(repositoryClass="Bag\Repository\Bag")
 * @ORM\Table(name="bag")
 */
class Bag extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="safra", type="string")
     */
    protected $safra;
    
    /**
     * @ORM\Column(name="pesoSem", type="decimal", precision=10, scale=2)
     */
    protected $pesoSem;
    
    /**
     * @ORM\Column(name="pesoTotal", type="decimal", precision=10, scale=2)
     */
    protected $pesoTotal;
    
    /**
     * @ORM\Column(name="saldo", type="decimal", precision=10, scale=2)
     */
    protected $saldo;
    
    /**
     * @ORM\OneToOne(targetEntity="Material", inversedBy="bag")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $material;
    
    /**
     * @ORM\OneToOne(targetEntity="Localizacao")
     * @ORM\JoinColumn(name="localizacao_id", referencedColumnName="id")
     */
    protected $localizacao;
    
    /**
     * @ORM\Column(name="data_inclusao", type="datetime")
     */
    protected $dataInclusao;

    public function getId() {
        return $this->id;
    }

    public function getSafra() {
        return $this->safra;
    }

    public function getSaldo() {
        return $this->saldo;
    }

    public function getMaterial() {
        return $this->material;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }
    
    public function getPesoSem() {
        return $this->pesoSem;
    }

    public function getPesoTotal() {
        return $this->pesoTotal;
    }
    
    public function getDataInclusao() {
        return $this->dataInclusao;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setSafra($safra) {
        $this->safra = $safra;
    }

    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }

    public function setMaterial($material) {
        $this->material = $material;
    }

    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }
    
    public function setPesoSem($pesoSem) {
        $this->pesoSem = $pesoSem;
    }

    public function setPesoTotal($pesoTotal) {
        $this->pesoTotal = $pesoTotal;
    }
    
    public function setDataInclusao($dataInclusao) {
        $this->dataInclusao = $dataInclusao;
    }
}
