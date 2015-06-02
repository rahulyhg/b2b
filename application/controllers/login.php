<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    // nuestro metodo costructor
    // primer metodo a ejecutarse dentro de la clase
    public function __construct() {
        // para que pueda heredar lo que esta en el controlador padre
        parent::__construct();
        // cargando archivo de idiomas
        $this->lang->load('generales');
        $this->lang->load('login');
        
        $this->load->helper('form');

        // cargamos la libreria de validacion de fornmulario
        $this->load->library('form_validation');

        // cargamos el modelo del login
        $this->load->model('login_m');
    }

    public function index() {

        $this->load->view('frontend/login/login_v');
        
        
    }

    public function isValid() {

        $argData = array(
            'user' => $this->input->post('txtUsername'),
            'password' => $this->input->post('txtPassword')
        );
        
//        $argData['sMsgError'] = 'ok';
        //si esta vacio 
        if (empty($argData['user']) || empty($argData['password'])) {
            $argData['sMsgError'] = lang('global.msgLoginError');
            $this->load->view('frontend/login/login_v', $argData);
        } else {
            //logeo success
            $sArray = $this->login_m->login($argData);

            if ($sArray["valid"] == 1) {
                //generamos la sesion
                $SesLimite = $this->config->item('sess_expiration');                
                $this->_generar_sesion($sArray["infoUser"], $SesLimite);

            } else { //error
                $argData['sMsgError'] = lang('global.msgLoginError1');
                $this->load->view('frontend/login/login_v', $argData);
            }
        }
        
//        echo $argData['sMsgError'];
    }

    // generamos la sesion con los datos del usuario
    function _generar_sesion($sArray, $SesLimite) {

        // armamos un array con los datos de la sesion
        
        //$f_fin = date('Y-m-d');//fecha sistema
        
        // mayor fecha de sistema de la tabla transaccion
        $result = $this->login_m->get_ultima_fecha();
        $f_fin = $result[0]["fecha_sistema"];
        $dias= 7;
        $f_ini = date("Y-m-d", strtotime("$f_fin - $dias day"));
        
        $arrSesion = array(
            'profile'       => $sArray['profile'],
            'user'          => $sArray['user'],
            'userName'      => $sArray['userName'],
            'idCompany'     => $sArray['idCompany'],
            'company'       => $sArray['company'],
            //'idContractor'  => $sArray['idContractor'],
            'contractor'    => $sArray['contractor'],
            'timeLogin'     => date('Y-m-d H:m:s'),
            
            'fecha_ini'     => $f_ini,
            'fecha_fin'     => $f_fin
            
        );

        // solo si se desea usar timepo limite de sesion personalizado
        if ($this->config->item('sess_use_time_expire')) {
            // lo pasamos a segundos
            $arrSesion['seslimite'] = time() + ($SesLimite * 60);
        } else {
            $arrSesion['seslimite'] = time() + $this->config->item('sess_expiration');
        }

        // se establece la sesion
        $this->session->set_userdata('ses_usuario', $arrSesion);
        redirect('main', 'location');
    }

}