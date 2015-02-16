<?php require_once '../autoloader.php';

use controller\controladorDeSessao;
use dao\UsuarioDao;
$login = filter_input(INPUT_POST, 'login',FILTER_SANITIZE_SPECIAL_CHARS);
$senha = filter_input(INPUT_POST, 'senha',FILTER_SANITIZE_SPECIAL_CHARS);

$bd = new UsuarioDao;
$ok = $bd->validaLogin($login, $senha);
if($ok) {
    controladorDeSessao::registraUsuario($ok);
    header("Location: ../livros/home.php");    
} else {
    header("Location: ../login.php?e=1");    
}
exit;
