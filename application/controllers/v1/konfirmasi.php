<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Konfirmasi extends REST_Controller {
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
    
    function aktivasi_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $id_member = isset($param['id_member'])?$param['id_member']:'';
        $nama = isset($param['nama'])?strtoupper($param['nama']):'';
        $tanggal = isset($param['tanggal'])?$param['tanggal']:'';
        $bank = isset($param['bank'])?$param['bank']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        $nama_pengirim = isset($param['nama_pengirim'])?strtoupper($param['nama_pengirim']):'';
        
        //cek kosong
        if($id_member == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. ID Member harus diisi.'
            ));
            return;
        }
        if($nama == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. Nama harus diisi.'
            ));
            return;
        }
        if($tanggal == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. Tanggal transfer harus diisi.'
            ));
            return;
        }
        if($bank == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. Bank penerima harus diisi.'
            ));
            return;
        }
        if($nominal <= 0){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. Nominal transfer harus diisi.'
            ));
            return;
        }
        if($nama_pengirim == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. Nama rekening pengirim harus diisi.'
            ));
            return;
        }
        
        $this->load->model('konfirmasi_model');
        $data = array(
            'id_member' => $id_member,
            'nama' => strtoupper($nama),
            'id_bank' => $bank,
            'atas_nama' => $nama_pengirim,
            'tgl' => $tanggal,
            'status' => '0',
            'nominal' => $nominal,
            'jenis_konfirmasi' => '1',
            'user_input' => 'sistem',
            'tgl_input' => date('Y-m-d H:i:s'),
        );
        
        $reg = $this->konfirmasi_model->insert_data($data);
        if($reg!=false){
            $this->response(array(
                'status' => true,
                'message' => 'Konfirmasi telah kami terima dan akan segera kami proses. Terima kasih.',
            ));
        }else{
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan konfirmasi. Silahkan coba beberapa saat lagi atau hubungi customer service.'
            ));
        }
    }
}