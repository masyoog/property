<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Komisi extends REST_Controller {
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
    
    function total_komisi_post(){
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
        $this->load->model('komisi_model');
        $total_komisi_registrasi = $this->komisi_model->get_total_registrasi($user);
        $total_komisi_royalty = $this->komisi_model->get_total_royalty($user);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'registrasi' => floatval($total_komisi_registrasi),
                'royalty' => floatval($total_komisi_royalty),
            ),
        ));
    }
    function total_registrasi_post(){
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
        $this->load->model('komisi_model');
        $total_komisi = $this->komisi_model->get_total_registrasi($user);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => floatval($total_komisi),
        ));
    }
    function detail_registrasi_post(){
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
        $this->load->model('komisi_model');
        $detail = $this->komisi_model->read_data_registrasi($user);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => $detail,
        ));
    }
    function total_royalty_post(){
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
        $this->load->model('komisi_model');
        $total_komisi = $this->komisi_model->get_total_royalty($user);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => floatval($total_komisi),
        ));
    }
}