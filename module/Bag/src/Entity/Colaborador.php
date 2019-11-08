<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Colaborador.
 * @ORM\Entity(repositoryClass="Bag\Repository\Colaborador")
 * @ORM\Table(name="sigrh.colaborador")
 */
class Colaborador extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="matricula", type="string")
     */
    protected $matricula;
    
    /**
     * @ORM\Column(name="nome", type="string")
     */
    protected $nome;

    function getMatricula() {
        return $this->matricula;
    }

    function getNome() {
        return $this->nome;
    }

    function setMatricula($matricula) {
        $this->matricula = $matricula;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

}
