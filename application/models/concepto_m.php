<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Concepto_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_concepto($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('CONCEPTO_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_tipo_concepto() {
        $data = array('COD0000004', '1'); //muestra:

        $query = "MPC_TC_TIPO_GET";
        
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

    function add_concepto($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('CONCEPTO_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_concepto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CONCEPTO_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_concepto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CONCEPTO_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }


}
