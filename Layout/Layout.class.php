<?php
namespace Layout;

use dao\UsuarioDao;
use model\Edicao;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author icm
 */
class Layout {
    static public function menuSuperior($usuario) {
        $menuDropdown = self::menuDrop();
        $menuAdiciona = self::menuAdiciona();
        $html = <<<END
<div class='corPadrao menuSuperior' style='height:58px;padding:2px'>
    <div style='padding:0px;margin-left:0px;padding:2px'>
        <table width='100%'><tr>
            <td width='40%' style='text-align: left;padding:2px' >
                <nav>
                $menuDropdown
                $menuAdiciona
                </nav>
            </td>
            <td width='20%' align='center'>
                <h3>Na Minha Estante</h3>
            </td>
            <td width='40%' style='text-align: right;'>
                <div style='margin-right:10px;'>
                Olá, {$usuario->getNome()}!&nbsp;&nbsp;&nbsp;
                <a href='../login.php'>Sair</a>
                </div>
            </td>         
        </tr></table>
    </div>
</div>
END;
        return $html;
    }
    
    static public function menuDrop() {
        $html = <<<END

    <ul class="menu">
        <li><a href="#"><div class='boxIcone'/></div><div class='boxIcone'/></div><div class='boxIcone'/></div></a>
            <ul>
                <li><a href="../livros/home.php">Principal</a></li> 
            </ul>
        </li>
    </ul>

END;
        return $html;
    }
    
        static public function menuAdiciona() {
        $html = <<<END

    <ul class="menu">
        <li><a href="#">
            <div class='boxIcone'         style='position:absolute;left: 12px;top: 17px;'/></div>
            <div class='boxIconeVertical' style='position:absolute;left: 25px;top:  4px;'/></div></a>
            <ul>
                <li><a href="../livros/novo.php"><span>+</span> Livro</a></li>                   
                <li><a href="../edicao/novo.php"><span>+</span> Edição</a></li>   
                <li><a href="#"><span>+</span> Autor</a></li>   
                <li><a href="#"><span>+</span> Gênero</a></li>   
                <li><a href="#"><span>+</span> Editora</a></li>   
            </ul>
        </li>
    </ul>

END;
        return $html;
    }
    
    private function geraLinhasLivros (Edicao $edicao) {
        if(count($edicao->getLivros()) === 1) {
            $livro = current($edicao->getLivros());
            
            $divs = "<tr style='background-color:#fcc;'>";
            $autores = $livro->getAutores();
            $divs .= "<td colspan='2'>Autorx(s): ".implode(', ', array_map(function($a){return $a->getNome();},$autores))."</td>";
            $divs .= "<td>Ano: {$livro->getAno()}</td>";
            $generos = $livro->getGeneros();
            $divs .= "<td>Gênero(s): ".implode(', ', array_map(function($g){return $g->getDescricao();},$generos))."</td>";
            $divs .= "</tr>";
        } else {
            $divs = "";
            $colors = array('#fcc','#cfc');
            $i = 0;
            foreach($edicao->getLivros() as $livro) {
                $divs .= "<tr style='background-color:{$colors[$i]};'>";
                $i = $i++ % 2;
                $autores = $livro->getAutores();
                $divs .= "<td>Livro: {$livro->getTitulo()}</td>";
                $divs .= "<td>Autorx(s): ".implode(', ', array_map(function($a){return $a->getNome();},$autores))."</td>";
                $divs .= "<td>Ano: {$livro->getAno()}</td>";
                $generos = $livro->getGeneros();
                $divs .= "<td>Gênero(s): ".implode(', ', array_map(function($g){return $g->getDescricao();},$generos))."</td>";
                $divs .= "</tr>";
            }
        }
        return $divs;
    }
    private function geraStringDonos (Edicao $edicao) {
        $usuarioDao = new UsuarioDao();
        $donos = array();
        foreach($edicao->getUsuariosDonos() as $idDono) {
            $donos[] = $usuarioDao->selecionaUsuario($idDono)->getNome();
        }
        return implode(', ', $donos);
    }
    private function geraStringLeitores (Edicao $edicao) {
        if(empty($edicao->getUsuariosLeitores())) {
            return "<span style='color:#777'>Nenhum</span>";
        }
        $usuarioDao = new UsuarioDao();
        $leitores = array();
        foreach($edicao->getUsuariosLeitores() as $idLeitor) {
            $nome = $usuarioDao->selecionaUsuario($idLeitor)->getNome();
            $leitores[] = $nome;
        }
        return implode(', ', $leitores);
    }
    function geraDivDaEdicao(Edicao $edicao) {
        $livros = self::geraLinhasLivros($edicao);
        $donos = self::geraStringDonos($edicao);
        $leitores = self::geraStringLeitores($edicao);
        echo <<<END
        <div style='padding:3px'><div class='divisoria' style='align:left'>
        <div style='text-align:left'>Título: <b>{$edicao->getTitulo()}</b></div>
        <div style=''><table width='100%'>
            {$livros}
            <tr>
                <td width='30%'>Editora: {$edicao->getEditora()->getNome()}</td>
                <td width='30%'>Idioma: {$edicao->getLingua()}</td>
                <td width='20%'>Ano de publicação: {$edicao->getAno()}</td>
                <td width='20%'>Número de Páginas: {$edicao->getNumeroDePaginas()}</td>
                
            </tr>
            <tr>
                <td colspan='1'>Donx(s): {$donos}</td>                
                <td colspan='3'>Leitorx(s): {$leitores}</td>                    
            </tr>
        </table></div>        
        </div></div>
END;
    }
    
    static function geraSelectBoxesData($nome) {
        $return = self::geraSelectBoxDia($nome);
        $return .= " / ".self::geraSelectBoxMes($nome);
        $return .= " / ".self::geraSelectBoxAno($nome);
        return $return;
    }
    private function geraSelectBoxDia($nome) {
        $valores = self::rangeWithKeys(1,31);
        return self::geraSelectBoxGenerico($valores, "dia$nome", 0, "Dia");
    }
    private function geraSelectBoxMes($nome) {
        $valores = self::rangeWithKeys(1,12);
        return self::geraSelectBoxGenerico($valores, "mes$nome", 0, "Mês");
    }
    private function geraSelectBoxAno($nome) {
        $valores = self::rangeWithKeys(date("Y"),1992);
        return self::geraSelectBoxGenerico($valores, "ano$nome", key($valores));
    }
    private function geraSelectBoxGenerico($valores, $nome, $chavePadrão=null, $valorPadrão=null) {
        $html = "<select name='$nome'>";
        if($chavePadrão !== null && !key_exists($chavePadrão, $valores)) {
            $html .= "<option value='$chavePadrão'>$valorPadrão</option>";
        }
        foreach ($valores as $chave => $valor) {
            $selected = ($chave == $chavePadrão)?"selected":"";
            $html .= "<option value='$chave' $selected>$valor</option>";
        }
        $html .= "</select>";
        return $html;
    }
    private function rangeWithKeys($begin, $end) {
        $rng = range($begin,$end);
        $values = array();
        foreach ($rng as $val) {
            $values[$val] = $val;
        } 
        return $values;
    }
}
