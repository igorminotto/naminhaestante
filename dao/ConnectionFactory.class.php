<?php
namespace dao;

class ConnectionFactory {

    private $BANCO_DE_DADOS;
    private $USUARIO;
    private $SENHA;
    private $HOST;
    private $conexao;
    
    public function __construct() {
        $infoBD = parse_ini_file('/var/www/naminhaestante/config/bancoDeDados.ini');
        $this->BANCO_DE_DADOS = $infoBD['database'];
        $this->USUARIO = $infoBD['username'];
        $this->SENHA = $infoBD['password'];
        $this->HOST = $infoBD['hostname'];
        $this->conectar();
    }
    
    public function __destruct() {
        $this->desconectar();
    }

    protected function getLastId() {
        return mysql_insert_id($this->conexao);
    }
    
    private function conectar() {
        $this->conexao = mysql_connect($this->HOST, $this->USUARIO, $this->SENHA, true) or trigger_error(mysql_error(), E_USER_ERROR);
        mysql_select_db($this->BANCO_DE_DADOS, $this->conexao);
    }

    private function desconectar() {
        mysql_close($this->conexao);
    }
    
    public function executaQuery($sqlQuery, $ignorarErros = false) {
        //echo "$sqlQuery<br/><br/>";
        if ($ignorarErros) {
	   $queryResult = mysql_query($sqlQuery, $this->conexao);
        } else {
	   $queryResult = mysql_query($sqlQuery, $this->conexao) or die(mysql_error());
        }
        return $queryResult;
    }
    
}