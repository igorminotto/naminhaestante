<?php
namespace model;

class Editora {
    private $idEditora;
    private $nome;
    
    public function __construct($idEditora, $nome) {
        $this->setId($idEditora);
        $this->setNome($nome);
    }
        
    public function getId() {
        return $this->idEditora;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($idEditora) {
        $this->idEditora = $idEditora;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
}
