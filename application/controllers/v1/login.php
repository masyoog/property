<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Login extends REST_Controller {
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
    private function do_login($user, $pass){
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Username / Password salah.')
            );
            return;
        }
        
        //cek login
        $this->load->model('member_model');
        $login = $this->member_model->login_api($user, $pass);
        if($login){
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $token_expired = date('Y-m-d H:i:s', strtotime('+7 day'));
            $this->member_model->update_data($user, array('token' => $token, 'token_expired' => $token_expired));
            
            $res = $login;
            $res->token = $token;
            $res->status=true;
            $this->response($res);
        }else{
            $this->response(
                array('status'=>false, 'error'=>'Username / Password salah.')
            );
        }
    }
    function index_get(){
        $user = $this->get('uid');
        $pass = $this->get('pid');
        $this->do_login($user,$pass);
    }
    function index_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        
        $this->do_login($user,$pass);
    }
}