<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class tipo_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_tipo($arrParam) {

        try {
            $arrResultado =  $this->db->query_sp('TIPO_GET2',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }
     function get_padre() {
        $data = array(null,'2'); //muestra:
        $query = "TIPO_GET2";
        $arrCombo = $this->db->query_sp($query, $data);
        $arrResultado = json_encode($arrCombo);

        return $arrResultado;
    }
//    function get_conceptos_activos($arrParam) {
//        $query = "CONCEPTO_PROYECTO_GET";
//        $arrCombo = $this->db->query_sp($query, $arrParam['id_proyecto']);
//        $i = -1;
//        foreach ($arrCombo as $value) {
//            $tmp[++$i] = $value["id_concepto"];
//        } 
//        return $tmp;
//    }
    

//    
        function get_estado() {
       
        $data = array('EST'); 
        $query = "TIPO_GET";
        $arrCombo = $this->db->query_sp($query, $data);
        $arrResultado = json_encode($arrCombo);
        return $arrResultado;
    }

    function add_tipo($arrParam) {
        try {
            $arrResultado = $this->db->query_sp('TIPO_INSERT',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        }
    }

   function upd_tipo($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('TIPO_UPDATE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
       }
    }
//    function add_conceptos_activos($arrParam) {
//
//       try {
//            $arrResultado = $this->db->query_sp('CONCEPTO_PROYECTO_INSERT',$arrParam);
//           return $arrResultado;
//        } catch (Exception $e) {
//           throw new Exception('Error Inesperado', 0, $e);
//           return FALSE;
//        }
//    }

//   function upd_conceptos_activos($arrParam) {
//
//        try {
//            $arrResultado = $this->db->query_sp('CONCEPTO_PROYECTO_UPDATE',$arrParam);
//            return $arrResultado;
//        } catch (Exception $e) {
//            throw new Exception('Error Inesperado', 0, $e);
//            return FALSE;
//        }
//    }

    function dlt_tipo($arrParam) {

        try {
            $arrResultado = $this->db->query_sp('TIPO_DELETE',$arrParam);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado', 0, $e);
            return FALSE;
        } 

            }
}
