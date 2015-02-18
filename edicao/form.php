<?php require_once '../autoloader.php';

use dao\EditoraDao;

$editoraDao = new EditoraDao;

$editoras = $editoraDao->selecionaEditoras();
$nomesEditoras = array();
foreach($editoras as $editora)
{
    $nomesEditoras[] = $editora->getNome();
}
$listaEditoras = '["'. implode('","', $nomesEditoras) . '"]';
?>
<table id="tabelaEdicao">
    <tr><td class="labelForm">Titulo da editora</td><td><input type="text" size='50' name='titulo' required/></td>
        <td width='20'></td></tr>
    <tr><td class="labelForm">Editora</td><td><input type="text" size='50' name='editora' required/></td>
        <td width='20'></td></tr>
    <tr><td class="labelForm">Língua</td><td><input type="text" size='20' name='lingua' /></td>
        <td width='20'></td></tr>
    <tr><td class="labelForm">Ano da publicação</td><td><input type="text" maxlength='4' max='2100' min='0' size='4' name='anoDaEdicao' /></td>
        <td></td></tr>
    <tr><td class="labelForm">Número de páginas</td><td><input type="text" maxlength='4' max='2100' min='0' size='4' name='numPaginas' /></td>
        <td width='20'></td></tr>
</table>
<br/>

<table id="tabelaPosicao">
    <tr><td class="labelForm">Posição</td><td><input type="text" size='50' name='posicao' /></td>
        <td width='20'></td></tr>
</table>    

<table id="tabelaLido">
    <tr><td class="labelForm">Lido</td>
        <td width='100'><input type="radio" size='50' name='lido' value='true' >Sim</td>
        <td width='335'><input type="radio" size='50' name='lido' value='false' checked>Não</td></tr>
    <tr id='datas' style="display:none"><td></td><td colspan="2">
            <div class='divisoria' style='height:40px;width:370px;text-align:center;line-height: 40px;'>
            De&nbsp;<input style="width:135px" name='dataInicio' type="date">&nbsp;
            até&nbsp;<input style="width:135px" name='dataFim' type="date"></div>
        </td>
    </tr>
</table>

<script>
    var editoras = <?php echo $listaEditoras ?>;
    $('[name=editora]').autocomplete({source:editoras});

    $('[name=lido]').change(function () {
       if($(this).val() === 'true') {
           $('#datas').show();
       } else {
           $('#datas').hide();
       }
    });
</script>
    