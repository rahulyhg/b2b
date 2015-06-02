<?php

/*
 * 
 * 
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    
    
   
    function get_listar_json($spName, $arrParam) {
        
        $arrCombo = $this->db->query_sp($spName, $arrParam);
        $arrResultado = json_encode($arrCombo);        
        return $arrResultado;
    }
    function get_dolares_en_dolares(){
        $data = array(NULL); //muestra:

        $query = "GET_DOLARES_EN_DOLARES";
        
        $arrCombo = $this->db->query_sp($query,$data);
        
        $arrResultado = ($arrCombo);
        
        return $arrResultado;
        
    }
    
        function get_dolares_en_soles(){
        $data = array(NULL); //muestra:

        $query = "GET_DOLARES_EN_SOLES";
        
        $arrCombo = $this->db->query_sp($query,$data);
        
        $arrResultado = ($arrCombo);
        
        return $arrResultado;
        }
        
        
                function get_soles_en_dolares(){
          $data = array(NULL); //muestra:

        $query = "GET_SOLES_EN_DOLARES";
        
        $arrCombo = $this->db->query_sp($query,$data);
        
        $arrResultado = ($arrCombo);
        
        return $arrResultado;
        }
        
        
                function get_soles_en_soles(){
          $data = array(NULL); //muestra:

        $query = "GET_SOLES_EN_SOLES";
        
        $arrCombo = $this->db->query_sp($query,$data);
        
        $arrResultado = ($arrCombo);
        
        return $arrResultado;
        }
//        function get_soles(){
//        $data = array('1'); //muestra:
//
//        $query = "GET_CANTIDAD";
//        
//        $arrCombo = $this->db->query_sp($query,$data);
//        
//        $arrResultado = ($arrCombo);
//        
//        return $arrResultado;
//        
//    }
//    
//        function get_cantidad_caajas(){
//              $data = array(null);
//            $query= "GET_CANTIDAD_CAJAS";
//            $arrCombo = $this->db->query_sp($query, $data);
//            $arrResuldato = ($arrCombo);
//            return $arrResuldato;
//        }
    
    
}