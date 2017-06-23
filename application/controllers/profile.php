<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Profile extends Site_Controller {
    
    public function __construct() {
        //override hak akses
        $this->isAkses = true;
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $data = array(
            'title' => "My Account",
            'subtitle' => "Edit My Account",
            'js' => array(
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
            ),
        );
        
        $code=  $this->data['username'];
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->user_model->get_data($id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect("");
        } else {
            $value = array(
                'user'=>$res->id_user,
                'nama'=>$res->nama,
                'id'=>$id,
            );
            $data['value']=$value;
        }
        
//        $this->view($data);
        $this->template->load('template/default', 'profile/index', $data);        
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
                'id_user' => $this->input->post('user'),
                'password' => md5($this->input->post('pass')),
                'nama' => $this->input->post('nama'),
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            if(empty($this->input->post('pass')) && empty($this->input->post('pass_confirm'))){
                unset($data['pass']);
            }
            $update = $this->user_model->update_data($id, $data, 'id_user');
            if ($update) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed to save data');
            }
            redirect($this->class);
//            $this->index();
        }
    }
    function cek_double_username(){
        $user=$this->input->post('user');
        $id=$this->input->post('id');
        if($user==$id){
            return true;
        }
        $res = $this->user_model->get_total_data("(id_user='$user')", 'id_user');
        if($res>0){
            $this->form_validation->set_message('cek_double_username', 'Username already exist, please use another one');
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
            $this->form_validation->set_message('cek_pass_lama', 'Invalid old password');
            return false;
        }else{
            return true;
        }        
    }
}
