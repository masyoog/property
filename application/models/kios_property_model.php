<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Kios_property_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_produk';
    }
    function get_produk(){
        $this->db->select();
//        $this->db->where('status','1');
        $this->db->order_by('id', 'desc');
        $sql = $this->db->get($this->table_name);
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $row->harga = _format_angka($row->harga);
                $row->gambar = base_url().'media/catalog_property/'.$row->gambar;
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }
    function get_foto($id){
        $this->db->where('id', $id);
        $sql = $this->db->get('m_produk_foto');
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $row->gambar = base_url().'media/kios_property/'.$row->gambar;
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
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
        $this->db->select('m.id_member, m.tgl, m.nama, m.alamat, b.kota, m.notelp, m.about_me, m.bisnis, m.alamat_bisnis, '
                . 'm.bisnis_lat, m.bisnis_lng, m.foto, l.kode as level');
        $this->db->from('m_member_profile m');
        $this->db->join('m_member b', 'm.id_member=b.id', 'left');
        $this->db->join('m_level l', 'b.level=l.level', 'left');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                if(empty($row->foto)){
                    $row->foto = base_url().'media/avatar/default.png';
                }else{
                    $row->foto = base_url().'media/avatar/'.$row->foto;
                }
                $row->tgl = _format_tgl($row->tgl);
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }
}
