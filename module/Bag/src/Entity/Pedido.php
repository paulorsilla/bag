<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Pedido.
 * @ORM\Entity(repositoryClass="Bag\Repository\Pedido")
 * @ORM\Table(name="pedido")
 */
class Pedido extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="tipo", type="integer")
     */
    protected $tipo;
    
    /**
     * @ORM\Column(name="data_retirada", type="datetime")
     */
    protected $dataRetirada;
    
    /**
     * @ORM\ManyToOne(targetEntity="Instituicao")
     * @ORM\JoinColumn(name="instituicao", referencedColumnName="cod_instituicao")
     */
    protected $instituicao;
    
    /**
     * @ORM\Column(name="requisitante", type="string")
     */
    protected $requisitante;
    
    /**
     * @ORM\Column(name="observacao", type="string")
     */
    protected $observacao;
    
    /**
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;
    
    /**
     * @ORM\Column(name="anexo_atm", type="string")
     */
    protected $anexoAtm;

    /**
     * @ORM\Column(name="area", type="string")
     */
    protected $area;

    /**
     * @ORM\Column(name="recebedor", type="string")
     */
    protected $recebedor;
    
    /**
     * @ORM\OneToMany(targetEntity="ItemPedido", mappedBy="pedido")
     */
    protected $itens;

    public function __construct() {
        $this->itens = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getDataRetirada() {
        return $this->dataRetirada;
    }

    public function getInstituicao() {
        return $this->instituicao;
    }

    public function getRequisitante() {
        return $this->requisitante;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAnexoAtm() {
        return $this->anexoAtm;
    }

    public function getArea() {
        return $this->area;
    }

    public function getRecebedor() {
        return $this->recebedor;
    }
    
    public function getItens() {
        return $this->itens;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setDataRetirada($dataRetirada) {
        $this->dataRetirada = $dataRetirada;
    }

    public function setInstituicao($instituicao) {
        $this->instituicao = $instituicao;
    }

    public function setRequisitante($requisitante) {
        $this->requisitante = $requisitante;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setAnexoAtm($anexoAtm) {
        $this->anexoAtm = $anexoAtm;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setRecebedor($recebedor) {
        $this->recebedor = $recebedor;
    }
    
    public function setItens($itens) {
        $this->itens = $itens;
    }
}
