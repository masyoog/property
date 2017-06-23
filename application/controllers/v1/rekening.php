<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Rekening extends REST_Controller {
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
    
    function saldo_sipro_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        //cek login
        $this->load->model('member_model');
        $login = $this->member_model->login_api($user, $pass);
        if($login == false){
            $this->response(
                array('status'=> false, 'error' => 'Invalid Credentials')
            );
            return;
        }
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'SIPRO');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'tgl' => date('d-m-Y H:i'),
                'norek' => $norek,
                'saldo' => floatval($saldo),
            ),
        ));
    }
    function saldo_wallet_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        //cek login
        $this->load->model('member_model');
        $login = $this->member_model->login_api($user, $pass);
        if($login == false){
            $this->response(
                array('status'=> false, 'error' => 'Invalid Credentials')
            );
            return;
        }
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'tgl' => date('d-m-Y H:i'),
                'norek' => $norek,
                'saldo' => floatval($saldo),
            ),
        ));
    }
}