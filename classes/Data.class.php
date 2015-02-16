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
    
    private $data;
    private $tipo;
    
    public function __construct($data) {
        $valido = $this->dataEhValida($data);
        if($valido) {
            $this->data = $valido;
        } else {
            $this->data = null; 
        }
    }
    
    public function getDataFormatBanco() {
        return $this->data->format('Y-m-d');
    }
    
    private function dataEhValida($data) {
        if(preg_match("`^(\d{2})//(\d{2})//(\d{4})$`", $data, $matches)) {
            var_dump($matches);
            $dataTmp = new DateTime;
            $dataTmp->setDate($matches[3], $matches[2], $matches[1]);
            if($dataTmp->format('d') !== $matches[1] ||
                    $dataTmp->format('m') !== $matches[2] ||
                    $dataTmp->format('Y') !== $matches[3]) {
                return false;
            }
            return $dataTmp;
        }
        return false;
    }
    
    public function __toString() {
        $this->getDataFormatBanco();
    }
}
