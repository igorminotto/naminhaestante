<?php
namespace dao;

use dao\ConnectionFactory;
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
class UsuarioDao extends ConnectionFactory {
    
    public function selecionaUsuarios() {
        $query = "SELECT id_usuario FROM usuarios";
        $result = $this->executaQuery($query);
        $usuarios = array();
        while($ln = mysql_fetch_array($result)) {
            $idUsuario = $ln['id_usuario'];
            $usuarios[$idUsuario] = $this->selecionaUsuario($idUsuario);
        }
        return $usuarios;
    }
    
    public function selecionaUsuario($idUsuario) {
        $query = "SELECT nome, email, senha "
                . "FROM usuarios "
                . "WHERE id_usuario = $idUsuario";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $usuario = new Usuario($idUsuario,
                $ln['nome'],
                $ln['email'],
                $ln['senha']);
        return $usuario;
    }
    
    public function validaLogin($login,$senha) {
        $query = "SELECT id_usuario FROM usuarios "
                . "WHERE (nome = '$login' OR email = '$login') "
                . "AND senha = '$senha'";
        $result = $this->executaQuery($query);
        $ln = mysql_fetch_array($result);
        $idUsuario = $ln['id_usuario'];
        return ($idUsuario)?$idUsuario:false;
    }
}
