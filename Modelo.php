<?php
require_once '../autoloader.php';

$usuario = controladorDeSessao::selecionaUsuarioLogado();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estante</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
</head>
<body>
    <div>
        <?php echo Layout::menuSuperior($usuario)?>
    </div>
    <div>
        
    </div>
    <div class='corCorpo corpo'>
        &nbsp;
    </div>
</body>
</html>
