<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Cabang_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_cabang';
    }
    function get_datalist($with_kode = true, $where = array()){
        $cabang = $this->read_data('', '', array_merge(array('status'=>'1'),$where));
        $cabanglist=array();
        if(count($cabang)>0){
            foreach($cabang as $val){
                $cabanglist[$val->kode] = ($with_kode?$val->kode.' - ':'').$val->nama;
            }
        }
        return $cabanglist;
    }
    function get_cabanglist(){
        $data = $this->read_data('','',array('status'=>'1'), 'id');
        $datalist=array();
        if(count($data)>0){
            foreach($data as $val){
                $datalist[] = $val;
            }
        }
        return $datalist;
    }
    function get_data_like($param){
        $this->db->select('kode, nama, alamat, email, notelp, fax, status');
        $this->db->from($this->table_name);
        $this->db->like('kode', $param);
        $this->db->or_like('nama', $param);
        $sql = $this->db->get();
        if($sql->num_rows() > 0){
            $rs=$sql->result();
            foreach ($rs as $row) {
                $data[] = $row;
            }
            return $data;
        }else{
            return array();
        }
    }
}
