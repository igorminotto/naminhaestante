<?php
require_once 'autoloader.php';
use controller\controladorDeSessao;
controladorDeSessao::desregistraUsuario();
$erro = filter_input(INPUT_GET, 'e',FILTER_SANITIZE_SPECIAL_CHARS);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estante - Login</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
</head>
<body>
    <div class='centerDiv corPadrao' align="center" style="font-size: 24px">
        <h3>Entrar</h3>
        <form action="controller/login.php" method="POST">
            <div style="width: 240px; height:50px;vertical-align: top">
            <?php if($erro) { 
                echo "<div align='center' class='erro'>Login ou senha incorretos</div>";
                }
            ?>
            </div>
            <table border='0'>    
                <tr><td>Login</td><td><input type="text" name="login" class='inputText'/></td></tr>
                <tr><td>Senha</td><td><input type="password" name="senha" class='inputText'/></td></tr>
                <tr><td style='height: 15px'></td></tr>
                <tr><td colspan="2" nowrap="" align="right"><input class='botaoVerde' type="submit"/></td></tr>
            </table>
        </form>
    </div>
</body>
</html>
