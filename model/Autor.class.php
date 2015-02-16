<?php
namespace model;

class Autor {
    private $idAutor;
    private $nome;

    public function __construct($idAutor,$nome) {
        $this->setId($idAutor);
        $this->setNome($nome);
    }
    
    public function getId() {
        return $this->idAutor;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($idAutor) {
        $this->idAutor = $idAutor;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
}