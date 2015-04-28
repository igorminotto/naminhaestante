<?php
require_once '../autoloader.php';

use controller\controladorDeSessao;
use dao\LivroDao;
use Layout\Layout;

$usuario = controladorDeSessao::selecionaUsuarioLogado();

$idLivro = filter_input(INPUT_GET, 'idLivro', FILTER_VALIDATE_INT);
if($idLivro) {
    $livroDao = new LivroDao;
    $livro = $livroDao->selecionaLivro($idLivro);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estante - Nova Edição</title>
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
        <h3>Nova Edição</h3>
        <div style='width:650px'>
            <form action="../controller/edicao.php" method='post'> 
                <div class='divisoria'>
                        
                    <?php include_once 'form.php' ?>    
                    
                    <div class="livros">
                        <?php 
                        if($idLivro) {
                            echo "<input type=\"hidden\" name=\"livros[]\" value=\"{$livro->getTitulo()}\">";
                        } else {
                            echo '<br/><br/><div style="text-align:center"><b>Livros</b></div>';
                            include_once '../livros/campo.php';
                            echo '<br><br>';
                        }
                        ?>      
                    </div>
                </div>
                <br/>
                <input class="botaoVerde" name='query' value='Inserir' type="submit"/>
                <br/><br/>
            </form>
            <script>

            </script>
        </div>
    </div>
</body>
</html>