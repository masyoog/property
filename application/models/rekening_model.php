<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Rekening_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_rekening';
    }
    
    function get_norek_member($id_member, $jenis_rekening){
        $this->db->select('norek');
        $this->db->from($this->table_name);
        $this->db->where(array('id_member' => $id_member, 'jenis_rekening' => $jenis_rekening));
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row->norek;
        }else{
            return null;
        }
    }
    
    function get_norek_upline($uplines, $jenis_rekening){
        $uplines = implode("','", $uplines);
        $this->db->select('id_member,norek,saldo');
        $this->db->from($this->table_name);
        $this->db->where(array("id_member IN ('". $uplines."')" => null , 'jenis_rekening' => $jenis_rekening));
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return null;
        }
    }
    
    /*
     * $data = array(
     *  'id_member' => 
     *  'jenis_rekening' => 
     *  'saldo' 
     * )
     */
    function insert_data($data) {
        $prefix = '01';
        switch (strtolower($data['jenis_rekening'])){
            case 'wallet':
                $prefix = '01';
                break;
            case 'sipro':
                $prefix = '02';
                break;
            case 'bispro':
                $prefix = '03';
                break;
            case 'angsur':
                $prefix = '04';
                break;
            default:
                $prefix = '05';
                break;
        }
        $data['norek'] = $prefix.$data['id_member'];
        
        $this->db->insert($this->table_name, $data);
        if ($this->db->affected_rows() > 0) {
            return $data['norek'];
        } else {
            return false;
        }
    }
    function get_saldo_akhir($norek){
        $data = $this->get_data($norek, 'norek');
        if($data!=null){
            return floatval($data->saldo);
        }else{
            return 0;
        }
    }
    /*
    function get_data_detail($id, $field_id='id') {
        $this->db->select('a.account_id, b.name as dealer, i.investor_id, i.name as investor, i.address as alamat, i.phone as no_telp, '
                . 'i.mail as email, a.minimal_deposit, a.balance, a.status, '
                . 'a.user_id as user_input, date(a.create_time) as tgl_input, ');
        $this->db->from($this->table_name.' a');
        $this->db->join('investor i', 'a.investor_id=i.investor_id','left');
        $this->db->join('broker b', 'a.broker_id=b.broker_id', 'left');
        $this->db->where($field_id, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
     * 
     */
}
