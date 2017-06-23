<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Base_Model extends CI_Model {

    var $table_name;

    public function __construct() {
        parent::__construct();
    }

    function insert_data($data) {
        $this->db->insert($this->table_name, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function read_data($limit='', $offset='', $where=array(), $order_by = '') {
        if($limit!=''){
            $this->db->limit($limit, $offset);
        }
        if(is_string($where)){
            $this->db->where($where);
        }else{
            if(count($where)>0){
                foreach($where as $key => $val){
                    $this->db->where($key, $val);
                }
            }
        }
        if(!empty($order_by)){
            $this->db->order_by($order_by);
        }
        $sql = $this->db->get($this->table_name);
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

    function update_data($id, $data, $field_id='id') {
        $this->db->where($field_id, $id);
        $this->db->update($this->table_name, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_data($id, $field_id='id') {
        $this->db->where($field_id, $id);
        $this->db->delete($this->table_name);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_data($id, $field_id='id') {
        $this->db->where($field_id, $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
    
    function get_data_where($where){
        return $this->read_data('','',$where);
    }
    
    function get_total_data($where=array(), $field_id='id'){
        $this->db->select('COUNT('.$this->table_name.'.'.$field_id.') AS jml');
        $this->db->from($this->table_name);
        if(is_string($where)){
            $this->db->where($where);
        }else{
            if(count($where)>0){
                foreach($where as $key => $val){
                    $this->db->where($key, $val);
                }
            }
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            return $rs[0]->jml;
        } else {
            return 0;
        }
    }
    function get_nama($id){
        $data = $this->get_data($id);
        if($data === null){
            return '';
        }else{
            return strtoupper($data->nama);
        }
    }
}
