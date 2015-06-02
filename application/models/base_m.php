<?php

/*
 * Autor            : Jonathan Ascencio
 * Fecha Creación   : 02/04/2013
 * Descripción      : Modelo Base para interactuar con la base datos
 * 
 * Autor            : [Autor]
 * Fecha Revisión   : [dd/mm/yyyy]
 * Descripción      : [Resumen]
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Base_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function set_grabar_json($spName, $arrParam) {
        
        try {
            $arrLista = $this->db->query_sp($spName, $arrParam);
            $arrResultado = json_encode($arrLista);
            if ($arrResultado == null) 
                return true;
            else
                return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }
    
    function get_listar_json($spName, $arrParam) {
        
        $arrLista = $this->db->query_sp($spName, $arrParam);

        $arrResultado = json_encode($arrLista);
        
        return $arrResultado;
    }

}
