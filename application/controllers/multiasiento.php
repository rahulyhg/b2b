<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Multiaciento extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('multi');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('multiasiento_m');
    }

    public function index() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'multiasiento';
        $arrMenu['mGroup'] = 'm_datos';
        $arrMenu['mOption'] = 'm_datos_02';
        $arrSesion['title'] = lang('multi.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/multiasiento/multiasiento_list_v', $arrSesion);
        $this->load->view('includes/footer');
        
    }
    
    public function new_multiasiento(){
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrSesion['title'] = lang('multi.new_title');
        $this->load->view('frontend/multiasiento/persona_requisito_list_v', $arrSesion);
    }
    
    public function edit_multiasiento(){
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        
    }
    
    public function get_multiasiento_list(){
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'NUEVA_TRANSACCION_GET';
        
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
        
    }
    
    public function add_multiasiento(){
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        
    }
    
    public function upd_multiasiento(){
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        
    }

    public function new_transaccion() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        //$result = $this->transaccion_m->get_rendicion();
        $arrSesion = array(
            'fecha_sistema' => date('Y/m/d'),
            //'rendicion'     => $result[0]["rendicion"]
        );//date('Y-m-d H:m:s') );
        $arrSesion['arrTipo'] = $this->transaccion_m->get_tipo();
        $arrSesion['arrCaja'] = $this->transaccion_m->get_caja();
        $arrSesion['arrSproyecto'] = $this->transaccion_m->get_sproyecto();
        $arrSesion['arrProyecto'] = $this->transaccion_m->get_proyecto();
        $arrSesion['arrSConcepto'] = $this->transaccion_m->get_sconcepto();
        $arrSesion['arrConcepto'] = $this->transaccion_m->get_concepto();
        $arrSesion['arrEmpresa'] = $this->transaccion_m->get_empresa();
        $this->load->view('frontend/transaccion/transaccion_new_v', $arrSesion);
    }

    public function edit_transaccion() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_transaccion' => $this->input->post('id'),
            'opcion'         => 2,
            'fechai'         => null,
            'fechaf'         => null
        );

        $result = $this->transaccion_m->get_transaccion($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'                => $result[0]["id_transaccion"],
                'cb_tipo'               => $result[0]["Tipo_transaccion"],
                'txt_rendicion'         => $result[0]["rendicion"],
                'txt_fecha_registro'    => date("Y/m/d", strtotime($result[0]["fecha_registro"])),
                'txt_fecha_sistema'     => date("Y/m/d", strtotime($result[0]["fecha_sistema"])),
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
            
            $arrSesion['arrTipo'] = $this->transaccion_m->get_tipo();
            $arrSesion['arrCaja'] = $this->transaccion_m->get_caja();
            $arrSesion['arrSproyecto'] = $this->transaccion_m->get_sproyecto();
            $arrSesion['arrProyecto'] = $this->transaccion_m->get_proyecto();
            $arrSesion['arrSConcepto'] = $this->transaccion_m->get_sconcepto();
            $arrSesion['arrConcepto'] = $this->transaccion_m->get_concepto();
            $arrSesion['arrEmpresa'] = $this->transaccion_m->get_empresa();
            $this->load->view('frontend/transaccion/transaccion_edit_v', $arrSesion);
        }
    }
    
    public function remove_transaccion() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_transaccion' => $this->input->post('id'),
            'opcion'         => 2,
            'fechai'         => null,
            'fechaf'         => null
        );

        $result = $this->transaccion_m->get_transaccion($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'                => $result[0]["id_transaccion"],
                'cb_tipo'               => $result[0]["Tipo_transaccion"],
                'txt_rendicion'         => $result[0]["rendicion"],
                'txt_fecha_registro'    => date("Y/m/d", strtotime($result[0]["fecha_registro"])),
                'txt_fecha_sistema'     => date("Y/m/d", strtotime($result[0]["fecha_sistema"])),
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
            
            $arrSesion['arrTipo'] = $this->transaccion_m->get_tipo();
            $arrSesion['arrCaja'] = $this->transaccion_m->get_caja();
            $arrSesion['arrSproyecto'] = $this->transaccion_m->get_sproyecto();
            $arrSesion['arrProyecto'] = $this->transaccion_m->get_proyecto();
            $arrSesion['arrSConcepto'] = $this->transaccion_m->get_sconcepto();
            $arrSesion['arrConcepto'] = $this->transaccion_m->get_concepto();
            $arrSesion['arrEmpresa'] = $this->transaccion_m->get_empresa();
            $this->load->view('frontend/transaccion/transaccion_remove_v', $arrSesion);
        }
    }
    
    public function get_transaccion_list(){
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'NUEVA_TRANSACCION_GET';
        
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
        
    }
    
    public function add_transaccion() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'cb_tipo',
                'label' => lang('transac.tipo'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_fecha_registro',
                'label' => lang('transac.freg'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_tipo_cambio',
                'label' => lang('transac.tcambio'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_importe',
                'label' => lang('transac.soles'),
                'rules' => 'required|trim|numeric'
            ),
            /*array(
                'field' => 'txt_rendicion',
                'label' => lang('transac.rendicion'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_documeto',
                'label' => lang('transac.docu'),
                'rules' => 'required|trim'
            ),*/
            array(
                'field' => 'txt_importedol',
                'label' => lang('transac.dolares'),
                'rules' => 'required|trim|numeric'
            ),
            array(
                'field' => 'cb_caja',
                'label' => lang('transac.caja'),
                'rules' => 'required|trim'
            ),
            /*array(
                'field' => 'txt_nro_boucher',
                'label' => lang('transac.cheque'),
                'rules' => 'required|trim'
            ),*/
            array(
                'field' => 'cb_caja',
                'label' => lang('transac.caja'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_sproy',
                'label' => lang('transac.sproy'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_proy',
                'label' => lang('transac.proy'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_sconcepto',
                'label' => lang('transac.sconcepto'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_concepto',
                'label' => lang('transac.concepto'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_empresa',
                'label' => lang('transac.empresa'),
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($config);

        //Reglas
        $this->form_validation->set_message('required', lang('valid.msgfield').' %s '.lang('valid.required'));
        $this->form_validation->set_message('min_length', lang('valid.msgfield').' %s '.lang('valid.min').' %s '.lang('valid.char'));
        $this->form_validation->set_message('max_length', lang('valid.msgfield').' %s '.lang('valid.max').' %s '.lang('valid.char'));
        $this->form_validation->set_message('numeric', lang('valid.msgfield').' %s '.lang('valid.numeric'));
        
        if (!$this->form_validation->run()) {

            foreach ($config as $v1) {
                foreach ($v1 as $k => $v) {
                    $mensaje = form_error($v);
                    if ($mensaje != "") {
                        break 2;
                    }
                }
            }
            $arrMessage['mensaje'] = $mensaje;
        } else {
            $fecha1 = $this->input->post('txt_fecha1');
            $fecha2 = $this->input->post('txt_fecha2');
            if($fecha1==''){
                $fecha1 = null;
            }
            if($fecha2==''){
                $fecha2 = null;
            }
            $tipo = $this->input->post('cb_tipo');
            $importe = $this->input->post('txt_importe');
            $importedol = $this->input->post('txt_importedol');
            if($tipo=='Ingreso'){
                $importe = abs($importe);
                $importedol = abs($importedol);
            }
            if($tipo=='Egreso'){
                $importe = (abs($importe))*(-1);
                $importedol = (abs($importedol))*(-1);
            }
            //$arrSesion = $this->session->userdata('ses_usuario');
            $data = array(
                'Tipo_transaccion'      => $this->input->post('cb_tipo'),
                'rendicion'             => $this->input->post('txt_rendicion'),
                'fecha_registro'        => date("Y-m-d", strtotime($this->input->post('txt_fecha_registro'))),
                'fecha_sistema'         => date('Y-m-d'),
                'documento'             => $this->input->post('txt_documento'),
                'tipo_cambio'           => $this->input->post('txt_tipo_cambio'),
                'importe'               => $importe,
                'importedol'            => $importedol,
                'id_cajabanco'          => $this->input->post('cb_caja'),
                'nro_boucher'           => $this->input->post('txt_nro_boucher'),
                'id_subcentroasignacion'=> $this->input->post('cb_sproy'),
                'id_centro_asignacion'  => $this->input->post('cb_proy'),
                'id_subconsepto'        => $this->input->post('cb_sconcepto'),
                'id_consepto'           => $this->input->post('cb_concepto'),
                'observacion'           => $this->input->post('txt_observacion'),
                'id_empresa'            => $this->input->post('cb_empresa'),
                'glosa'                 => $this->input->post('txt_glosa'),
                'id_cuecontable'        => $this->input->post('txt_cta_dr'),
                'id_cuecontablecr'      => $this->input->post('txt_cta_dc'),
                'fecha_doc'             => $fecha1,
                'nro_doc'               => $this->input->post('txt_ndoc'),
                'id_cuecontablecc'      => $this->input->post('txt_cta_dr2'),
                'id_cuecontablecccr'    => $this->input->post('txt_cta_dc2'),
                'fecha_doccc'           => $fecha2,
                'glosacc'               => $this->input->post('txt_glosa2')
            );
            //
            //$arrSesion['rendicion']= $this->input->post('txt_rendicion');
            try {
                $result = $this->transaccion_m->add_transaccion($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        //$arrMessage['mensaje'] = 'add transaccion';
        echo $arrMessage['mensaje'];
    }
    
    public function upd_transaccion() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'cb_tipo',
                'label' => lang('transac.tipo'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_fecha_registro',
                'label' => lang('transac.freg'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_tipo_cambio',
                'label' => lang('transac.tcambio'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_importe',
                'label' => lang('transac.soles'),
                'rules' => 'required|trim|numeric'
            ),
            /*array(
                'field' => 'txt_rendicion',
                'label' => lang('transac.rendicion'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'txt_documeto',
                'label' => lang('transac.docu'),
                'rules' => 'required|trim'
            ),*/
            array(
                'field' => 'txt_importedol',
                'label' => lang('transac.dolares'),
                'rules' => 'required|trim|numeric'
            )
        );
        $this->form_validation->set_rules($config);

        //Reglas
        $this->form_validation->set_message('required', lang('valid.msgfield').' %s '.lang('valid.required'));
        $this->form_validation->set_message('min_length', lang('valid.msgfield').' %s '.lang('valid.min').' %s '.lang('valid.char'));
        $this->form_validation->set_message('max_length', lang('valid.msgfield').' %s '.lang('valid.max').' %s '.lang('valid.char'));
        $this->form_validation->set_message('numeric', lang('valid.msgfield').' %s '.lang('valid.numeric'));
        
        if (!$this->form_validation->run()) {

            foreach ($config as $v1) {
                foreach ($v1 as $k => $v) {
                    $mensaje = form_error($v);
                    if ($mensaje != "") {
                        break 2;
                    }
                }
            }
            $arrMessage['mensaje'] = $mensaje;
        } else {
            $fecha1 = $this->input->post('txt_fecha1');
            $fecha2 = $this->input->post('txt_fecha2');
            if($fecha1==''){
                $fecha1 = null;
            }
            if($fecha2==''){
                $fecha2 = null;
            }
            $tipo = $this->input->post('cb_tipo');
            $importe = $this->input->post('txt_importe');
            $importedol = $this->input->post('txt_importedol');
            if($tipo=='Ingreso'){
                $importe = abs($importe);
                $importedol = abs($importedol);
            }
            if($tipo=='Egreso'){
                $importe = (abs($importe))*(-1);
                $importedol = (abs($importedol))*(-1);
            }
            //$arrSesion = $this->session->userdata('ses_usuario');
            $data = array(
                'id_transaccion'        => $this->input->post('txt_id'),
                'Tipo_transaccion'      => $this->input->post('cb_tipo'),
                'rendicion'             => $this->input->post('txt_rendicion'),
                'fecha_registro'        => date("Y-m-d", strtotime($this->input->post('txt_fecha_registro'))),
                //'fecha_sistema'         => date('Y-m-d'),
                'documento'             => $this->input->post('txt_documento'),
                'tipo_cambio'           => $this->input->post('txt_tipo_cambio'),
                'importe'               => $importe,
                'importedol'            => $importedol,
                'id_cajabanco'          => $this->input->post('cb_caja'),
                'nro_boucher'           => $this->input->post('txt_nro_boucher'),
                'id_subcentroasignacion'=> $this->input->post('cb_sproy'),
                'id_centro_asignacion'  => $this->input->post('cb_proy'),
                'id_subconsepto'        => $this->input->post('cb_sconcepto'),
                'id_consepto'           => $this->input->post('cb_concepto'),
                'observacion'           => $this->input->post('txt_observacion'),
                'id_empresa'            => $this->input->post('cb_empresa'),
                'glosa'                 => $this->input->post('txt_glosa'),
                'id_cuecontable'        => $this->input->post('txt_cta_dr'),
                'id_cuecontablecr'      => $this->input->post('txt_cta_dc'),
                'fecha_doc'             => $fecha1,
                'nro_doc'               => $this->input->post('txt_ndoc'),
                'id_cuecontablecc'      => $this->input->post('txt_cta_dr2'),
                'id_cuecontablecccr'    => $this->input->post('txt_cta_dc2'),
                'fecha_doccc'           => $fecha2,
                'glosacc'               => $this->input->post('txt_glosa2')
            );
            //
            //$arrSesion['rendicion']= $this->input->post('txt_rendicion');
            try {
                $result = $this->transaccion_m->upd_transaccion($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        //$arrMessage['mensaje'] = 'add transaccion';
        echo $arrMessage['mensaje'];
    }
    
    public function dlt_transaccion() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array('id_transaccion' => $this->input->post('txt_id'));
        try{
            $result = $this->transaccion_m->dlt_transaccion($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }
}
