<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Home_model extends Base_Model {

    public function __construct() {
        parent::__construct();
    }
    function get_jumlah($type = ''){
        $stat = array(
            'booking' => 0,
            'pickup' => 1,
            'entry' => 2,
            'outgoing' => 3,
            'incoming' => 4,
            'delivery' => 5,
            'pod' => 6,
            'dex' => 7,
            'entry_podbalik' => 8,
            'podbalik' => 9,
            'void' => 10,
        );
        switch ($type){
            case 'pickup':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['booking'], 'date(tgl)' => date('Y-m-d'), 'id_cabang'=>$this->data['cabang']));
                break;
            case 'connote':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['entry'], 'date(tgl)' => date('Y-m-d'), 'id_cabang'=>$this->data['cabang']));
                break;
            case 'outgoing':
                $this->db->from('t_outgoing');
                $this->db->where(array('date(tgl)' => date('Y-m-d'), 'cabang'=>$this->data['cabang']));
                break;
            case 'incoming':
                $this->db->from('t_incoming');
                $this->db->where(array('date(tgl)' => date('Y-m-d'), 'cabang'=>$this->data['cabang']));
                break;
            case 'delivery':
                $this->db->from('t_delivery');
                $this->db->where(array('date(tgl)' => date('Y-m-d'), 'cabang'=>$this->data['cabang']));
                break;
            case 'pod':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['pod'], 'date(tgl)' => date('Y-m-d'), 'id_cabang'=>$this->data['cabang']));
                break;
            case 'podbalik':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['podbalik'], 'date(tgl)' => date('Y-m-d'), 'id_cabang'=>$this->data['cabang']));
                break;
            case 'invoice':
                $this->db->from('t_invoice');
                $this->db->where(array('date(tgl)' => date('Y-m-d'), 'id_cabang'=>$this->data['cabang']));
                break;
            
            case 'out_pickup':
                $this->db->from('t_connote');
                $this->db->where(array('status < ' => $stat['pickup'], 'id_cabang'=>$this->data['cabang']));
                break;
            case 'out_connote':
                $this->db->from('t_connote');
                $this->db->where(array('status < ' => $stat['entry'], 'id_cabang'=>$this->data['cabang']));
                break;
            case 'out_outgoing':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['entry'], 'id_cabang'=>$this->data['cabang']));
                break;
            case 'out_incoming':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['outgoing'], 'id_cabang_tujuan'=>$this->data['cabang']));
                break;
            case 'out_delivery':
            case 'out_pod':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['incoming'], 'id_cabang_tujuan'=>$this->data['cabang']));
                break;
            case 'out_podbalik':
                $this->db->from('t_connote');
                $this->db->where("status = {$stat['pod']} AND noref != '' AND (id_cabang_tujuan = '{$this->data['cabang']}' OR id_cabang = '{$this->data['cabang']}')");
                break;
            case 'out_invoice':
                $this->db->from('t_connote');
                $this->db->where(array('status' => $stat['pod'], 'id_customer != ' => '', 'id_cabang'=>$this->data['cabang']));
                break;
            case 'out_payment':
                $this->db->from('t_invoice');
                $this->db->where(array('status_lunas'=>'0', 'id_cabang'=>$this->data['cabang']));
                break;
            default:
                break;
        }
        
        return $this->db->count_all_results();
    }
}
