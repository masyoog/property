<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Kolektor_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_kolektor';
    }
    function get_datalist($with_kode = true, $where = array()){
        $cabang = $this->read_data('', '', $where);
        $cabanglist=array();
        if(count($cabang)>0){
            foreach($cabang as $val){
                $cabanglist[$val->id] = ($with_kode?$val->id.' - ':'').$val->nama;
            }
        }
        return $cabanglist;
    }
}
