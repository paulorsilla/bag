<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe NumeracaoEstaca.
 * @ORM\Entity(repositoryClass="Bag\Repository\NumeracaoEstaca")
 * @ORM\Table(name="numeracao_estaca")
 */
class NumeracaoEstaca extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="ano")
     */
    protected $ano;
    
    /**
     * @ORM\Column(name="sequencia", type="integer")
     */
    protected $sequencia;
    
    /**
     * @ORM\Column(name="prefixo", type="string")
     */
    protected $prefixo;
    
    public function getAno() {
        return $this->ano;
    }

    public function getSequencia() {
        return $this->sequencia;
    }

    public function getPrefixo() {
        return $this->prefixo;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function setSequencia($sequencia) {
        $this->sequencia = $sequencia;
    }

    public function setPrefixo($prefixo) {
        $this->prefixo = $prefixo;
    }
}