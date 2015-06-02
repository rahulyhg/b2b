<?php

/*
 * Desarrollador    :   
 * Fecha Creación   :   
 * 
 * Desarrollador    :   [Desarrollador]
 * Fecha Edición    :   [yyyy.mm.dd]
 * 
 * Descripción      :   metodos reporte saldo por mes
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rptsaldosxmes extends CI_Controller {
    var $_arr_Sesion;
    
    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");

        $this->_arr_Sesion = $this->session->userdata('ses_usuario');
        $this->lang->load('generales');
        $this->lang->load('rptsaldosxmes');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('rptsaldosxmes_m');
    }
    public function index() {
        
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración   
        $arrSesion = $this->_arr_Sesion;
        
        $arrSesion['title'] = lang('rptsaldosxmes.title');
        $arrMenu['mGroup'] = 'm_consultas';
        $arrMenu['mOption'] = 'm_consultas_09';
        $arrRpt = array(
            'fecha'       => null,
         );   
        $this->session->set_userdata('arrayrpt', $arrRpt);
        
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/rptsaldosxmes/rptsaldosxmes_list_v');
        $this->load->view('includes/footer');        
    }
    
    function get_proyectos(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array(null,2);
        $objmovimiento = new $this->rptcajaemp_m;
        $str = $objmovimiento->get_proyectos($arrParam);
        return json_encode($str);
    }
    
    function get_conceptos(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array(null,2);
        $objtransaccion = new $this->rptcajaemp_m;
        $str = $objtransaccion->get_conceptos($arrParam);
        return json_encode($str);
    }
    
    function get_cajas(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array(null,2);
        $objmovimiento = new $this->rptcajaemp_m;
        $str = $objmovimiento->get_cajas($arrParam);
        return json_encode($str);
    }
    public function load_reporte($p_fecha){
        
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrRpt = array(
            'fecha'       => $p_fecha,
         );   
        $this->session->set_userdata('arrayrpt', $arrRpt);
        
        echo($p_fecha);
    }
             
    function get_reportemov_list(){
        
    if ($this->seguridad->sec_class(__METHOD__)) return;
    $arrSesion = $this->session->userdata('arrayrpt');
    $param1 = $arrSesion['fecha'];

    if($param1 == '-1'){
        $param1 = NULL;    
    }

     $parametroGrid = array(
                            'p1' => $param1
     );
     $spName = 'GET_SALDOSXMES'; 

     $out = $this->base_m->get_listar_json($spName, $parametroGrid);

     echo $out;

    }
             
    function get_reportemov_list2(){
    if ($this->seguridad->sec_class(__METHOD__)) return;
    $arrSesion = $this->session->userdata('arrayrpt');
    $param1 = $arrSesion['fecha'];

    if($param1 == '-1'){
        $param1 = NULL;    
    }
     $parametroGrid = array(
                            'p1' => $param1
     );
     $spName = 'GET_SALDOSXMES2'; 
     $out = $this->base_m->get_listar_json($spName, $parametroGrid);
     echo $out;

    }
}
