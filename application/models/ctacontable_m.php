<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ctacontable_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_ctacontable($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('CTA_CONTABLE_GET',$arrParam);
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

    

    function add_ctacontable($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('CTA_CONTABLE_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_ctacontable($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CTA_CONTABLE_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function dlt_ctacontable($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('CTA_CONTABLE_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
