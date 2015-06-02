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

class Repmovdc extends CI_Controller {
    var $_arr_Sesion;
    
    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");

        $this->_arr_Sesion = $this->session->userdata('ses_usuario');
        $this->lang->load('generales');
        $this->lang->load('repmovdc');
        $this->load->helper('form');
        $this->load->helper('date');
        $this->load->library('form_validation');
        $this->load->model('repmovdc_m');
    }
    public function index() {
        
        // if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración   
        $arrSesion = $this->_arr_Sesion;
        
        $arrSesion['title'] = lang('rptmov.title');
        $arrMenu['mGroup'] = 'm_consultas';
        $arrMenu['mOption'] = 'm_consultas_10';
        $arraySesion['jsonCuentadc']     =  $this->repmovdc_m->get_cuentadc();
        $arrRpt = array(
            'arrCuentadc'    => -2,
            'fInicio'        => null,
            'fFin'           => null,
         );   
        $this->session->set_userdata('arrayrpt', $arrRpt);
        
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/repmovdc/repmovdc_list_v',$arraySesion);
        $this->load->view('includes/footer');        
    }
    

    public function view_movimiento(){
        // if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_transaccion' => $this->input->post('id'),
            'opcion'         => 2,
            'fechai'         => null,
            'fechaf'         => null
        );

        $result = $this->repmovdc_m->get_transaccion($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'                => $result[0]["id_transaccion"],
                'cb_tipo'               => $result[0]["Tipo_transaccion"],
                'txt_rendicion'         => $result[0]["rendicion"],
                'txt_fecha_registro'    => $result[0]["fecha_registro"],
                'txt_fecha_sistema'     => $result[0]["fecha_sistema"],
                'txt_tipo_cambio'       => $result[0]["tipo_cambio"],
                'txt_documento'         => $result[0]["documento"],
                'txt_importe'           => $result[0]["importe"],
                'txt_importedol'        => $result[0]["importedol"],
                'cb_caja'               => $result[0]["id_cajabanco"],
                'txt_nro_boucher'       => $result[0]["nro_boucher"],
                'cb_sproy'              => $result[0]["id_subcentroasignacion"],
                'cb_proy'               => (int)$result[0]["id_centro_asignacion"],
                'cb_sconcepto'          => $result[0]["id_subconsepto"],
                'cb_concepto'           => (int)$result[0]["id_concepto"],
                'txt_observacion'       => $result[0]["observacion"],
                'cb_empresa'            => $result[0]["id_empresa"],
                'txt_glosa'             => $result[0]["glosa"],
                'txt_cta_dr'            => $result[0]["id_cuecontable"],
                'txt_cta_dc'            => $result[0]["id_cuecontablecr"],
                'txt_fecha1'            => $result[0]["fecha_doc"],
                'txt_ndoc'              => $result[0]["nro_doc"],
                'txt_cta_dr2'           => $result[0]["id_cuecontablecc"],
                'txt_cta_dc2'           => $result[0]["id_cuecontablecccr"],
                'txt_fecha2'            => $result[0]["fecha_doccc"],
                'txt_glosa2'            => $result[0]["glosacc"]
            );
            
            $arrSesion['arrTipo'] = $this->repmovdc_m->get_tipo();
            $arrSesion['arrCaja'] = $this->repmovdc_m->get_caja();
            $arrSesion['arrSproyecto'] = $this->repmovdc_m->get_sproyecto();
            $arrSesion['arrProyecto'] = $this->repmovdc_m->get_proyecto();
            $arrSesion['arrSConcepto'] = $this->repmovdc_m->get_sconcepto();
            $arrSesion['arrConcepto'] = $this->repmovdc_m->get_concepto();
            $arrSesion['arrEmpresa'] = $this->repmovdc_m->get_empresa();
            $this->load->view('frontend/rptcajaemp/rptcajaemp_view_v', $arrSesion);
        }
    }
    
    public function load_reporte($cuentaID,$fecha_ini,$fecha_fin){
        // if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrRpt = array(
            'arrCuentadc'    => $cuentaID,
            'fInicio'    => $fecha_ini,
            'fFin'       => $fecha_fin,
         );   
        $this->session->set_userdata('arrayrpt', $arrRpt);
    }
             
    function get_repmovdc_list(){
    // if ($this->seguridad->sec_class(__METHOD__)) return;
    $arrSesion = $this->session->userdata('arrayrpt');
        
    $param1 = $arrSesion['arrCuentadc'];
    $param5 = $arrSesion['fInicio'];
    $param6 = $arrSesion['fFin'];

    if($param1 == '-1'){
        $param1 = NULL;    
    }
    if($param5 == 'SF'){
        $param5 = NULL;
    }
    if($param6 == 'SF'){
        $param6 = NULL;
    }

     $parametroGrid = array(
                            'p1' => $param1,
                            'fi' => $param5,
                            'ff' => $param6
     );
     $spName = 'REP_MOV_DC';     
     
     
     $out = $this->base_m->get_listar_json($spName, $parametroGrid);

     echo $out;

    }
    
    function get_repmovdc_sum(){
    // if ($this->seguridad->sec_class(__METHOD__)) return;
    $arrSesion = $this->session->userdata('arrayrpt');
    $param1 = $arrSesion['arrCuentadc'];
    $param5 = $arrSesion['fInicio'];
    $param6 = $arrSesion['fFin'];

    if($param1 == '-1'){
        $param1 = NULL;    
    }
    if($param5 == 'SF'){
        $param5 = NULL;
    }
    if($param6 == 'SF'){
        $param6 = NULL;
    }

     $parametroGrid = array(
                            'p1' => $param1,
                            'fi' => $param5,
                            'ff' => $param6
     );
     $spName = 'REP_MOV_DC_SUM'; 
      
     $outsum = $this->base_m->get_listar_json($spName, $parametroGrid);

     echo $outsum;
     
    }

}
