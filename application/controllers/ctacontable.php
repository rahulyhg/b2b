<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ctacontable extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('ctacon');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('ctacontable_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'ctacontable';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_06';
        $arrSesion['title'] = lang('ctacon.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('frontend/ctacontable/ctacontable_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_ctacontable() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $this->load->view('frontend/ctacontable/ctacontable_new_v', $arrSesion);
    }

    public function edit_ctacontable() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_cuenta' => $this->input->post('id')
        );

        $result = $this->ctacontable_m->get_ctacontable($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'           => $result[0]["id_cuenta"],
                'txt_c_cuenta'    => $result[0]["c_cuenta"],
                'txt_c_codigo'  => $result[0]["c_codigo"],
                'cb_estado'        => $result[0]["Estado"]
            );
            
            $arrSesion['arrEst'] = $this->ctacontable_m->get_estado();
            $this->load->view('frontend/ctacontable/ctacontable_edit_v', $arrSesion);
        }
    }
    
    public function remove_ctacontable() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_cuenta' => $this->input->post('id')
        );

        $result = $this->ctacontable_m->get_ctacontable($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'           => $result[0]["id_cuenta"],
                'txt_c_cuenta'    => $result[0]["c_cuenta"],
                'txt_c_codigo'  => $result[0]["c_codigo"],
                'cb_estado'        => $result[0]["Estado"]
            );
            
            $arrSesion['arrEst'] = $this->ctacontable_m->get_estado();
            $this->load->view('frontend/ctacontable/ctacontable_remove_v', $arrSesion);
        }
    }

    public function get_ctacontable_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'CTA_CONTABLE_GET';
        $arrParam = array(null);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_ctacontable() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            
            array(
                'field' => 'txt_c_cuenta',
                'label' => lang('ctacon.cuen'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_codigo',
                'label' => lang('ctacon.cod'),
                'rules' => 'required|trim|exact_length[5]|numeric'
            )
        );
        $this->form_validation->set_rules($config);
        
        //Reglas
        $this->form_validation->set_message('required', lang('valid.msgfield').' %s '.lang('valid.required'));
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
                'c_cuenta'       => $this->input->post('txt_c_cuenta'),
                'c_codigo'     => $this->input->post('txt_c_codigo'),
                'Estado'          => 'ACT',//'COD0000002', //Activo
                'f_creacion'      => date('Y-m-d H:m:s')
            );
            
            try {
                $result = $this->ctacontable_m->add_ctacontable($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_ctacontable() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            
            array(
                'field' => 'txt_c_cuenta',
                'label' => lang('ctacon.cuen'),
                'rules' => 'required|trim|min_length[3]'
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
                                'id_cuenta'    => $this->input->post('txt_id'),
                                'c_cuenta'       => $this->input->post('txt_c_cuenta'),
                                'c_estado'        => $this->input->post('cb_estado'), //Activo
            );
            
            try {
                $result = $this->ctacontable_m->upd_ctacontable($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_ctacontable() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $arrParam = array('id_cuenta' => $this->input->post('txt_id'));
        try{
            $result = $this->ctacontable_m->dlt_ctacontable($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}
