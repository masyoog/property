<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

Class User_model extends Base_Model {
    
    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_user';
    }
    function get_data($id, $field_id=null) {
        $this->db->select("u.id_user, u.nama, g.nama AS nama_group, u.status, "
                . "u.user_input, u.tgl_input, u.user_update, u.tgl_update", false);
        $this->db->from('m_user u');
        $this->db->where('u.id_user', $id);
        $this->db->join('m_user_group g', 'u.id_user_group=g.id', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
    function login($username, $password) {
        $this->db->select('u.id_user, u.password, u.nama, u.id_user_group, u.id_cabang, g.nama as nama_group');
        $this->db->from('m_user u');
        $this->db->join('m_user_group g','u.id_user_group = g.id', 'left');
        $this->db->where('u.id_user', $username);
        $this->db->where('u.password', md5($password));
        $this->db->where('u.status', '1');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    function login_menu($username){
        $this->db->select('a.id_menu, a.add, a.edit, a.delete, a.print, a.export');
        $this->db->from('m_user_akses a');
        $this->db->join('m_user u', 'u.id_user_group=a.id_group_user');
        $this->db->where('u.user', $username);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $res = $query->result();
            foreach($res as $row){
                $data[] = $row->id_menu;
            }
            return $data;
        }else{
            return null;
        }
    }
    function read_data_join_group($limit='', $offset='', $where=array()) {
        $this->db->select('u.*, g.nama AS nama_group');
        $this->db->from('m_user AS u');
        $this->db->join('m_user_group AS g', 'g.id=u.id_user_group', 'LEFT');
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
        $sql = $this->db->get();
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
    function get_data_join_group($where=array()){
        $this->db->select('u.*, g.nama AS nama_group');
        $this->db->from('m_user AS u');
        $this->db->join('m_user_group AS g', 'g.id=u.id_user_group', 'LEFT');
        if(count($where)>0){
            foreach($where as $key => $val){
                $this->db->where($key, $val);
            }
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
    function get_total_data_join_group($where=array()){
        $this->db->select('COUNT(u.id_user) AS jml');
        $this->db->from('m_user AS u');
        $this->db->join('m_user_group AS g', 'g.id=u.id_user_group', 'LEFT');
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
}
