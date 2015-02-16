<?php
namespace model;

class Genero {
    private $idGenero;
    private $descricao;
    
    public function __construct($idGenero,$descricao) {
        $this->setId($idGenero);
        $this->setDescricao($descricao);
    }
    
    public function getId() {
        return $this->idGenero;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId($idGenero) {
        $this->idGenero = $idGenero;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}
