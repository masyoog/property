<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Program_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_program';
    }
    function get_data_programlist(){
//        $investasi = array();
//        $this->db->select('id_program, count(distinct id_member) as member, sum(nominal) as nominal');
//        $this->db->from('t_investasi');
//        $this->db->group_by('id_program, id_member');
//        $sql = $this->db->get();
//        if($sql->num_rows() > 0){
//            $rs = $sql->result();
//            foreach ($rs as $row){
//                $investasi[$row->id_program] = $row;
//            }
//        }
        
        $this->db->select('p.id, p.nama, p.deskripsi, p.foto, p.nominal_target, p.tgl, count(distinct i.id_member) as jml_member, sum(i.nominal) as nominal_investasi');
        $this->db->from($this->table_name.' p');
        $this->db->join('t_investasi i', 'p.id=i.id_program', 'left');
        $this->db->where('p.status', '1');
        $this->db->group_by('i.id_program');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
//                $row->nominal_investasi = 0;
//                $row->jml_member = 0;
//                $row->prosentase = 0;
//                if(isset($investasi[$row->id])){
//                    $inv = $investasi[$row->id];
//                    $row->nominal_investasi = _format_angka($inv->nominal);
//                    $row->jml_member = _format_angka($inv->member);
//                    $row->prosentase = _format_uang($inv->nominal / $row->nominal_target);
//                }
                $row->foto = base_url().'media/bispro/'.$row->foto;
                $row->jml_member = _format_angka($row->jml_member);
                $row->prosentase = _format_uang(($row->nominal_investasi / $row->nominal_target)*100);
                $row->nominal_investasi = _format_angka($row->nominal_investasi);
                $row->nominal_target = _format_angka($row->nominal_target);
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }
    function get_datalist($where = array()){
        $program = $this->read_data('', '', $where);
        $datalist=array();
        if(count($program)>0){
            foreach($program as $val){
                $datalist[] = $val->nama;
            }
        }
        return $datalist;
    }
}
