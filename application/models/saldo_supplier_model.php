<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Saldo_supplier_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_saldo_supplier';
    }
}
