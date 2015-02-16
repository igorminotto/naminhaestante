<?php
namespace dao;

use classes\Data;
use dao\ConnectionFactory;
use model\Edicao;
use model\Genero;
use model\Usuario;

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
class EdicaoDao extends ConnectionFactory {
    
    private $livroDao;
    private $usuarioDao;
    private $editoraDao;
    
    public function __construct() {
        parent::__construct();
        $this->livroDao = new LivroDao();
        $this->usuarioDao = new UsuarioDao();
        $this->editoraDao = new EditoraDao();
    }
    
    
    public function selecionaEdicoes() {
        $query = "SELECT id_edicao FROM edicoes";
        $result = $this->executaQuery($query);
        $edicoes = array();
        while($ln = mysql_fetch_array($result)) {
            $idEdicao = $ln['id_edicao'];
            $edicoes[$idEdicao] = $this->selecionaEdicao($idEdicao);
        }
        return $edicoes;
    }
    
    public function selecionaEdicao($idEdicao) {
        $query = "SELECT titulo, id_editora, lingua, ano, numero_de_paginas "
                . "FROM edicoes "
                . "WHERE id_edicao = $idEdicao";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $editora = $this->editoraDao->selecionaEditora($ln['id_editora']);
        $edicao = new Edicao($idEdicao,
                $ln['titulo'],
                $editora,
                $ln['lingua'],
                $ln['ano'],
                $ln['numero_de_paginas']);
        $this->selecionaDonosDaEdicao($edicao);
        $this->selecionaLeitoresDaEdicao($edicao);
        $this->selecionaLivrosDaEdicao($edicao);
        return $edicao;
    }
    
    public function insereEdicao(Edicao $edicao) {
        $editora = $edicao->getEditora();
        if(!$editora->getId()) {
            $idEditora = $this->editoraDao->insereEditora($editora);
            $editora = $this->editoraDao->selecionaEditora($idEditora);
        }
        $query = "INSERT INTO edicoes "
                . " (titulo,id_editora,ano,lingua,numero_de_paginas)"
                . " VALUES ('{$edicao->getTitulo()}',{$editora->getId()},"
                . "{$edicao->getAno()},'{$edicao->getLingua()}',"
                . "{$edicao->getNumeroDePaginas()}) ";
                echo "$query";
        $result = $this->executaQuery($query);
        if($result) {
            $idEdicao = $this->getLastId();
        } else {
            return $result;
        }
        $edicao->setId($idEdicao);
        if(!empty($edicao->getUsuariosDonos())){
            foreach ($edicao->getUsuariosDonos() as $idDono) {
                if(!$idDono) {
                    return false;
                }
                $this->adicionaDonoAEdicao($idDono, $edicao);
            }
        } else {return false;}
        if(!empty($edicao->getUsuariosLeitores())){
            foreach ($edicao->getUsuariosLeitores() as $idLeitor) {
                if($idLeitor) {
                    $this->adicionaLeitorAEdicao($idLeitor, $edicao);    
                } 
            }
        }
        if(!empty($edicao->getLivros())){
            /* @var $livro Livro  */
            foreach ($edicao->getLivros() as $livro) {
                if($livro->getId()) {
                    $this->adicionaLivroAEdicao($livro->getId(), $edicao);    
                } 
            }
        }
        return $idEdicao;
    }
    
    public function adicionaDonoAEdicao($idUsuarioDono, Edicao $edicao) {
        $query = "INSERT INTO edicoes_possuidas (id_usuario, id_edicao, posicao) "
                . "VALUES ({$idUsuarioDono},{$edicao->getId()},"
                . "'{$edicao->getPosicao($idUsuarioDono)}') ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function adicionaLeitorAEdicao($idUsuarioLeitor, Edicao $edicao) {
        $query = "INSERT INTO edicoes_lidas (id_usuario, id_edicao,data_inicio,data_fim)"
                . "VALUES ({$idUsuarioLeitor},{$edicao->getId()},"
                . "'{$edicao->getDataInicio($idUsuarioLeitor)->getDataFormatBanco()}',"
                . "'{$edicao->getDataFim($idUsuarioLeitor)->getDataFormatBanco()}') ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function adicionaLivroAEdicao($idLivro, Edicao $edicao) {
        $query = "INSERT INTO livros_da_edicao (id_livro, id_edicao)"
                . "VALUES ({$idLivro},{$edicao->getId()}) ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function selecionaDonosDaEdicao(Edicao $edicao) {
        $query = "SELECT id_usuario, posicao "
                . "FROM edicoes_possuidas "
                . "WHERE id_edicao = {$edicao->getId()}";
        $result = $this->executaQuery($query);
        //$edicao->set(array());
        while($ln = mysql_fetch_array($result)) {
            $edicao->addUsuarioDono($ln['id_usuario'], $ln['posicao']);
        }
        return $edicao->getUsuariosDonos();
    }
    
    public function selecionaLeitoresDaEdicao(Edicao $edicao) {
        $query = "SELECT id_usuario, data_inicio, data_fim "
                . "FROM edicoes_lidas "
                . "WHERE id_edicao = {$edicao->getId()}";
        $result = $this->executaQuery($query);
        //$edicao->set(array());
        while($ln = mysql_fetch_array($result)) {
            $edicao->addUsuarioLeitor($ln['id_usuario'], 
                    new Data($ln['data_inicio']),
                    new Data($ln['data_fim']));
        }
        return $edicao->getUsuariosDonos();
    }
    
    public function selecionaLivrosDaEdicao(Edicao $edicao) {
        $query = "SELECT id_livro "
                . "FROM livros_da_edicao "
                . "WHERE id_edicao = {$edicao->getId()}";
        $result = $this->executaQuery($query);
        //$edicao->set(array());
        while($ln = mysql_fetch_array($result)) {
            $livro = $this->livroDao->selecionaLivro($ln['id_livro']);
            $edicao->addLivro($livro);
        }
        return $edicao->getLivros();
    }
}