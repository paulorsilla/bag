<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Genero.
 * @ORM\Entity(repositoryClass="Bag\Repository\ImportacaoCadernetaCaracteristica")
 * @ORM\Table(name="genero")
 */
class ImportacaoCadernetaCaracteristica extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="ImportacaoCaderneta", inversedBy="caracteristicas")
     * @ORM\JoinColumn(name="importacao_caderneta_id", referencedColumnName="id")
     */
    protected $importacaoCaderneta;

    /**
     * @ORM\ManyToOne(targetEntity="Caracteristica")
     * @ORM\JoinColumn(name="caracteristica_id", referencedColumnName="id")
     */
    protected $caracteristica;

    /**
     * @ORM\Column(name="coluna", type="integer")
     */
    protected $coluna;
    
    public function getId() {
        return $this->id;
    }

    public function getImportacaoCaderneta() {
        return $this->importacaoCaderneta;
    }

    public function getCaracteristica() {
        return $this->caracteristica;
    }

    public function getColuna() {
        return $this->coluna;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setImportacaoCaderneta($importacaoCaderneta) {
        $this->importacaoCaderneta = $importacaoCaderneta;
    }

    public function setCaracteristica($caracteristica) {
        $this->caracteristica = $caracteristica;
    }

    public function setColuna($coluna) {
        $this->coluna = $coluna;
    }
   
}