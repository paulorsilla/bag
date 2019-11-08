<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Localização.
 * @ORM\Entity(repositoryClass="Bag\Repository\Localizacao")
 * @ORM\Table(name="localizacao")
 */


class Localizacao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Modulo", inversedBy="localizacoes")
     * @ORM\JoinColumn(name="modulo_id", referencedColumnName="id")
     */
    protected $modulo;
    
    /**
     * @ORM\Column(name="localizacao", type="string")
     */
    protected $localizacao;

    /**
     * @ORM\Column(name="status", type="boolean")
     */
    protected $status;

    public function getId() {
        return $this->id;
    }

    public function getModulo() {
        return $this->modulo;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
    }
        
    public function setLocalizacao($localizacao) {
        $this->localizacao = $localizacao;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}