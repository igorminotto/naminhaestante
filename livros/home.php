<?php
require_once '../autoloader.php';

use controller\controladorDeSessao;
use dao\EdicaoDao;
use Layout\Layout;
use model\Edicao;


$usuario = controladorDeSessao::selecionaUsuarioLogado();
$bd = new EdicaoDao;
$edicoes = $bd->selecionaEdicoes();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estante - Livros</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <script type="text/javascript" src="../jquery/jquery.min.js"></script>
</head>
<body>
    <div>
        <?php echo Layout::menuSuperior($usuario)?>
    </div>
    <div>
        
    </div>
    <div class='corCorpo corpo' align='center'>
        <?php if(empty($edicoes)) { 
            echo "<span class='erro'>Não existem livros cadastrados. "
            . "Insira o primeiro clicando <a href='../livros/novo.php'>aqui</a>.</span>";
            exit; 
        }?>
        <h3>Edições</h3>
        <table width='100%'>
            <tr>
                <td width='20%'>
                    
                </td>
                <td>
                    <?php 
                    /* @var $edicao Edicao */
                    foreach ($edicoes as $edicao) {
                        echo Layout::geraDivDaEdicao($edicao);
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
