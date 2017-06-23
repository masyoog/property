<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Ppob_produk extends REST_Controller {
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
    
    function pdam_get(){
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_pdam();
        
        $this->response($data);
    }
    function pinjaman_get(){
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_pinjaman();
        
        $this->response($data);
    }
    function telp_pasca_get(){
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_telp_pasca();
        
        $this->response($data);
    }
    function tv_get(){
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_tv();
        
        $this->response($data);
    }
    
    function operator_pulsa_get(){
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_operator_pulsa();
        
        $this->response($data);
    }
    function pulsa_get(){
        $opr = $this->get('operator');
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_pulsa($opr);
        
        $this->response($data);
    }
    function operator_game_get(){
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_operator_game();
        
        $this->response($data);
    }
    function game_get(){
        $opr = $this->get('operator');
        $this->load->model('ppob_produk_model');
        $data = $this->ppob_produk_model->get_game($opr);
        
        $this->response($data);
    }
}