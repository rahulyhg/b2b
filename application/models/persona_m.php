<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Persona_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_persona($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('PERSONA_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_monedas() {
        $data = array(null); //muestra:

        $query = "MONEDA_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_empresas() {
        $data = array(null,'2'); //muestra:

        $query = "EMPRESA_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    /*
    function get_cuentas() {
        $data = array(null); //muestra:

        $query = "CUENTA_DC_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    */
    
    function get_tipo() {
        
        $data = array(null,'3'); 

        $query = "CAJA_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_estado() {
        
        $data = array('EST'); 

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function add_caja($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('CAJA_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_caja($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CAJA_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_caja($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CAJA_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
