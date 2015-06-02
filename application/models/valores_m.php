<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class valores_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

 function get_valores() {
        
        $data = array(null); 

        $query = "GET_VALORES";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
    
  function get_total() {
        
        $data = array(null); 

        $query = "GET_TOTAL";
        
        $arrCombo = $this->db->query_sp($query, $data);
        
        $arrResultado = json_encode($arrCombo);
        
        return $arrResultado;
    }
  
// function get_max(){
//        $data = array (null);
//        
//        $query = "GET_MAX";
//        
//        $arrCombo = $this->db->query_sp($query , $data);
//        
//        $arrResultado = json_encode($arrCombo);
//        
//        return $arrResultado;
// }
}