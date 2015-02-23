<?php
namespace classes;

use DateTime;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Data
 *
 * @author icm
 */
class Data {
    const ANO = 1;
    const ANO_MES = 2;
    const ANO_MES_DIA = 3;
    
    private $dataBanco;
    private $data;
    private $ano;
    private $mes;
    private $dia;
    private $tipo;
    
    public function __construct($data) {
        $valido = $this->dataEhValida($data);
        if($valido) {
            $this->data = $data;
            $this->dataBanco = $valido;
        } else {
            $valido = $this->dataBancoEhValida($data);
            if($valido) {
                $this->data = $valido;
                $this->dataBanco = $data;
            } else {
                $this->data = false; 
                $this->dataBanco = "";
            }
        }
        $valores = explode("-", $this->dataBanco);    
        switch(count($valores)) {
            case 3:
                $this->dia = $valores[2];
            case 2:
                $this->mes = $valores[1];
            case 1:
                $this->ano = $valores[0];
                break;
            default:
                $this->ano = null;
                $this->mes = null;
                $this->dia = null;
                $this->tipo = null;
        }
        $this->tipo = count($valores);
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function getDataFormatoBanco() {
        return $this->dataBanco;
    }
    
    private function dataEhValida($data) {
        if(preg_match("`^(\d{4})$`", $data, $matches)) {
            return "{$matches[1]}";
        }
        if(preg_match("`^(\d{2})/(\d{4})$`", $data, $matches)) {
            return "{$matches[2]}-{$matches[1]}";
        }
        if(preg_match("`^(\d{2})/(\d{2})/(\d{4})$`", $data, $matches)) {
            return "{$matches[3]}-{$matches[2]}-{$matches[1]}";
        }
        return false;
    }
    
    private function dataBancoEhValida($data) {
        if(preg_match("`^(\d{4})$`", $data, $matches)) {
            return "{$matches[1]}";
        }
        if(preg_match("`^(\d{4})-(\d{2})$`", $data, $matches)) {
            return "{$matches[2]}/{$matches[1]}";
        }
        if(preg_match("`^(\d{4})-(\d{2})-(\d{2})$`", $data, $matches)) {
            return "{$matches[3]}/{$matches[2]}/{$matches[1]}";
        }
        return false;
    }
    
    public function __toString() {
        return $this->getDataFormatoBanco();
    }
}
