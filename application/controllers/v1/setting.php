<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Setting extends REST_Controller {
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
    
    function share_get(){
        $this->load->model('setting_model', 'setting');
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'subject' => $this->setting->get_share_subject(),
                'message' => $this->setting->get_share_message(),
                'image' => $this->setting->get_share_image(),
            )
        ));
    }
    function wa_get(){
        $this->load->model('setting_model', 'setting');
        $nomor = $this->setting->get_no_wa_konfirmasi();
        $no = explode(',', $nomor);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'nomor' => $no,
        ));
        
    }
}