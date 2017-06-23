<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Komisi_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'l_komisi';
    }
    
    function get_total_registrasi($id){
        $this->db->select('sum(nominal) as nominal');
        $this->db->from($this->table_name);
        $this->db->where('level', '1');
        $this->db->where('id_member', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res->nominal;
        } else {
            return 0;
        }
    }
    function get_total_royalty($id){
        $this->db->select('sum(nominal) as nominal');
        $this->db->from($this->table_name);
        $this->db->where('level <> ', '1');
        $this->db->where('id_member', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $res = $query->row();
            return $res->nominal;
        } else {
            return 0;
        }
    }
    function read_data_registrasi($id){
        $this->db->select('id_downline, nominal, level');
        $this->db->from($this->table_name);
        $this->db->where('level', '1');
        $this->db->where('id_member', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $rs=$query->result();
            foreach ($rs as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }
    
    function delete_komisi($where){
        $this->db->where($where);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
