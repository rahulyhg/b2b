<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Error404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('error404'); // cargo los archivos del lenguaje
    }

    public function index() {
        $this->load->view('frontend/pages/404error_v');
    }

}