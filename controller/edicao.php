<?php require_once '../autoloader.php';

use classes\Data;
use controller\controladorDeSessao;
use dao\EdicaoDao;
use dao\EditoraDao;
use dao\LivroDao;
use model\Edicao;
use model\Editora;

$query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

$controlador = new controladorDeSessao();
$usuarioLogado = $controlador->selecionaUsuarioLogado();
$idUsuarioLogado = $usuarioLogado->getId();

$livroDao = new LivroDao;
$editoraDao = new EditoraDao;
$edicaoDao = new EdicaoDao;

switch ($query) {
    case 'Inserir':
        $titulos = filter_input(INPUT_POST, 'livros' , FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY);
        $livros = array();
        foreach ($titulos as $titulo) {
            $livros[] = current($livroDao->buscaLivro($titulo));
        }
        if(count($titulos) === 1) {
            $titulo = current($titulos);
        } 
        
        exit;
        $nomeDaEditora = filter_input(INPUT_POST, 'editora' , FILTER_SANITIZE_SPECIAL_CHARS);
        $editora = current($editoraDao->selecionaEditoras($nomeDaEditora));
        if(!$editora) {
            $editora = new Editora(null, $nomeDaEditora);
        }
        $anoDaEdicao = filter_input(INPUT_POST, 'anoDaEdicao' , FILTER_VALIDATE_INT);
        $numeroDePaginas = filter_input(INPUT_POST, 'numPaginas' , FILTER_VALIDATE_INT);
        $lingua = filter_input(INPUT_POST, 'lingua' , FILTER_SANITIZE_SPECIAL_CHARS);
        $edicao = new Edicao(null, $titulo, $editora, $lingua, $anoDaEdicao, $numeroDePaginas);
        
        $posicao = filter_input(INPUT_POST, 'posicao' , FILTER_SANITIZE_SPECIAL_CHARS);
        $edicao->addUsuarioDono($idUsuarioLogado, $posicao);
        
        $lido = filter_input(INPUT_POST, 'lido' , FILTER_VALIDATE_BOOLEAN);
        if($lido) {
            $dataInicio = new Data(filter_input(INPUT_POST, 'dataInicio'));
            $dataFim = new Data(filter_input(INPUT_POST, 'dataFim'));
            $edicao->addUsuarioLeitor($idUsuarioLogado, $dataInicio, $dataFim);
        }
        
        $edicao->addLivro($livro);
        
        $idEdicao = $edicaoDao->insereEdicao($edicao);
        
        header('Location: ../livros/home.php');
        break;
    case 'Default':
        break;
}
