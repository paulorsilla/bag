<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Imagem.
 * @ORM\Entity(repositoryClass="Bag\Repository\Imagem")
 * @ORM\Table(name="imagem")
 */
class Imagem extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(name="nome_arquivo", type="string")
     */
    protected $nomeArquivo;

    /**
     * @ORM\Column(name="observacoes", type="string")
     */
    protected $observacoes;
    
    public function getId() {
        return $this->id;
    }

    public function getNomeArquivo() {
        return $this->nomeArquivo;
    }

    public function getObservacoes() {
        return $this->observacoes;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNomeArquivo($nomeArquivo) {
        $this->nomeArquivo = $nomeArquivo;
    }

    public function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }
    
}