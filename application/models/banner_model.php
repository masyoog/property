<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Banner_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'c_banner_mobile_apps';
    }
    function get_datalist(){
        $data = $this->read_data();
        $datalist=array();
        if(count($data)>0){
            foreach($data as $val){
                $datalist[] = base_url().'media/banner/'.$val->filename;
            }
        }
        return $datalist;
    }
}
