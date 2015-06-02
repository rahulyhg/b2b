<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporteproy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('rptproy');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('reporteproy_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'reporteproy';
        $arrMenu['mGroup'] = 'm_consultas';
        $arrMenu['mOption'] = 'm_consultas_04';
        $arrSesion['title'] = lang('rptproy.title');

        $filtros = array(
            'fecha_ini'     => null,
            'fecha_fin'     => null,
            'proy'          => -1
        );
        
        $this->session->set_userdata('filtros', $filtros);
        
        // cargamos  la interfaz
        $arrSesion['arrProy'] =  $this->reporteproy_m->get_proyecto();
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/reporteproy/reporteproy_list_v', $arrSesion);
        $this->load->view('includes/footer');
        
    }
    
    public function update_filtros($p_ini,$p_fin,$p_proy){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $ini = null;
        $fin = null;
        $proy = null;
        
        if($p_ini!= '-1'){
            $ini = $p_ini;
        }
        if($p_fin!= '-1'){
            $fin = $p_fin;
        }
        if($p_proy!= '-1'){
            $proy = $p_proy;
        }
        
        $filtros = array(
            'fecha_ini'     => $ini,
            'fecha_fin'     => $fin,
            'proy'          => $proy
        );
        
        $this->session->set_userdata('filtros', $filtros);
        
        echo('ini-'.$p_ini.' fin-'.$p_fin.' proy-'.$p_proy);
    }

    public function get_saldos_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'GET_SALDOS_PROY';
        
        $arrSesion = $this->session->userdata('filtros');
        $f_ini = $arrSesion['fecha_ini'];
        $f_fin = $arrSesion['fecha_fin'];
        $proy = $arrSesion['proy'];
        
        $arrParam = array($f_ini,$f_fin,$proy);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
        
    }
    
}

