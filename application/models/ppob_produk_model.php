<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Ppob_produk_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_ppob_produk';
    }
    
    function get_pdam(){
        $where = array('p.id_group' => '37');
        return $this->get_datalist($where);
    }
    function get_pinjaman(){
        $where = array('p.id_group' => '38');
        return $this->get_datalist($where);
    }
    function get_telp_pasca(){
        $where = array('p.id_group' => '36');
        return $this->get_datalist($where);
    }
    function get_tv(){
        $where = array('p.id_group' => '35');
        return $this->get_datalist($where);
    }
    function get_pulsa($opr){
        $where = array('p.id_group' => $opr);
        
        $this->db->select('p.kode, p.nama, p.fee_member');
        $this->db->from($this->table_name.' p');
        $this->db->where($where);
        $this->db->order_by('denom, nama');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs=$query->result();
            foreach ($rs as $row) {
                $data[$row->kode] = $row->nama;
            }
            return $data;
        } else {
            return array();
        }
    }
    function get_game($opr){
        $where = array('p.id_group' => $opr);
        
        $this->db->select('p.kode, p.nama, p.fee_member');
        $this->db->from($this->table_name.' p');
        $this->db->where($where);
        $this->db->where('p.status', '1');
        $this->db->order_by('denom, nama');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs=$query->result();
            foreach ($rs as $row) {
                $data[$row->kode] = $row->nama;
            }
            return $data;
        } else {
            return array();
        }
    }
    function get_operator_pulsa(){
        $this->db->select('id, nama');
        $this->db->from('m_ppob_produk_group');
        $this->db->where('jenis', 'PULSA');
        $this->db->order_by('nama');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs=$query->result();
            foreach ($rs as $row) {
                $data[$row->id] = $row->nama;
            }
            return $data;
        } else {
            return array();
        }
    }
    function get_operator_game(){
        $this->db->select('id, nama');
        $this->db->from('m_ppob_produk_group');
        $this->db->where('jenis', 'GAME');
        $this->db->order_by('nama');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs=$query->result();
            foreach ($rs as $row) {
                $data[$row->id] = $row->nama;
            }
            return $data;
        } else {
            return array();
        }
    }
    
    private function get_datalist($where = array()){
        $this->db->select('p.kode, p.nama, p.fee_member');
        $this->db->from($this->table_name.' p');
        $this->db->where($where);
        $this->db->where('p.status', '1');
        $this->db->order_by('nama');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs=$query->result();
            foreach ($rs as $row) {
                $data[$row->kode] = $row->nama;
            }
            return $data;
        } else {
            return array();
        }
    }
}
