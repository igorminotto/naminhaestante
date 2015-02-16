function deletarInput () {
    var linha = $(this).parent().parent();
    linha.remove();
}

function criaImagemDeletar() {
    var html = '<img style="position:relative; top:2px; cursor:pointer" '+
            'src="https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/Delete.png" '+
            ' class="botaoDeletar" alt="apagar">';
    return html;
}