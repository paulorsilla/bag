<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe RegeneracaoCaracteristica.
 * @ORM\Entity(repositoryClass="Bag\Repository\RegeneracaoCaracteristica")
 * @ORM\Table(name="regeneracao_caracteristica")
 */
class RegeneracaoCaracteristica extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Caracteristica")
     * @ORM\JoinColumn(name="caracteristica_id", referencedColumnName="id")
     */
    protected $caracteristica;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Regeneracao")
     * @ORM\JoinColumn(name="regeneracao_id", referencedColumnName="id")
     */
    protected $regeneracao;

    public function getCaracteristica() {
        return $this->caracteristica;
    }

    public function getRegeneracao() {
        return $this->regeneracao;
    }

    public function setCaracteristica($caracteristica) {
        $this->caracteristica = $caracteristica;
    }

    public function setRegeneracao($regeneracao) {
        $this->regeneracao = $regeneracao;
    }
    
    public function __toString() {
        return $this->getCaracteristica()->getNomeCurto();
    }
    
}
