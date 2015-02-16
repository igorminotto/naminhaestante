<?php
namespace dao;

use model\Autor;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AutorDao
 *
 * @author icm
 */
class AutorDao extends ConnectionFactory {
    public function selecionaAutor($idAutor) {
        $query = "SELECT nome "
                . "FROM autores "
                . "WHERE id_autor = $idAutor";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $autor = new Autor($idAutor,
                $ln['nome']);
        return $autor;
    }
    
    public function selecionaAutores($nome = null) {
        $select = "SELECT id_autor FROM autores ";
        $where = ($nome)?" WHERE nome like '$nome' ":'';
        $orderBy = " ORDER BY nome DESC ";
        $query = $select.$where.$orderBy;
        $result = $this->executaQuery($query);
        $autores = array();
        while($ln = mysql_fetch_array($result)) {
            $idAutor = $ln['id_autor'];
            $autores[$idAutor] = $this->selecionaAutor($idAutor);
        }
        return $autores;
    }
    
    public function insereAutor(Autor $autor) {
        $query = "INSERT INTO autores (nome)"
                . "VALUES ('{$autor->getNome()}') ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function atualizaAutor(Autor $autor) {
        $query = "UPDATE autores "
                . "SET nome='{$autor->getNome()}' "
                . "WHERE id_autor = {$autor->getId()}";
        $result = $this->executaQuery($query);
        return ($result)?$autor->getId():$result;
    }
}
