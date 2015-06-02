<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('tipo');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('tipo_m');
    }
    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'tipo';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_09';
        $arrSesion['title'] = lang('tipo.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/tipo/tipo_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }
    public function new_tipo() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
       $arrSesion['arrPadre'] = $this->tipo_m->get_padre();
       $this->load->view('backend/tipo/tipo_new_v', $arrSesion);//, $arrSesion);
    }
   public function edit_tipo() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_tipo' => $this->input->post('id'),
            'opcion' => 1
        );
        $result = $this->tipo_m->get_tipo($data);
        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id_tipo'           => $result[0]["id_tipo"],
                'txt_id_tipo_padre'     => $result[0]["id_tipo_padre"],
                'txt_c_tipo'            => $result[0]["c_tipo"],
                'cb_estado'             => $result[0]["estado"]
            );
            
            $arrSesion['arrEst'] = $this->tipo_m->get_estado();
            $this->load->view('backend/tipo/tipo_edit_v', $arrSesion);
        }
    }
    public function get_tipo_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'TIPO_GET2';
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    public function add_tipo() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_id_tipo',
                'label' => lang('tipo.id'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_tipo',
                'label' => lang('tipo.desc'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_id_tipo_padre',
                'label' => lang('tipo.padre'),
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
                'id_tipo'               => $this->input->post('txt_id_tipo'),
                'c_tipo'                => $this->input->post('txt_c_tipo'),
                'id_tipo_padre'         => $this->input->post('cb_id_tipo_padre'),
                'Estado'                =>'ACT'
                
            );
            
            try {
                $result = $this->tipo_m->add_tipo($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }

        public function upd_tipo() {
        $config = array(
            
            array(
                'field' => 'txt_c_tipo',
                'label' => lang('tipo.desc'),
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
                                'id_tipo'    => $this->input->post('txt_id'),
                                'c_tipo'        => $this->input->post('txt_c_tipo'),
                                'Estado'        =>  $this->input->post('cb_estado')
            );
            
            try {
                $result = $this->tipo_m->upd_tipo($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    public function dlt_proyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array('id_proyecto' => $this->input->post('txt_id'));
        try{
            $result = $this->proyecto_m->dlt_proyecto($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}
