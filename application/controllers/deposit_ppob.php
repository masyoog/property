<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Deposit_ppob extends Site_Controller {
    protected $template_name = "default";

    private $field;
    
    public function __construct() {
        parent::__construct();
        $this->load->model('deposit_ppob_model', 'my_model');
        
    }
    
    function index(){
        $data = array(
            "title" => "Topup Deposit PPOB",
            'subtitle' => 'Topup PPOB',
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
        
        $data['response'] = '';
        $sal = $this->my_model->get_data('PPOB');
        $data['saldo'] = _format_angka($sal->saldo);
        
        $this->view2($data);
    }
    function tiket(){
        $data = array(
            "title" => "Topup Deposit PPOB",
            'subtitle' => 'Topup PPOB',
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
        
        $param = $this->input->post();
        $nominal = floatval($param['nominal']);
        if($nominal<=0){
            $data['response'] = 'Nominal tidak valid. Silahkan input nominal dengan angka yang valid.';
        }
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/admin/tiket';
//        _var_dump($url);
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
            'nominal' => $nominal.'',
        ));
//        _var_dump($res);
//        die();
        
        $data['response'] = $res['4'];
        $sal = $this->my_model->get_data('PPOB');
        $data['saldo'] = _format_angka($sal->saldo);
        
        $this->view2($data);
    }
    function hapus_tiket(){
        $data = array(
            "title" => "Topup Deposit PPOB",
            'subtitle' => 'Topup PPOB',
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
        
        
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/admin/hapus_tiket';
//        _var_dump($url);
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
        ));
//        _var_dump($res);
//        die();
        
        $data['response'] = $res['4'];
        $sal = $this->my_model->get_data('PPOB');
        $data['saldo'] = _format_angka($sal->saldo);
        
        $this->view2($data);
    }
    function refresh(){
        //send to server
        $this->load->model('setting_model');
        $url = $this->setting_model->get_ppob_url().'/admin/saldo';
//        _var_dump($url);
        $res = $this->send($url, array(
            'user' => $this->setting_model->get_ppob_user(),
            'pass' => md5($this->setting_model->get_ppob_pin()),
        ));
//        _var_dump($res);
//        die();
        $rc = $res['3'];
        
        if($rc=='0000'){
            //sukses
            $saldo = floatval($res['6']['3']);
            $this->my_model->update_data('PPOB', array('saldo' => $saldo));
            
        }else{
            //gagal
            $this->session->set_flashdata('msg_err', $res['4']);
        }
        
        redirect(base_url().$this->class_name);
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
