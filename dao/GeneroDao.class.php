<?php
namespace dao;

use model\Genero;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneroDao
 *
 * @author icm
 */
class GeneroDao extends ConnectionFactory {
    public function selecionaGenero($idGenero) {
        $query = "SELECT descricao "
                . "FROM generos "
                . "WHERE id_genero = $idGenero";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $genero = new Genero($idGenero,
                $ln['descricao']);
        return $genero;
    }
    
    public function selecionaGeneros($descGenero = null) {
        $select = "SELECT id_genero FROM generos ";
        $where = ($descGenero)?" WHERE descricao like '$descGenero' ":'';
        $orderBy = ' ORDER BY descricao DESC';
        $query = $select.$where.$orderBy;
        $result = $this->executaQuery($query);
        $generos = array();
        while($ln = mysql_fetch_array($result)) {
            $idGenero = $ln['id_genero'];
            $generos[$idGenero] = $this->selecionaGenero($idGenero);
        }
        return $generos;
    }
    
    public function insereGenero(Genero $genero) {
        $query = "INSERT INTO generos (descricao)"
                . "VALUES ('{$genero->getDescricao()}') ";
        $result = $this->executaQuery($query);
        return ($result)?$this->getLastId():$result;
    }
    
    public function atualizaGenero(Genero $genero) {
        $query = "UPDATE generos "
                . "SET descricao='{$genero->getDescricao()}' "
                . "WHERE id_genero = {$genero->getId()}";
        $result = $this->executaQuery($query);
        return ($result)?$genero->getId():$result;
    }
}
