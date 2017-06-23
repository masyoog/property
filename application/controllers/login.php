<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $cek = $this->session->userdata(USER_AUTH);
        if (empty($cek)) {
            $frm['captcha'] = $this->captcha();
            $this->load->view("login/index", $frm);
        } else {
            redirect('home', 'refresh');
        }
    }

    function verify() {
        $this->load->model('user_model', '', TRUE);
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_cek_db');
        $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|xss_clean|callback_cek_captcha');

        if ($this->form_validation->run() == false) {
            $frm['captcha'] = $this->captcha();
            $this->load->view('login/index', $frm);
        }else{
            redirect('home', 'refresh');
        }
    }

    private function captcha() {
        $this->load->helper('captcha');
        $this->session->unset_userdata('c_captcha');
        $vals = array(
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => './system/fonts/ltypeb.ttf',
            'img_width' => '150',
            'img_height' => 40,
            'expiration' => 7200
        );
        $cap = create_captcha($vals);
        $data = array(
            'captcha_time' => $cap['time'],
            'word' => $cap['word']
        );
        $this->session->set_userdata('c_captcha', $cap['word']);
        return $cap['image'];
    }
    
    function cek_captcha(){
        if(strtoupper($this->input->post('captcha')) == strtoupper($this->session->userdata('c_captcha'))){
            return true;
        }else{
            $this->form_validation->set_message('cek_captcha', 'Kode captcha tidak valid');
            $this->session->unset_userdata(USER_AUTH);
            return false;
        }
    }
    
    function cek_db(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->user_model->login($username, $password);

        if ($result) {
            $this->load->model('menu_model', '', TRUE);
            $row=$result[0];
            $menu_flat=$this->menu_model->get_all_menu($row->id_user_group);
//            echo "<pre>";print_r($menu_flat);echo"</pre>";
            $nodes = array();
            $menu = array();
            $hak_akses=array();
            $s_menu='';
            if(count($menu_flat) > 0){
                foreach ($menu_flat as &$node) {
                    if($node['link']!=''){
                        $hak_akses[$node['link']]=$node['role'];
                    }
                    $node['child'] = array();
                    $id = $node['id'];
                    $parent = $node['parent'];
                    $nodes[$id] = & $node;
                    if (array_key_exists($parent, $nodes)) {
                        $nodes[$parent]['child'][] = & $node;
                    } else {
                        $menu[] = & $node;
                    }
                }
                foreach($menu as $m){
                    if(count($m['child'])>0){
                        $s_menu.= '
                        <li>
                            <a href="#">'.(($m['icon']!='' && $m['icon']!='null')?'<i class="fa fa-'.$m['icon'].' fa-fw"></i>&nbsp;':'').ucfirst($m['menu']).' <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">';
                        foreach($m['child'] as $child){
                            $s_menu.= '
                                <li><a href="'.(($child['link']!='' && $child['link']!='null')?base_url().$child['link']:'#').'">'.(($child['icon']!='' && $child['icon']!='null')?'<i class="fa fa-'.$child['icon'].' fa-fw"></i>&nbsp;':'').ucfirst($child['menu']).'</a></li>';
                        }
                        $s_menu.= '
                            </ul>
                        </li>';
                    }else{
                        $s_menu.= '
                        <li><a href="'.(($m['link']!='' && $m['link']!='null')?base_url().$m['link']:'#').'">'.(($m['icon']!='' && $m['icon']!='null')?'<i class="fa fa-'.$m['icon'].' fa-fw"></i>&nbsp;':'').ucfirst($m['menu']).'</a></li>';
                        }
                }
            }
            $sess_array = array(
                'login'=>true,
                'id' => $row->id,
                'username' => $row->user,
                'nama' => $row->nama,
                'level' => $row->id_user_group,
                'cabang' => $row->id_cabang,
                'company' => $this->get_company($row->id_cabang),
                'is_nasional' => $row->is_nasional,
            );
            $this->session->set_userdata(USER_AUTH, $sess_array);
            $sess_menu = array(
                'menu' => $s_menu,
                'role' => $hak_akses,
            );
            $this->nativesession->set(USER_AUTH, $sess_menu);
            
            return true;
        } else {
            $this->form_validation->set_message('cek_db', 'Username/password tidak cocok');
            $this->session->unset_userdata(USER_AUTH);
            return false;
        }
    }
    
    private function get_company($cabang){
        $this->load->model('cabang_model');
        $data = $this->cabang_model->get_data($cabang);
        if($data == null) return;
        $this->load->model('setting_model');
        return array(
            'logo' => 'asset/logo/logo.jpg',
            'nama' => strtoupper($this->setting_model->get_nama_perusahaan()),
            'kode_cabang' => $data->id,
            'nama_cabang' => $data->nama,
            'no_cabang' => $data->kode,
            'alamat1' => $data->alamat,
            'alamat2' => $data->alamat2,
            'telp' => $data->telp,
            'fax' => $data->fax,
            'website' => $this->setting_model->get_website(),
            'email' => $this->setting_model->get_email(),
        );
    }

}
