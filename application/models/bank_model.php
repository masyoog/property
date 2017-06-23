<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Bank_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_bank';
    }
    function get_datalist(){
        $data = $this->read_data('', '', array('status'=>'1'));
        $datalist=array();
        if(count($data)>0){
            foreach($data as $val){
                $datalist[$val->id] = $val->nama.' - '.$val->norek;
            }
        }
        return $datalist;
    }
    function get_bank(){
        return $this->read_data('', '', array('status'=>'1', 'id > '=> '1'));
    }
    function get_kodebank(){
        $this->db->select('id, bank, kode, status');
        $this->db->from('m_bank_kode');
        $this->db->where('status', '1');
        $this->db->order_by('bank');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
        
    }
}
