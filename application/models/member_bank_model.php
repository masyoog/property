<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Member_bank_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_member_bank';
    }
    function get_bank($id){
        $this->db->select('b.id, b.norek, b.atas_nama, k.bank, k.kode');
        $this->db->from($this->table_name.' b');
        $this->db->join('m_bank_kode k', 'b.id_kode_bank=k.id', 'left');
        $this->db->where('b.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
}
