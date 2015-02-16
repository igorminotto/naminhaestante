<?php require_once '../autoloader.php';

use dao\LivroDao;
use model\Livro;

$livroDao = new LivroDao;

$livros = $livroDao->selecionaLivros();
$nomesDoLivros = array();
/* @var $livro Livro */
foreach($livros as $idLivro => $livro)
{
    $titulosDosLivros[$idLivro] = $livro->getTitulo();
}
$listaLivros = '["'. implode('","', $titulosDosLivros) . '"]';
?>
<table id="tabelaLivros">
</table>
<button type="button" id="adicionarLivro" class="botaoAdicionar">Adicionar Livro</button>

<script src="../javascript/campos.js"></script>
<script>
    var livros = <?php echo $listaLivros ?>;
    function geraEntradaLivro(del) {
        var html = '<tr><td class="labelForm">Livro</td><td>'+
                '<input class="ui-widget inputLivro" size="50" name="livros[]" type="text"/>'+
                '</td><td class="buttonColumn">';
        if(del) {
            html += criaImagemDeletar();
        }
        html += '</td></tr>';
        $('#tabelaLivros').append(html);
        $('.inputLivro').autocomplete({source:livros});
        $('.botaoDeletar').click(deletarInput);
    }
    $('#adicionarLivro').click(function() {
        geraEntradaLivro(true);
    });
    geraEntradaLivro(false);
</script>