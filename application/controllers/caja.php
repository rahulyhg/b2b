<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Caja extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('caja');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('caja_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'caja';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_08';
        $arrSesion['title'] = lang('caja.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/caja/caja_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_caja() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrSesion['arrMoneda'] = $this->caja_m->get_monedas();
        $arrSesion['arrEmpresa'] = $this->caja_m->get_empresas();
        $arrSesion['arrTipo'] = $this->caja_m->get_tipo();
        $this->load->view('frontend/caja/caja_new_v', $arrSesion);
    }

    public function edit_caja() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_caja' => $this->input->post('id'),
            'opcion'  => 1
        );

        $result = $this->caja_m->get_caja($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'          => $result[0]["id_caja"],
                'txt_c_caja'      => $result[0]["c_caja"],
                'txt_c_codigo'    => $result[0]["c_codigo"],
                'cb_moneda'       => $result[0]["id_moneda"],
                'cb_empresa'      => $result[0]["id_empresa"],
                'cb_tipo'         => $result[0]["t_caja"],
                'cb_estado'       => $result[0]["Estado"]
            );
            
            $arrSesion['arrMoneda'] = $this->caja_m->get_monedas();
            $arrSesion['arrEmpresa'] = $this->caja_m->get_empresas();
            $arrSesion['arrTipo'] = $this->caja_m->get_tipo();
            $arrSesion['arrEst'] = $this->caja_m->get_estado();
            $this->load->view('frontend/caja/caja_edit_v', $arrSesion);
        }
    }

    public function remove_caja() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_caja' => $this->input->post('id'),
            'opcion'  => 1
        );

        $result = $this->caja_m->get_caja($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'          => $result[0]["id_caja"],
                'txt_c_caja'      => $result[0]["c_caja"],
                'txt_c_codigo'    => $result[0]["c_codigo"],
                'cb_moneda'       => $result[0]["id_moneda"],
                'cb_empresa'      => $result[0]["id_empresa"],
                'cb_tipo'         => $result[0]["t_caja"],
                'cb_estado'       => $result[0]["Estado"]
            );
            
            $arrSesion['arrMoneda'] = $this->caja_m->get_monedas();
            $arrSesion['arrEmpresa'] = $this->caja_m->get_empresas();
            $arrSesion['arrTipo'] = $this->caja_m->get_tipo();
            $arrSesion['arrEst'] = $this->caja_m->get_estado();
            $this->load->view('frontend/caja/caja_remove_v', $arrSesion);
        }
    }
    
    public function get_caja_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'CAJA_GET';
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_caja() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_caja',
                'label' => lang('caja.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_codigo',
                'label' => lang('caja.cod'),
                'rules' => 'required|trim|min_length[1]|max_length[3]|numeric'
            ),
            array(
                'field' => 'cb_moneda',
                'label' => lang('caja.mon'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_empresa',
                'label' => lang('caja.emp'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_tipo',
                'label' => lang('caja.tipo'),
                'rules' => 'required|trim'
            ),
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

            $data = array(
                'c_caja'        => $this->input->post('txt_c_caja'),
                'c_codigo'      => $this->input->post('txt_c_codigo'),
                'id_moneda'     => $this->input->post('cb_moneda'),
                'id_empresa'    => $this->input->post('cb_empresa'),
                't_caja'        => $this->input->post('cb_tipo'),
                'Estado'        => 'ACT',
                'f_creacion'    => date('Y-m-d H:m:s')
            );
            
            try {
                $result = $this->caja_m->add_caja($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_caja() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_caja',
                'label' => lang('caja.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_moneda',
                'label' => lang('caja.mon'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_empresa',
                'label' => lang('caja.emp'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_tipo',
                'label' => lang('caja.tipo'),
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
                                'id_caja'       => $this->input->post('txt_id'),
                                'c_caja'        => $this->input->post('txt_c_caja'),
                                'id_moneda'     => $this->input->post('cb_moneda'),
                                'id_empresa'    => $this->input->post('cb_empresa'),
                                't_caja'       => $this->input->post('cb_tipo'),
                                'c_estado'      => $this->input->post('cb_estado'),
            );
            
            try {
                $result = $this->caja_m->upd_caja($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_caja() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $arrParam = array('id_caja' => $this->input->post('txt_id'));
        try{
            $result = $this->caja_m->dlt_caja($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}

