<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Faq_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_faq';
    }
    function get_datalist(){
        $data = $this->read_data('','',array('status'=>'1'),'');
        $datalist=array();
        if(count($data)>0){
            foreach($data as $val){
                $datalist[] = $val;
            }
        }
        return $datalist;
    }
}
