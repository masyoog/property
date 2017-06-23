<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Member_model extends Base_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'm_member';
    }

    function login_api($username, $password) {
        $this->db->select('m.id, m.nama, m.no_ktp, m.alamat, m.email, m.nohp, l.kode as level, l.nama as nama_level, m.id_upline1');
        $this->db->from('m_member m');
        $this->db->join('m_level l', 'm.level = l.level', 'left');
        $this->db->where('m.id', $username);
        $this->db->where('m.pass', $password);
        $this->db->where('m.status', '1');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    function get_profile($id) {
        $this->db->select('b.id as id_member, m.tgl, b.nama, b.alamat, b.kota, b.nohp, b.nohp_alt, b.email, m.about_me, m.bisnis, m.alamat_bisnis, '
                . 'm.bisnis_lat, m.bisnis_lng, m.foto, l.kode as level');
        $this->db->from('m_member b');
        $this->db->join('m_member_profile m', 'm.id_member=b.id', 'left');
        $this->db->join('m_level l', 'b.level=l.level', 'left');
        $this->db->where('b.id', $id);
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $row = $sql->row();
            if (empty($row->foto)) {
                $row->foto = base_url() . 'media/avatar/default.png';
            } else {
                $row->foto = base_url() . 'media/avatar/' . $row->foto;
            }
            $row->tgl = _format_tgl($row->tgl);
            $row->gallery = $this->get_gallery($id);

            return $row;
        } else {
            return null;
        }
    }

    function get_gallery($id) {
        $this->db->where('id_member', $id);
        $sql = $this->db->get('m_member_gallery');
        if ($sql->num_rows() > 0) {
            $rs = $sql->result();
            foreach ($rs as $row) {
                $row->gambar = base_url() . 'media/gallery/' . $row->gambar;
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }

    /*
     * $data = array(
     * id_member =>
     * id_kode_bank =>
     * norek =>
     * atas_nama =>
     * )
     */

    function tambah_bank($data) {
        $this->db->insert('m_member_bank', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_bank($id) {
        $this->db->select('b.id, b.norek, b.atas_nama, k.bank, k.kode');
        $this->db->from('m_member_bank b');
        $this->db->join('m_bank_kode k', 'b.id_kode_bank=k.id', 'left');
        $this->db->where('id_member', $id);
        $sql = $this->db->get();
        if ($sql->num_rows() > 0) {
            $rs = $sql->result();
            foreach ($rs as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return array();
        }
    }

    function get_datalist($with_kode = true, $where = array()) {
        $cabang = $this->read_data('', '', $where);
        $cabanglist = array();
        if (count($cabang) > 0) {
            foreach ($cabang as $val) {
                $cabanglist[$val->id] = ($with_kode ? $val->id . ' - ' : '') . $val->nama;
            }
        }
        return $cabanglist;
    }

    function get_total_downline($id_member) {
        $ret = array(
            'downline1' => $this->get_total_downline1($id_member),
            'downline2' => $this->get_total_downline2($id_member),
            'downline3' => $this->get_total_downline3($id_member),
            'downline4' => $this->get_total_downline4($id_member),
            'downline5' => $this->get_total_downline5($id_member),
        );

        return $ret;
    }

    function get_total_downline1($id_member) {
        $this->db->select('status, count(id) as jml');
        $this->db->from($this->table_name);
        $this->db->where('id_upline1', $id_member);
        $this->db->group_by('status');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            $data = array(0, 0);
            foreach ($rs as $row) {
                $data[$row->status] = intval($row->jml);
            }
            return $data;
        } else {
            return array(0, 0);
        }
    }

    function get_total_downline2($id_member) {
        $this->db->select('status, count(id) as jml');
        $this->db->from($this->table_name);
        $this->db->where('id_upline2', $id_member);
        $this->db->group_by('status');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            $data = array(0, 0);
            foreach ($rs as $row) {
                $data[$row->status] = intval($row->jml);
            }
            return $data;
        } else {
            return array(0, 0);
        }
    }

    function get_total_downline3($id_member) {
        $this->db->select('status, count(id) as jml');
        $this->db->from($this->table_name);
        $this->db->where('id_upline3', $id_member);
        $this->db->group_by('status');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            $data = array(0, 0);
            foreach ($rs as $row) {
                $data[$row->status] = intval($row->jml);
            }
            return $data;
        } else {
            return array(0, 0);
        }
    }

    function get_total_downline4($id_member) {
        $this->db->select('status, count(id) as jml');
        $this->db->from($this->table_name);
        $this->db->where('id_upline4', $id_member);
        $this->db->group_by('status');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            $data = array(0, 0);
            foreach ($rs as $row) {
                $data[$row->status] = intval($row->jml);
            }
            return $data;
        } else {
            return array(0, 0);
        }
    }

    function get_total_downline5($id_member) {
        $this->db->select('status, count(id) as jml');
        $this->db->from($this->table_name);
        $this->db->where('id_upline5', $id_member);
        $this->db->group_by('status');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            $data = array(0, 0);
            foreach ($rs as $row) {
                $data[$row->status] = intval($row->jml);
            }
            return $data;
        } else {
            return array(0, 0);
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

    function aktivasi($data) {
        $this->db->trans_start();

        $member = $this->get_data($data['id_member']);
        if ($member == null) {
            return false;
        }
        //1. insert t_aktivasi
        $this->db->insert('t_aktivasi', array(
            'tgl' => date('Y-m-d H:i:s'),
            'id_bank' => $data['id_bank'],
            'id_member' => $member->id,
            'nominal' => floatval($data['nominal']),
            'ket' => $data['ket'],
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));

        //2. update status
        $this->db->where('id', $data['id_member']);
        $this->db->update($this->table_name, array('status' => '1', 'tgl_aktivasi' => date('Y-m-d H:i:s')));

        $this->load->model('setting_model');
        $pokok = $this->setting_model->get_simpanan_pokok();
        $wajib = $this->setting_model->get_simpanan_wajib();

        //3. create rekening: wallet, sipro, bispro
        $this->load->model('rekening_model');
        $norek_wallet = $this->rekening_model->insert_data(array(
            'id_member' => $data['id_member'],
            'jenis_rekening' => 'WALLET',
            'saldo' => 0,
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));
        $norek_sipro = $this->rekening_model->insert_data(array(
            'id_member' => $data['id_member'],
            'jenis_rekening' => 'SIPRO',
            'saldo' => 0,
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));
        $norek_bispro = $this->rekening_model->insert_data(array(
            'id_member' => $data['id_member'],
            'jenis_rekening' => 'BISPRO',
            'saldo' => 0,
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));

        //4. insert t_simpanan_pokok & wajib
        $this->load->model('simpanan_pokok_model');
        $this->simpanan_pokok_model->insert_data(array(
            'id_member' => $data['id_member'],
            'nominal' => $pokok,
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));
        $this->load->model('simpanan_wajib_model');
        $this->simpanan_wajib_model->insert_data(array(
            'id_member' => $data['id_member'],
            'nominal' => $wajib,
            'user_input' => $data['user_input'],
            'tgl_input' => $data['tgl_input'],
        ));

        if ($member->jenis_member == 'SIPRO') {
            $biaya_aktivasi = $this->setting_model->get_biaya_aktivasi_sipro();
            //5. input fee upline
            $this->load->model('fee_registrasi_model', 'fee_model');
            $fee = $this->fee_model->get_data('1');
            //upline1
            if (!empty($member->id_upline1)) {
                $m_upline = $this->get_data($member->id_upline1);
                if ($m_upline->jenis_member == 'SIPRO') {
                    $norek = $this->rekening_model->get_norek_member($member->id_upline1, 'WALLET');
                    if ($norek != null) {
                        $komisi = floatval($fee->upline1);
                        $now = date('Y-m-d H:i:s');
                        //insert l_komisi
                        $this->db->insert('l_komisi', array(
                            'tgl' => $now,
                            'id_member' => $member->id_upline1,
                            'id_downline' => $member->id,
                            'nominal' => $komisi,
                            'level' => '1',
                        ));
                        //insert mutasi
                        $saldo = $this->rekening_model->get_saldo_akhir($norek);
                        $this->db->insert('t_rek_wallet', array(
                            'tgl' => $now,
                            'norek' => $norek,
                            'jenis_trx' => 'FEE',
                            'ket' => 'FEE 1: ' . $member->id . ' ' . $member->nama,
                            'dk' => 'K',
                            'nominal' => $komisi,
                            'saldo_awal' => $saldo,
                            'saldo_akhir' => $saldo + $komisi,
                            'user_input' => $data['user_input'],
                            'tgl_input' => $now,
                        ));
                        //update saldo
                        $this->db->where('norek', $norek);
                        $this->db->set('saldo', 'saldo+' . $komisi, false);
                        $this->db->update('m_rekening');
                    }
                }
            }
            //upline2
            if (!empty($member->id_upline2)) {
                $m_upline = $this->get_data($member->id_upline2);
                if ($m_upline->jenis_member == 'SIPRO') {
                    $norek = $this->rekening_model->get_norek_member($member->id_upline2, 'WALLET');
                    if ($norek != null) {
                        $komisi = floatval($fee->upline2);
                        $now = date('Y-m-d H:i:s');
                        //insert l_komisi
                        $this->db->insert('l_komisi', array(
                            'tgl' => $now,
                            'id_member' => $member->id_upline2,
                            'id_downline' => $member->id,
                            'nominal' => $komisi,
                            'level' => '2',
                        ));
                        //insert mutasi
                        $saldo = $this->rekening_model->get_saldo_akhir($norek);
                        $this->db->insert('t_rek_wallet', array(
                            'tgl' => $now,
                            'norek' => $norek,
                            'jenis_trx' => 'FEE',
                            'ket' => 'FEE 2: ' . $member->id . ' ' . $member->nama,
                            'dk' => 'K',
                            'nominal' => $komisi,
                            'saldo_awal' => $saldo,
                            'saldo_akhir' => $saldo + $komisi,
                            'user_input' => $data['user_input'],
                            'tgl_input' => $now,
                        ));
                        //update saldo
                        $this->db->where('norek', $norek);
                        $this->db->set('saldo', 'saldo+' . $komisi, false);
                        $this->db->update('m_rekening');
                    }
                }
            }
            //upline3
            if (!empty($member->id_upline3)) {
                $m_upline = $this->get_data($member->id_upline3);
                if ($m_upline->jenis_member == 'SIPRO') {
                    $norek = $this->rekening_model->get_norek_member($member->id_upline3, 'WALLET');
                    if ($norek != null) {
                        $komisi = floatval($fee->upline3);
                        $now = date('Y-m-d H:i:s');
                        //insert l_komisi
                        $this->db->insert('l_komisi', array(
                            'tgl' => $now,
                            'id_member' => $member->id_upline3,
                            'id_downline' => $member->id,
                            'nominal' => $komisi,
                            'level' => '3',
                        ));
                        //insert mutasi
                        $saldo = $this->rekening_model->get_saldo_akhir($norek);
                        $this->db->insert('t_rek_wallet', array(
                            'tgl' => $now,
                            'norek' => $norek,
                            'jenis_trx' => 'FEE',
                            'ket' => 'FEE 3: ' . $member->id . ' ' . $member->nama,
                            'dk' => 'K',
                            'nominal' => $komisi,
                            'saldo_awal' => $saldo,
                            'saldo_akhir' => $saldo + $komisi,
                            'user_input' => $data['user_input'],
                            'tgl_input' => $now,
                        ));
                        //update saldo
                        $this->db->where('norek', $norek);
                        $this->db->set('saldo', 'saldo+' . $komisi, false);
                        $this->db->update('m_rekening');
                    }
                }
            }
            //upline4
            if (!empty($member->id_upline4)) {
                $m_upline = $this->get_data($member->id_upline4);
                if ($m_upline->jenis_member == 'SIPRO') {
                    $norek = $this->rekening_model->get_norek_member($member->id_upline4, 'SIPRO');
                    if ($norek != null) {
                        $komisi = floatval($fee->upline4);
                        $now = date('Y-m-d H:i:s');
                        //insert l_komisi
                        $this->db->insert('l_komisi', array(
                            'tgl' => $now,
                            'id_member' => $member->id_upline4,
                            'id_downline' => $member->id,
                            'nominal' => $komisi,
                            'level' => '4',
                        ));
                        //insert mutasi
                        $saldo = $this->rekening_model->get_saldo_akhir($norek);
                        $this->db->insert('t_rek_sipro', array(
                            'tgl' => $now,
                            'norek' => $norek,
                            'jenis_trx' => 'FEE',
                            'ket' => 'FEE 4: ' . $member->id . ' ' . $member->nama,
                            'dk' => 'K',
                            'nominal' => $komisi,
                            'saldo_awal' => $saldo,
                            'saldo_akhir' => $saldo + $komisi,
                            'user_input' => $data['user_input'],
                            'tgl_input' => $now,
                        ));
                        //update saldo
                        $this->db->where('norek', $norek);
                        $this->db->set('saldo', 'saldo+' . $komisi, false);
                        $this->db->update('m_rekening');
                    }
                }
            }
            //upline5
            //dihilangkan 2017-05-01
            /*
              if(!empty($member->id_upline5)){
              $m_upline = $this->get_data($member->id_upline5);
              if($m_upline->jenis_member=='SIPRO'){
              $norek = $this->rekening_model->get_norek_member($member->id_upline5, 'SIPRO');
              if($norek!=null){
              $komisi = floatval($fee->upline5);
              $now = date('Y-m-d H:i:s');
              //insert l_komisi
              $this->db->insert('l_komisi', array(
              'tgl' => $now,
              'id_member' => $member->id_upline5,
              'id_downline' => $member->id,
              'nominal' => $komisi,
              'level' => '5',
              ));
              //insert mutasi
              $saldo = $this->rekening_model->get_saldo_akhir($norek);
              $this->db->insert('t_rek_sipro', array(
              'tgl' => $now,
              'norek' => $norek,
              'jenis_trx' => 'FEE',
              'ket' => 'FEE 5: '.$member->id.' '.$member->nama,
              'dk' => 'K',
              'nominal' => $komisi,
              'saldo_awal' => $saldo,
              'saldo_akhir' => $saldo + $komisi,
              'user_input' => $data['user_input'],
              'tgl_input' => $now,
              ));
              //update saldo
              $this->db->where('norek', $norek);
              $this->db->set('saldo', 'saldo+'.$komisi, false);
              $this->db->update('m_rekening');
              }
              }
              }
             * 
             */
        } else {
            $biaya_aktivasi = $this->setting_model->get_biaya_aktivasi_bispro();
        }

        $sisa_nominal = $data['nominal'] - $biaya_aktivasi;
        //6. tambah saldo rek wallet bila ada sisa
        if ($sisa_nominal > 0) {
            //insert mutasi
            $now = date('Y-m-d H:i:s');
            $saldo = $this->rekening_model->get_saldo_akhir($norek_wallet);
            $this->db->where('norek', $norek);
            $this->db->insert('t_rek_wallet', array(
                'tgl' => $now,
                'norek' => $norek,
                'jenis_trx' => 'STR',
                'ket' => 'AKTIVASI : ' . $member->id . ' ' . $member->nama,
                'dk' => 'K',
                'nominal' => $sisa_nominal,
                'saldo_awal' => $saldo,
                'saldo_akhir' => $saldo + $sisa_nominal,
                'user_input' => $data['user_input'],
                'tgl_input' => $now,
            ));
            //update saldo
            $this->db->where('norek', $norek_wallet);
            $this->db->set('saldo', 'saldo+' . $sisa_nominal, false);
            $this->db->update('m_rekening');
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            //log error
            log_message();

            return false;
        } else {
            return true;
        }
    }

    function update_device_id($id_member, $device) {
        $this->db->select('COUNT(id) AS jml');
        $this->db->from('m_member_device');
        $this->db->where('id_member', $id_member);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rs = $query->result();
            $jml = $rs[0]->jml;
        } else {
            $jml = 0;
        }
        if ($jml > 0) {
            $this->db->where('id_member', $id_member);
            $this->db->update('m_member_device', array(
                'device_id' => $device,
                'tgl_update' => date('Y-m-d H:i:s'),
            ));
        } else {
            $this->db->insert('m_member_device', array(
                'id_member' => $id_member,
                'device_id' => $device,
                'tgl_update' => date('Y-m-d H:i:s'),
            ));
        }
    }

    function update_upline($data) {
        $this->load->model('rekening_model');
        $this->load->model('komisi_model');
        $this->load->model('wallet_model');
        $this->load->model('fee_registrasi_model', 'fee_model');

        $this->db->trans_start();
        $fee = $this->fee_model->get_data('1');
        $fee = _object2Array($fee);
        $idOutlet = $data['id'];
        $member = $this->get_data($idOutlet);
        
        //Tarik Komisi, update saldo rekening
        $downline = $this->get_member_tree($idOutlet);
        
        if (count($downline) > 0) {
            foreach ($downline as $down) {
                $upline = $this->get_data($down['parent']);
                $uplines = [$upline->id, $upline->id_upline1, $upline->id_upline2, $upline->id_upline3, $upline->id_upline4];
                $uplines = array_filter($uplines);

                $noreks = $this->rekening_model->get_norek_upline($uplines, 'WALLET');

                if ($noreks) {
                    foreach ($noreks as $rek) {
                        $ket = 'ADJ: UBAH UPLINE ' . $down['id'] . ' FROM ' . $data['id_upline_old'] . ' TO ' . $data['id_upline'];
                        $whrRek = "norek=".$this->db->escape($rek->norek)." AND (jenis_trx='FEE' OR jenis_trx='ADJ') AND (ket like 'FEE%" . $down['id'] . "%' OR ket like 'ADJ: UBAH UPLINE " . $down['id'] . "%')";
                        $walletK = $this->wallet_model->getTotalAmount($whrRek,'K', false);
                        $walletD = $this->wallet_model->getTotalAmount($whrRek,'D', false);
                        $adjust = $walletK - $walletD;
                        if ($adjust != 0) {
                            //TODO cek saldo cukup
                            $saldoAwal = $rek->saldo;
                            $saldoAkhir = $rek->saldo - $adjust;
                            $level = array_search($rek->id_member, $uplines) + 1;
                            //insert mutasi                        
                            $now = date('Y-m-d H:i:s');
                            $this->db->insert('t_rek_wallet', array(
                                'tgl' => $now,
                                'norek' => $rek->norek,
                                'jenis_trx' => 'ADJ',
                                'ket' => $ket,
                                'dk' => ($adjust > 0 ? 'D' : 'K'),
                                'nominal' => abs($adjust),
                                'saldo_awal' => $saldoAwal,
                                'saldo_akhir' => $saldoAkhir,
                                'user_input' => $this->nativesession->get(USER_AUTH)['username'],
                                'tgl_input' => $now,
                            ));
                            //update saldo
                            $this->db->where('norek', $rek->norek);
                            $this->db->set('saldo', 'saldo+('.$adjust.')', false);
                            $this->db->update('m_rekening');
                        }
                        //delete l_komisi
                        $this->komisi_model->delete_komisi(["id_member" => $rek->id_member, "id_downline" => $down['id']]);
                    }
                }
            }
        }

        //Update Upline
        $downline = $this->get_member_tree($idOutlet, 1);
        if (count($downline) > 0) {
            foreach ($downline as $down) {
                if ($down['id'] == $idOutlet) {
                    $upline = $this->get_data($data['id_upline']);
                } else {
                    $upline = $this->get_data($down['parent']);
                }

                $outletUpline = [
                    'id_upline1' => $upline->id,
                    'id_upline2' => $upline->id_upline1,
                    'id_upline3' => $upline->id_upline2,
                    'id_upline4' => $upline->id_upline3,
                    'id_upline5' => $upline->id_upline4,
                    'tgl_update' => date('Y-m-d H:i:s'),
                    'user_update' => $this->nativesession->get(USER_AUTH)['username'],
                ];

                $updateOutletUpline = $this->update_data($down['id'], $outletUpline);
            }
        }

        if (intval($member->status) > 0) {
            //Set Komisi Upline 
            $downline = $this->get_member_tree($idOutlet);
            if (count($downline) > 0) {
                foreach ($downline as $down) {
                    $upline = $this->get_data($down['parent']);
                    $uplines = [$upline->id, $upline->id_upline1, $upline->id_upline2, $upline->id_upline3, $upline->id_upline4];
                    $uplines = array_filter($uplines);

                    $noreks = $this->rekening_model->get_norek_upline($uplines, 'WALLET');

                    if ($noreks) {
                        foreach ($noreks as $rek) {
                            $level = array_search($rek->id_member, $uplines) + 1;
                            $now = date('Y-m-d H:i:s');
                            $komisi = $fee["upline" . $level];

                            $whrRek = "norek=".$this->db->escape($rek->norek)." AND (jenis_trx='FEE' OR jenis_trx='ADJ') AND (ket like 'FEE%" . $down['id'] . "%' OR ket like 'ADJ: UBAH UPLINE " . $down['id'] . "%')";
                            $walletK = $this->wallet_model->getTotalAmount($whrRek, 'K', false);
//                            echo $this->db->last_query()."<br>";
                            $walletD = $this->wallet_model->getTotalAmount($whrRek, 'D', false);
//                            echo $this->db->last_query()."<br>";
                            $adjust = floatval($komisi) - (floatval($walletK) - floatval($walletD));
                            
                            if ($adjust != 0) {
                                //TODO cek saldo cukup
                                $saldoAwal = $rek->saldo;
                                $saldoAkhir = $rek->saldo + $adjust;

                                //insert mutasi                        

                                $this->db->insert('t_rek_wallet', array(
                                    'tgl' => $now,
                                    'norek' => $rek->norek,
                                    'jenis_trx' => 'FEE',
                                    'ket' => 'FEE ' . $level . ': ' . $down['id'] . ' ' . $data['nama'],
                                    'dk' => ($adjust > 0 ? 'K' : 'D'),
                                    'nominal' => abs($adjust),
                                    'saldo_awal' => $saldoAwal,
                                    'saldo_akhir' => $saldoAkhir,
                                    'user_input' => $this->nativesession->get(USER_AUTH)['username'],
                                    'tgl_input' => $now,
                                ));
                                //update saldo
                                $this->db->where('norek', $rek->norek);
                                $this->db->set('saldo', 'saldo+('. $adjust.')', false);
                                $this->db->update('m_rekening');
                            }
                            //insert l_komisi
                            $this->db->insert('l_komisi', array(
                                'tgl' => $now,
                                'id_member' => $rek->id_member,
                                'id_downline' => $down['id'],
                                'nominal' => $komisi,
                                'level' => $level,
                            ));
                        }
                    }
                }
            }
        }
        $this->db->trans_complete();
//        die();
        if ($this->db->trans_status() === FALSE) {
            //log error
            log_message();

            return false;
        } else {
            return $data;
        }
        
    }

    function registrasi($data, $bank) {
        $this->db->trans_start();

        $upline = $this->get_data($data['id_upline1']);
        if ($upline == null) {
            return false;
        }

        $data['id'] = $this->get_new_id() . '';
        $data['tgl_registrasi'] = date('Y-m-d H:i:s');
        $data['id_upline2'] = $upline->id_upline1;
        $data['id_upline3'] = $upline->id_upline2;
        $data['id_upline4'] = $upline->id_upline3;
        $data['id_upline5'] = $upline->id_upline4;
        $data['status'] = '0';
        $data['id_cabang'] = $upline->id_cabang;
        if (!isset($data['user_input'])) {
            $data['user_input'] = $upline->id;
        }
        $data['tgl_input'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table_name, $data);

        //insert bank
        $bank['id_member'] = $data['id'];
        $this->db->insert('m_member_bank', $bank);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            //log error
            log_message();

            return false;
        } else {
            return $data;
        }
    }

    function get_new_id() {
        $this->db->select_max('id');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $new_id = floatval($row->id) + 1;
            return $new_id;
        } else {
            return 1;
        }
    }

    function get_member_list($keyword = "") {
        $this->db->distinct();
        $this->db->select("id, nama");
        $this->db->from($this->table_name);
        $this->db->like('id', $keyword);
        $this->db->or_like('nama', $keyword);
        $this->db->where('status', '1');
        $this->db->limit(20);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $rs = $q->result();
            foreach ($rs as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return null;
        }
    }

    function get_member_tree($id_upline, $status = '') {


        $this->db->select("id, nama, status, nohp, email, id_upline1 as id_upline");
        $this->db->from($this->table_name);
        if (!empty($id_upline)) {
            $id_upline = $this->db->escape($id_upline);
            $this->db->where("(id=$id_upline OR id_upline1=$id_upline OR id_upline2=$id_upline "
                    . "OR id_upline3=$id_upline OR id_upline4=$id_upline OR id_upline5=$id_upline)", NULL, FALSE);

            if ($status != '') {
                $status = $this->db->escape(intval($status));
                $this->db->where('status', $status);
            }
        }

        $q = $this->db->get();
//        die($this->db->last_query());
        if ($q->num_rows() > 0) {
            $rs = $q->result();
            foreach ($rs as $row) {
                $data[] = array(
                    'id' => $row->id,
                    'text' => $row->id . ' - ' . $row->nama . ($row->status == '0' ? ' (BELUM AKTIF)' : '') . ' - No. Telp: ' . $row->nohp,
                    'href' => '#' . $row->id,
                    'parent' => $row->id_upline,
                );
            }
            return $data;
        } else {
            return null;
        }
    }

}
