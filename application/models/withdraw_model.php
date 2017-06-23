<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Withdraw_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_request_withdraw';
    }
    
    public function cancel_withdraw($data){
        //refund saldo
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($data['id_member'], $data['jenis_rekening']);
        if($data['jenis_rekening'] == 'SIPRO'){
            $this->load->model('sipro_model', 'model');
        }else{
            $this->load->model('wallet_model', 'model');
        }
        $refund = $this->model->refund(array(
            'norek' => $norek,
            'nominal' => $data['nominal'],
            'ket' => 'REFUND WDR '.$data['id'],
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));
        if($refund){
            //update status
            $this->db->where('id', $data['id']);
            $this->db->update($this->table_name, array(
                'status' => $data['status'],
                'ket' => $data['ket'],
                'user_update' => $data['user_input'],
                'tgl_update' => $data['tgl_input'],
            ));
            return true;
        }else{
            return false;
        }
        
    }
}
