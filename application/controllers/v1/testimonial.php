<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Testimonial extends REST_Controller {
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
    function add_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $testimonial = isset($param['testimonial'])?$param['testimonial']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($testimonial)){
            $this->response(
                array('status'=>false, 'error'=>'Tetimonial harus diisi.')
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
        
        $this->load->model('testimonial_model', 'my_model');
        $testi_exist = $this->my_model->get_testimonial($user);
        if($testi_exist != null){
            $this->response(
                array('status'=>false, 'error'=>'Anda hanya diperbolehkan mengirim 1 buah testimonial')
            );
            return;
        }
        
        $req = $this->my_model->insert_data(array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user, 
            'testimonial' => $testimonial,
            'status' => '0'
        ));
        if($req){
            $this->response(array(
                'status' => true,
                'message' => 'Terima kasih telah bersedia mengirimkan testimonial. Testimonial Anda telah kami terima dan sedang menunggu proses approval dari admin untuk dapat dipublish.',
            ));
        }else{
            $this->response(array(
                'status' => false,
                'error' => 'Gagal mengirim testimonial. Silahkan coba beberapa saat lagi.',
            ));
        }
    }
    private function get_datalist(){
        $this->load->model('testimonial_model');
        $data = $this->testimonial_model->get_datalist();
        
        $this->response($data);
    }
    
    function index_get(){
        $this->get_datalist();
    }
}