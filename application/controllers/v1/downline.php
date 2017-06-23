<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH.'/libraries/REST_Controller.php';

class Downline extends REST_Controller {
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
    
    function jaringan_post(){
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
        $data = $this->member_model->get_member_tree($user);
        $nodes = array();
        $member = array();
        if(count($data) > 0){
            foreach ($data as &$node) {
//                $node['nodes'] = array();
                $id = $node['id'];
                $parent = $node['parent'];
                $node['name'] = $node['text'];
                unset($node['text'], $node['id'], $node['href'], $node['parent']);
                $nodes[$id] = & $node;
                if (array_key_exists($parent, $nodes)) {
                    $nodes[$parent]['tree'][] = & $node;
                } else {
                    $member[] = & $node;
                }
            }
        }
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => $member
        ));
    }
    
    function total_downline_post(){
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
        $downline = $this->member_model->get_total_downline($user);
        $downline1['aktif'] = floatval($downline['downline1'][0]);
        $downline1['non_aktif'] = floatval($downline['downline1'][1]);
        $downline1['total'] = $downline1['aktif'] + $downline1['non_aktif'];
        
        $downline2['aktif'] = floatval($downline['downline2'][0]);
        $downline2['non_aktif'] = floatval($downline['downline2'][1]);
        $downline2['total'] = $downline2['aktif'] + $downline2['non_aktif'];
        
        $downline3['aktif'] = floatval($downline['downline3'][0]);
        $downline3['non_aktif'] = floatval($downline['downline3'][1]);
        $downline3['total'] = $downline3['aktif'] + $downline3['non_aktif'];
        
        $downline4['aktif'] = floatval($downline['downline4'][0]);
        $downline4['non_aktif'] = floatval($downline['downline4'][1]);
        $downline4['total'] = $downline4['aktif'] + $downline4['non_aktif'];
        
        $downline5['aktif'] = floatval($downline['downline5'][0]);
        $downline5['non_aktif'] = floatval($downline['downline5'][1]);
        $downline5['total'] = $downline5['aktif'] + $downline5['non_aktif'];
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'downline1' => $downline1,
                'downline2' => $downline2,
                'downline3' => $downline3,
                'downline4' => $downline4,
                'downline5' => $downline5,
            ),
        ));
    }
    function total_downline1_post(){
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
        $total_downline = $this->member_model->get_total_downline1($user);
        
        $aktif = $total_downline[1];
        $non_aktif = $total_downline[0];
        $total = $aktif+$non_aktif;
        
        $this->response(array(
            'status' => true,
            'message' => '',
            'data' => array(
                'total' => floatval($total),
                'aktif' => floatval($aktif),
                'non_aktif' => floatval($non_aktif)
            ),
        ));
    }
}