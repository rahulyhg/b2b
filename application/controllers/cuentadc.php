<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cuentadc extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('cdc');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('cuentadc_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'cuentadc';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_07';
        $arrSesion['title'] = lang('cdc.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/cuentadc/cuentadc_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_cuentadc() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrSesion['arrEmp'] = $this->cuentadc_m->get_empresa();
        $this->load->view('frontend/cuentadc/cuentadc_new_v', $arrSesion);
    }

    public function edit_cuentadc() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_cuenta' => $this->input->post('id'),
            'opcion'    => '1'
        );

        $result = $this->cuentadc_m->get_cuentadc($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'         => $result[0]["id_cuenta"],
                'txt_c_cuenta'   => $result[0]["c_cuenta"],
                'txt_c_codigo'   => $result[0]["c_codigo"],
                'cb_empresa'     => $result[0]["id_empresa"],
                'cb_estado'      => $result[0]["Estado"]
            );
            
            $arrSesion['arrEmp'] = $this->cuentadc_m->get_empresa();
            $arrSesion['arrEst'] = $this->cuentadc_m->get_estado();
            $this->load->view('frontend/cuentadc/cuentadc_edit_v', $arrSesion);
        }
    }
    
    public function remove_cuentadc() {
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_cuenta' => $this->input->post('id'),
            'opcion'    => '1'
        );

        $result = $this->cuentadc_m->get_cuentadc($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'         => $result[0]["id_cuenta"],
                'txt_c_cuenta'   => $result[0]["c_cuenta"],
                'txt_c_codigo'   => $result[0]["c_codigo"],
                'cb_empresa'     => $result[0]["id_empresa"],
                'cb_estado'      => $result[0]["Estado"]
            );
            
            $arrSesion['arrEmp'] = $this->cuentadc_m->get_empresa();
            $arrSesion['arrEst'] = $this->cuentadc_m->get_estado();
            $this->load->view('frontend/cuentadc/cuentadc_remove_v', $arrSesion);
        }
    }

    public function get_cuentadc_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'CUENTA_DC_GET';
        $arrParam = array(null,'1');
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_cuentadc() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_cuenta',
                'label' => lang('cdc.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_codigo',
                'label' => lang('cdc.cod'),
                'rules' => 'required|trim|exact_length[4]|numeric'
            ),
            array(
                'field' => 'cb_empresa',
                'label' => lang('cdc.emp'),
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($config);

        //Reglas
        $this->form_validation->set_message('required', lang('valid.msgfield').' %s '.lang('valid.required'));
        $this->form_validation->set_message('min_length', lang('valid.msgfield').' %s '.lang('valid.min').' %s '.lang('valid.char'));
        $this->form_validation->set_message('max_length', lang('valid.msgfield').' %s '.lang('valid.max').' %s '.lang('valid.char'));
        $this->form_validation->set_message('exact_length', lang('valid.msgfield').' %s '.lang('valid.exact').' %s '.lang('valid.char'));
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

            $data = array(
                'c_cuenta'           => $this->input->post('txt_c_cuenta'),
                'c_codigo'           => $this->input->post('txt_c_codigo'),
                'id_empresa'         => $this->input->post('cb_empresa'),
                'Estado'             => 'ACT',
                'FechaCreacion'      => date('Y-m-d H:m:s')
            );
            
            try {
                $result = $this->cuentadc_m->add_cuentadc($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_cuentadc() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_cuenta',
                'label' => lang('cdc.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_empresa',
                'label' => lang('cdc.emp'),
                'rules' => 'required|trim'
            )
        );
        $this->form_validation->set_rules($config);

        //Reglas
        $this->form_validation->set_message('required', lang('valid.msgfield').' %s '.lang('valid.required'));
        $this->form_validation->set_message('min_length', lang('valid.msgfield').' %s '.lang('valid.min').' %s '.lang('valid.char'));
        
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
            
            $arrParam = array(
                                'id_cuenta'        => (string) $this->input->post('txt_id'),
                                'c_cuenta'         => $this->input->post('txt_c_cuenta'),
                                'id_empresa'       => $this->input->post('cb_empresa'),
                                'Estado'           => $this->input->post('cb_estado')
            );
            
            try {
                $result = $this->cuentadc_m->upd_cuentadc($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_cuentadc() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $arrParam = array('id_cuenta' => $this->input->post('txt_id'));
        try{
            $result = $this->cuentadc_m->dlt_cuentadc($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}
