<?php require_once '../autoloader.php';

use dao\GeneroDao;

$generoDao = new GeneroDao;

$generos = $generoDao->selecionaGeneros();
$descGeneros = array();
foreach($generos as $genero)
{
    $descGeneros[] = $genero->getDescricao();
}
$listaGeneros = '["'. implode('","', $descGeneros) . '"]';
?>
<table id="tabelaGeneros">
    <tr><td colspan="3" align="center"><b>Gêneros</b></td></tr>
</table>
<button type="button" id="adicionarGenero" class="botaoAdicionar">Adicionar Gênero</button>

<script src="../javascript/campos.js"></script>
<script>
    var generos = <?php echo $listaGeneros ?>;
    function geraEntradaGenero(del) {
        var html = '<tr><td class="labelForm">Gênero</td><td>'+
                '<input class="ui-widget inputGenero" size="50" name="generos[]" type="text"/>'+
                '</td><td class="buttonColumn">';
        if(del) {
            html += criaImagemDeletar();
        }
        html += '</td></tr>';
        $('#tabelaGeneros').append(html);
        $('.inputGenero').autocomplete({source:generos});
        $('.botaoDeletar').click(deletarInput);
    }
    $('#adicionarGenero').click(function() {
        geraEntradaGenero(true);
    });
    geraEntradaGenero(false);
</script>