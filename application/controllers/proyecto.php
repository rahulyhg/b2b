<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyecto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('proy');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('proyecto_m');
    }
    /*falta crear el menu proyecto*/
    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'proyecto';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_02';
        $arrSesion['title'] = lang('proy.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/proyecto/proyecto_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }
    
    public function new_proyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $arrSesion['arrCtaControl'] = $this->proyecto_m->get_cuentas();
        $arrSesion['arrCtaIngreso'] = $this->proyecto_m->get_cuentas();
        $this->load->view('backend/proyecto/proyecto_new_v', $arrSesion);//, $arrSesion);
    }
    
    public function edit_proyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_proyecto' => $this->input->post('id'),
            'opcion'      => 1
        );

        $result = $this->proyecto_m->get_proyecto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_proyecto"],
                'txt_c_codigo'      => $result[0]["c_codigo"],
                'txt_c_proyecto'    => $result[0]["c_proyecto"],
                'cb_cta_control'    => $result[0]["cta_control"],
                'cb_cta_ingreso'    => $result[0]["cta_ingreso"],
                'cb_estado'         => $result[0]["Estado"]
            );
            
            $arrSesion['arrCtaControl'] = $this->proyecto_m->get_cuentas();
            $arrSesion['arrCtaIngreso'] = $this->proyecto_m->get_cuentas();
            $arrSesion['arrEst'] = $this->proyecto_m->get_estado();
            $this->load->view('backend/proyecto/proyecto_edit_v', $arrSesion);
        }
    }

    public function configurar() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_proyecto' => $this->input->post('id'),
            'opcion'      => 1
        );

        $result = $this->proyecto_m->get_proyecto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_proyecto"],
                'txt_c_proyecto'    => $result[0]["c_proyecto"],
                'txt_c_codigo'      => $result[0]["c_codigo"]
            );
            
            $arrSesion['arrConcepto'] = $this->proyecto_m->get_concepto();
            $arrSesion['chklist_concepto'] = $this->proyecto_m->get_conceptos_activos($data);
            $this->load->view('backend/proyecto/conceptoxproyecto_config_v', $arrSesion);
        }
    }

    public function remove_proyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_proyecto' => $this->input->post('id'),
            'opcion'      => 1
        );

        $result = $this->proyecto_m->get_proyecto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_proyecto"],
                'txt_c_codigo'      => $result[0]["c_codigo"],
                'txt_c_proyecto'    => $result[0]["c_proyecto"],
                'cb_cta_control'    => $result[0]["cta_control"],
                'cb_cta_ingreso'    => $result[0]["cta_ingreso"],
                'cb_estado'         => $result[0]["Estado"]
            );
            
            $arrSesion['arrCtaControl'] = $this->proyecto_m->get_cuentas();
            $arrSesion['arrCtaIngreso'] = $this->proyecto_m->get_cuentas();
            $arrSesion['arrEst'] = $this->proyecto_m->get_estado();
            $this->load->view('backend/proyecto/proyecto_remove_v', $arrSesion);
        }
    }

    public function get_proyecto_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'PROYECTO_GET';
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }

    public function add_proyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_codigo',
                'label' => lang('proy.cod'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_proyecto',
                'label' => lang('proy.proy'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_cta_control',
                'label' => lang('proy.seltip'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_cta_ingreso',
                'label' => lang('proy.seltip'),
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

            //$arrSesion = $this->session->userdata('ses_usuario');
            $data = array(
                'c_codigo'           => $this->input->post('txt_c_codigo'),
                'c_proyecto'           => $this->input->post('txt_c_proyecto'),
                'cta_control'           => $this->input->post('cb_cta_control'),
                'cta_ingreso'           => $this->input->post('cb_cta_ingreso'),
                'Estado'                => 'ACT', //Activo
                'FechaCreacion'         => date('Y-m-d H:m:s')
            );
            
            try {
                $result = $this->proyecto_m->add_proyecto($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }

    public function upd_proyecto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_proyecto',
                'label' => lang('proy.proy'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_cta_control',
                'label' => lang('proy.seltip'),
                'rules' => 'required|trim'
            ),
            array(
                'field' => 'cb_cta_ingreso',
                'label' => lang('proy.seltip'),
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

            //$arrSesion = $this->session->userdata('ses_usuario');
            $arrParam = array(
                                'id_proyecto'          => (string) $this->input->post('txt_id'),
                                'c_proyecto'           => $this->input->post('txt_c_proyecto'),
                                'cta_control'           => $this->input->post('cb_cta_control'),
                                'cta_ingreso'           => $this->input->post('cb_cta_ingreso'),
                                'c_estado'             => $this->input->post('cb_estado')
                                
            );
            
            try {
                $result = $this->proyecto_m->upd_proyecto($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function upd_conceptos_activos() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array(
            'id_proyecto'   => $this->input->post('txt_id')
        );
        
        $this->proyecto_m->upd_conceptos_activos($arrParam);
        
        $seleccionConcepto = $this->input->post('chklist_concepto');

        if (is_array($seleccionConcepto)){
            foreach($seleccionConcepto as $concepto){
                $arrParam = array(
                    'id_proyecto'       => $this->input->post('txt_id'),
                    'id_concepto'       => $concepto                                   
                );
                $this->proyecto_m->add_conceptos_activos($arrParam);
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
