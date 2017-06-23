<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Provinsi_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_provinsi';
    }
    function get_datalist(){
        $prov = $this->read_data('','',array(),'nama');
        $provlist=array();
        if(count($prov)>0){
            foreach($prov as $val){
                $provlist[$val->nama] = $val->nama;
            }
        }
        return $provlist;
    }
}
