<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Topup_sipro_model extends Base_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * data = array(
     *  'id_member' =>
     *  'id_bank' =>
     *  'nominal' =>
     *  'ket' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function topup($data){
        $this->db->trans_start();
        
        $this->load->model('rekening_model');
        $this->load->model('member_model');
        $member = $this->member_model->get_data($data['id_member']);
        $nominal = floatval($data['nominal']);
        $now = date('Y-m-d H:i:s');
        $norek_sipro = $this->rekening_model->get_norek_member($data['id_member'], 'SIPRO');
        
        if($data['id_bank']=='WALLET'){
            $norek_wallet = $this->rekening_model->get_norek_member($data['id_member'], 'WALLET');
            $saldo_wallet = $this->rekening_model->get_saldo_akhir($norek_wallet);
            //cek saldo wallet
            if($saldo_wallet<$nominal){
                return false;
            }
            //1. potong saldo wallet
            //insert mutasi
            $this->db->insert('t_rek_wallet', array(
                'tgl' => $now,
                'norek' => $norek_wallet,
                'jenis_trx' => 'TRF',
                'ket' => 'TOPUP SIPRO TO '.$norek_sipro.': '.$member->id.' '.$member->nama,
                'dk' => 'D',
                'nominal' => $nominal,
                'saldo_awal' => $saldo_wallet,
                'saldo_akhir' => $saldo_wallet - $nominal,
                'user_input' => $data['user_input'],
                'tgl_input' => $now,
            ));
            //update saldo
            $this->db->where('norek', $norek_wallet);
            $this->db->set('saldo', 'saldo-'.$nominal, false);
            $this->db->update('m_rekening');
        }
        
        //1. insert mutasi
        $saldo_sipro = $this->rekening_model->get_saldo_akhir($norek_sipro);
        $this->db->insert('t_rek_sipro', array(
            'tgl' => $now,
            'norek' => $norek_sipro,
            'jenis_trx' => 'STR',
            'ket' => 'TOPUP FROM '.$norek_wallet.': '.$member->id.' '.$member->nama,
            'dk' => 'K',
            'nominal' => $nominal,
            'saldo_awal' => $saldo_sipro,
            'saldo_akhir' => $saldo_sipro + $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo
        $this->db->where('norek', $norek_sipro);
        $this->db->set('saldo', 'saldo+'.$nominal, false);
        $this->db->update('m_rekening');
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            //log error
            log_message();
            
            return false;
        }else{
            return true;
        }
    }
    
    /*
     * data = array(
     *  'id_member' =>
     *  'id_bank' =>
     *  'nominal' =>
     *  'ket' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function validasi($data){
        $this->db->trans_start();
        
        $this->load->model('rekening_model');
        $norek = $this->rekening_model->get_norek_member($data['id_member'], 'SIPRO');
        $this->load->model('member_model');
        $member = $this->member_model->get_data($data['id_member']);
        
        //1. insert mutasi
        $now = date('Y-m-d H:i:s');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $nominal = floatval($data['nominal']);
        $this->db->insert('t_rek_sipro', array(
            'tgl' => $now,
            'norek' => $norek,
            'jenis_trx' => 'STR',
            'ket' => 'TOPUP : '.$member->id.' '.$member->nama,
            'dk' => 'K',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo + $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo
        $this->db->where('norek', $norek);
        $this->db->set('saldo', 'saldo+'.$nominal, false);
        $this->db->update('m_rekening');
        
        //3. update status konfirmasi
        $this->db->where('id', $data['id']);
        $this->db->update('t_topup_konfirmasi', array(
            'status' => '1',
            'ket' => $data['ket'],
            'id_bank' => $data['id_bank'],
            'nominal' => $data['nominal'],
            'user_update' => $data['user_input'],
            'tgl_update' => $data['tgl_input']
        ));
        
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            //log error
            log_message();
            
            return false;
        }else{
            return true;
        }
    }
}
