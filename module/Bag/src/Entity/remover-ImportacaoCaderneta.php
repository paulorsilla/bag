<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Classe Imagem.
 * @ORM\Entity(repositoryClass="Bag\Repository\ImportacaoCaderneta")
 * @ORM\Table(name="importacao_caderneta")
 */
class ImportacaoCaderneta extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="coluna_cgs", type="integer")
     */
    protected $colunaCgs;
    
    /**
     * @ORM\Column(name="coluna_acesso", type="integer")
     */
    protected $colunaAcesso;
    
    /**
     * @ORM\Column(name="coluna_localizacao", type="integer")
     */
    protected $colunaLocalizacao;
    
    /**
     * @ORM\Column(name="coluna_especie", type="integer")
     */
    protected $colunaEspecie;
    
    /**
     * @ORM\Column(name="coluna_programa", type="integer")
     */
    protected $colunaPrograma;
    
    /**
     * @ORM\Column(name="coluna_cultivar", type="integer")
     */
    protected $colunaCultivar;
    
    /**
     * @ORM\Column(name="coluna_anotacao", type="integer")
     */
    protected $colunaAnotacao;
    
    /**
     * @ORM\Column(name="nome_arquivo", type="string")
     */
    protected $nomeArquivo;
    
    /**
     * @ORM\Column(name="data_importacao", type="datetime")
     */
    protected $dataImportacao;
    
    /**
     *@ORM\OneToMany(targetEntity="ImportacaoCadernetaCaracteristica", mappedBy="importacaoCaderneta")
     */
    protected $caracteristicas;

    
    public function __construct() {
        $this->carcteristicas = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getColunaCgs() {
        return $this->colunaCgs;
    }

    public function getColunaAcesso() {
        return $this->colunaAcesso;
    }

    public function getColunaLocalizacao() {
        return $this->colunaLocalizacao;
    }

    public function getColunaEspecie() {
        return $this->colunaEspecie;
    }

    public function getColunaPrograma() {
        return $this->colunaPrograma;
    }

    public function getColunaCultivar() {
        return $this->colunaCultivar;
    }

    public function getColunaAnotacao() {
        return $this->colunaAnotacao;
    }

    public function getNomeArquivo() {
        return $this->nomeArquivo;
    }

    public function getDataImportacao() {
        return $this->dataImportacao;
    }

    public function getCaracteristicas() {
        return $this->caracteristicas;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setColunaCgs($colunaCgs) {
        $this->colunaCgs = $colunaCgs;
    }

    public function setColunaAcesso($colunaAcesso) {
        $this->colunaAcesso = $colunaAcesso;
    }

    public function setColunaLocalizacao($colunaLocalizacao) {
        $this->colunaLocalizacao = $colunaLocalizacao;
    }

    public function setColunaEspecie($colunaEspecie) {
        $this->colunaEspecie = $colunaEspecie;
    }

    public function setColunaPrograma($colunaPrograma) {
        $this->colunaPrograma = $colunaPrograma;
    }

    public function setColunaCultivar($colunaCultivar) {
        $this->colunaCultivar = $colunaCultivar;
    }

    public function setColunaAnotacao($colunaAnotacao) {
        $this->colunaAnotacao = $colunaAnotacao;
    }

    public function setNomeArquivo($nomeArquivo) {
        $this->nomeArquivo = $nomeArquivo;
    }

    public function setDataImportacao($dataImportacao) {
        $this->dataImportacao = $dataImportacao;
    }

    public function setCaracteristicas($caracteristicas) {
        $this->caracteristicas = $caracteristicas;
    }
    
}