<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyecto_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_proyecto($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('PROYECTO_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_concepto() {
        
        $data = array(null,'2');
        $query = "CONCEPTO_GET";      
        $arrCombo = $this->db->dropdown($query, $data);        
        return $arrCombo;
    }
    
    function get_conceptos_activos($arrParam) {
        $query = "CONCEPTO_PROYECTO_GET";
        $arrCombo = $this->db->query_sp($query, $arrParam['id_proyecto']);
        $i = -1;
        foreach ($arrCombo as $value) {
            $tmp[++$i] = $value["id_concepto"];
        } 
        return $tmp;
    }
    
    function get_cuentas() {
        $data = array(null,'2'); //muestra:
        $query = "CUENTA_DC_GET";
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

    function add_proyecto($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('PROYECTO_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_proyecto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('PROYECTO_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function add_conceptos_activos($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CONCEPTO_PROYECTO_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_conceptos_activos($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CONCEPTO_PROYECTO_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_proyecto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('PROYECTO_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
