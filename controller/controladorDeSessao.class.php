<?php
namespace controller;

use dao\UsuarioDao;

class controladorDeSessao {
    
    public static function registraUsuario($idUsuario) {
        session_start();
        $_SESSION['idUsuario'] = $idUsuario;
    }
    
    public static function selecionaUsuarioLogado() {
        session_start();
        if(!isset($_SESSION['idUsuario'])) {
            header('Location: ../login.php');
        }
        $idUsuario = $_SESSION['idUsuario'];
        $usuarioDao = new UsuarioDao;
        return $usuarioDao->selecionaUsuario($idUsuario);
    }
    
    public static function desregistraUsuario() {
        session_start();
        unset($_SESSION['idUsuario']);
    }
}
