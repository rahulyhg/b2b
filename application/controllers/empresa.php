<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('emp');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('empresa_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'empresa';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_01';
        $arrSesion['title'] = lang('emp.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/empresa/empresa_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_empresa() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $this->load->view('backend/empresa/empresa_new_v');//, $arrSesion);
    }

    public function edit_empresa() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_empresa' => $this->input->post('id'),
            'opcion'     => '1'
        );

        $result = $this->empresa_m->get_empresa($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_empresa"],
                'txt_c_nomraz'      => $result[0]["c_nomraz"],
                'txt_c_codigo'      => $result[0]["c_codigo"],
                'cb_estado'         => $result[0]["Estado"]
            );
            
            $arrSesion['arrEst'] = $this->empresa_m->get_estado();
            $this->load->view('backend/empresa/empresa_edit_v', $arrSesion);
        }
    }
    
    public function remove_empresa() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_empresa' => $this->input->post('id'),
            'opcion'     => '1'
        );

        $result = $this->empresa_m->get_empresa($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_empresa"],
                'txt_c_nomraz'   => $result[0]["c_nomraz"],
                'txt_c_codigo'   => $result[0]["c_codigo"],
                'cb_estado'         => $result[0]["Estado"]
            );
            
            $arrSesion['arrEst'] = $this->empresa_m->get_estado();
            $this->load->view('backend/empresa/empresa_remove_v', $arrSesion);
        }
    }
    
    public function get_empresa_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'EMPRESA_GET';
        $arrParam = array(null,'1');
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_empresa() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_nomraz',
                'label' => lang('emp.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_codigo',
                'label' => lang('emp.cod'),
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
                'c_nomraz'           => $this->input->post('txt_c_nomraz'),
                'c_codigo'           => $this->input->post('txt_c_codigo'),
                'Estado'             => 'ACT',//Activo
                'FechaCreacion'      => date('Y-m-d H:m:s')
            );
            
            try {
                $result = $this->empresa_m->add_empresa($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_empresa() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_nomraz',
                'label' => lang('emp.descr'),
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
                                'id_empresa'         => $this->input->post('txt_id'),
                                'c_nomraz'           => $this->input->post('txt_c_nomraz'),
                                'c_estado'           => $this->input->post('cb_estado'), //Activo
            );
            
            try {
                $result = $this->empresa_m->upd_empresa($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_empresa() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $arrParam = array('id_empresa' => $this->input->post('txt_id'));
        try{
            $result = $this->empresa_m->dlt_empresa($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}
