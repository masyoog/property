<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends Site_Controller {
    protected $template_name = "default";
    private $field;
    private $stat;

    function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('dashboard_model', 'my_model');
        
    }

    function index() {
        //buat nanti
        $this->data['dashboard']['panel']['revenue'] = false;
        $this->data['dashboard']['panel']['revenue2'] = false;
        $this->data['dashboard']['panel']['revenue3'] = false;
        $this->data['dashboard']['panel']['revenue4'] = false;
        //
        $data = array(
            "title" => "DASHBOARD",
            'subtitle' => 'reports & statistics',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/rickshaw/rickshaw.css",
                base_url() . "assets/css/theme-default/libs/morris/morris.core.css",
            ),
            'js' => array(
                base_url() . "assets/js/libs/moment/moment.min.js",
                base_url() . "assets/js/libs/flot/jquery.flot.min.js",
                base_url() . "assets/js/libs/flot/jquery.flot.time.min.js",
                base_url() . "assets/js/libs/flot/jquery.flot.resize.min.js",
                base_url() . "assets/js/libs/flot/jquery.flot.orderBars.js",
                base_url() . "assets/js/libs/flot/jquery.flot.pie.js",
                base_url() . "assets/js/libs/flot/curvedLines.js",
                base_url() . "assets/js/libs/jquery-knob/jquery.knob.min.js",
                base_url() . "assets/js/libs/sparkline/jquery.sparkline.min.js",
                base_url() . "assets/js/libs/d3/d3.min.js",
                base_url() . "assets/js/libs/d3/d3.v3.js",
                base_url() . "assets/js/libs/rickshaw/rickshaw.min.js",
                base_url() . "assets/js/core/demo/DemoDashboard.js",
                base_url() . "assets/js/pages/dashboard.js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        
        $this->view($data);
    }
    function get_total(){
        $data = array(
            'withdraw' => $this->my_model->get_total('withdraw'),
            'aktivasi' => $this->my_model->get_total('aktivasi'),
            'topup' => $this->my_model->get_total('topup'),
            'komplain' => $this->my_model->get_total('komplain'),
            'testimonial' => $this->my_model->get_total('testimonial'),
        );
        echo json_encode($data);
    }
    function get_total_dashboard(){
        $tot_member_aktif = $this->my_model->get_total('member_aktif');
        $tot_member_nonaktif = $this->my_model->get_total('member_nonaktif');
        $tot_member = $tot_member_aktif+$tot_member_nonaktif;
        $data = array(
            'member_aktif' => $tot_member_aktif,
            'member_nonaktif' => $tot_member_nonaktif,
            'member_aktif_persen' => _format_uang($tot_member_aktif/($tot_member)),
            'member_nonaktif_persen' => _format_uang($tot_member_nonaktif/($tot_member)),
        );
        echo json_encode($data);
    }
}
