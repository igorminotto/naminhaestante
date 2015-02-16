<?php require_once '../autoloader.php';

use controller\controladorDeSessao;
use Layout\Layout;

$usuario = controladorDeSessao::selecionaUsuarioLogado();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estante - Novo livro</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <link rel="stylesheet" type="text/css" href="../jquery/jquery-ui.css">
    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript" src="../jquery/jquery-ui.js"></script>
    <style>
        .labelForm {
            width:125px;
            text-align:right;
        }
        .buttonColumn {
            width:20px;
        }
    </style>
</head>
<body>
    <div>
        <?php echo Layout::menuSuperior($usuario)?>
    </div>
    <div>
        
    </div>
    <div class='corCorpo corpo' align="center">
        <h3>Novo Livro</h3>
        <div style='width:650px'>
            <form action="../controller/livro.php" method='post'> 
                <div class='divisoria'>
                    <?php include_once 'form.php'; ?>
                </div>
                <br/>
                <input class="botaoVerde" name='query' value='Inserir Livro' type="submit"/>
                <br/><br/>
            </form>
        </div>
    </div>
</body>
</html>
