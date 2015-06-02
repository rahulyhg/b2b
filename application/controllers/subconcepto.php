<?php

/*   */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subconcepto extends CI_Controller {


    public function __construct() {
        parent::__construct();
        include_once("lib/inc/jqgrid_dist.php");
        $this->lang->load('generales');
        $this->lang->load('sconcep');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('subconcepto_m');
    }

    public function index() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // cargamos parametros de sesión y configuración
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['controller'] = 'subconcepto';
        $arrMenu['mGroup'] = 'm_conf';
        $arrMenu['mOption'] = 'm_conf_05';
        $arrSesion['title'] = lang('sconcep.title');
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);
        $this->load->view('includes/panel', $arrSesion);
        $this->load->view('backend/subconcepto/subconcepto_list_v', $arrSesion);
        $this->load->view('includes/footer');
    }

    public function new_subconcepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrSesion['arrConceptos'] = $this->subconcepto_m->get_conceptos();
        $this->load->view('backend/subconcepto/subconcepto_new_v', $arrSesion);
    }

    public function edit_subconcepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_sconcepto' => $this->input->post('id'),
            'opcion'       => 1
        );

        $result = $this->subconcepto_m->get_subconcepto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_sconcepto"],
                'c_sconcepto'   => $result[0]["c_sconcepto"],
                'c_scodigo'   => $result[0]["c_scodigo"],
                'cb_id_concepto'     => $result[0]["id_concepto"],
                'cb_estado'         => $result[0]["Estado"]
            );
            $arrSesion['arrEst'] = $this->subconcepto_m->get_estado();
            $arrSesion['arrConceptos'] = $this->subconcepto_m->get_conceptos();
            $this->load->view('backend/subconcepto/subconcepto_edit_v', $arrSesion);
        }
    }

    public function remove_subconcepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $data = array(
            'id_sconcepto' => $this->input->post('id'),
            'opcion'       => 1
        );

        $result = $this->subconcepto_m->get_subconcepto($data);

        if (count($result) == 0) {
            echo null;
        } else {
            $arrSesion = array(
                'txt_id'            => $result[0]["id_sconcepto"],
                'c_sconcepto'   => $result[0]["c_sconcepto"],
                'c_scodigo'   => $result[0]["c_scodigo"],
                'c_id_concepto'     => $result[0]["id_concepto"],
                'cb_estado'         => $result[0]["Estado"]
            );
            $arrSesion['arrEst'] = $this->subconcepto_m->get_estado();
            $arrSesion['arrConceptos'] = $this->subconcepto_m->get_conceptos();
            $this->load->view('backend/subconcepto/subconcepto_remove_v', $arrSesion);
        }
    }

    public function get_subconcepto_list(){
        if ($this->seguridad->sec_class(__METHOD__)) return;
        
        $spName = 'SUBCONCEPTO_GET';
        $arrParam = array(null,1);
        $result = $this->base_m->get_listar_json($spName, $arrParam);
        echo $result;
    }
    
    public function add_subconcepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $config = array(
            array(
                'field' => 'txt_c_sconcepto',
                'label' => lang('sconcep.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'txt_c_scodigo',
                'label' => lang('sconcep.cod'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_id_concepto',
                'label' => lang('sconcep.concep'),
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
                'c_sconcepto'           => $this->input->post('txt_c_sconcepto'),
                'c_scodigo'             => $this->input->post('txt_c_scodigo'),
                'c_id_concepto'            =>  $this->input->post('cb_id_concepto'),
                'Estado'                => 'ACT', //COD0000002
            );
            
            try {
                $result = $this->subconcepto_m->add_sconcepto($data);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }
        echo $arrMessage['mensaje'];
    }
    
    
    
    public function upd_subconcepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        // Datos de validación
        $config = array(
            array(
                'field' => 'txt_c_sconcepto',
                'label' => lang('sconcep.descr'),
                'rules' => 'required|trim|min_length[3]'
            ),
            array(
                'field' => 'cb_id_concepto',
                'label' => lang('sconcep.selcon'),
                'rules' => 'required|trim'
            ),
                        array(
                'field' => 'cb_estado',
                'label' => lang('sconcep.Estado'),
                'rules' => 'required|trim|min_length[3]')
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
                                'id_sconcepto'             => (string) $this->input->post('txt_id'),
                                'c_sconcepto'           => $this->input->post('txt_c_sconcepto'),
                                'c_id_concepto'           =>$this->input->post('cb_id_concepto'),    
                                'Estado'                => $this->input->post('cb_estado'), //Activo
            );
            
            try {
                $result = $this->subconcepto_m->upd_subconcepto($arrParam);
                $arrMessage['mensaje'] = $result[0]['Mensaje'];
            } catch (Exception $e) {
                $arrMessage['mensaje'] = lang('error.trans');
            }
        }

        echo $arrMessage['mensaje'];
    }
    
    public function dlt_subconcepto() {
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam = array('id_subconcepto' => $this->input->post('txt_id'));
        try{
            $result = $this->subconcepto_m->dlt_subconcepto($arrParam);
            $arrMessage['mensaje'] = $result[0]['Mensaje'];
        } catch (Exception $e){
            $arrMessage['mensaje'] = lang('error.trans');
        }
        
        echo $arrMessage['mensaje'];
    }

}
