<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Dashboard_model extends Base_Model {

    public function __construct() {
        parent::__construct();
    }
    function get_total($type = ''){
        switch ($type){
            case 'aktivasi':
                $this->db->from('t_konfirmasi');
                $this->db->where(array('status' => '0', 'jenis_konfirmasi'=>'1'));
                break;
            case 'withdraw':
                $this->db->from('t_request_withdraw');
                $this->db->where(array('status' => '0'));
                break;
            case 'topup':
                $this->db->from('t_topup_konfirmasi');
                $this->db->where(array('status' => '0'));
                $this->db->where_in('jenis_konfirmasi');
                break;
            case 'testimonial':
                $this->db->from('m_testimonial');
                $this->db->where(array('status' => '0'));
                break;
            case 'komplain':
                $this->db->from('t_komplain');
                $this->db->where(array('status' => '0'));
                break;
            case 'member_aktif':
                $this->db->from('m_member');
                $this->db->where(array('status' => '1'));
                break;
            case 'member_nonaktif':
                $this->db->from('m_member');
                $this->db->where(array('status' => '0'));
                break;
            default:
                break;
        }
        
        return $this->db->count_all_results();
    }
}
