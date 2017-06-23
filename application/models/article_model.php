<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Article_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_news';
    }
    function get_datalist(){
        return array();
        /*
        $this->db->select('m.id as id_member, t.tgl, t.testimonial, m.nama, l.kode as level, p.foto');
        $this->db->from($this->table_name.' t');
        $this->db->where('t.status', '1');
        $this->db->join('m_member m', 't.id_member=m.id', 'left');
        $this->db->join('m_member_profile p', 'm.id=p.id_member', 'left');
        $this->db->join('m_level l', 'm.level=l.level', 'left');
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
         * 
         */
    }
}
