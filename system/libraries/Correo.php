<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * Developert   :   Jonathan Ascencio
 * Create Date  :   2013.01.22
 * Description  :   Genera una arreglo para poblar los objetos select
 * 
 * Company      :   Adexus Perú S.A.
 */
class Correo {

    public function __construct() {
        log_message('debug', "Correo App Class Initialized");

        // Seteando el objeto super
        $this->CI = & get_instance();

        // Cargando configuracion de basedatos
        $this->CI->load->library('email');

        log_message('debug', "Correo App Successfully Run");
    }

    public function enviar_correo($sAsunto, $sCuerpo, $arrDestinatario = NULL) {
        $nombreRemitente = 'Info Adexus App';
        $correoRemitente = $this->CI->email->smtp_user;
        
        if ( is_null($arrDestinatario) ){
            $arrDestinatario = array('jascencio@adexus.com.pe');
        }
        
        $this->CI->email->from($correoRemitente, $nombreRemitente);
        $this->CI->email->to($arrDestinatario);
        $this->CI->email->subject($sAsunto);
        $this->CI->email->message($sCuerpo);
        
        $resultado = $this->CI->email->send();
        
        return $resultado;
    }
    
}

// ------------------------------------------------------------------------

