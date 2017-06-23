<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';
class Profile extends REST_Controller {
    private $id_group_user_customer = '2';
    
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
        
        $member = $this->member_model->get_profile($user);
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => $member
        ));
        
    }
    function update_device_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $device = isset($param['id'])?$param['id']:'';
        
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
        
        $this->member_model->update_device_id($user, $device);
        
        $this->response(array(
            'status' => true,
            'message' => 'Device ID updated successfully.',
        ));
        
    }
    function forgot_password_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $email = isset($param['email'])?$param['email']:'';
        
        if(empty($email)){
            $this->response(
                array('status'=>false,'msg'=>'Email harus diisi.')
            );
            return;
        }
        //cek email exist
        $this->load->model('member_model');
        $exist = $this->member_model->read_data('','',array('email'=>$email));
        if(!$exist){
            $this->response(
                array('status'=>false, 'error'=>'Email '.$email.' tidak ditemukan.')
            );
            return;
        }
        
        $token = strtoupper(time().md5($email.time().$this->config->item('encryption_key')));
        $insert = $this->account_model->reset_pass($email, $token);
        if($insert){
            $url_reset = 'https://pro2m.co.id/reset_password/'.$token;

            $config_email = array(
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
            $this->load->library('email', $config_email);

            $this->email->to($email);
            $this->email->from($this->config->item('smtp_user'), 'PRO2M');

            $this->email->subject('[PRO2M] UBAH PASSWORD');
            $msg = '
                Dengan hormat,<br>
                Bersama ini kami kirimkan tautan yang dapat digunakan untuk reset password Anda.<br><br>

                Silahkan mengikuti URL berikut: <br>
                '.$url_reset.' <br><br>

                Terima kasih. <br><br>

                Hormat Kami, <br>
                PRO2M
                ';
            $this->email->message($msg);
            if($this->email->send()){
                $this->response(
                    array('status'=>true, 'message'=>'Email telah berhasil dikirimkan. Silahkan mengikuti URL yang ada di email Anda.')
                );
            }else{
                $this->response(
                    array('status'=>false, 'error'=>'Gagal mengirimkan ke email, silahkan menghubungi customer service kami.')
                );
            }
        }else{
            $this->response(
                array('status'=>false, 'message'=>'Proses gagal dilakukan, silahkan menghubungi customer service kami.')
            );
        }
    }
    function edit_post(){
        $user = $this->post('uid');
        $pass = $this->post('pid');
        
        $no_akun = $this->post('id_customer');
        $nama = $this->post('nama');
        $email = $this->post('email');
        $telp = $this->post('telp');
        $alamat = $this->post('alamat');
        $alamat2 = $this->post('alamat2');
        $cabang = $this->post('id_cabang');
        $kodepos = $this->post('kodepos');
        
        if(empty($user)){
            $this->response(
                array('status'=>false,'msg'=>'Anda tidak mempunyai hak akses.')
            );
            return;
        }
        if(empty($nama)){
            $this->response(
                array('status'=>false,'msg'=>'Data input tidak lengkap.')
            );
            return;
        }
        if(empty($email)){
            $this->response(
                array('status'=>false,'msg'=>'Data input tidak lengkap.')
            );
            return;
        }
        if(empty($telp)){
            $this->response(
                array('status'=>false,'msg'=>'Data input tidak lengkap.')
            );
            return;
        }
        if(empty($alamat)){
            $this->response(
                array('status'=>false,'msg'=>'Data input tidak lengkap.')
            );
            return;
        }
        
        //login
        $this->load->model('user_model');
        $data_user = $this->user_model->login_api($user, $pass);
        if(!$data_user){
            $this->response(
                array('status'=>false, 'msg'=>'Password yang Anda masukkan salah.')
            );
            return;
        }
        
        $dt = array(
            'nama'=>strtoupper($nama),
            'id_customer'=>$no_akun,
            'user'=>$email,
            'telp'=>$telp,
            'email'=>$email,
            'alamat'=> strtoupper($alamat),
            'alamat2'=> strtoupper($alamat2),
            'id_cabang'=>$cabang,
            'kodepos'=>$kodepos,
        );
        
        $this->load->model('account_model');
        $update = $this->account_model->update_account($user, $dt);
        if ($update) {
            $data = $data_user;
            $data->status=true;
            $data->msg='Account telah berhasil diubah';
        } else {
            $data = array('status' => false, 'msg' => 'Update account gagal dilakukan');
        }
        
        $this->response($data);
        
    }
    function ubah_password_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $pass_baru = isset($param['pass_baru'])?$param['pass_baru']:'';
        
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
        
        $update = $this->member_model->update_data($user, array('pass'=>$pass_baru));
        if ($update) {
            $data = array('status' => true, 'message' => 'Password telah berhasil diubah');
        } else {
            $data = array('status' => false, 'error' => 'Update password gagal dilakukan');
        }
        
        $this->response($data);
    }
    
    function tambah_bank_post(){
        $param = json_decode(file_get_contents('php://input'), TRUE);
        
        $user = isset($param['uid'])?$param['uid']:'';
        $pass = isset($param['pid'])?$param['pid']:'';
        $id_bank = isset($param['id_bank'])?$param['id_bank']:'';
        $norek = isset($param['norek'])?$param['norek']:'';
        $atas_nama = isset($param['atas_nama'])?strtoupper($param['atas_nama']):'';
        
        if(empty($user) || empty($pass)){
            $this->response(
                array('status'=>false, 'error'=>'Invalid Credentials')
            );
            return;
        }
        if(empty($id_bank)){
            $this->response(
                array('status'=>false, 'error'=>'Bank harus diisi')
            );
            return;
        }
        if(empty($norek)){
            $this->response(
                array('status'=>false, 'error'=>'Nomor rekening harus diisi')
            );
            return;
        }
        if(empty($atas_nama)){
            $this->response(
                array('status'=>false, 'error'=>'Atas nama harus diisi')
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
        
        $this->load->model('member_model');
        $add = $data = $this->member_model->tambah_bank(array(
            'id_member' => $user,
            'id_kode_bank' => $id_bank,
            'norek' => $norek,
            'atas_nama' => $atas_nama,
        ));
        if($add){
            $this->response(
                array(
                    'status' => true,
                    'message' => 'Penambahan bank telah berhasil dilakukan.'
                )
            );
        }else{
            $this->response(
                array('status'=> false, 'error' => 'Gagal melakukan penambahan bank. Silahkan coba beberapa saat lagi.')
            );
        }
    }
    function bank_get(){
        $user = $this->get('uid');
        
        $this->load->model('member_model');
        $data = $this->member_model->get_bank($user);
        
        $this->response($data);
    }
    
}