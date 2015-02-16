<?php require_once '../autoloader.php';

use dao\AutorDao;

$autorDao = new AutorDao;

$autores = $autorDao->selecionaAutores();
$nomesDoAutores = array();
foreach($autores as $autor)
{
    $nomesDosAutores[] = $autor->getNome();
}
$listaAutores = '["'. implode('","', $nomesDosAutores) . '"]';
?>
<table id="tabelaAutores">
    <tr><td colspan="3" align="center"><b>Autores</b></td></tr>    
</table>
<button type="button" id="adicionarAutor" class="botaoAdicionar">Adicionar Autor</button>

<script src="../javascript/campos.js"></script>
<script>
    var autores = <?php echo $listaAutores ?>;
    function geraEntradaAutor(del) {
        var html = '<tr><td class="labelForm">Autor</td><td>'+
                '<input class="ui-widget inputAutor" size="50" name="autores[]" type="text"/>'+
                '</td><td class="buttonColumn">';
        if(del) {
            html += criaImagemDeletar();
        }
        html += '</td></tr>';
        $('#tabelaAutores').append(html);
        $('.inputAutor').autocomplete({source:autores});
        $('.botaoDeletar').click(deletarInput);
    }
    $('#adicionarAutor').click(function() {
        geraEntradaAutor(true);
    });
    geraEntradaAutor(false);
</script>