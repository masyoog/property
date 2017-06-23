<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Sipro_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 't_rek_sipro';
    }
    
    /*
     * data = array(
     *  'id_member' =>
     *  'norek_sipro' =>
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
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek_sipro']);
        $this->db->insert('t_rek_sipro', array(
            'tgl' => $now,
            'norek' => $data['norek_sipro'],
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
        $this->db->where('norek', $data['norek_sipro']);
        $this->db->set('saldo', 'saldo-'.$nominal, false);
        $this->db->update('m_rekening');
        
        //3. insert quee request
        $this->db->insert('t_request_withdraw', array(
            'tgl' => $now,
            'jenis_rekening' => 'SIPRO',
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
    function refund($data){
        $this->db->trans_start();
        
        $now = date('Y-m-d H:i:s');
        $nominal = floatval($data['nominal']);
        
        //1. insert mutasi
        $saldo = $this->rekening_model->get_saldo_akhir($data['norek']);
        $this->db->insert('t_rek_sipro', array(
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
    
}
