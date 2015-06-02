<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subconcepto_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_subconcepto($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('SUBCONCEPTO_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
        
    }
    function get_conceptos() {
        $data = array(null,2); //muestra:

        $query = "CONCEPTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    /*function get_tipo_subconcepto() {
        $data = array('COD0000004'); //Agregar codigos de tipo de subconcepto:

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }*/
    
    function get_estado() {
        
        $data = array('EST'); 

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function add_sconcepto($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('SUBCONCEPTO_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_subconcepto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('SUBCONCEPTO_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_subconcepto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('SUBCONCEPTO_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
