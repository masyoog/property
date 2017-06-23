<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Harga_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_harga';
    }
    function get_data_detail($id) {
        $this->db->select("h.id as id, CONCAT(h.origin, ' - ', b.nama, ' ', b.kota) as origin, CONCAT(h.destination, ' - ', b2.nama, ' ', b2.kota) as destination, "
                . "CONCAT(h.maskapai, ' - ', m.nama) as maskapai, h.harga, "
                . "h.tgl_input, h.user_input, h.tgl_update, h.user_update", false);
        $this->db->from($this->table_name.' h');
        $this->db->where('h.id', $id);
        $this->db->join('m_bandara b', 'b.kode=h.origin', 'left');
        $this->db->join('m_bandara b2', 'b2.kode=h.destination', 'left');
        $this->db->join('m_maskapai m', 'm.kode=h.maskapai', 'left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }
    function get_publish_rate($asal, $tujuan, $layanan, $kiriman, $berat){
        $harga = 0;
        $min_kg = 0;
        $min_charge = 0;
        
        $this->db->distinct();
        $this->db->limit(1);
        $this->db->select('h.harga, h.min_kg, h.min_charge');
        $this->db->from($this->table_name.' h');
        $this->db->join('m_routing k', 'h.id_cabang=k.id_cabang', 'left');
        $this->db->where(array(
            'k.id_kabupaten' => $asal,
            'h.id_kabupaten' => $tujuan,
            'h.id_layanan' => $layanan,
            'h.id_kiriman' => $kiriman,
        ));
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $row=$q->row();
            
            $harga = floatval($row->harga);
            $min_kg = intval($row->min_kg);
            $min_charge = intval($row->min_charge);
        }
        if($berat < $min_kg){
            $berat = $min_kg;
        }
        $biaya = ($harga * $berat);
        if($biaya < $min_charge){
            $biaya = $min_charge;
        }
        
        return floatval($biaya);
    }
    function get_publish_rate_all($asal, $tujuan, $berat){
        $berat = ceil($berat);
        $data = array();
        
        $this->db->distinct();
        $this->db->select("h.id_layanan, h.id_kiriman, h.lead_time, h.harga, h.min_kg, h.min_charge, ko.nama as origin, kd.nama as destination, 'Publish Rate' as customer", false);
        $this->db->from($this->table_name.' h');
        $this->db->join('m_routing k', 'h.id_cabang=k.id_cabang', 'left');
        $this->db->join('m_kabupaten ko', 'k.id_kabupaten=ko.id', 'left');
        $this->db->join('m_kabupaten kd', 'h.id_kabupaten=kd.id', 'left');
        $this->db->where(array(
            'k.id_kabupaten' => $asal,
            'h.id_kabupaten' => $tujuan,
        ));
        $this->db->order_by('h.id_layanan, h.id_kiriman');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $rs=$q->result();
            $rate = array();
            $ori = ''; $dest = ''; $cus='';
            foreach ($rs as $row) {
                $ori = $row->origin;
                $dest = $row->destination;
                $cus = $row->customer;
                
                $harga = floatval($row->harga);
                $min_kg = intval($row->min_kg);
                $min_charge = intval($row->min_charge);
                $tmp_berat = $berat;
                
                if($tmp_berat < $min_kg){
                    $tmp_berat = $min_kg;
                }
                $biaya = ($harga * $tmp_berat);
                if($biaya < $min_charge){
                    $biaya = $min_charge;
                }
                
                $rate[] = array(
                    'service' => $row->id_layanan,
                    'kiriman' => $row->id_kiriman,
                    'harga_per_kg' => $row->harga,
                    'lead_time' => $row->lead_time,
                    'minimum_kg' => $row->min_kg,
                    'minimum_charge' => $row->min_charge,
                    'harga' => $biaya,
                );
            }
            $data['origin'] = $ori;
            $data['destination'] = $dest;
            $data['customer'] = $cus;
            $data['berat'] = $berat;
            $data['status'] = true;
            $data['rate'] = $rate;
            
            return $data;
        }else{
            return array('status'=>false,'msg'=>'HARGA TIDAK DITEMUKAN / BELUM DISET');
        }
    }
    
    function get_harga($param = array()){
        $harga = 0;
        $min_kg = 0;
        $min_charge = 0;
        
        $berat = intval($param['total_berat_bulat']);
        
        $this->db->select('h.harga, h.min_kg, h.min_charge');
        $this->db->from('m_harga_kabupaten h');
        $this->db->where(array(
            'h.id_cabang' => $param['cabang_asal'],
            'h.id_kabupaten' => $param['kabupaten'],
            'h.id_layanan' => $param['layanan'],
            'h.id_kiriman' => $param['kiriman'],
        ));
        
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $row=$q->row();
            
            $harga = floatval($row->harga);
            $min_kg = intval($row->min_kg);
            $min_charge = intval($row->min_charge);
        }
        if($berat < $min_kg){
            $berat = $min_kg;
        }
        $biaya = ($harga * $berat);
        if($biaya < $min_charge){
            $biaya = $min_charge;
        }
        $ret = array(
            'harga_per_kg' => $harga,
            'min_kg' => $min_kg,
            'min_charge' => $min_charge,
            'harga' => $biaya
        );
        return $ret;
    }
}
