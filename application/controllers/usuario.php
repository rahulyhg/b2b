<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('user');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('date');
        $this->load->model('usuario_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'usuario';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_10';
        
        $arrSesion['title'] = lang('user.title');
//        cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/usuario/usuario_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }
    
    
    
    
    public function get_usuario_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'USUARIO_GET';
        $arrParam = array(null);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
}