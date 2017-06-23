<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Group_user_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_user_group';
    }
    function insert_data($data) {
        $modul = $data['modul'];
        $dashboard = $data['dashboard'];
        unset($data['modul'], $data['dashboard']);
        
        $this->db->trans_start();
        $this->db->insert($this->table_name, $data);
        $id = $this->db->insert_id();
        if(!empty($modul) && count($modul)>0){
            $dt = array();
            foreach($modul as $key => $val){
                $dt[] = array(
                    'id_group_user' => $id,
                    'id_menu' => $key,
                    'print' => $val['print'],
                    'add' => $val['add'],
                    'delete' => $val['delete'],
                    'edit' => $val['edit'],
                    'export' => $val['export'],
                    'tgl_input' => $data['tgl_input'],
                    'user_input' => $data['user_input'],
                );
            }
            $this->db->insert_batch('m_user_akses', $dt);
        }
        $dashboard['id_group_user'] = $id;
        $dashboard['tgl_input'] = $data['tgl_input'];
        $dashboard['user_input'] = $data['user_input'];
        $this->db->insert('m_user_akses_dashboard', $dashboard);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE){
            //log error
            log_message();
            
            return false;
        }else{
            return true;
        }
    }
    function update_data($id, $data, $field_id=null) {
        $modul = $data['modul'];
        $dashboard = $data['dashboard'];
        unset($data['modul'], $data['dashboard']);
        
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        
        $this->db->where('id_group_user', $id);
        $this->db->delete('m_user_akses');
        
        if(!empty($modul) && count($modul)>0){
            $dt = array();
            foreach($modul as $key => $val){
                $dt[] = array(
                    'id_group_user' => $id,
                    'id_menu' => $key,
                    'print' => $val['print'],
                    'add' => $val['add'],
                    'delete' => $val['delete'],
                    'edit' => $val['edit'],
                    'export' => $val['export'],
                    'tgl_input' => $data['tgl_update'],
                    'user_input' => $data['user_update'],
                    'tgl_update' => $data['tgl_update'],
                    'user_update' => $data['user_update'],
                );
            }
            $this->db->insert_batch('m_user_akses', $dt);
        }
        $this->db->from('m_user_akses_dashboard');
        $this->db->where('id_group_user', $id);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $dashboard['tgl_input'] = $data['tgl_update'];
            $dashboard['user_input'] = $data['user_update'];
            $dashboard['tgl_update'] = $data['tgl_update'];
            $dashboard['user_update'] = $data['user_update'];
            $this->db->where('id_group_user', $id);
            $this->db->update('m_user_akses_dashboard', $dashboard);
        }else{
            $dashboard['id_group_user'] = $id;
            $dashboard['tgl_input'] = $data['tgl_update'];
            $dashboard['user_input'] = $data['user_update'];
            $dashboard['tgl_update'] = $data['tgl_update'];
            $dashboard['user_update'] = $data['user_update'];
            $this->db->insert('m_user_akses_dashboard', $dashboard);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE){
            //log error
            log_message();
            
            return false;
        }else{
            return true;
        }
    }
    function delete_data($id, $field_id=null) {
        $this->db->trans_start();
        
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
        
        $this->db->where('id_group_user', $id);
        $this->db->delete('m_user_akses');
        
        $this->db->where('id_group_user', $id);
        $this->db->delete('m_user_akses_dashboard');
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE){
            //log error
            log_message();
            
            return false;
        }else{
            return true;
        }
    }
    function get_datalist(){
        $usergroup = $this->read_data();
        $grouplist=array();
        if(count($usergroup)>0){
            foreach($usergroup as $val){
                $grouplist[$val->id] = $val->nama;
            }
        }
        return $grouplist;
    }
    function get_data($id, $field_id=null){
        $this->db->where('id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            $res = $query->row();
            $dashboard = $this->get_dashboard($res->id);
            return array(
                'id' => $res->id,
                'nama'=>$res->nama,
                'menu'=>$this->get_menu($res->id),
                'outstanding' => $dashboard['outstanding'],
                'summary' => $dashboard['summary'],
                'panel' => $dashboard['panel'],
            );
        } else {
            return null;
        }
    }
    function get_menu($group){
        $this->db->select('id_menu, print, add, delete, edit, export');
        $this->db->from('m_user_akses');
        $this->db->where('id_group_user', $group);
        $query = $this->db->get();
        if($query->num_rows()>0){
            $res = $query->result();
            $menu = array();
            foreach($res as $row){
                $menu[$row->id_menu] = array(
                    'print' => intval($row->print),
                    'add' => intval($row->add),
                    'delete' => intval($row->delete),
                    'edit' => intval($row->edit),
                    'export' => intval($row->export),
                );
            }
            return $menu;
        }else{
            return null;
        }
    }
    function get_dashboard($group){
        $this->db->from('m_user_akses_dashboard');
        $this->db->where('id_group_user', $group);
        $query = $this->db->get();
        if($query->num_rows()>0){
            $rs = $query->result();
            $res = $rs[0];
            return array(       
                'outstanding' => array(
                    'cn' => $res->out_cn,
                    'outgoing' => $res->out_outgoing,
                    'incoming' => $res->out_incoming,
                    'delivery' => $res->out_delivery,
                    'pod' => $res->out_pod,
                    'dex' => $res->out_dex,
                    'invoice' => $res->out_invoice,
                    'payment' => $res->out_payment,
                ),
                'summary' => array(
                    'pickup' => $res->summary_pickup,
                    'cn' => $res->summary_cn,
                    'outgoing' => $res->summary_outgoing,
                    'incoming' => $res->summary_incoming,
                    'delivery' => $res->summary_delivery,
                    'pod' => $res->summary_pod,
                    'dex' => $res->summary_dex,
                    'payment' => $res->summary_payment,
                ),
                'panel' => array(
                    'transaksi' => $res->panel_transaksi,
                    'revenue' => $res->panel_revenue,
                    'tracing' => $res->panel_tracing,
                ),
            );
        }else{
            return array(       
                'outstanding' => array(
                    'cn' => 0,
                    'outgoing' => 0,
                    'incoming' => 0,
                    'delivery' => 0,
                    'pod' => 0,
                    'dex' => 0,
                    'invoice' => 0,
                    'payment' => 0,
                ),
                'summary' => array(
                    'pickup' => 0,
                    'cn' => 0,
                    'outgoing' => 0,
                    'incoming' => 0,
                    'delivery' => 0,
                    'pod' => 0,
                    'dex' => 0,
                    'payment' => 0,
                ),
                'panel' => array(
                    'transaksi' => 0,
                    'revenue' => 0,
                    'tracing' => 0,
                )
            );
        }
    }
}
