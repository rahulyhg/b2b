<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perfil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('prof');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('perfil_m');
    }
    
    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'perfil';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_11';
        $arrSesion['title'] = lang('prof.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/perfil/perfil_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }
    
    public function get_perfil_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'PERFIL_GET';
        $arrParam = array(null);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
}