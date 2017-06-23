<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Sipro extends REST_Controller {
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
    function withdraw_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        $bank = isset($param['bank'])?$param['bank']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=> false, 'error' => 'Invalid Credentials')
            );
            return;
        }
        //cek nominal
        if($nominal<=0){
            $this->response(
                array('status'=> false, 'error' => 'Nominal tidak valid')
            );
            return;
        }
        if(empty($bank) || $bank == 0){
            $this->response(
                array('status'=> false, 'error' => 'Bank tujuan transfer harus diisi.')
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
        //cek saldo
        $this->load->model('setting_model');
        $minim_saldo = $this->setting_model->get_minimum_sipro();
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        if($saldo < $nominal || $saldo < $minim_saldo){
            $this->response(
                array('status'=> false, 'error' => 'Saldo SIPRO Anda tidak mencukupi. Minimum saldo untuk dapat ditarik adalah Rp '. _format_angka($minim_saldo).'. Saldo Anda Rp '. _format_angka($saldo))
            );
            return;
        }
        
        $this->load->model('sipro_model');
        $req = $this->sipro_model->withdraw(array(
            'id_member' => $user,
            'norek_sipro' => $norek,
            'nominal' => $nominal,
            'id_bank' => $bank,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        
        if($req){            
            $this->response(array(
                'status' => true,
                'message' => 'Permintaan withdraw SIPRO Anda sebesar Rp '.  _format_angka($nominal).' telah kami terima, silahkan tunggu proses selesai dilakukan. '
            ));
        }else{
            $this->response(
                array('status'=> false, 'error' => 'Permintaan withdraw SIPRO Anda GAGAL dilakukan. Silahkan coba beberapa saat lagi.')
            );
        }
    }
    function topup_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        $ket = isset($param['berita'])?$param['berita']:'';
        
        //cek nominal
        if($nominal<=0){
            $this->response(
                array('status'=> false, 'error' => 'Nominal tidak valid')
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
        
        $this->load->model('bank_model');
        $bank = $this->bank_model->read_data('','',array('id <> '=>'1'));
        $norek_bank = array();
        foreach($bank as $val){
            $norek_bank[] = array(
                'norek' => $val->norek,
                'atas_nama' => $val->atas_nama,
                'bank' => $val->nama
            );
        }
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'nominal' => $nominal +  mt_rand(1, 999),
                'norek' => $norek_bank,
            ),
        ));
    }
    function mutasi_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $periode1 = isset($param['periode1'])?$param['periode1']:'';
        $periode2 = isset($param['periode2'])?$param['periode2']:'';
        
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
        
        $this->load->model('sipro_model');
        $mutasi = $this->sipro_model->mutasi($norek, $periode1, $periode2);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => $mutasi
        ));
    }
}