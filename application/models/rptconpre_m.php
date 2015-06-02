<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rptconpre_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
        
    function get_transaccion($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('NUEVA_TRANSACCION_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
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
    function get_tipo() {
        
        $data = array('TRA'); 

        $query = "TIPO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    function get_caja() {
        $data = array(null,2); //muestra:

        $query = "CAJA_GET";
        
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
    function get_proyectos($arrParam) {
        try{    
            $result = $this->db->query_sp('PROYECTO_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }
    }
       
    function get_cajas($arrParam) {
        try{
            $result = $this->db->query_sp('CAJA_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }
    }
    
    function get_subproyectos($arrParam) {
        try{
            $result = $this->db->query_sp('SUBPROYECTO_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }
    }  
    
    function get_conceptos($arrParam) {        
        try{
            $result = $this->db->query_sp('CONCEPTO_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }
    }
    
    function get_subconceptos($arrParam) {
        try{
            $result = $this->db->query_sp('SUBCONCEPTO_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }
    }
    
    function get_subproyecto_by_proyecto($arrParam) {
      try{
            $result = $this->db->query_sp('SUBPROYECTO_X_PROYECTO_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }  
    }
    
    function get_subconcepto_by_concepto($arrParam) {
      try{
            $result = $this->db->query_sp('SUBCONCEPTO_X_CONCEPTO_GET',$arrParam);
            return $result;  
        }catch(Exception $e){
            throw new Exception("Error Inesperado",0,$e);
        }  
    }
}