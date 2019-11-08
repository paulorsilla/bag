<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe ItemRegeneracaoAcao.
 * @ORM\Entity(repositoryClass="Bag\Repository\ItemRegeneracaoAcao")
 * @ORM\Table(name="item_regeneracao_acao")
 */
class ItemRegeneracaoAcao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="ItemRegeneracao", inversedBy="acoes")
     * @ORM\JoinColumn(name="item_regeneracao_id", referencedColumnName="id")
     */
    protected $itemRegeneracao;

    /**
     * @ORM\ManyToOne(targetEntity="Acao")
     * @ORM\JoinColumn(name="acao_id", referencedColumnName="id")
     */
    protected $acao;
    
    /**
     * @ORM\Column(name="observacao", type="string")
     */
    protected $observacao;
    
    /**
     * @ORM\Column(name="data_acao", type="datetime")
     */
    protected $dataAcao;
    
    /**
     * @ORM\Column(name="status", type="integer")
     */
    protected $status;
   
    public function getId() {
        return $this->id;
    }

    public function getItemRegeneracao() {
        return $this->itemRegeneracao;
    }

    public function getAcao() {
        return $this->acao;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getDataAcao() {
        return $this->dataAcao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setItemRegeneracao($itemRegeneracao) {
        $this->itemRegeneracao = $itemRegeneracao;
    }

    public function setAcao($acao) {
        $this->acao = $acao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setDataAcao($dataAcao) {
        $this->dataAcao = $dataAcao;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
}
