<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Penarikan_wallet extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('wallet_model', 'my_model');
        
    }
    
    function index(){
        $data = array(
            "title" => "Tarik Tunai Rekening E-Wallet",
            'subtitle' => 'Setoran Dana',
            'fields' => $this->field,
            'css' => array(
                base_url() . "assets/css/theme-default/libs/select2/select2.css",
                base_url() . "assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css", 
            ),
            'js' => array(
                base_url() . "assets/js/libs/jquery-ui/jquery-ui.min.js",
                base_url() . "assets/js/libs/select2/select2.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
                base_url() . "assets/js/pages/".$this->class_name.".js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        
        $this->load->model('bank_model');
        $data['bank_list'] = $this->bank_model->get_datalist();
        
        $this->view2($data);
    }
    
    function insert() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('id_member', 'ID Member', 'trim|required|xss_clean|callback_cek_member');
        $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required|numeric|xss_clean|callback_cek_saldo');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id_member' => $input['id_member'],
                'nominal' => floatval($input['nominal']),
                'ket' => $input['ket'],
                'user_input' => $this->data['username'],
                'tgl_input' => $now,
            );
            $create = $this->my_model->tarikan($data);
            if ($create) {
                $this->load->model('member_model');
                $member = $this->member_model->get_data($data['id_member']);
                //send email
                $config = array(
                    'smtp_crypto' => 'tls',
                    'protocol' => 'smtp',
                    'smtp_host' => $this->config->item('smtp_host'),
                    'smtp_user' => $this->config->item('smtp_user'),
                    'smtp_pass' => $this->config->item('smtp_pass'),
                    'smtp_port' => $this->config->item('smtp_port'),
                    'mailtype' => 'text',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'crlf' => "\r\n",
                    'newline' => "\r\n"
                );
                $this->load->library('email', $config);

                $this->email->to($member->email);
                $this->email->from($this->config->item('smtp_user'), 'PRO2M');

                $this->email->subject('[PRO2M] PENARIKAN DANA E-WALLET');
                $msg = '
                    Dear '.$member->nama.' ('.$member->id.'),
                        
                    Penarikan dana rekening E-WALLET Anda telah berhasil dilakukan sebesar Rp '._format_angka($data['nominal']).'.

                    Terima kasih.

                    Regards,
                    PRO2M
                    ';
                $this->email->message($msg);
                $msgs = array();
                $err_msgs = array();
                if($this->email->send()){
                    $msgs[] = 'Email telah berhasil dikirimkan ke '.$member->email;
                }else{
                    $err_msgs[] = 'GAGAL mengirimkan email ke '.$member->email.'.';
                }
                
                //send sms
                $this->load->model('outbox_model');
                $this->outbox_model->send_sms(array(
                    'nomor' => $member->nohp,
                    'id_member' => $member->id,
                    'nama' => $member->nama,
                    'tgl' => date('Y-m-d H:i:s'),
                    'pesan' => 'Yth.'.$member->nama.' ('.$member->id.'), penarikan dana rekening E-WALLET Anda telah berhasil dilakukan sebesar Rp '._format_angka($data['nominal']),
                    'type' => '1',
                    'port' => '0',
                    'status' => '0'
                ));
                $msgs[] = 'Data telah berhasil disimpan.';
                
                if(!empty($msgs)){
                    $this->session->set_flashdata('msg', implode('<br>', $msgs));
                }
                if(!empty($err_msgs)){
                    $this->session->set_flashdata('msg_err', implode('<br>', $err_msgs));
                }
                
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }
    
    function cek_member(){
        $id=$this->input->post('id_member');
        $this->load->model('member_model');
        $res = $this->member_model->get_data($id);
        if($res==null){
            $this->form_validation->set_message('cek_member', 'ID Member tidak ditemukan.');
            return false;
        }else{
            return true;
        }        
    }
    function cek_saldo(){
        $id=$this->input->post('id_member');
        $bank = $this->input->post('bank');
        $nominal = floatval($this->input->post('nominal'));
        $this->load->model('rekening_model');
        if($bank!='WALLET' || empty($id)){
            return true;
        }
        $norek = $this->rekening_model->get_norek_member($id, 'WALLET');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        
        if($saldo<$nominal){
            $this->form_validation->set_message('cek_saldo', 'Saldo Member tidak mencukupi. Saldo yang bisa digunakan sebesar '._format_angka($saldo));
            return false;
        }else{
            return true;
        }        
    }
}
