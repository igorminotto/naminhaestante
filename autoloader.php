<?php  

function autoload($Class) {
    $raiz = '/var/www/estante/';
    // nome completo da classe
    $nomeCompleto = str_replace('\\', '/', $Class);
    // se está tentando carregar uma classe da Monolog
    if (preg_match('/Monolog/', $nomeCompleto)){
        $caminhoPraClasse = $raiz.'vendor/monolog/monolog/src/'.$nomeCompleto.'.php';
    }else if (preg_match('/PhpOffice\/PhpWord/', $nomeCompleto)){
        $nomeCompleto = preg_replace('/PhpOffice\//', "" ,$nomeCompleto);
        $caminhoPraClasse = $raiz.'vendor/phpoffice/phpword/src/'.$nomeCompleto.'.php';
    }else if (preg_match('/Psr/', $nomeCompleto)){
        $caminhoPraClasse = $raiz.'vendor/psr/log/'.$nomeCompleto.'.php';
    }else if (preg_match('/testes/', $nomeCompleto)){ // testes não têm extensão '.class'
        $caminhoPraClasse = $raiz.$nomeCompleto.'.php';
    }else {
        $caminhoPraClasse = $raiz.$nomeCompleto.'.class.php';
    }
    if (file_exists($caminhoPraClasse)){
        require_once $caminhoPraClasse;
    }
}

spl_autoload_register('autoload');