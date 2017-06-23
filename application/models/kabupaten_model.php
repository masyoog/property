<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Kabupaten_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_kabupaten';
    }
    function get_datalist($prov=''){
        $where = array();
        if(!empty($prov)){
            $where=array(
                'id_provinsi' => $prov
            );
        }
        $prov = $this->read_data('','',$where, 'nama');
        $datalist=array();
        if(count($prov)>0){
            foreach($prov as $val){
                $datalist[$val->id] = $val->nama.(!empty($val->kode)?' ('.$val->kode.')':'');
            }
        }
        return $datalist;
    }
    function get_data_detail($id) {
        $this->db->select('k.*, p.nama as provinsi');
        $this->db->from('m_kabupaten k');
        $this->db->where('k.id', $id);
        $this->db->join("m_provinsi p", "p.id=k.id_provinsi",'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
    function get_data_like($param){
        $this->db->select('k.id, k.kode, k.nama as kabupaten, p.nama as provinsi');
        $this->db->from('m_kabupaten k');
        $this->db->join("m_provinsi p", "p.id=k.id_provinsi",'left');
        $this->db->like('k.nama', $param);
        $this->db->limit(10);
        $sql = $this->db->get();
        if($sql->num_rows() > 0){
            $rs=$sql->result();
            foreach ($rs as $row) {
                $row->label = $row->kabupaten.', '.$row->provinsi;
                $row->value = $row->kabupaten.', '.$row->provinsi;
                $row->name = $row->kabupaten.', '.$row->provinsi;
                $data[] = $row;
            }
            return $data;
        }else{
            return array();
        }
    }
}
