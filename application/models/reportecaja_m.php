<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportecaja_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function get_saldos($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('GET_SALDOS',$arrParam);
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
    
}
