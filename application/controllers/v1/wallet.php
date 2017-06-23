<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Wallet extends REST_Controller {
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
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        //cek saldo
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        if($saldo<$nominal){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '. _format_angka($saldo))
            );
            return;
        }
        
        $this->load->model('wallet_model');
        $req = $this->wallet_model->withdraw(array(
            'id_member' => $user,
            'norek_wallet' => $norek,
            'nominal' => $nominal,
            'id_bank' => $bank,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        
        if($req){            
            $this->response(array(
                'status' => true,
                'message' => 'Permintaan withdraw E-Wallet Anda sebesar Rp '.  _format_angka($nominal).' telah kami terima, silahkan tunggu proses selesai dilakukan. '
            ));
        }else{
            $this->response(
                array('status'=> false, 'error' => 'Permintaan withdraw E-Wallet Anda GAGAL dilakukan. Silahkan coba beberapa saat lagi.')
            );
        }
    }
    function transfer_sipro_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        
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
        
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $norek_sipro = $this->rekening_model->get_norek_member($user, 'SIPRO');
        //cek saldo
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        if($saldo<$nominal){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo))
            );
            return;
        }
        
        $this->load->model('wallet_model');
        $req = $this->wallet_model->transfer_sipro(array(
            'id_member' => $user,
            'nama' => $login->nama,
            'norek_wallet' => $norek,
            'norek_sipro' => $norek_sipro,
            'nominal' => $nominal,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        
        $saldo_sipro = $this->rekening_model->get_saldo_akhir($norek_sipro);
        
        if($req){
            //send email asal
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

            $this->email->to($login->email);
            $this->email->from($this->config->item('smtp_user'), 'PRO2M');
            $this->email->subject('[PRO2M] Topup SIPRO');
            
            $noref = time();
            $msg = '
                Yth. '.$login->nama.' ('.$login->id.'),<br><br>

                Topup saldo SIPRO telah berhasil dilakukan. <br><br>
                Tanggal : '.date('d-m-Y H:i:s').'<br>
                ID Member : '.$login->id.'<br>
                Nama : '.$login->nama.'<br>
                Nominal : Rp '._format_angka($nominal).'<br>
                Noref : '.$noref.'<br>
                Saldo SIPRO sekarang : <strong>'._format_angka($saldo_sipro).'</strong><br><br>
                

                Terima kasih.<br><br>

                Regards,<br>
                PRO2M
                ';
            $this->email->message($msg);
            $this->email->send();
            
            //send sms
            $this->load->model('outbox_model');
            $this->outbox_model->send_sms(array(
                'nomor' => $login->nohp,
                'id_member' => $login->id,
                'nama' => $login->nama,
                'tgl' => date('Y-m-d H:i:s'),
                'pesan' => 'Yth.'.$login->nama.', Topup saldo SIPRO Anda sebesar '._format_angka($nominal).' telah BERHASIL dilakukan. Saldo SIPRO Anda saat ini=Rp '._format_angka($saldo_sipro).'.',
                'type' => '1',
                'port' => '0',
                'status' => '0'
            ));
            
            $this->response(array(
                'status' => true,
                'message' => 'Topup saldo SIPRO Anda sebesar Rp '.  _format_angka($nominal).' telah BERHASIL dilakukan. Saldo SIPRO Anda saat ini adalah Rp '.  _format_angka($saldo_sipro),
            ));
        }else{
            $this->response(
                array('status'=> false, 'error' => 'GAGAL melakukan transfer. Silahkan coba beberapa saat lagi.')
            );
        }
    }
    function transfer_bispro_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        
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
        
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $norek_bispro = $this->rekening_model->get_norek_member($user, 'BISPRO');
        $norek_upline = $this->rekening_model->get_norek_member($user, 'BISPRO');
        //cek saldo
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        if($saldo<$nominal){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo))
            );
            return;
        }
        
        $this->load->model('wallet_model');
        $req = $this->wallet_model->transfer_bispro(array(
            'id_member' => $user,
            'nama' => $login->nama,
            'norek_wallet' => $norek,
            'norek_bispro' => $norek_bispro,
            'nominal' => $nominal,
            'id_upline' => $login->id_upline1,
            'norek_upline' => $norek_upline,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        
        $saldo_bispro = $this->rekening_model->get_saldo_akhir($norek_bispro);
        
        if($req){
            //send email asal
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

            $this->email->to($login->email);
            $this->email->from($this->config->item('smtp_user'), 'PRO2M');
            $this->email->subject('[PRO2M] Pembelian Saham BISPRO');
            
            $noref = time();
            $msg = '
                Yth. '.$login->nama.' ('.$login->id.'),<br><br>

                Pembelian saham BISPRO telah berhasil dilakukan. <br><br>
                Tanggal : '.date('d-m-Y H:i:s').'<br>
                ID Member : '.$login->id.'<br>
                Nama : '.$login->nama.'<br>
                Nominal : Rp '._format_angka($nominal).'<br>
                Noref : '.$noref.'<br>
                Saldo BISPRO Anda sekarang : <strong>'._format_angka($saldo_bispro).'</strong><br><br>
                

                Terima kasih.<br><br>

                Regards,<br>
                PRO2M
                ';
            $this->email->message($msg);
            $this->email->send();
            
            //send sms
            $this->load->model('outbox_model');
            $this->outbox_model->send_sms(array(
                'nomor' => $login->nohp,
                'id_member' => $login->id,
                'nama' => $login->nama,
                'tgl' => date('Y-m-d H:i:s'),
                'pesan' => 'Yth.'.$login->nama.', Pembelian saham BISPRO Anda sebesar '._format_angka($nominal).' telah BERHASIL dilakukan. Saldo BISPRO Anda saat ini=Rp '._format_angka($saldo_bispro).'.',
                'type' => '1',
                'port' => '0',
                'status' => '0'
            ));
            
            $this->response(array(
                'status' => true,
                'message' => 'Pembelian saham BISPRO Anda sebesar Rp '.  _format_angka($nominal).' telah BERHASIL dilakukan. Saldo BISPRO Anda saat ini adalah Rp '.  _format_angka($saldo_bispro),
            ));
        }else{
            $this->response(
                array('status'=> false, 'error' => 'GAGAL melakukan pembelian saham BISPRO. Silahkan coba beberapa saat lagi.')
            );
        }
    }
    function transfer_inq_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $tujuan = isset($param['id_member'])?$param['id_member']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        $ket = isset($param['berita'])?strtoupper($param['berita']):'';
        
        //cek login
        $this->load->model('member_model');
        $login = $this->member_model->login_api($user, $pass);
        if($login == false){
            $this->response(
                array('status'=> false, 'error' => 'Invalid Credentials')
            );
            return;
        }
        //cek tujuan transfer
        if($user==$tujuan){
            $this->response(
                array('status'=> false, 'error' => 'Anda tidak diizinkan melakukan transfer ke ID Member '.$tujuan.'. Silahkan gunakan ID Member lain.')
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
        
        $this->load->model('member_model');
        $row_member = $this->member_model->get_data_where(array('id'=>$tujuan, 'status'=>'1'));
        if($row_member==null){
            $this->response(
                array('status'=> false, 'error' => 'ID Member tujuan transfer tidak terdaftar')
            );
            return;
        }
        $member = $row_member[0];
                
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'id_member' => $member->id,
                'nama' => $member->nama,
                'nominal' => _format_angka($nominal),
                'berita' => $ket,
            ),
        ));
    }
    function transfer_pay_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $tujuan = isset($param['id_member'])?$param['id_member']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):0;
        $ket = isset($param['berita'])?strtoupper($param['berita']):'';
        
        //cek login
        $this->load->model('member_model');
        $login = $this->member_model->login_api($user, $pass);
        if($login == false){
            $this->response(
                array('status'=> false, 'error' => 'Invalid Credentials')
            );
            return;
        }
        //cek tujuan transfer
        if($user==$tujuan){
            $this->response(
                array('status'=> false, 'error' => 'Anda tidak diizinkan melakukan transfer ke ID Member tersebut. Silahkan gunakan ID Member lain.')
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
        $this->load->model('member_model');
        $row_member = $this->member_model->get_data_where(array('id'=>$tujuan, 'status'=>'1'));
        if($row_member==null){
            $this->response(
                array('status'=> false, 'error' => 'ID Member tujuan transfer tidak terdaftar')
            );
            return;
        }
        $member = $row_member[0];
        
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $norek_tujuan = $this->rekening_model->get_norek_member($tujuan, 'WALLET');
        //cek saldo
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        if($saldo<$nominal){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo))
            );
            return;
        }
        
        $this->load->model('wallet_model');
        $req = $this->wallet_model->transfer(array(
            'id_asal' => $user,
            'id_tujuan' => $member->id,
            'nama_asal' => $login->nama,
            'nama_tujuan' => $member->nama,
            'norek_asal' => $norek,
            'norek_tujuan' => $norek_tujuan,
            'nominal' => $nominal,
            'berita' => $ket,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        if($req){
            //send email asal
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

            $this->email->to($login->email);
            $this->email->from($this->config->item('smtp_user'), 'PRO2M');
            $this->email->subject('[PRO2M] Transfer Saldo E-Wallet PRO2M');
            
            $noref = time();
            $msg = '
                Yth. '.$login->nama.' ('.$login->id.'),<br><br>

                Transfer saldo telah berhasil dilakukan. <br><br>
                Tanggal : '.date('d-m-Y H:i:s').'<br>
                ID Member : '.$member->id.'<br>
                Nama : '.$member->nama.'<br>
                Nominal : Rp '._format_angka($nominal).'<br>
                Noref : '.$noref.'<br><br>
                

                Terima kasih.<br><br>

                Regards,<br>
                PRO2M
                ';
            $this->email->message($msg);
            $this->email->send();
            
            //send email tujuan
            $this->email->to($member->email);
            $this->email->from($this->config->item('smtp_user'), 'PRO2M');
            $this->email->subject('[PRO2M] Terima Saldo E-Wallet PRO2M');
            
            $msg = '
                Yth. '.$member->nama.' ('.$member->id.'),<br><br>

                Anda telah menerima transfer saldo E-Wallet PRO2M dari: <br><br>
                ID Member : '.$login->id.'<br>
                Nama : '.$login->nama.'<br>
                Nominal : Rp '._format_angka($nominal).'<br>
                Noref : '.$noref.'<br><br>
                
                Silahkan login dan cek saldo Anda.<br><br>                

                Terima kasih.<br><br>

                Regards,<br>
                PRO2M
                ';
            $this->email->message($msg);
            $this->email->send();
            
            //send sms tujuan
            $this->load->model('outbox_model');
            $this->outbox_model->send_sms(array(
                'nomor' => $member->nohp,
                'id_member' => $member->id,
                'nama' => $member->nama,
                'tgl' => date('Y-m-d H:i:s'),
                'pesan' => 'Yth.'.$member->nama.', Anda telah menerima transfer saldo E-Wallet dari '.$login->nama.' ('.$login->id.') sebesar '._format_angka($nominal).'. Silahkan login dan cek saldo Anda',
                'type' => '1',
                'port' => '0',
                'status' => '0'
            ));
            
            $this->response(array(
                'status' => true,
                'message' => 'Transfer saldo E-Wallet Anda ke '.$member->id.' - '.$member->nama.' sebesar Rp '.  _format_angka($nominal).' telah BERHASIL dilakukan.',
            ));
        }else{
            $this->response(
                array('status'=> false, 'error' => 'GAGAL melakukan transfer. Silahkan coba beberapa saat lagi.')
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
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        
        $this->load->model('wallet_model');
        $mutasi = $this->wallet_model->mutasi($norek, $periode1, $periode2);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => $mutasi
        ));
    }
}