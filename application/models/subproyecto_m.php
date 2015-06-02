<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subproyecto_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_subproyecto($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('SUBPROYECTO_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }    
    function get_proyectos() {
        $data = array(null,2); //muestra:

        $query = "PROYECTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_cuentas() {
        $data = array(null); //muestra:

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

    function get_tipocuenta() {
        
        $data = array('CUE'); 

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function add_subproyecto($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('SUBPROYECTO_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_subproyecto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('SUBPROYECTO_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_subproyecto($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('SUBPROYECTO_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
