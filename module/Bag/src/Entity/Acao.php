<?php

namespace Bag\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Classe Acao.
 * @ORM\Entity(repositoryClass="Bag\Repository\Acao")
 * @ORM\Table(name="acao")
 */
class Acao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @ORM\Column(name="descricao", type="string")
     */
    protected $descricao;
    
    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}