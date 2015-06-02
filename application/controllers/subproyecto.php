<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subproyecto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('subproy');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('subproyecto_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'subproyecto';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_03';
        $arrSesion['title'] = lang('subproy.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/subproyecto/subproyecto_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_subproyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrSesion['arrProyectos'] = $this->subproyecto_m->get_proyectos();
        $this->load->view('backend/subproyecto/subproyecto_new_v', $arrSesion);
    }

    public function edit_subproyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_sproyecto' => $this->input->post('id'),
            'opcion'       => 1
        );

        $result = $this->subproyecto_m->get_subproyecto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'           => $result[0]["id_sproyecto"],
                'txt_c_sproyecto'  => $result[0]["c_sproyecto"],
                'txt_c_scodigo'    => $result[0]["c_scodigo"],
                'cb_proyecto'      => $result[0]["id_proyecto"],
                'cb_estado'        => $result[0]["Estado"]
            );
            
            $arrSesion['arrProyectos'] = $this->subproyecto_m->get_proyectos();
            $arrSesion['arrEst'] = $this->subproyecto_m->get_estado();
            $this->load->view('backend/subproyecto/subproyecto_edit_v', $arrSesion);
        }
    }

    public function remove_subproyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_sproyecto' => $this->input->post('id'),
            'opcion'       => 1
        );

        $result = $this->subproyecto_m->get_subproyecto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'           => $result[0]["id_sproyecto"],
                'txt_c_sproyecto'  => $result[0]["c_sproyecto"],
                'txt_c_scodigo'    => $result[0]["c_scodigo"],
                'cb_proyecto'      => $result[0]["id_proyecto"],
                'cb_estado'        => $result[0]["Estado"]
            );
            
            $arrSesion['arrProyectos'] = $this->subproyecto_m->get_proyectos();
            $arrSesion['arrEst'] = $this->subproyecto_m->get_estado();
            $this->load->view('backend/subproyecto/subproyecto_remove_v', $arrSesion);
        }
    }
    
    public function get_subproyecto_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $spName = 'SUBPROYECTO_GET';
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_subproyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_sproyecto',
                'label' => lang('subproy.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_scodigo',
                'label' => lang('subproy.cod'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_proyecto',
                'label' => lang('subproy.proy'),
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
            $data = array(
                'c_sproyecto'     => $this->input->post('txt_c_sproyecto'),
                'c_scodigo'       => $this->input->post('txt_c_scodigo'),
                'id_proyecto'     => $this->input->post('cb_proyecto'),
                'Estado'          => 'ACT',
                'f_creacion'      => date('Y-m-d H:m:s')
            );
            
            try {
                $result = $this->subproyecto_m->add_subproyecto($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_subproyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_sproyecto',
                'label' => lang('subproy.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_proyecto',
                'label' => lang('subproy.proy'),
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
                                'id_sproyecto'    => $this->input->post('txt_id'),
                                'c_sproyecto'     => $this->input->post('txt_c_sproyecto'),
                                'id_proyecto'     => $this->input->post('cb_proyecto'),
                                'c_estado'        => $this->input->post('cb_estado'), //Activo
            );
            
            try {
                $result = $this->subproyecto_m->upd_subproyecto($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_subproyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array('id_subproyecto' => $this->input->post('txt_id'));
        try{
            $result = $this->subproyecto_m->dlt_subproyecto($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }


}
