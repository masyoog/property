<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Data extends Site_Controller {
    
    public function __construct() {
        $this->isAkses = true;
        
        parent::__construct();
    }
    
    function index(){
    }
    
    function tracking(){
        $cn = urldecode($this->security->xss_clean($this->input->post('cn')));
        $this->load->model('tracking_model');
        $data = $this->tracking_model->get_tracking($cn);
        
        echo json_encode($data);
    }
    
    //--autocomplete
    function get_data_provinsi() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $where="("
            . "nama like '%$key%'"
            . ")";
        $this->load->model('provinsi_model');
        $data = $this->provinsi_model->read_data(10, '', $where, 'nama');
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'label' => $row->nama,
                    'value' => $row->nama,
                    'id_provinsi'=>$row->id,
                    'nama_provinsi'=>$row->nama,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_data_kabupaten() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $prov = urlencode($this->security->xss_clean($this->input->get('provinsi')));
        $where="("
            . "nama like '%$key%'"
            . ") AND id_provinsi = '".$prov."'";
        $this->load->model('kabupaten_model');
        $data = $this->kabupaten_model->read_data(10, '', $where, 'nama');
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'label' => $row->nama,
                    'value' => $row->nama,
                    'id_kabupaten'=>$row->id,
                    'nama_kabupaten'=>$row->nama,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_data_kecamatan() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $prov = urlencode($this->security->xss_clean($this->input->get('provinsi')));
        $kab = urlencode($this->security->xss_clean($this->input->get('kabupaten')));
        $where="("
            . "nama like '%$key%'"
            . ") AND id_kabupaten = '".$kab."' AND id_provinsi='".$prov."'";
        $this->load->model('kecamatan_model');
        $data = $this->kecamatan_model->read_data(10, '', $where, 'nama');
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'label' => $row->nama,
                    'value' => $row->nama,
                    'id_kecamatan'=>$row->id,
                    'nama_kecamatan'=>$row->nama,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_data_kelurahan() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $prov = urlencode($this->security->xss_clean($this->input->get('provinsi')));
        $kab = urlencode($this->security->xss_clean($this->input->get('kabupaten')));
        $kec = urlencode($this->security->xss_clean($this->input->get('kecamatan')));
        $where="("
            . "nama like '%$key%'"
            . ") AND id_kecamatan = '".$kec."' AND id_kabupaten = '".$kab."' AND id_provinsi='".$prov."'";
        $this->load->model('kelurahan_model');
        $data = $this->kelurahan_model->read_data(10, '', $where, 'nama');
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'label' => $row->nama,
                    'value' => $row->nama,
                    'id_kelurahan'=>$row->id,
                    'nama_kelurahan'=>$row->nama,
                    'kodepos'=>$row->kodepos,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_akun() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $where="("
            . "id like '%$key%' OR "
            . "nama like '%$key%'"
            . ") AND (id_cabang='".$this->data['cabang']."')";
        $this->load->model('customer_model');
        $data = $this->customer_model->get_data_where($where);
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
//                $ret['query'] = $key;
//                $ret['suggestions'][] = array(
                $ret[] = array(
                    'label' => $row->id.' - '.$row->nama,
                    'value' => $row->id.' - '.$row->nama,
                    'data' => $row->id,
                    'nama'=>$row->nama,
                    'alamat'=>$row->alamat,
                    'alamat2'=>$row->alamat2,
                    'kota'=>$row->kota,
                    'kodepos'=>$row->kodepos,
                    'telp'=>$row->telp,
                    'kontak_person'=>$row->kontak_person,
                    'ppn'=>$row->tipe_ppn,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kelurahan() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $where="("
            . "kodepos like '$key%' OR "
            . "kelurahan like '%$key%' OR "
            . "kecamatan like '%$key%' OR "
            . "kabupaten like '%$key%' "
            . ")";
        $this->load->model('kelurahan_view_model');
        $data = $this->kelurahan_view_model->read_data(50, '', $where, 'kodepos, kelurahan');
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'label' => $row->kodepos.' - '.$row->kelurahan.', '.$row->kecamatan.', '.$row->kabupaten,
                    'value' => $row->kodepos.' - '.$row->kelurahan,
                    'kodepos'=>$row->kodepos,
                    'nama_provinsi'=>$row->provinsi,
                    'nama_kabupaten'=>$row->kabupaten,
                    'nama_kecamatan'=>$row->kecamatan,
                    'nama_kelurahan'=>$row->kelurahan,
                    'id_provinsi'=>$row->id_provinsi,
                    'id_kabupaten'=>$row->id_kabupaten,
                    'id_kecamatan'=>$row->id_kecamatan,
                    'id_kelurahan'=>$row->id_kelurahan,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kota() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $where="("
            . "id like '%$key%' OR "
            . "nama like '%$key%'"
            . ")";
        $this->load->model('kota_model');
        $data = $this->kota_model->get_data_where($where);
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'id' => $row->id,
                    'label'=> $row->nama,
                    'value' => $row->nama,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_nopol() {
        $key = urldecode($this->security->xss_clean($this->input->get('term')));
        $where="("
            . "nopol like '%$key%'"
            . ")";
        $this->load->model('kendaraan_model');
        $data = $this->kendaraan_model->get_data_where($where);
        $ret=array();
        if(count($data)>0){
            foreach ($data as $row) {
                $ret[] = array(
                    'id' => $row->id,
                    'label'=> $row->nopol,
                    'value' => $row->nopol,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_c_berat_volume(){
        $layanan = urldecode($this->security->xss_clean($this->input->post('layanan')));
        
        $ret = array(
            'konstanta' => 0
        );
        $this->load->model('layanan_model');
        $ret['konstanta'] = $this->layanan_model->get_konstanta($layanan);
        
        echo json_encode($ret);
    }
    //--combobox
    function get_asuransilist(){
        $ret=array();
        $this->load->model('asuransi_model');
        $dt = $this->asuransi_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_cabanglist(){
        $ret=array();
        $this->load->model('cabang_model');
        $dt = $this->cabang_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_customerlist(){
        $ret=array();
        $cabang = $this->input->post('cabang');
        if(empty($cabang)){
            $cabang = $this->data['cabang'];
        }
        $this->load->model('customer_model');
        $dt = $this->customer_model->get_datalist($cabang);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kirimanlist(){
        $ret=array();
        $this->load->model('kiriman_model');
        $dt = $this->kiriman_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_komoditaslist(){
        $ret=array();
        $this->load->model('komoditas_model');
        $dt = $this->komoditas_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_komoditas_kategorilist(){
        $ret=array();
        $this->load->model('komoditas_kategori_model');
        $dt = $this->komoditas_kategori_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kurirlist(){
        $ret=array();
        $this->load->model('kurir_model');
        $dt = $this->kurir_model->get_datalist($this->data['cabang']);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_layananlist(){
        $ret=array();
        $this->load->model('layanan_model');
        $dt = $this->layanan_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_modalist(){
        $ret=array();
        $this->load->model('moda_model');
        $dt = $this->moda_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_packinglist(){
        $ret=array();
        $this->load->model('packing_model');
        $dt = $this->packing_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_ppnlist(){
        $ret=array();
        $this->load->model('ppn_model');
        $dt = $this->ppn_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_provinsilist(){
        $ret=array();
        $this->load->model('provinsi_model');
        $dt = $this->provinsi_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kabupatenlist(){
        $prov = $this->input->post('provinsi');
        $ret=array();
        $this->load->model('kabupaten_model');
        $dt = $this->kabupaten_model->get_datalist($prov);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kecamatanlist(){
        $prov = $this->input->post('provinsi');
        $kab = $this->input->post('kabupaten');
        $ret=array();
        $this->load->model('kecamatan_model');
        $dt = $this->kecamatan_model->get_datalist($prov, $kab);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kelurahanlist(){
        $prov = $this->input->post('provinsi');
        $kab = $this->input->post('kabupaten');
        $kec = $this->input->post('kecamatan');
        $ret=array();
        $this->load->model('kelurahan_model');
        $dt = $this->kelurahan_model->get_datalist($prov, $kab, $kec);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_kodepos_kelurahan(){
        $desa = $this->input->post('kelurahan');
        $this->load->model('kelurahan_model');
        $data = $this->kelurahan_model->get_kodepos_kelurahan($desa);
        
        echo json_encode($data);
    }
    function get_saleslist(){
        $ret=array();
        $cabang = $this->input->post('cabang');
        if(empty($cabang)){
            $cabang = $this->data['cabang'];
        }
        $this->load->model('sales_model');
        $dt = $this->sales_model->get_datalist($cabang);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_supirlist(){
        $ret=array();
        $cabang = $this->input->post('cabang');
        if(empty($cabang)){
            $cabang = $this->data['cabang'];
        }
        $this->load->model('supir_model');
        $dt = $this->supir_model->get_datalist($cabang);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_tipe_bayarlist(){
        $ret=array();
        $this->load->model('tipe_bayar_model');
        $dt = $this->tipe_bayar_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_vendorlist(){
        $ret=array();
        $this->load->model('vendor_model');
        $dt = $this->vendor_model->get_datalist($this->data['cabang']);
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
    function get_vialist(){
        $ret=array();
        $this->load->model('via_model');
        $dt = $this->via_model->get_datalist();
        if(count($dt)>0){
            foreach($dt as $key => $val){
                $ret[] = array(
                    'id'=>$key,
                    'value'=>$val,
                );
            }
        }
        echo json_encode($ret);
    }
}
