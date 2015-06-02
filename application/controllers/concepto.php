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
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_04';
        $arrSesion['title'] = lang('concep.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/concepto/concepto_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_concepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $this->load->view('backend/concepto/concepto_new_v');
    }

    public function edit_concepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_concepto' => $this->input->post('id'),
            'opcion'      => '1'
        );

        $result = $this->concepto_m->get_concepto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_concepto"],
                'txt_c_concepto'   => $result[0]["c_concepto"],
                'txt_c_codigo'   => $result[0]["c_codigo"],
                'cb_estado'         => $result[0]["Estado"]
            );
            

            $arrSesion['arrEst'] = $this->concepto_m->get_estado();
            $this->load->view('backend/concepto/concepto_edit_v', $arrSesion);
        }
    }

    public function remove_concepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_concepto' => $this->input->post('id'),
            'opcion'      => '1'
        );

        $result = $this->concepto_m->get_concepto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_concepto"],
                'txt_c_concepto'   => $result[0]["c_concepto"],
                'txt_c_codigo'   => $result[0]["c_codigo"],
                'cb_estado'         => $result[0]["Estado"]
            );
            
            $arrSesion['arrEst'] = $this->concepto_m->get_estado();
            $this->load->view('backend/concepto/concepto_remove_v', $arrSesion);
        }
    }

    public function get_concepto_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'CONCEPTO_GET';
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_concepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'c_concepto',
                'label' => lang('concep.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'c_codigo',
                'label' => lang('concep.cod'),
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

            $data = array(
                'c_sconcepto'           => $this->input->post('c_concepto'),
                'c_scodigo'           => $this->input->post('c_codigo'),
                'Estado'                => 'ACT', //COD0000002

            );
            
            try {
                $result = $this->concepto_m->add_concepto($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_concepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_concepto',
                'label' => lang('concep.descr'),
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
                                'id_concepto'          => (string) $this->input->post('txt_id'),
                                'c_concepto'           => $this->input->post('txt_c_concepto'),
                                'Estado'               => $this->input->post('cb_estado'), //Activo
            );
            
            try {
                $result = $this->concepto_m->upd_concepto($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_concepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array('id_concepto' => $this->input->post('txt_id'));
        try{
            $result = $this->concepto_m->dlt_concepto($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}
