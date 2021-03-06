<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Provinsi extends REST_Controller {
    public function __construct() {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers:	{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }
        parent::__construct();
    }
    
    function get_datalist(){
        $this->load->model('provinsi_model');
        $data = $this->provinsi_model->get_datalist();
//        _var_dump($data);
        
        $this->response($data);
    }
    
    function index_get(){
        $this->get_datalist();
    }
}