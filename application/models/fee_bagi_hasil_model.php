<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Fee_bagi_hasil_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'c_fee_bagi_hasil';
    }
}
