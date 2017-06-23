<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Project_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_project';
    }
    function get_datalist($where = array()){
        $cabang = $this->read_data('', '', $where);
        $datalist=array();
        if(count($cabang)>0){
            foreach($cabang as $val){
                $datalist[] = $val->nama;
            }
        }
        return $datalist;
    }
}
