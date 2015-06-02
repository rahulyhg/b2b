<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    var $_pivot = 5;
    var $_arr_Sesion;
    var $p_contrata = 'user_cta';
    public function __construct() {

        parent::__construct();
        $this->_arr_Sesion = $this->session->userdata('ses_usuario');
        $this->lang->load('generales'); // cargo los archivos del lenguaje
        $this->lang->load('main'); // carga los archivos personales por pagina del lenguaje
        // cargamos el modelo del login
        $this->load->model('base_m');
    }

    public function index() {   
        if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrSesion = $this->session->userdata('ses_usuario');
        $arrSesion['title'] = lang('ind.title');
        $arrMenu['mGroup'] = 'm_dsk';
        $arrMenu['mOption'] = '';
        // cargamos  la interfaz
        $this->load->view('includes/header');
        $this->load->view('includes/menu', $arrMenu);

        $this->load->view('includes/panel', $arrSesion);        
        $this->load->view('frontend/main/main_v', $arrSesion);
        $this->load->view('includes/footer');
    }
    
    public function load_indicadores() {   
        //if ($this->seguridad->sec_class(__METHOD__)) return;
        $arrParam['arrsolsol'] = $this->get_monto_soles_en_soles();
        $arrParam['arrsoldol'] = $this->get_monto_soles_en_dolares();
        $arrParam['arrdoldol'] = $this->get_monto_dolares_en_dolares();
        $arrParam['arrdolsol'] = $this->get_monto_dolares_en_soles();
        
        $this->load->view('frontend/main/main_indicadores_v', $arrParam);
    }
    
    function get_monto_soles_en_soles(){
        $resultado = 0;
        $arrResultado = $this->base_m->get_listar("GET_SOLES_EN_SOLES", array(null));
        if (count($arrResultado) > 0 ){
            $resultado = $arrResultado[0]["Soles"];
        }
        return $resultado;
    }
    
    function get_monto_soles_en_dolares(){
        $resultado = 0;
        $arrResultado = $this->base_m->get_listar("GET_SOLES_EN_DOLARES", array (null));
        if (count($arrResultado) > 0 ){
            $resultado = $arrResultado[0]["Soles"];
        }
        return $resultado;
    }
    
   function get_monto_dolares_en_dolares(){
        $resultado = 0;
        $arrResultado = $this->base_m->get_listar("GET_DOLARES_EN_DOLARES", array (null));
        if (count($arrResultado) > 0 ){
            $resultado = $arrResultado[0]["Dolares"];
        }
        return $resultado;
    }
   function get_monto_dolares_en_soles(){
        $resultado = 0;
        $arrResultado = $this->base_m->get_listar("GET_DOLARES_EN_SOLES", array (null));
        if (count($arrResultado) > 0 ){
            $resultado = $arrResultado[0]["Dolares"];
        }
        return $resultado;
    }

    public function logout() {

        cerrar_sesion();
    }
}
?>
