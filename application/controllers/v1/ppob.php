<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Ppob extends REST_Controller {
    public $FIELD_ID_MEMBER = 0;
    public $FIELD_TANGGAL = 1;
    public $FIELD_NORESI = 2;
    public $FIELD_PRODUK = 3;
    public $FIELD_RC = 4;
    public $FIELD_KETERANGAN = 5;
    public $FIELD_NOMINAL = 6;
    public $FIELD_ADMIN = 7;
    public $FIELD_IDPEL = 8;
    public $FIELD_NAMA_PELANGGAN = 9;
    public $FIELD_JML_TAGIHAN = 10;
    public $FIELD_PERIODE = 11;
    public $FIELD_NOREF = 12;
    public $FIELD_IDTRX = 13;
    public $FIELD_HARGA = 14;
    public $FIELD_SALDO = 15;
    public $FIELD_STRUK = 16;
    public $FIELD_IDPEL_PULSA_GAME = 7;
    public $FIELD_NOREF_PULSA_GAME = 8;
    public $FIELD_IDTRX_PULSA_GAME = 9;
    public $FIELD_HARGA_PULSA_GAME = 10;
    public $FIELD_SALDO_PULSA_GAME = 11;
    public $FIELD_STRUK_PULSA_GAME = 12;
    
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
    function history_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $tgl = isset($param['tgl'])?$param['tgl']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($tgl)){
            $tgl = date('Y-m-d');
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
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = $this->ppob->history_payment(array(
            'id_member' => $user,
            'tgl' => $tgl,
        ));
        
        $this->response(array(
            'status' => true,
            'message' => 'History Transaksi Periode '.  _format_tgl($tgl),
            'data' => $data,
        ));
        
    }
    function inquiry_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $produk = isset($param['produk'])?$param['produk']:'';
        $idpel = isset($param['idpel'])?$param['idpel']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($produk)){
            $this->response(
                array('status'=>false, 'error'=>'Produk harus diisi')
            );
            return;
        }
        if(empty($idpel)){
            $this->response(
                array('status'=>false, 'error'=>'ID Pelanggan harus diisi')
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
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user,
            'produk' => $produk,
            'idpel' => $idpel,
            'type' => '0',
            'status' => '0'
        );
        
        $id = $this->ppob->insert_data($data);
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/trx/inquiry';
        
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'produk' => $produk,
            'idpel' => $idpel,
            'idtrx' => $id,
        ));
        
        $rc = $res[$this->FIELD_RC];
        $status = '2';
        $sukses = false;
        if($rc=='0000'){
            $status = '1';
            $sukses = true;
        }else if($rc=='0046'){  //saldo tidak cukup
            $rc = '0005';
            $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI';
        }
        
        $this->ppob->update_data($id, array(
            'rc' => $rc,
            'ket' => $res[$this->FIELD_KETERANGAN],
            'status' => $status,
            'noresi' => $res[$this->FIELD_NORESI],
            'nominal' => floatval($res[$this->FIELD_NOMINAL]),
            'struk' => $res[$this->FIELD_STRUK]
        ));
        
        $this->response(array(
            'status' => true,
            'message' => $res[$this->FIELD_KETERANGAN],
            'data' => array(
                'sukses' => $sukses,
                'rc' => $res[$this->FIELD_RC],
                'ket' => $res[$this->FIELD_KETERANGAN],
                'struk' => $res[$this->FIELD_STRUK],
                'produk' => $res[$this->FIELD_PRODUK],
                'idpel' => $res[$this->FIELD_IDPEL],
                'nama_pelanggan' => $res[$this->FIELD_NAMA_PELANGGAN],
                'nominal' => floatval($res[$this->FIELD_NOMINAL]),
                'noresi' => $res[$this->FIELD_NORESI],
                'idtrx' => $id,
            )
        ));
        
    }
    function payment_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $produk = isset($param['produk'])?$param['produk']:'';
        $idpel = isset($param['idpel'])?$param['idpel']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):'';
        $noresi = isset($param['noresi'])?$param['noresi']:'';
        $idtrx = isset($param['idtrx'])?$param['idtrx']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($produk)){
            $this->response(
                array('status'=>false, 'error'=>'Produk harus diisi')
            );
            return;
        }
        if(empty($idpel)){
            $this->response(
                array('status'=>false, 'error'=>'ID Pelanggan harus diisi')
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
        
        //cek saldo
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $this->load->model('ppob_produk_model', 'ppob_produk');
        $produk_ppob = $this->ppob_produk->get_data($produk, 'kode');
        $nominal_total = $nominal;
        if($produk=='PLNPRA'){
            $nominal_total = $nominal + 2500;
        }
        $nominalPotong = $nominal_total - floatval($produk_ppob->fee_member);
        if($saldo < floatval($nominalPotong)){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo).'. Saldo yang dibutuhkan '.  _format_angka($nominalPotong))
            );
            return;
        }        
        //potong saldo
        $this->load->model('wallet_model');
        $ret = $this->wallet_model->payment(array(
            'norek' => $norek,
            'nominal' => $nominalPotong,
            'ket' => 'PPOB : '.$produk.' '.$idpel,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        if($ret===false){
            $this->response(
                array('status'=> false, 'error' => 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI')
            );
            return;
        }
        //
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user,
            'produk' => $produk,
            'idpel' => $idpel,
            'type' => '1',
            'status' => '0'
        );
        
        $id = $this->ppob->insert_data($data);
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/trx/payment';
        
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'produk' => $produk,
            'idpel' => $idpel,
            'nominal' => floatval($nominal),
            'noresi' => $noresi,
            'idtrx' => $id,
        ));
        
        $rc = $res[$this->FIELD_RC];
        //if gagal, refund
        if($rc!='0000'){
            $this->wallet_model->refund(array(
                'norek' => $norek,
                'nominal' => $nominalPotong,
                'ket' => 'REFUND PPOB : '.$produk.' '.$idpel,
                'user_input' => $user,
                'tgl_input' => date('Y-m-d H:i:s'),
            ));
            
        }else if($rc=='0068'){  //timeout
            //insert into trx suspect
            $this->ppob->insert_suspect(array(
                'tgl' => date('Y-m-d H:i:s'),
                'id_member' => $user,
                'produk' => $produk,
                'idpel' => $idpel,
                'type' => '1',
                'status' => '0',
                'rc' => $rc,
                'nominal' => floatval($nominal),
                'ket' => $res[$this->FIELD_KETERANGAN],
            ));
            
        }
        $status = '2';
        $sukses = false;
        if($rc=='0000'){
            $status = '1';
            $sukses = true;
            $noresi = $res[$this->FIELD_NORESI];
            
            //update saldo supplier
            $this->load->model('saldo_supplier_model');
            $this->saldo_supplier_model->update_data('PPOB', array(
                'tgl_update' => date('Y-m-d H:i:s'),
                'saldo' => floatval($res[$this->FIELD_SALDO]),
            ));
        }else if($rc=='0046'){  //saldo tidak cukup
            $rc = '0005';
            $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI';
        }
        
        $this->ppob->update_data($id, array(
            'rc' => $rc,
            'ket' => $res[$this->FIELD_KETERANGAN],
            'status' => $status,
            'noresi' => $noresi,
            'nominal' => floatval($res[$this->FIELD_NOMINAL]),
            'struk' => $res[$this->FIELD_STRUK]
        ));
        
        $this->response(array(
            'status' => true,
            'message' => $res[$this->FIELD_KETERANGAN],
            'data' => array(
                'sukses' => $sukses,
                'rc' => $res[$this->FIELD_RC],
                'ket' => $res[$this->FIELD_KETERANGAN],
                'struk' => $res[$this->FIELD_STRUK],
                'idpel' => $res[$this->FIELD_IDPEL],
                'nama_pelanggan' => $res[$this->FIELD_NAMA_PELANGGAN],
                'nominal' => floatval($res[$this->FIELD_NOMINAL])
            )
        ));
        
    }
    function inquiry_pdam_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $produk = isset($param['produk'])?$param['produk']:'';
        $idpel1 = isset($param['idpel'])?$param['idpel']:'';
        $idpel2 = isset($param['idpel2'])?$param['idpel2']:'';
        $idpel3 = isset($param['idpel3'])?$param['idpel3']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($produk)){
            $this->response(
                array('status'=>false, 'error'=>'Produk harus diisi')
            );
            return;
        }
        if(empty($idpel1) && empty($idpel2) && empty($idpel3)){
            $this->response(
                array('status'=>false, 'error'=>'ID Pelanggan harus diisi')
            );
            return;
        }
        
        $idpel = '';
        if(!empty($idpel1)){
            $idpel = $idpel1;
        }else if(!empty($idpel2)){
            $idpel = $idpel2;
        }else if(!empty($idpel3)){
            $idpel = $idpel3;
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
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user,
            'produk' => $produk,
            'idpel' => $idpel,
            'type' => '0',
            'status' => '0'
        );
        
        $id = $this->ppob->insert_data($data);
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/pdam/inquiry';
        
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'produk' => $produk,
            'idpel' => $idpel1,
            'idpel2' => $idpel2,
            'idpel3' => $idpel3,
            'idtrx' => $id,
        ));
        
        $rc = $res[$this->FIELD_RC];
        $status = '2';
        $sukses = false;
        if($rc=='0000'){
            $status = '1';
            $sukses = true;
        }else if($rc=='0046'){  //saldo tidak cukup
            $rc = '0005';
            $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI';
        }
        
        $this->ppob->update_data($id, array(
            'rc' => $rc,
            'ket' => $res[$this->FIELD_KETERANGAN],
            'status' => $status,
            'noresi' => $res[$this->FIELD_NORESI],
            'nominal' => floatval($res[$this->FIELD_NOMINAL]),
            'struk' => $res[$this->FIELD_STRUK]
        ));
        
        $this->response(array(
            'status' => true,
            'message' => $res[$this->FIELD_KETERANGAN],
            'data' => array(
                'sukses' => $sukses,
                'rc' => $res[$this->FIELD_RC],
                'ket' => $res[$this->FIELD_KETERANGAN],
                'struk' => $res[$this->FIELD_STRUK],
                'produk' => $res[$this->FIELD_PRODUK],
                'idpel' => $res[$this->FIELD_IDPEL],
                'nama_pelanggan' => $res[$this->FIELD_NAMA_PELANGGAN],
                'nominal' => floatval($res[$this->FIELD_NOMINAL]),
                'noresi' => $res[$this->FIELD_NORESI],
                'idtrx' => $id,
            )
        ));
        
    }
    function payment_pdam_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $produk = isset($param['produk'])?$param['produk']:'';
        $idpel1 = isset($param['idpel'])?$param['idpel']:'';
        $idpel2 = isset($param['idpel2'])?$param['idpel2']:'';
        $idpel3 = isset($param['idpel3'])?$param['idpel3']:'';
        $nominal = isset($param['nominal'])?floatval($param['nominal']):'';
        $noresi = isset($param['noresi'])?$param['noresi']:'';
        $idtrx = isset($param['idtrx'])?$param['idtrx']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($produk)){
            $this->response(
                array('status'=>false, 'error'=>'Produk harus diisi')
            );
            return;
        }
        if(empty($idpel1) && empty($idpel2) && empty($idpel3)){
            $this->response(
                array('status'=>false, 'error'=>'ID Pelanggan harus diisi')
            );
            return;
        }
        
        $idpel = '';
        if(!empty($idpel1)){
            $idpel = $idpel1;
        }else if(!empty($idpel2)){
            $idpel = $idpel2;
        }else if(!empty($idpel3)){
            $idpel = $idpel3;
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
        
        //cek saldo
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $this->load->model('ppob_produk_model', 'ppob_produk');
        $produk_ppob = $this->ppob_produk->get_data($produk, 'kode');
        $nominalPotong = $nominal - floatval($produk_ppob->fee_member);
        if($saldo < floatval($nominalPotong)){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo).'. Saldo yang dibutuhkan '.  _format_angka($nominalPotong))
            );
            return;
        }        
        //potong saldo
        $this->load->model('wallet_model');
        $ret = $this->wallet_model->payment(array(
            'norek' => $norek,
            'nominal' => $nominalPotong,
            'ket' => 'PPOB : '.$produk.' '.$idpel,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        if($ret===false){
            $this->response(
                array('status'=> false, 'error' => 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI')
            );
            return;
        }
        //
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user,
            'produk' => $produk,
            'idpel' => $idpel,
            'type' => '1',
            'status' => '0'
        );
        
        $id = $this->ppob->insert_data($data);
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/pdam/payment';
        
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'produk' => $produk,
            'idpel' => $idpel1,
            'idpel2' => $idpel2,
            'idpel3' => $idpel3,
            'nominal' => floatval($nominal),
            'noresi' => $noresi,
            'idtrx' => $id,
        ));
        
        $rc = $res[$this->FIELD_RC];
        //if gagal, refund
        if($rc!='0000'){
            $this->wallet_model->refund(array(
                'norek' => $norek,
                'nominal' => $nominalPotong,
                'ket' => 'REFUND PPOB : '.$produk.' '.$idpel,
                'user_input' => $user,
                'tgl_input' => date('Y-m-d H:i:s'),
            ));
            
        }else if($rc=='0068'){  //timeout
            //insert into trx suspect
            $this->ppob->insert_suspect(array(
                'tgl' => date('Y-m-d H:i:s'),
                'id_member' => $user,
                'produk' => $produk,
                'idpel' => $idpel,
                'type' => '1',
                'status' => '0',
                'rc' => $rc,
                'nominal' => floatval($nominal),
                'ket' => $res[$this->FIELD_KETERANGAN],
            ));
            
        }
        $status = '2';
        $sukses = false;
        if($rc=='0000'){
            $status = '1';
            $sukses = true;
            $noresi = $res[$this->FIELD_NORESI];
            
            //update saldo supplier
            $this->load->model('saldo_supplier_model');
            $this->saldo_supplier_model->update_data('PPOB', array(
                'tgl_update' => date('Y-m-d H:i:s'),
                'saldo' => floatval($res[$this->FIELD_SALDO]),
            ));
        }else if($rc=='0046'){  //saldo tidak cukup
            $rc = '0005';
            $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI';
        }
        
        $this->ppob->update_data($id, array(
            'rc' => $rc,
            'ket' => $res[$this->FIELD_KETERANGAN],
            'status' => $status,
            'noresi' => $noresi,
            'nominal' => floatval($res[$this->FIELD_NOMINAL]),
            'struk' => $res[$this->FIELD_STRUK]
        ));
        
        $this->response(array(
            'status' => true,
            'message' => $res[$this->FIELD_KETERANGAN],
            'data' => array(
                'sukses' => $sukses,
                'rc' => $res[$this->FIELD_RC],
                'ket' => $res[$this->FIELD_KETERANGAN],
                'struk' => $res[$this->FIELD_STRUK],
                'idpel' => $res[$this->FIELD_IDPEL],
                'nama_pelanggan' => $res[$this->FIELD_NAMA_PELANGGAN],
                'nominal' => floatval($res[$this->FIELD_NOMINAL])
            )
        ));
        
    }
    function pulsa_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $produk = isset($param['produk'])?$param['produk']:'';
        $idpel = isset($param['idpel'])?$param['idpel']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($produk)){
            $this->response(
                array('status'=>false, 'error'=>'Produk harus diisi')
            );
            return;
        }
        if(empty($idpel)){
            $this->response(
                array('status'=>false, 'error'=>'Nomor HP harus diisi')
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
        
        //cek saldo
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $this->load->model('ppob_produk_model', 'ppob_produk');
        $produk_ppob = $this->ppob_produk->get_data($produk, 'kode');
        $nominalPotong = floatval($produk_ppob->fee_member);
        if($saldo < floatval($nominalPotong)){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo).'. Saldo yang dibutuhkan '.  _format_angka($nominalPotong))
            );
            return;
        }        
        //potong saldo
        $this->load->model('wallet_model');
        $ret = $this->wallet_model->payment(array(
            'norek' => $norek,
            'nominal' => $nominalPotong,
            'ket' => 'PPOB : '.$produk.' '.$idpel,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        if($ret===false){
            $this->response(
                array('status'=> false, 'error' => 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI')
            );
            return;
        }
        //
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user,
            'produk' => $produk,
            'idpel' => $idpel,
            'type' => '1',
            'status' => '0'
        );
        
        $id = $this->ppob->insert_data($data);
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/trx/pulsa';
        
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'produk' => $produk,
            'idpel' => $idpel,
            'idtrx' => $id,
        ));
        
        $rc = $res[$this->FIELD_RC];
        //if gagal, refund
        if($rc!='0000'){
            $this->wallet_model->refund(array(
                'norek' => $norek,
                'nominal' => $nominalPotong,
                'ket' => 'REFUND PPOB : '.$produk.' '.$idpel,
                'user_input' => $user,
                'tgl_input' => date('Y-m-d H:i:s'),
            ));
            
        }else if($rc=='0068'){  //timeout
            //insert into trx suspect
            $this->ppob->insert_suspect(array(
                'tgl' => date('Y-m-d H:i:s'),
                'id_member' => $user,
                'produk' => $produk,
                'idpel' => $idpel,
                'type' => '1',
                'status' => '0',
                'rc' => $rc,
                'nominal' => floatval($nominalPotong),
                'ket' => $res[$this->FIELD_KETERANGAN],
            ));
            
        }
        $status = '2';
        $sukses = false;
        if($rc=='0000'){
            $status = '1';
            $sukses = true;
            $noresi = $res[$this->FIELD_NORESI];
            if(empty($res[$this->FIELD_NOREF_PULSA_GAME])){
                $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI ANDA '.$produk.' KE '.$idpel.' SEDANG DIPROSES';
            }else{
                $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI ANDA '.$produk.' KE '.$idpel.' BERHASIL. SN = '.$res[$this->FIELD_NOREF_PULSA_GAME];
            }
            
            //update saldo supplier
            $this->load->model('saldo_supplier_model');
            $this->saldo_supplier_model->update_data('PPOB', array(
                'tgl_update' => date('Y-m-d H:i:s'),
                'saldo' => floatval($res[$this->FIELD_SALDO_PULSA_GAME]),
            ));
        }else if($rc=='0046'){  //saldo tidak cukup
            $rc = '0005';
            $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI';
        }
        
        $this->ppob->update_data($id, array(
            'rc' => $rc,
            'ket' => $res[$this->FIELD_KETERANGAN],
            'status' => $status,
            'noresi' => $noresi,
            'nominal' => floatval($res[$this->FIELD_NOMINAL]),
            'struk' => ''
        ));
        
        $this->response(array(
            'status' => true,
            'message' => $res[$this->FIELD_KETERANGAN],
            'data' => array(
                'sukses' => $sukses,
                'rc' => $res[$this->FIELD_RC],
                'ket' => $res[$this->FIELD_KETERANGAN],
                'struk' => $res[$this->FIELD_KETERANGAN],
                'idpel' => $res[$this->FIELD_IDPEL_PULSA_GAME],
                'nominal' => floatval($res[$this->FIELD_NOMINAL])
            )
        ));
    }
    
    function game_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $produk = isset($param['produk'])?$param['produk']:'';
        $idpel = isset($param['idpel'])?$param['idpel']:'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($produk)){
            $this->response(
                array('status'=>false, 'error'=>'Produk harus diisi')
            );
            return;
        }
        if(empty($idpel)){
            $this->response(
                array('status'=>false, 'error'=>'Nomor HP harus diisi')
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
        
        //cek saldo
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($user, 'WALLET');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $this->load->model('ppob_produk_model', 'ppob_produk');
        $produk_ppob = $this->ppob_produk->get_data($produk, 'kode');
        $nominalPotong = floatval($produk_ppob->fee_member);
        if($saldo < floatval($nominalPotong)){
            $this->response(
                array('status'=> false, 'error' => 'Saldo Anda tidak mencukupi. Saldo Anda '.  _format_angka($saldo).'. Saldo yang dibutuhkan '.  _format_angka($nominalPotong))
            );
            return;
        }        
        //potong saldo
        $this->load->model('wallet_model');
        $ret = $this->wallet_model->payment(array(
            'norek' => $norek,
            'nominal' => $nominalPotong,
            'ket' => 'PPOB : '.$produk.' '.$idpel,
            'user_input' => $user,
            'tgl_input' => date('Y-m-d H:i:s'),
        ));
        if($ret===false){
            $this->response(
                array('status'=> false, 'error' => 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI')
            );
            return;
        }
        //
        
        $this->load->model('transaksi_ppob_model', 'ppob');
        
        $data = array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_member' => $user,
            'produk' => $produk,
            'idpel' => $idpel,
            'type' => '1',
            'status' => '0'
        );
        
        $id = $this->ppob->insert_data($data);
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/trx/game';
        
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'produk' => $produk,
            'idpel' => $idpel,
            'idtrx' => $id,
        ));
        
        $rc = $res[$this->FIELD_RC];
        //if gagal, refund
        if($rc!='0000'){
            $this->wallet_model->refund(array(
                'norek' => $norek,
                'nominal' => $nominalPotong,
                'ket' => 'REFUND PPOB : '.$produk.' '.$idpel,
                'user_input' => $user,
                'tgl_input' => date('Y-m-d H:i:s'),
            ));
            
        }else if($rc=='0068'){  //timeout
            //insert into trx suspect
            $this->ppob->insert_suspect(array(
                'tgl' => date('Y-m-d H:i:s'),
                'id_member' => $user,
                'produk' => $produk,
                'idpel' => $idpel,
                'type' => '1',
                'status' => '0',
                'rc' => $rc,
                'nominal' => floatval($nominalPotong),
                'ket' => $res[$this->FIELD_KETERANGAN],
            ));
            
        }
        $status = '2';
        $sukses = false;
        if($rc=='0000'){
            $status = '1';
            $sukses = true;
            $noresi = $res[$this->FIELD_NORESI];
            if(empty($res[$this->FIELD_NOREF_PULSA_GAME])){
                $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI ANDA '.$produk.' KE '.$idpel.' SEDANG DIPROSES';
            }else{
                $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI ANDA '.$produk.' KE '.$idpel.' BERHASIL. SN = '.$res[$this->FIELD_NOREF_PULSA_GAME];
            }
            
            //update saldo supplier
            $this->load->model('saldo_supplier_model');
            $this->saldo_supplier_model->update_data('PPOB', array(
                'tgl_update' => date('Y-m-d H:i:s'),
                'saldo' => floatval($res[$this->FIELD_SALDO_PULSA_GAME]),
            ));
        }else if($rc=='0046'){  //saldo tidak cukup
            $rc = '0005';
            $res[$this->FIELD_KETERANGAN] = 'TRANSAKSI TIDAK DAPAT DIPROSES. SILAHKAN DICOBA LAGI';
        }
        
        $this->ppob->update_data($id, array(
            'rc' => $rc,
            'ket' => $res[$this->FIELD_KETERANGAN],
            'status' => $status,
            'noresi' => $noresi,
            'nominal' => floatval($res[$this->FIELD_NOMINAL]),
            'struk' => ''
        ));
        
        $this->response(array(
            'status' => true,
            'message' => $res[$this->FIELD_KETERANGAN],
            'data' => array(
                'sukses' => $sukses,
                'rc' => $res[$this->FIELD_RC],
                'ket' => $res[$this->FIELD_KETERANGAN],
                'struk' => $res[$this->FIELD_KETERANGAN],
                'idpel' => $res[$this->FIELD_IDPEL_PULSA_GAME],
                'nominal' => floatval($res[$this->FIELD_NOMINAL])
            )
        ));
    }

    private function send($url, $data){
        $this->load->library('curl');
        $json = json_encode($data);
        $this->curl->create($url);
        if(substr($url, 0, 5)==='https'){
            // For SSL Sites. Check whether the Host Name you are connecting to is valid
            $this->curl->option('SSL_VERIFYPEER', false);
            //  Ensure that the server is the server you mean to be talking to
            $this->curl->option('SSL_VERIFYHOST', false);
            // Defines the SSL Version to be Used
//            $this->curl->option('SSLVERSION', 3);
        }
        $this->curl->option(CURLOPT_HTTPHEADER, array('Content-type: application/json; Charset=UTF-8'));
        $this->curl->post($json);
        // Execute - returns responce 
        $result = $this->curl->execute();

        $res = json_decode($result);
        
        if($this->curl->error_code){
            $this->session->set_flashdata('msg_err', $this->curl->error_string);
        }
        
        return $res;
    }    
}