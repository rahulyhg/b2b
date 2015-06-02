<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporteproy_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function get_saldos($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('GET_SALDOS_PROY',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_proyecto() {
        $data = array(null,2); //muestra:

        $query = "PROYECTO_GET";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
}

