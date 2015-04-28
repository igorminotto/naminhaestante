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
    <?php 
    if(!isset($idLivro) || $idLivro <= 0) {
        echo <<<END
    <tr><td class="labelForm">Titulo da edição</td><td><input type="text" size='50' name='titulo' required/></td>
        <td width='20'></td></tr>
END;
    }
    ?>
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
            <div class='divisoria' style='height:120px;width:300px;text-align:center;line-height: 40px;'>
                De <?php echo Layout\Layout::geraSelectBoxesData("Inicio"); ?><br>
                até <?php echo Layout\Layout::geraSelectBoxesData("Fim"); ?><br>
                Ano em que foi lido: 
                <span id="divAnoLido">
                    <input type="text" name="anoLido" size="4" maxlength="4" value="" disabled/>
                </span>
            </div>
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
    
    function atualizaSelectAnoFim() {
        var d = new Date();
        var year = d.getFullYear();
        var html = "";
        for (i = year; i >= $("[name=anoInicio]").val(); i--) {
            html = html + "<option value='"+i+"'>"+i+"</option>";
        }
        $("[name=anoFim]").html(html);
        $("[name=anoFim]").val($("[name=anoInicio]").val());
    }
    function atualizaSelectAnoLido() {
        var html = "<select name='anoLido'>";
        for (i = $("[name=anoFim]").val(); i >= $("[name=anoInicio]").val(); i--) {
            html = html + "<option value='"+i+"'>"+i+"</option>";
        }
        html += "</select>";
        $("#divAnoLido").html(html);
        $("[name=anoLido]").val($("[name=anoFim]").val());
    }
    function atualizaAnoLido() {
        atualizaSelectAnoLido();
        if($("[name=anoInicio]").val() === $("[name=anoFim]").val()) {
            $('[name=anoLido]').prop("disabled",true);
        }
    }
    atualizaSelectAnoFim();
    atualizaAnoLido();
    $("[name=anoInicio]").change(function () {
        atualizaSelectAnoFim();
        atualizaAnoLido();
    });
    $("[name=anoFim]").change(function () {
        atualizaAnoLido();
    });
</script>
    