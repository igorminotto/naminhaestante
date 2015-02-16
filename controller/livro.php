<?php require_once '../autoloader.php';

use controller\controladorDeSessao;
use dao\AutorDao;
use dao\GeneroDao;
use dao\LivroDao;
use model\Autor;
use model\Genero;
use model\Livro;

$query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_SPECIAL_CHARS);

$controlador = new controladorDeSessao();
$usuarioLogado = $controlador->selecionaUsuarioLogado();
$idUsuarioLogado = $usuarioLogado->getId();

$livroDao = new LivroDao;
$autorDao = new AutorDao;
$generoDao = new GeneroDao;

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
        
        header('Location: ../edicao/novo.php?idLivro='.$idLivro);
        break;
    case 'Default':
        break;
}
