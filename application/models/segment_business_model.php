<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Segment_business_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'segment_business';
    }
    function get_datalist(){
        $this->db->select('id, name');
        $this->db->from('segment_business');
        $this->db->order_by('id', 'asc');
        
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $data[$row->id] = $row->nama;
            }
            return $data;
        } else {
            return null;
        }
                
        return $data;
    }
}
