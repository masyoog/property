<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Jaringan_mitra_kerja extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        
    }
    
    function index() {
        $data = array(
            "title" => "Jaringan Mitra Kerja",
            'subtitle' => 'List Data',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/bootstrap-treeview/bootstrap-treeview.min.css", 
                base_url() . "assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css", 
            ),
            'js' => array(
                base_url() . "assets/js/libs/jquery-ui/jquery-ui.min.js",
                base_url() . "assets/js/libs/bootstrap-treeview/bootstrap-treeview.min.js",
                base_url() . "assets/js/pages/".$this->class_name.".js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        
        $this->view($data);
    }
}
