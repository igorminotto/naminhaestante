<?php require_once '../autoloader.php';

use classes\Data;
use controller\controladorDeSessao;
use dao\AutorDao;
use dao\EdicaoDao;
use dao\EditoraDao;
use dao\GeneroDao;
use dao\LivroDao;
use model\Autor;
use model\Edicao;
use model\Editora;
use model\Genero;
use model\Livro;

$query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

$controlador = new controladorDeSessao();
$usuarioLogado = $controlador->selecionaUsuarioLogado();
$idUsuarioLogado = $usuarioLogado->getId();

$livroDao = new LivroDao;
$autorDao = new AutorDao;
$generoDao = new GeneroDao;
$editoraDao = new EditoraDao;
$edicaoDao = new EdicaoDao;

switch ($query) {
    case 'Inserir Livro':
        $titulo  = filter_input(INPUT_POST, 'titulo' , FILTER_SANITIZE_SPECIAL_CHARS);
        $ano     = filter_input(INPUT_POST, 'ano'    , FILTER_VALIDATE_INT);
        $livro   = new Livro(null, $titulo, $ano);
        
        $autores = filter_input(INPUT_POST, 'autores', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY);
        foreach($autores as $nomeDoAutor) {
            $autor = current($autorDao->selecionaAutores($nomeDoAutor));
            if(!$autor) {
                $autor = new Autor(null, $nomeDoAutor);
            }
            $livro->addAutor($autor);
        }
        
        $generos = filter_input(INPUT_POST, 'generos', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY);
        foreach($generos as $descGenero) {
            $genero = current($generoDao->selecionaGeneros($descGenero));
            if(!$genero) {
                $genero = new Genero(null, $descGenero);
            }
            $livro->addGenero($genero);
        }
        
        $livro->setIdUsuario($idUsuarioLogado);
        $idLivro = $livroDao->insereLivro($livro);
        
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
