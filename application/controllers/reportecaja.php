<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportecaja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('rptcaja');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('reportecaja_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'reportecaja';
        $arrMenu['mGroup'] = 'm_consultas';
        $arrMenu['mOption'] = 'm_consultas_03';
        $arrSesion['title'] = lang('rptcaja.title');

        $filtros = array(
            'fecha_ini'     => null,
            'fecha_fin'     => null,
            'caja'          => -1
        );
        
        $this->session->set_userdata('filtros', $filtros);
        
        // cargamos  la interfaz
        $arrSesion['arrCaja'] =  $this->reportecaja_m->get_caja();
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/reportecaja/reportecaja_list_v', $arrSesion);
        $this->load->view('includes/footer');
        
    }
    
    public function update_filtros($p_ini,$p_fin,$p_caja){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $ini = null;
        $fin = null;
        $caja = null;
        
        if($p_ini!= '-1'){
            $ini = $p_ini;
        }
        if($p_fin!= '-1'){
            $fin = $p_fin;
        }
        if($p_caja!= '-1'){
            $caja = $p_caja;
        }
        
        $filtros = array(
            'fecha_ini'     => $ini,
            'fecha_fin'     => $fin,
            'caja'          => $caja
        );
        
        $this->session->set_userdata('filtros', $filtros);
        
        echo('ini-'.$p_ini.' fin-'.$p_fin.' caja-'.$p_caja);
    }

    public function get_saldos_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'GET_SALDOS';
        
        $arrSesion = $this->session->userdata('filtros');
        $f_ini = $arrSesion['fecha_ini'];
        $f_fin = $arrSesion['fecha_fin'];
        $caja = $arrSesion['caja'];
        
        $arrParam = array($f_ini,$f_fin,$caja);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
        
    }
    
}


