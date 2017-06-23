<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Transaksi_ppob_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_transaksi_ppob';
    }
    
    /*
     * data = array
     * id_member =>
     * tgl => 
     */
    function history_payment($param){
        $data = array();
        $this->db->where(array(
            'id_member' => $param['id_member'],
            'type' => '1',
        ));
        $this->db->like("date(tgl)", $param['tgl'], 'after');
        $sql = $this->db->get($this->table_name);
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return $data;
        }
        
    }
    
    function insert_data($data) {
        $this->db->insert($this->table_name, $data);
        if ($this->db->affected_rows() > 0) {
            $id = $this->db->insert_id();
            return $id;
        } else {
            return false;
        }
    }
    
    function insert_suspect($data){
        $this->db->insert('t_transaksi_ppob_suspect', $data);
        if ($this->db->affected_rows() > 0) {
            $id = $this->db->insert_id();
            return $id;
        } else {
            return false;
        }
    }
    
}
