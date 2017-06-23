<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Registrasi extends REST_Controller {
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
    
    function index_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $nama = isset($param['nama'])?$param['nama']:'';
        $no_ktp = isset($param['no_ktp'])?$param['no_ktp']:'';
        $alamat = isset($param['alamat'])?$param['alamat']:'';
        $kota = isset($param['kota'])?$param['kota']:'';
        $provinsi = isset($param['provinsi'])?$param['provinsi']:'';
        $kodepos = isset($param['kodepos'])?$param['kodepos']:'';
        $nohp = isset($param['nohp'])?$param['nohp']:'';
        $nohp_alt = isset($param['nohp_alternatif'])?$param['nohp_alternatif']:'';
        $email = isset($param['email'])?$param['email']:'';
        $jenis_member = isset($param['type'])?$param['type']:'';
        $id_upline = isset($param['upline'])?$param['upline']:'';
        
        $npwp = isset($param['no_npwp'])?$param['no_npwp']:'';
        $id_bank = isset($param['bank_id'])?$param['bank_id']:'';
        $norek = isset($param['bank_norek'])?$param['bank_norek']:'';
        $atas_nama = isset($param['bank_atas_nama'])?strtoupper($param['bank_atas_nama']):'';
        
        if($jenis_member == 'SISPRO'){
            $jenis_member = 'SIPRO';
        }
        
        if($jenis_member == 'BISPRO'){
            $this->response(array(
                'status' => false,
                'error' => 'Mohon maaf, untuk saat ini jenis member BISPRO masih belum aktif.'
            ));
            return;
        }
        
        //cek kosong
        if($nama == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Nama harus diisi.'
            ));
            return;
        }
        if($no_ktp == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Nomor KTP harus diisi.'
            ));
            return;
        }
        if($alamat == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Alamat harus diisi.'
            ));
            return;
        }
        if($kota == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Kota harus diisi.'
            ));
            return;
        }
        if($provinsi == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Provinsi harus diisi.'
            ));
            return;
        }
        if($nohp == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Nomor HP harus diisi.'
            ));
            return;
        }
        if($email == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Email harus diisi.'
            ));
            return;
        }
        if($jenis_member == ''){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Jenis member harus diisi. Member SIPRO atau BISPRO'
            ));
            return;
        }
        $this->load->model('setting_model');
        if($id_upline == ''){
            $id_upline = $this->setting_model->get_setting('default_id_upline');
        }
        
        $this->load->model('member_model');
        $upline = $this->member_model->get_data($id_upline);
        //cek upline
        if($upline==null){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. ID Upline tidak dikenali'
            ));
            return;
        }
        //cek duplikat no ktp
        if($this->member_model->get_total_data(array('no_ktp' => $no_ktp))>0){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Nomor KTP sudah pernah didaftarkan. Silahkan menggunakan nomor identitas yang lain.'
            ));
            return;
        }
        
        //cek duplikat nomor HP
        if($this->member_model->get_total_data(array('nohp' => $nohp))>0){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Nomor HP sudah pernah didaftarkan. Silahkan menggunakan nomor lain.'
            ));
            return;
        }
        //cek duplikat email
        $jml_email = $this->member_model->get_total_data(array('email' => $email));
        if($jml_email>0){
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Email '.$email.' sudah pernah didaftarkan. Silahkan menggunakan email lain.'
            ));
            return;
        }
        
        $data = array(
            'nama' => strtoupper($nama), 'no_ktp' => $no_ktp, 'alamat' => strtoupper($alamat), 'kota' => strtoupper($kota), 'provinsi' => strtoupper($provinsi), 'kodepos' => $kodepos,
            'nohp' => $nohp, 'nohp_alt' => $nohp_alt, 'email' => $email, 'jenis_member' => strtoupper($jenis_member), 'id_upline1' => $id_upline, 
            'no_npwp' => $npwp
        );
        $reg = $this->member_model->registrasi($data, array(
            'id_kode_bank' => $id_bank, 'norek' => $norek, 'atas_nama' => $atas_nama
        ));
        if($reg!=false){
            //send email
            $config = array(
//                'smtp_crypto' => 'tls',
                'protocol' => 'smtp',
                'smtp_host' => $this->config->item('smtp_host'),
                'smtp_user' => $this->config->item('smtp_user'),
                'smtp_pass' => $this->config->item('smtp_pass'),
                'smtp_port' => $this->config->item('smtp_port'),
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE,
                'crlf' => "\r\n",
                'newline' => "\r\n"
            );
            $this->load->library('email', $config);

            $this->email->to($data['email']);
            $this->email->from($this->config->item('smtp_user'), 'PRO2M');

            $this->email->subject('[PRO2M] Registrasi Member PRO2M');
            $this->load->model('bank_model');
            $bank = $this->bank_model->read_data('','',array('id <> '=>'1'));
            $norek_bank = '';
            $norek_bank_arr = array();
            foreach($bank as $val){
                $norek_bank_arr[] = array(
                    'norek' => $val->norek,
                    'atas_nama' => $val->atas_nama,
                    'bank' => $val->nama
                );
                $norek_bank.='Nomor Rekening: '.$val->norek.'<br>';
                $norek_bank.='Atas Nama: '.$val->atas_nama.'<br>';
                $norek_bank.='Nama Bank: '.$val->nama.'<br>';
                $norek_bank.='<br>';
            }
            $biaya_aktivasi = 0;
            if($data['jenis_member']=='SIPRO'){
                $biaya_aktivasi = floatval($this->setting_model->get_biaya_aktivasi_sipro());
            }else if($data['jenis_member']=='BISPRO'){
                $biaya_aktivasi = floatval($this->setting_model->get_biaya_aktivasi_bispro());
            }
            
            $msg = '
                Yth. '.$data['nama'].',<br><br>

                Selamat, Anda telah terdaftar menjadi member PRO2M. <br><br>
                
                ID Member Anda: '.$reg['id'].'<br><br>
                
                Namun status keanggotaan Anda saat ini masih belum aktif, 
                silahkan melakukan aktivasi dengan melakukan transfer ke rekening berikut: <br><br>
                
                '.$norek_bank.'
                Nominal: Rp '._format_angka($biaya_aktivasi).'<br><br>
                
                Bila sudah melakukan transfer, silahkan klik URL di bawah ini untuk konfirmasi:<br>
                https://pro2m.co.id/konfirmasi?id='.$reg['id'].'<br><br>
                
                Segera aktivasi ID Anda dan nikmati berbagai fasilitas PRO2M.<br>
                Download Aplikasi mobile PRO2M di https://goo.gl/PVWABu <br><br><br>
                

                Terima kasih.<br><br>

                Regards,<br>
                PRO2M
                ';
            $this->email->message($msg);
            $msgs = array();
            if($this->email->send()){
                $msgs[] = 'Email telah berhasil dikirimkan ke '.$data['email'].'.';
            }else{
                $msgs[] = 'GAGAL mengirimkan email ke '.$data['email'].'. Silahkan hubungi Customer Service kami.';
            }
            //send sms
            $this->load->model('outbox_model');
            $this->outbox_model->send_sms(array(
                'nomor' => $data['nohp'],
                'id_member' => $reg['id'],
                'nama' => $data['nama'],
                'tgl' => date('Y-m-d H:i:s'),
                'pesan' => 'Yth.'.$data['nama'].', Selamat Anda terdaftar menjadi member PRO2M dg ID '.$reg['id'].'. Silahkan aktivasi dg trf '._format_angka($biaya_aktivasi).' ke rek PRO2M. Info norek ada di website https://pro2m.co.id. Download App di https://goo.gl/PVWABu',
                'type' => '1',
                'port' => '0',
                'status' => '0'
            ));
            $message = implode(" ", $msgs);

            $this->response(array(
                'status' => true,
                'message' => 'Registrasi telah berhasil dilakukan. Silahkan cek email Anda untuk instruksi selanjutnya. '.$message,
                'data' => array(
                    'id_member' => $reg['id'],
                    'nama' => $reg['nama'],
                    'nominal' => $biaya_aktivasi,
                    'norek' => $norek_bank_arr,
                    'message' => $msg,
                ),
            ));
        }else{
            $this->response(array(
                'status' => false,
                'error' => 'Gagal melakukan registrasi. Silahkan coba beberapa saat lagi atau hubungi customer service.'
            ));
        }
    }
}