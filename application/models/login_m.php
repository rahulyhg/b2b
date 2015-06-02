<?php

/*
 * Autor            : Jonathan Ascencio
 * Fecha Creación   : 07/01/2013
 * Descripción      : Valida si existe el usuario en la base datos
 * 
 * Autor            : [Autor]
 * Fecha Revisión   : [dd/mm/yyyy]
 * Descripción      : [Resumen]
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function login($array) {
        //$array['password']  = sha1(md5($array['password']));

        $arrParam = array( $array['user'], $array['password'], '1' );
        $consulta = $this->db->query_sp("MPC_TM_USUARIO_VALID", $arrParam);
        
        if (count($consulta) == 1) {
                $array = array();
                $array['profile']       = $consulta[0]["PerfilId"];
                $array['user']          = $consulta[0]["UsuarioId"];
                $array['userName']      = $consulta[0]["UsuarioNombre"];
                $array['idCompany']     = 1;
                //$consulta[0]["EmpresaId"];
                $array['company']       = 'Adexus';//$consulta[0]["Empresa"];
                //$array['idContractor']  = $consulta[0]["ContratistaId"];
                $array['contractor']    = 'Adexus';//$consulta[0]["Contratista"];
        }
        
        $arrResultado = array(
                'valid'     => count($consulta),
                'infoUser'  => $array
        );
        
        return $arrResultado;
    }
    
    function get_ultima_fecha() {
        try {
            $data = array(null);
            $arrResultado =  $this->db->query_sp('GET_ULTIMA_FECHA',$data);
            return $arrResultado;
        } catch (Exception $e) {
            throw new Exception('Error Inesperado');
        }
    }

}
