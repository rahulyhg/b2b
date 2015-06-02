<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Asiento_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function add_asiento($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('TRANSACCION_AGR_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_asiento($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('TRANSACCION_AGR_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_asiento($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('TRANSACCION_AGR_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }
    
    function transfer_asiento($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('NUEVA_TRANSACCION_AGR_TRANSFER',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }
    
    function get_asiento($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('TRANSACCION_AGR_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_transaccion($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('NUEVA_TRANSACCION_AGRUP_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_caja() {
        $data = array(null,2); //muestra:

        $query = "CAJA_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function get_sproyecto() {
        $data = array(null,2); //muestra:

        $query = "SUBPROYECTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function get_proyecto() {
        $data = array(null,2); //muestra:

        $query = "PROYECTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_sconcepto() {
        $data = array(null,'2'); //muestra:

        $query = "SUBCONCEPTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_concepto() {
        $data = array(null,'2'); //muestra:

        $query = "CONCEPTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_empresa() {
        $data = array(null,'2'); //muestra:

        $query = "EMPRESA_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
    function get_tipo() {
        
        $data = array('TRA'); 

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }

    function add_transaccion($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('NUEVA_TRANSACCION_AGRUP_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }
    function upd_transaccion($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('NUEVA_TRANSACCION_AGRUP_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }
    function dlt_transaccion($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('NUEVA_TRANSACCION_AGRUP_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
