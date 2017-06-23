<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Testimonial_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_testimonial';
    }
    
    function get_testimonial($id_member){
        $this->db->where(array('id_member'=>$id_member, 'status' => '1'));
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
    function get_datalist(){
        $this->db->select('m.id as id_member, t.tgl, t.testimonial, m.nama, l.kode as level, p.foto');
        $this->db->from($this->table_name.' t');
        $this->db->where('t.status', '1');
        $this->db->join('m_member m', 't.id_member=m.id', 'left');
        $this->db->join('m_member_profile p', 'm.id=p.id_member', 'left');
        $this->db->join('m_level l', 'm.level=l.level', 'left');
        $this->db->order_by('t.tgl desc');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                if(empty($row->foto)){
                    $row->foto = base_url().'media/avatar/default.png';
                }
                $row->tgl = _format_tgl($row->tgl);
                $data[] = $row;
            }
            return $data;
        }else{
            return array();
        }
    }
}
