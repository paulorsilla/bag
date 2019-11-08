<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Coleta.
 * @ORM\Entity(repositoryClass="Bag\Repository\Avaliacao")
 * @ORM\Table(name="avaliacao")
 */
class Avaliacao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="data_avaliacao", type="datetime")
     */
    protected $dataAvaliacao;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="responsavel_id", referencedColumnName="id")
     */
    protected $responsavel;

    /**
     * @ORM\ManyToOne(targetEntity="Regeneracao")
     * @ORM\JoinColumn(name="regeneracao_id", referencedColumnName="id")
     */
    protected $regeneracao;

    /**
     * @ORM\Column(name="substituicoes", type="string")
     */
    protected $substituicoes;
    
    /**
     * @ORM\ManyToMany(targetEntity="Caracteristica")
     * @ORM\JoinTable(name="avaliacao_caracteristica",
     *      joinColumns={@ORM\JoinColumn(name="avaliacao_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="caracteristica_id", referencedColumnName="id")}
     * )
     */
    protected $caracteristicas;
    
    /**
     * @ORM\OneToMany(targetEntity="ItemAvaliacao", mappedBy="avaliacao")
     */
    protected $itens;
    
    public function __construct()
    {
        $this->caracteristicas = new ArrayCollection();
        $this->itens = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDataAvaliacao() {
        return $this->dataAvaliacao;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function getRegeneracao() {
        return $this->regeneracao;
    }

    public function getSubstituicoes() {
        return $this->substituicoes;
    }

    public function getCaracteristicas() {
        return $this->caracteristicas;
    }

    public function getItens() {
        return $this->itens;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDataAvaliacao($dataAvaliacao) {
        $this->dataAvaliacao = $dataAvaliacao;
    }

    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    public function setRegeneracao($regeneracao) {
        $this->regeneracao = $regeneracao;
    }

    public function setSubstituicoes($substituicoes) {
        $this->substituicoes = $substituicoes;
    }

    public function setCaracteristicas($caracteristicas) {
        $this->caracteristicas = $caracteristicas;
    }

    public function setItens($itens) {
        $this->itens = $itens;
    }
    
}


