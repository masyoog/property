<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Simpanan_pokok_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_simpanan_pokok';
    }
    
    /*
     * $data = array(
     *  'id_member' => 
     *  'nominal' => 
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function insert_data($data) {
        $data['tgl'] = date('Y-m-d H:i:s');
        $data['saldo_awal'] = $this->get_saldo_akhir();
        $data['saldo_akhir'] = $data['saldo_awal'] + $data['nominal'];
        
        $this->db->insert($this->table_name, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_saldo_akhir(){
        $this->db->select('saldo_akhir');
        $this->db->from($this->table_name);
        $this->db->order_by('id desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            return floatval($row->saldo_akhir);
        }else{
            return 0;
        }
    }
}
