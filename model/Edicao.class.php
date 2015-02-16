<?php
namespace model;

use classes\Data;

class Edicao {
    private $idEdicao;
    private $titulo;
    private $editora;
    private $lingua;
    private $ano;
    private $numeroDePaginas;
    
    //UsuariosDonos;
    private $posicoes;
    
    //UsuariosLeitores;
    private $datasInicio;
    private $datasFim;
    
    //Livros da edição
    private $livros;
    
    public function __construct($idEdicao,$titulo, Editora $editora, $lingua = null, $ano=null, $numeroDePaginas = null) {
        $this->setId($idEdicao);
        $this->setTitulo($titulo);
        $this->setEditora($editora);
        $this->setLingua($lingua);
        $this->setAno($ano);
        $this->setNumeroDePaginas($numeroDePaginas);
        $this->posicoes = array();
        $this->datasInicio = array();
        $this->datasFim = array();
        $this->livros = array();
    }
    
    public function getId() {
        return $this->idEdicao;
    }

    public function setId($idEdicao) {
        $this->idEdicao = $idEdicao;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getAno() {
        return $this->ano;
    }

    public function getNumeroDePaginas() {
        return $this->numeroDePaginas;
    }

    public function getEditora() {
        return $this->editora;
    }
    
    public function getLingua() {
        return $this->lingua;
    }

    public function setLingua($lingua) {
        $this->lingua = $lingua;
    }

        public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function setNumeroDePaginas($numeroDePaginas) {
        $this->numeroDePaginas = $numeroDePaginas;
    }

    public function setEditora($editora) {
        $this->editora = $editora;
    }

    /*********DONOS***************/
    public function addUsuarioDono($idUsuarioDono,$posicao = null) {
        $this->posicoes[$idUsuarioDono] = $posicao;
    }
    public function getUsuariosDonos() {
        return array_keys($this->posicoes);
    }
    public function getPosicao($idUsuarioDono) {
        return $this->posicoes[$idUsuarioDono];
    }
    public function usuariosEhDono($idUsuario) {
        return key_exists($idUsuario,$this->posicoes);
    }
    /*********LEITORES***************/
    public function addUsuarioLeitor($idUsuarioLeitor, Data $dataInicio = null, Data $dataFim = null) {
        $this->datasInicio[$idUsuarioLeitor] = $dataInicio;
        $this->datasFim[$idUsuarioLeitor] = $dataFim;
    }
    public function getUsuariosLeitores() {
        return array_keys($this->datasInicio);
    }
    public function getDataInicio($idUsuarioDono) {
        return $this->datasInicio[$idUsuarioDono];
    }
    public function getDataFim($idUsuarioDono) {
        return $this->datasFim[$idUsuarioDono];
    }
    /*********LIVROS***************/
    public function addLivro(Livro $livro) {
        $this->livros[$livro->getId()] = $livro;
    }
    public function getLivros() {
        return $this->livros;
    }
}
