<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Wallet_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_rek_wallet';
    }
    
    function getTotalAmount($whr, $type='K', $escape=true){
        $this->db->select_sum('nominal');
        $this->db->where(['dk'=>$type]);
        if ( !$escape ){
            $this->db->where($whr, null, false);
        } else {
            $this->db->where($whr);
        }
        
        $rs = $this->db->get($this->table_name);
        
        if ($rs->num_rows() > 0) {            
            return floatval($rs->row()->nominal);
        } else {
            return 0;
        }
    }
    /*
     * data = array(
     *  'id_member' =>
     *  'norek_wallet' =>
     *  'nominal' => 
     *  'id_bank' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function withdraw($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        $this->load->model('member_bank_model', 'bank');
        $bank = $this->bank->get_bank($data['id_bank']);
        
        //1. insert mutasi wallet
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek_wallet']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek_wallet'],
            'jenis_trx' => 'TAR',
            'ket' => substr('WDR '.$bank->kode.':'.$bank->norek.' '.$bank->atas_nama, 0, 50),
            'dk' => 'D',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo - $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo wallet
        $this->db->where('norek', $data['norek_wallet']);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
        $this->db->update('m_rekening');
        
        //3. insert quee request
        $this->db->insert('t_request_withdraw', array(
            'tgl' => $now,
            'jenis_rekening' => 'WALLET',
            'id_member' => $data['id_member'],
            'nominal' => $nominal,
            'id_bank' => $bank->id,
            'kode_bank' => $bank->kode,
            'nama_bank' => $bank->bank,
            'norek' => $bank->norek,
            'atas_nama' => $bank->atas_nama,
            'status' => '0',
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
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
    
    /*
     * data = array(
     *  'id_member' =>
     *  'nama' =>
     *  'norek_wallet' =>
     *  'norek_bispro' =>
     *  'nominal' => 
     *  'id_upline' => 
     *  'norek_upline' => 
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function transfer_bispro($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        //1. insert mutasi wallet
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek_wallet']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek_wallet'],
            'jenis_trx' => 'TRF',
            'ket' => 'TRF TO BISPRO : '.$data['norek_bispro'],
            'dk' => 'D',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo - $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo wallet
        $this->db->where('norek', $data['norek_wallet']);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
        $this->db->update('m_rekening');
        
        //3. insert mutasi bispro
        $saldo_bispro = $this->rekening_model->get_saldo_akhir($data['norek_bispro']);
        $this->db->insert('t_rek_bispro', array(
            'tgl' => $now,
            'norek' => $data['norek_bispro'],
            'jenis_trx' => 'TRF',
            'ket' => 'TRF FROM WALLET : '.$data['norek_wallet'],
            'dk' => 'K',
            'nominal' => $nominal,
            'saldo_awal' => $saldo_bispro,
            'saldo_akhir' => $saldo_bispro + $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //4. update saldo bispro
        $this->db->where('norek', $data['norek_bispro']);
        $this->db->set('saldo', 'saldo+'.$nominal, false);
        $this->db->update('m_rekening');
        
        //5. input komisi bispro
        $saldo_upline = $this->rekening_model->get_saldo_akhir($data['norek_upline']);
        $persen = 10/100;
        if($saldo_upline<1000000){
            $persen = 5/100;
        }
        $komisi = $persen * $nominal;
        //insert l_komisi_bispro
        $this->db->insert('l_komisi_bispro', array(
            'tgl' => $now,
            'id_member' => $data['id_upline'],
            'id_downline' => $data['id_member'],
            'nominal' => $komisi,
            'level' => '1',
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
    
    /*
     * data = array(
     *  'id_member' =>
     *  'nama' =>
     *  'norek_wallet' =>
     *  'norek_sipro' =>
     *  'nominal' => 
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function transfer_sipro($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        //1. insert mutasi wallet
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek_wallet']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek_wallet'],
            'jenis_trx' => 'TRF',
            'ket' => 'TRF TO SIPRO : '.$data['norek_sipro'],
            'dk' => 'D',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo - $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo wallet
        $this->db->where('norek', $data['norek_wallet']);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
        $this->db->update('m_rekening');
        
        //3. insert mutasi sipro
        $saldo_sipro = $this->rekening_model->get_saldo_akhir($data['norek_sipro']);
        $this->db->insert('t_rek_sipro', array(
            'tgl' => $now,
            'norek' => $data['norek_sipro'],
            'jenis_trx' => 'TRF',
            'ket' => 'TRF FROM WALLET : '.$data['norek_wallet'],
            'dk' => 'K',
            'nominal' => $nominal,
            'saldo_awal' => $saldo_sipro,
            'saldo_akhir' => $saldo_sipro + $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //4. update saldo sipro
        $this->db->where('norek', $data['norek_sipro']);
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
     *  'norek_asal' =>
     *  'norek_tujuan' =>
     *  'nominal' =>
     *  'berita' => 
     *  'id_asal' =>
     *  'id_tujuan' =>
     *  'nama_asal' =>
     *  'nama_tujuan' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function transfer($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        //1. insert mutasi asal
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek_asal']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek_asal'],
            'jenis_trx' => 'TRF',
            'ket' => substr('TRF TO '.$data['id_tujuan'].' '.$data['nama_tujuan']. ' : '.$data['berita'], 0, 50),
            'dk' => 'D',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo - $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo asal
        $this->db->where('norek', $data['norek_asal']);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
        $this->db->update('m_rekening');
        
        //3. insert mutasi tujuan
        $saldo_tujuan = $this->rekening_model->get_saldo_akhir($data['norek_tujuan']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek_tujuan'],
            'jenis_trx' => 'TRF',
            'ket' => substr('TRF FROM '.$data['id_asal'].' '.$data['nama_asal']. ' : '.$data['berita'], 0, 50),
            'dk' => 'K',
            'nominal' => $nominal,
            'saldo_awal' => $saldo_tujuan,
            'saldo_akhir' => $saldo_tujuan + $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //4. update saldo tujuan
        $this->db->where('norek', $data['norek_tujuan']);
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
    
    function mutasi($norek, $periode1, $periode2){
        $this->db->select('tgl, ket, dk, nominal, saldo_akhir');
        $this->db->from($this->table_name);
        $this->db->where(array(
            'norek' => $norek,
            'date(tgl) >= ' => $periode1,
            'date(tgl) <= ' => $periode2
            )
        );
        $this->db->order_by('tgl desc');
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs=$sql->result();
            foreach ($rs as $row) {
                $row->tgl = _format_tgl($row->tgl);
                $row->nominal = _format_angka($row->nominal);
                $row->saldo_akhir = _format_angka($row->saldo_akhir);
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
        
    }
    
    /*
     * data = array(
     *  'norek' =>
     *  'nominal' =>
     *  'ket' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function payment($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        //1. insert mutasi
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek'],
            'jenis_trx' => 'PAY',
            'ket' => substr($data['ket'], 0, 50),
            'dk' => 'D',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo - $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo
        $this->db->where('norek', $data['norek']);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
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
     *  'norek' =>
     *  'nominal' =>
     *  'ket' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function refund($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        //1. insert mutasi
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $data['norek'],
            'jenis_trx' => 'ADJ',
            'ket' => substr($data['ket'], 0, 50),
            'dk' => 'K',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo + $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo
        $this->db->where('norek', $data['norek']);
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
    function setoran($data){
        $this->db->trans_start();
        
        $this->load->model('rekening_model');
        $this->load->model('member_model');
        $member = $this->member_model->get_data($data['id_member']);
        $nominal = floatval($data['nominal']);
        $now = date('Y-m-d H:i:s');
        $norek = $this->rekening_model->get_norek_member($data['id_member'], 'WALLET');
        $this->load->model('bank_model');
        $bank = $this->bank_model->get_data($data['id_bank']);
        
        //1. insert mutasi
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $norek,
            'jenis_trx' => 'STR',
            'ket' => substr('SETORAN '.$bank->nama.' - '.$bank-norek.' : '.$member->id.' '.$member->nama, 0, 50),
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
     *  'nominal' =>
     *  'ket' =>
     *  'user_input' =>
     *  'tgl_input' =>
     * )
     */
    function tarikan($data){
        $this->db->trans_start();
        
        $this->load->model('rekening_model');
        $this->load->model('member_model');
        $member = $this->member_model->get_data($data['id_member']);
        $nominal = floatval($data['nominal']);
        $now = date('Y-m-d H:i:s');
        $norek = $this->rekening_model->get_norek_member($data['id_member'], 'WALLET');
//        $this->load->model('bank_model');
//        $bank = $this->bank_model->get_data($data['id_bank']);
        
        //1. insert mutasi
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $norek,
            'jenis_trx' => 'TRK',
            'ket' => substr('TARIK TUNAI : '.$member->id.' '.$member->nama, 0, 50),
            'dk' => 'D',
            'nominal' => $nominal,
            'saldo_awal' => $saldo,
            'saldo_akhir' => $saldo - $nominal,
            'user_input' => $data['user_input'],
            'tgl_input' => $now,
        ));
        //2. update saldo
        $this->db->where('norek', $norek);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
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
        $norek = $this->rekening_model->get_norek_member($data['id_member'], 'WALLET');
        $this->load->model('member_model');
        $member = $this->member_model->get_data($data['id_member']);
        
        //1. insert mutasi
        $now = date('Y-m-d H:i:s');
        $saldo = $this->rekening_model->get_saldo_akhir($norek);
        $nominal = floatval($data['nominal']);
        $this->db->insert('t_rek_wallet', array(
            'tgl' => $now,
            'norek' => $norek,
            'jenis_trx' => 'STR',
            'ket' => substr('TOPUP : '.$member->id.' '.$member->nama, 0, 50),
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
