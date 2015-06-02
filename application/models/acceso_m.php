<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acceso_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_empresa($arrParam) {

        try {
            $result = $this->db->get_where('MPC_TM_EMPRESA', $arrParam);
            $arrRecords = $result->row_array();

            return $arrRecords;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_tipo_empresa() {
        $this->load->library('dropdown');
        
        $arrCombo = array();

        $query = 'SELECT TipoId, DescripcionLargaTipo FROM MPC_TC_TIPO WHERE TipoPadreID = "COD000004"';
        
        $arrCombo = $this->dropdown->query_to_array($query);
        
        return $arrCombo;
    }
    
    function get_estado() {
        $this->load->library('dropdown');
        
        $arrCombo = array();

        $query = 'SELECT TipoId, DescripcionLargaTipo FROM MPC_TC_TIPO WHERE TipoPadreID = "COD000001"';
        
        $arrCombo = $this->dropdown->query_to_array($query);
        
        return $arrCombo;
    }

    function add_empresa($arrParam) {
        try {
            $this->db->insert('MPC_TM_EMPRESA', $arrParam);

            if ($this->db->affected_rows() == 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

    function upd_empresa($arrParam, $arrWhere) {

        try {
            $this->db->update('MPC_TM_EMPRESA', $arrParam, $arrWhere);
            
            if ($this->db->affected_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

}
