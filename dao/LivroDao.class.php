<?php
namespace dao;

use dao\AutorDao;
use dao\ConnectionFactory;
use dao\GeneroDao;
use model\Autor;
use model\Genero;
use model\Livro;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDao
 *
 * @author icm
 */
class LivroDao extends ConnectionFactory {
    
    private $autorDao;
    private $generoDao;
    public function __construct() {
        parent::__construct();
        $this->autorDao = new AutorDao;
        $this->generoDao = new GeneroDao;
    }
    
    public function selecionaLivros() {
        $query = "SELECT id_livro FROM livros";
        $result = $this->executaQuery($query);
        $livros = array();
        while($ln = mysql_fetch_array($result)) {
            $idLivro = $ln['id_livro'];
            $livros[$idLivro] = $this->selecionaLivro($idLivro);
        }
        return $livros;
    }
    
    public function selecionaLivro($idLivro) {
        $query = "SELECT titulo, ano "
                . "FROM livros "
                . "WHERE id_livro = $idLivro";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $livro = new Livro($idLivro,
                $ln['titulo'],
                $ln['ano']);
        $this->selecionaAutoresDoLivro($livro);
        $this->selecionaGenerosDoLivro($livro);
        return $livro;
    }
    
    public function buscaLivro($possivelTitulo) {
        $query = "SELECT id_livro "
                . "FROM livros "
                . "WHERE titulo like '%$possivelTitulo%'";
        $result = $this->executaQuery($query);
        $livros = array();
        while($ln = mysql_fetch_assoc($result)) {
            $idLivro = $ln['id_livro'];
            $livros[$idLivro] = $this->selecionaLivro($idLivro);
        }
        return $livros;
    }
    
    public function insereLivro(Livro $livro) {
        $query = "INSERT INTO livros (titulo,ano)"
                . "VALUES ('{$livro->getTitulo()}',{$livro->getAno()}) ";
        $result = $this->executaQuery($query);
        if($result) {
            $idLivro = $this->getLastId();
        } else {
            return $result;
        }
        $livro->setId($idLivro);
        if(!empty($livro->getAutores())){
            /* @var $autor Autor */
            foreach ($livro->getAutores() as $autor) {
                if(!$autor->getId()) {
                    $idAutor = $this->autorDao->insereAutor($autor);
                    $autor = $this->autorDao->selecionaAutor($idAutor);
                }
                $this->adicionaAutorAoLivro($autor, $livro);
            }
        }
        if(!empty($livro->getGeneros())){
            /* @var $autor Genero */
            foreach ($livro->getGeneros() as $genero) {
                if(!$genero->getId()) {
                    $idGenero = $this->generoDao->insereGenero($genero);
                    $genero = $this->generoDao->selecionaGenero($idGenero);
                } 
                $this->adicionaGeneroAoLivro($genero, $livro);
            }
        }
        return $idLivro;
    }
    
    public function adicionaAutorAoLivro(Autor $autor, Livro $livro) {
        $query = "INSERT INTO livros_escritos (id_autor, id_livro) "
                . "VALUES ({$autor->getId()},{$livro->getId()}) ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function adicionaGeneroAoLivro(Genero $genero, Livro $livro) {
        $query = "INSERT INTO generos_do_livro (id_genero, id_livro)"
                . "VALUES ({$genero->getId()},{$livro->getId()}) ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function selecionaAutoresDoLivro(Livro $livro) {
        $query = "SELECT id_autor "
                . "FROM livros_escritos "
                . "WHERE id_livro = {$livro->getId()}";
        $result = $this->executaQuery($query);
        $livro->setAutores(array());
        while($ln = mysql_fetch_array($result)) {
            $idAutor = $ln['id_autor'];
            $autor = $this->autorDao->selecionaAutor($idAutor);
            $livro->addAutor($autor);
        }
        return $livro->getAutores();
    }
    
    public function selecionaGenerosDoLivro(Livro $livro) {
        $query = "SELECT id_genero "
                . "FROM generos_do_livro "
                . "WHERE id_livro = {$livro->getId()}";
        $result = $this->executaQuery($query);
        $livro->setGeneros(array());
        while($ln = mysql_fetch_array($result)) {
            $idGenero = $ln['id_genero'];
            $genero = $this->generoDao->selecionaGenero($idGenero);
            $livro->addGenero($genero);
        }
        return $livro->getGeneros();
    }
}
