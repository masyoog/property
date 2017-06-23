<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class News_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_news';
    }
    function get_datalist(){
        $this->db->select('id, judul title, gambar image, tgl date, user');
        $this->db->from($this->table_name);
        $this->db->order_by('tgl desc, id desc');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $row->date = _format_tgl($row->date);
                $row->image = base_url().'media/news/'.$row->image;
                $data[] = $row;
            }
            return $data;
        }else{
            return array();
        }
    }
    function get_item($id){
        $this->db->select('id, judul title, teks description, gambar image, tgl date, user', false);
        $this->db->from($this->table_name);
        $this->db->where('id', $id);
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $data=$sql->row();
            $data->date = _format_tgl($data->date);
            $data->image = base_url().'media/news/'.$data->image;
            return $data;
        }else{
            return array();
        }
    }
}
