<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('language'); // cargo la libreria language (core/MY_Lang.php & core/MY_Config.php)
        $this->lang->load('generales'); // cargo los archivos del lenguaje creados anteriormente (en mi caso: generales_lang.php)
        $this->load->helper("url");
    }

    public function index() {
        $arrSesion = $this->session->userdata('ses_usuario');
        $datos['sTitulo'] = 'CodeIgniter: Index';

        // esto es opcional, nos calcula el tiempo restante de la sesion
        $datos['TiempoRestante'] = 'Tiempo restante: ';

        // verificamos la sesión 
        $datos['sSaludo'] = $this->session->userdata('ses_usuario') ?
                'Bienvenido <b>' . $arrSesion['usuario'] . '</b> | <a href="' .
                site_url('index_c/cerrar_sesion') . '">Cerrar sesión</a>' :
                'Bienvenido <b>visitante</b>, por favor <a href="' .
                site_url('login_c') . '">Inicia sesión</a>';
        $this->load->view('frontend/sesion/welcome_message', $datos);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */