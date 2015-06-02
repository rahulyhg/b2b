<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Concepto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('concep');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('concepto_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'concepto';
        $arrMenu['mGroup'] = 'm_dsk';//'m_mae';
        $arrMenu['mOption'] = 'm_dsk';
        $arrSesion['title'] = lang('concep.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/main/main_v', $arrSesion);
        $this->load->view('includes/footer');
                
    }
                public function get_valores_list(){
                 if ($this->seguridad->sec_class(__METHOD__)) return;

                 $spName = 'GET_VALORES';
                 $arrParam = array(null,1);
                 $result = $this->base_m->get_listar_json($spName, $arrParam);
                 echo $result;
             } 
    
    }