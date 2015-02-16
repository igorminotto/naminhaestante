<?php
namespace dao;

use model\Editora;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditoraDao
 *
 * @author icm
 */
class EditoraDao extends ConnectionFactory {
    public function selecionaEditora($idEditora) {
        $query = "SELECT nome "
                . "FROM editoras "
                . "WHERE id_editora = $idEditora";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $editora = new Editora($idEditora,
                $ln['nome']);
        return $editora;
    }
    
    public function selecionaEditoras($nome = null) {
        $select = "SELECT id_editora FROM editoras ";
        $where = ($nome)?" WHERE nome like '$nome' ":'';
        $orderBy = " ORDER BY nome DESC ";
        $query = $select.$where.$orderBy;
        $result = $this->executaQuery($query);
        $editoras = array();
        while($ln = mysql_fetch_array($result)) {
            $idEditora = $ln['id_editora'];
            $editoras[$idEditora] = $this->selecionaEditora($idEditora);
        }
        return $editoras;
    }
    
    public function insereEditora(Editora $editora) {
        $query = "INSERT INTO editoras (nome)"
                . "VALUES ('{$editora->getNome()}') ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function atualizaEditora(Editora $editora) {
        $query = "UPDATE editoras "
                . "SET nome='{$editora->getNome()}' "
                . "WHERE id_editora = {$editora->getId()}";
        $result = $this->executaQuery($query);
        return ($result)?$editora->getId():$result;
    }
}
