<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

Class Menu_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_menu';
    }

    function get_all_menu($group){
        $this->db->select('m.id, m.menu, m.link, m.icon, m.id_parent, a.print, a.add, a.delete, a.edit, a.export');
        $this->db->from('m_menu AS m');
        $this->db->join('m_user_akses AS a', 'a.id_menu=m.id', 'LEFT');
        $this->db->where('m.status', '1');
        $this->db->where('a.id_group_user', $group);
        $this->db->order_by('m.id_parent, m.urutan, m.menu');
        
        $query = $this->db->get();
        
        $menu = array();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            foreach ($rs as $row) {
                $menu[] = array(
                    'id' => $row->id,
                    'menu' => $row->menu,
                    'link' => $row->link,
                    'icon' => $row->icon,
                    'role' => array(
                        'print' => boolval($row->print), 
                        'add' => boolval($row->add), 
                        'delete' => boolval($row->delete), 
                        'edit' => boolval($row->edit),
                        'export' => boolval($row->export),
                    ),
                    'parent' => $row->id_parent,
                );
            }
        }
        return $menu;
    }
    function get_menu($group){
        $this->db->select('m.id, m.menu, m.link, m.icon, a.print, a.add, a.delete, a.edit, a.export');
        $this->db->from('m_menu AS m');
        $this->db->join('m_user_akses AS a', 'a.id_menu=m.id', 'LEFT');
        $this->db->where('m.status', '1');
        $this->db->where('a.id_group_user', $group);
        $this->db->where("(m.id_parent=0 OR m.id_parent='' OR m.id_parent='-')");
        $this->db->order_by('m.urutan, m.menu');
        
        $query = $this->db->get();
        
        $menu = array();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            foreach ($rs as $row) {
                $menu[] = array(
                    'id' => $row->id,
                    'menu' => $row->menu,
                    'link' => $row->link,
                    'icon' => $row->icon,
                    'role' => array(
                        'print' => boolval($row->print), 
                        'add' => boolval($row->add), 
                        'delete' => boolval($row->delete), 
                        'edit' => boolval($row->edit),
                        'export' => boolval($row->export),
                    ),
                    'child' => $this->get_menu_child($row->id, $group)
                );
            }
        }
        return $menu;
    }
    function get_menu_child($parent, $group){
        $this->db->select('m.id, m.menu, m.link, m.icon, a.print, a.add, a.delete, a.edit, a.export');
        $this->db->from('m_menu AS m');
        $this->db->join('m_user_akses AS a', 'a.id_menu=m.id', 'LEFT');
        $this->db->where('m.id_parent', $parent);
        $this->db->where('m.status', '1');
        $this->db->where('a.id_group_user', $group);
        $this->db->order_by('m.urutan, m.menu');
        
        $query = $this->db->get();
        
        $menu=array();
        if ($query->num_rows() > 0) {
            $rs=$query->result();
            foreach ($rs as $row){
                $menu[] = array(
                    'id' => $row->id,
                    'menu' => $row->menu,
                    'link' => $row->link,
                    'icon' => $row->icon,
                    'role' => array(
                        'print' => boolval($row->print), 
                        'add' => boolval($row->add), 
                        'delete' => boolval($row->delete), 
                        'edit' => boolval($row->edit),
                        'export' => boolval($row->export),
                    ),
                    'child' => $this->get_menu_child($row->id, $group)
                );
            }
        }
        return $menu;
    }
    function get_data_menu(){
        $this->db->select('m.id, m.menu, m.link, m.icon, m.id_parent');
        $this->db->from('m_menu AS m');
        $this->db->where('m.status', '1');
        $this->db->order_by('m.id_parent, m.urutan, m.menu');
        
        $query = $this->db->get();
        
        $menu = array();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            foreach ($rs as $row) {
                $menu[] = array(
                    'id' => $row->id,
                    'menu' => $row->menu,
                    'link' => $row->link,
                    'icon' => $row->icon,
                    'parent' => $row->id_parent,
                );
            }
        }
        return $menu;
    }
}
