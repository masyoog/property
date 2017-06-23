<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Konfirmasi_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_konfirmasi';
    }
    
    public function cancel_konfirmasi($id, $data){
        $this->db->where(id, $id);
        $this->db->update($this->table_name, $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        
    }
}
