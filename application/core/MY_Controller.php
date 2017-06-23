<?php

class Site_Controller extends CI_Controller {
    protected $class_name;
    protected $method_name;
    protected $template_name;
    
    var $auth;
    public $data;
    public $isAkses;
    public $title;
    public $subtitle;
    public $is_pusat = false;
    
    function __construct(){
        parent::__construct();        
        $this->class_name = $this->router->fetch_class();
        $this->method_name = $this->router->fetch_method();
        
        if($this->method_name == "view")exit("URL Not Valid");
        
        $this->title = $this->config->item("app_name");
        $this->class = $this->router->fetch_class();
        $sess1=array();
        $sess2=array();
        if(is_array($this->session->userdata(USER_AUTH))){
            $sess1=$this->session->userdata(USER_AUTH);
            $sess1['msg']=  $this->session->flashdata('msg');
            $sess1['msg_err']=  $this->session->flashdata('msg_err');
        }
        if(is_array($this->nativesession->get(USER_AUTH))){
            $sess2=$this->nativesession->get(USER_AUTH);
        }
        $this->data = array_merge($sess1, $sess2);
        $this->auth = new Userauth();
        if (!$this->auth->is_logged() && !$this->isAkses){
            redirect('', 'refresh');
        }
        if(!$this->auth->is_page() && !$this->isAkses){
            redirect($this->router->fetch_class().'/error_page');
        }
        if(!$this->auth->is_hak() && !$this->isAkses){
            redirect($this->router->fetch_class().'/error_page');
        }
        if(!empty($this->data['menu'])){
            $this->template->set('menu',  $this->get_menu());
        }
        if(!empty($this->data['nama'])){
            $this->template->set('nama', $this->data['nama']);
        }
        if(!empty($this->data['nama_group'])){
            $this->template->set('nama_group', $this->data['nama_group']);
        }
        if(empty($this->data['dealer'])){
            $this->is_pusat = true;
        }
    }
    
    function view($data = array()){
        $data = array_merge($data, 
            array(
                'class_name' => $this->class_name, 
                'method_name' => $this->method_name,
                'role' => isset($this->data['role'][$this->class_name]) ? $this->data['role'][$this->class_name] : array(),
            )
        );
        $method = $this->method_name;
        if($method=="insert"){
            $method = "add";
        }
        if($method=="update"){
            $method = "edit";
        }
        $this->template->load('template/'.$this->template_name, 
                $this->class_name.'/'.$method, 
                $data
        );        
    }
    function view2($data = array()){
        $data = array_merge($data, 
            array(
                'class_name' => $this->class_name, 
                'method_name' => $this->method_name,
                'role' => isset($this->data['role'][$this->class_name]) ? $this->data['role'][$this->class_name] : array(),
            )
        );
        $method = $this->method_name;
        if($method=="insert"){
            $method = "index";
        }
        if($method=="update"){
            $method = "edit";
        }
        $this->template->load('template/'.$this->template_name, 
                $this->class_name.'/'.$method, 
                $data
        );        
    }
    function get_menu(){
        $s_menu='';
        foreach($this->data['menu'] as $m){
            if(count($m['child'])>0){
                $s_menu.= '
                    <li class="gui-folder">
                        <a href="javascript:void(0);">'.(($m['icon']!='' && $m['icon']!='null')?'<div class="gui-icon"><i class="'.$m['icon'].'"></i></div>':'').'<span class="title">'.ucfirst($m['menu']).'</span></a>
                        <ul>';
                    foreach($m['child'] as $child){
                        $s_menu.= '
                            <li><a'.($this->class_name==$child['link']?' class="active"':'').' href="'.(($child['link']!='' && $child['link']!='null')?base_url().$child['link']:'#').'">'.(($child['icon']!='' && $child['icon']!='null')?'<i class="'.$child['icon'].'"></i>&nbsp;':'').'<span class="title">'.ucfirst($child['menu']).'</span></a></li>';
                    }
                    $s_menu.= '
                        </ul>
                    </li>
                ';
            }else{
                $s_menu.= '
                    <li>
                        <a'.($this->class_name==$m['link']?' class="active"':'').' href="'.(($m['link']!='' && $m['link']!='null')?base_url().$m['link']:'#').'">
                            '.(($m['icon']!='' && $m['icon']!='null')?'<div class="gui-icon"><i class="'.$m['icon'].'"></i></div>':'').'<span class="title">'.ucfirst($m['menu']).'</span>
                        </a>
                    </li>
                ';
            }
        }
        return $s_menu;
    }
    function error_page($msg='') {
        $data = '';
        $data['message'] = $msg;
        $this->template->set('title', 'Error Page');
        $this->template->load('template/default', '404', array_merge($this->data, $data));
    }
    function get_action_button($param, $args=""){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/detail/'.$param.'"><i class="fa fa-eye fa-fw"></i> Detail</a>';
            if($role['edit'] || $role['delete']){
                $ret.= '
                <button type="button" class="btn ink-reaction btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    '.($role['edit']?'<li><a href="'.  base_url().$this->class.'/edit/'.$param.'"><i class="fa fa-edit"></i> Edit Data</a></li>':'').'
                    '.($role['delete']?'<li><a href="'.base_url().$this->class.'/delete/'.$param.'" onClick="return confirm(\'Apakah Anda yakin ingin menghapus data?\');"><i class="fa fa-trash"></i> Hapus Data</a></li>':'').'
                </ul>';
            }
        $ret.='
            </div>';
        return $ret;
    }
}

class App_Controller extends Site_Controller {
    protected $class_name;
    protected $method_name;
    protected $template;
    
    function __construct(){
        parent::__construct();
        
        if(!isset($_SESSION["is_login"])){
            redirect("");
        }
    }
}
