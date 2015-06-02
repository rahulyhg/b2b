<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cuentadc_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_cuentadc($arrParam) {
        try {
            $arrResultado =  $this->db->query_sp('CUENTA_DC_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_estado() {
        
        $data = array('EST'); 

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_empresa() {
        
        $data = array(null,'2'); 

        $query = "EMPRESA_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function add_cuentadc($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('CUENTA_DC_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_cuentadc($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CUENTA_DC_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_cuentadc($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CUENTA_DC_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
