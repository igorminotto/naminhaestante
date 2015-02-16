<?php namespace model;
require_once '../autoloader.php';

use model\Autor;
use model\Genero;

class Livro {
    private $idLivro;
    private $titulo;
    private $ano;
    
    private $autores;
    private $generos;
            
    public function __construct($idLivro,$titulo,$ano=null) {
        $this->setId($idLivro);
        $this->setTitulo($titulo);
        $this->setAno($ano);
    }
    
    public function getId() {
        return $this->idLivro;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAno() {
        return $this->ano;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getPosicao() {
        return $this->posicao;
    }

    public function getData() {
        return $this->data;
    }

    public function setId($idLivro) {
        $this->idLivro = $idLivro;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setPosicao($posicao) {
        $this->posicao = $posicao;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function getAutores() {
        return $this->autores;
    }

    public function getGeneros() {
        return $this->generos;
    }

    public function setAutores($autores) {
        $this->autores = $autores;
    }
    
    public function addAutor(Autor $autor) {
        $this->autores[] = $autor;
    }

    public function setGeneros($generos) {
        $this->generos = $generos;
    }

    public function addGenero(Genero $genero) {
        $this->generos[] = $genero;
    }
}
