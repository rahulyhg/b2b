    <?php

/*
 * Desarrollador    :   Cesar Mamani Dominguez
 * Fecha Creación   :   2013.06.28
 * 
 * Desarrollador    :   [Desarrollador]
 * Fecha Edición    :   [yyyy.mm.dd]
 * 
 * Descripción      :   metodos Reporte Movimiento Alternativo
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rptrem extends CI_Controller {
    var $arr_Sesion, $proyectoID, $conceptoID;
    
    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");

        $this->_arr_Sesion = $this->session->userdata('ses_usuario');
        $this->lang->load('generales');
        $this->lang->load('rptrem');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('rptrem_m');
    }
    public function index() {
        
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración   
        $arrSesion = $this->_arr_Sesion;
        
        $arrSesion['title'] = lang('rptrem.title');
        $arrMenu['mGroup'] = 'm_consultas';
        $arrMenu['mOption'] = 'm_consultas_08';
        $arrRpt = array(

            'RemInicio'    => null,
            'RemFin'       => null,
         );   
        $this->session->set_userdata('arrayrpt', $arrRpt);
        
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/rptrem/rptrem_list_v',$arrSesion);
        $this->load->view('includes/footer');        
    }

    
    public function load_reporte($rem_ini,$rem_fin){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrRpt = array(
            'RemInicio'    => $rem_ini,
            'RemFin'       => $rem_fin,
         );   
        $this->session->set_userdata('arrayrpt', $arrRpt);
    }
             
    function get_rptrem_list(){
    if ($this->seguridad->sec_class(__METHOD__)) return;
    $arrSesion = $this->session->userdata('arrayrpt');
    $param5 = $arrSesion['RemInicio'];
    $param6 = $arrSesion['RemFin'];

    if($param5 == 'SF'){
        $param5 = NULL;
    }
    if($param6 == 'SF'){
        $param6 = NULL;
    }

     $parametroGrid = array(
                            'fi' => $param5,
                            'ff' => $param6
     );
     $spName = 'REP_NUM_REM';     

     $out = $this->base_m->get_listar_json($spName, $parametroGrid);

     echo $out;

    }
    
 

}