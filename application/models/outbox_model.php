<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Outbox_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_outbox';
    }
    
    function send_sms($data){
        $this->insert_data($data);
    }
}
