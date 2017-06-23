<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class My_Account extends Site_Controller {

    private $role;
    private $field;
    
    public function __construct() {
        //override hak akses
        $this->isAkses = true;
        parent::__construct();
        
        $this->load->model('user_model');
        
        $this->table_name = "m_user";
        $this->load->model('group_user_model');
        $this->grouplist = $this->group_user_model->get_datalist();
        $this->load->model('cabang_model');
        $this->cabanglist = $this->cabang_model->get_datalist();
        $this->field = array(
            'user' => array(
                'type'=>'text',
                'required'=>true,
                'label'=>'Username',
                'placeholder'=>'Username',
                'maxLength'=>32,
                'readonly'=>true,
            ),
            'pass_old' => array(
                'type'=>'password',
                'required'=>true,
                'label'=>'Password Lama',
                'placeholder'=>'Password Lama',
                'maxLength'=>32,
            ),
            'pass' => array(
                'type'=>'password',
                'required'=>false,
                'label'=>'Password Baru',
                'placeholder'=>'Password Baru',
                'maxLength'=>32,
            ),
            'pass_confirm' => array(
                'type'=>'password',
                'required'=>false,
                'label'=>'Password Baru Lagi',
                'placeholder'=>'Ulangi password Baru',
                'maxLength'=>32,
            ),
            'nama' => array(
                'type'=>'text',
                'required'=>true,
                'label'=>'Nama',
                'maxLength'=>48,
            ),
            'id' => array(
                'type'=>'hidden',
            ),
        );
    }

    function index() {
        $code=  $this->data['id'];
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->user_model->get_data($id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect('my_account');
        } else {
            $form_input = new My_form();
            $form_input->set($this->field);
            $value = array(
                'user'=>$res->user,
                'nama'=>$res->nama,
                'id'=>$id,
            );
            $form_input->set_value($value);
            $data["form_element"] = $form_input->render_form("edit");
        }
        $data['title']="My Account";
        $data['subtitle']="Edit My Account";
        $this->template->load('template', $this->class.'/input', $data);
    }
    
    function update() {
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('user', 'Username', 'trim|required|xss_clean|callback_cek_double_username');
        $this->form_validation->set_rules('pass_old', 'Password Lama', 'trim|required|xss_clean|callback_cek_pass_lama');
        $this->form_validation->set_rules('pass', 'Password Baru', 'trim|xss_clean|matches[pass_confirm]');
        $this->form_validation->set_rules('pass_confirm', 'Password Konfirmasi', 'trim|xss_clean');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $id = $this->input->post('id');
            $now=date('Y-m-d H:i:s');
            $data = array(
                'user' => $this->input->post('user'),
                'pass' => md5($this->input->post('pass').$this->config->item("encryption_key")),
                'nama' => $this->input->post('nama'),
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            if(empty($this->input->post('pass')) && empty($this->input->post('pass_confirm'))){
                unset($data['pass']);
            }
            $update = $this->user_model->update_data($id, $data);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data telah berhasil diubah');
            } else {
                $this->session->set_flashdata('msg_err', 'Data gagal diubah ');
            }
            redirect('home');
        }
    }
    function cek_double_username(){
        $user=$this->input->post('user');
        $id=$this->input->post('id');
        $res = $this->user_model->get_total_data("(user='$user' AND id<>'$id')");
        if($res>0){
            $this->form_validation->set_message('cek_double_username', 'Username sudah dipakai, silahkan menggunakan username lain');
            return false;
        }else{
            return true;
        }        
    }
    function cek_pass_lama(){
        $user=$this->data['username'];
        $pass=$this->input->post('pass_old');
        $res = $this->user_model->login($user, $pass);
        if($res===false){
            $this->form_validation->set_message('cek_pass_lama', 'Password lama tidak valid');
            return false;
        }else{
            return true;
        }        
    }
}
