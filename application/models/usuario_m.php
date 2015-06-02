<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    
    function get_usuario($arrParam) {
        try {
            $arrResultado =  $this->db->query_sp('USUARIO_GET',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
}