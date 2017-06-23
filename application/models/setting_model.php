<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once 'base_model.php';

class Setting_model extends Base_Model {
    public $SIMPANAN_POKOK = "simpanan_pokok";
    public $SIMPANAN_WAJIB = "simpanan_wajib";
    public $MINIMUM_SIPRO = "minimum_sipro";
    public $MINIMUM_BISPRO = "minimum_bispro";
    public $BIAYA_AKTIVASI_SIPRO = "biaya_aktivasi_sipro";
    public $BIAYA_AKTIVASI_BISPRO = "biaya_aktivasi_bispro";
    public $PPOB_USER = 'ppob_user';
    public $PPOB_PIN = 'ppob_pin';
    public $PPOB_URL = 'ppob_url';
    public $SHARE_SUBJECT = 'share_subject';
    public $SHARE_IMAGE = 'share_image';
    public $SHARE_MESSAGE = 'share_message';
    public $NO_WA_KONFIRMASI = 'no_wa_konfirmasi';
    
    public function __construct() {
        parent::__construct();
        $this->table_name = 'c_setting';
    }
    
    function get_simpanan_pokok(){
        return floatval($this->get_setting($this->SIMPANAN_POKOK));
    }
    function get_simpanan_wajib(){
        return floatval($this->get_setting($this->SIMPANAN_WAJIB));
    }
    function get_minimum_sipro(){
        return floatval($this->get_setting($this->MINIMUM_SIPRO));
    }
    function get_minimum_bispro(){
        return floatval($this->get_setting($this->MINIMUM_BISPRO));
    }
    function get_biaya_aktivasi_sipro(){
        return floatval($this->get_setting($this->BIAYA_AKTIVASI_SIPRO));
    }
    function get_biaya_aktivasi_bispro(){
        return floatval($this->get_setting($this->BIAYA_AKTIVASI_BISPRO));
    }
    function get_ppob_user(){
        return $this->get_setting($this->PPOB_USER);
    }
    function get_ppob_pin(){
        return $this->get_setting($this->PPOB_PIN);
    }
    function get_ppob_url(){
        return $this->get_setting($this->PPOB_URL);
    }
    function get_share_subject(){
        return $this->get_setting($this->SHARE_SUBJECT);
    }
    function get_share_message(){
        return $this->get_setting($this->SHARE_MESSAGE);
    }
    function get_share_image(){
        return $this->get_setting($this->SHARE_IMAGE);
    }
    function get_no_wa_konfirmasi(){
        return $this->get_setting($this->NO_WA_KONFIRMASI);
    }

    public function get_setting($id){
        $ret = $this->get_data($id, 'kode');
        if($ret!=null){
            return $ret->nilai;
        }else{
            return '';
        }
    }
}
