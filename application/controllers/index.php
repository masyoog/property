<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {
    
    function __construct(){
        parent::__construct();
    }
    
    function index() {
        $data = array(
            "title" => "LOGIN"
        );
        if($this->input->post("username")){
            $this->verify();
        }else{
            if(!empty($this->nativesession->get(USER_AUTH))){
                redirect('dashboard', 'refresh');
            }
        }
        $this->template->load('template/login', 'index/index', $data);        
        
    }

    private function verify() {
        $this->load->model('user_model', '', TRUE);
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_cek_db');

        if ($this->form_validation->run()) {
            redirect('dashboard', 'refresh');
        }
    }
    
    function cek_db(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->user_model->login($username, $password);
        
        if ($result) {
            $this->load->model('menu_model');
            $this->load->model('group_user_model');
            $row=$result[0];
            $dashboard = $this->group_user_model->get_dashboard($row->id_user_group);
            $menu_flat=$this->menu_model->get_all_menu($row->id_user_group);
//            echo "<pre>";print_r($menu_flat);echo"</pre>";
            $nodes = array();
            $menu = array();
            $hak_akses=array();
            $parent_menu=array();
            if(count($menu_flat) > 0){
                foreach ($menu_flat as &$node) {
                    $parent_menu[$node['link']] = $node['parent'];
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
            }
            $role_profile =  array(
                'profile' => array(
                    'print' => 1,
                    'add' => 1,
                    'delete' => 1,
                    'edit' => 1,
                    'export' => 1,
                )
            );
            $sess_array = array(
                'login'=>true,
                'username' => $row->id_user,
                'nama' => $row->nama,
                'nama_group' => $row->nama_group,
                'level' => $row->id_user_group,
                'cabang' => $row->id_cabang,
                'menu' => $menu,
                'menu_parent' => $parent_menu,
                'dashboard' => $dashboard,
                'role' => array_merge($hak_akses,$role_profile),
            );
            $this->nativesession->set(USER_AUTH, $sess_array);
            
            return true;
        } else {
            $this->form_validation->set_message('cek_db', 'Username/password tidak cocok');
            $this->session->unset_userdata(USER_AUTH);
            $this->nativesession->delete(USER_AUTH);
            return false;
        }
    }
    
    function logout() {
//        $this->session->sess_destroy();
//        $this->nativesession->destroy();
        $this->session->unset_userdata(USER_AUTH);
        $this->nativesession->delete(USER_AUTH);
        redirect('index', 'refresh');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */