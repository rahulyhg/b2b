<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adjuntarxrequisito_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    function get_requisito($arrParam){
        
        try {
            $result = $this->db->get_where('MPC_TM_REQUISITO', $arrParam);
            $arrRecords = $result->row_array();
            
            return $arrRecords;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
    
    function get_personas($arrParam) {
        
        $data = array(0, $this->_arr_Sesion["idContractor"], $arrParam['RequisitoId'], 2); //muestra: 
        $query = "MPC_TC_PERSONA_REQUISITO_GET";        
        $arrCombo = $this->db->dropdown($query, $data);
        
        return $arrCombo;
        
    }
    
    
    public function add_documento($arrParam)
    {
        try {
            $this->db->insert('MPC_TC_DOCUMENTO', $arrParam);

            if ($this->db->affected_rows() == 1) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return 0;
        }
    } 
    
    public function upd_persona_requisito($arrParam)
    {
        try {
                        
            return $this->db->simple_query('CALL MPC_TC_PERSONA_REQUISITO_MASIVO ('.
                                               $arrParam['PersonaRequisitoId'].',"'.    
                                               $arrParam['FlagMasivo'].'",'.
                                               $arrParam['DocumentoId'].')');
            
            
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
        
    }
    
}