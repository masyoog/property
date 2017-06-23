<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Harga extends Site_Controller {
    protected $template_name = "default";

    private $field;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('harga_model');
        
    }
    
    function get_data(){
        $this->datatables->select('h.id as id, h.origin as origin, h.destination as destination, '
//                . 'c.kode as kode_origin, c.nama as nama_origin, c.kota as kota_origin, '
//                . 'c2.kode as kode_destination, c2.nama as nama_destination, c2.kota as kota_destination, '
                . "CONCAT(h.maskapai, ' - ', m.nama) AS maskapai, h.harga as harga, h.id AS action", false)
                ->unset_column('id')
                ->add_column('action', $this->get_action_button('$1'), 'id')
                ->edit_column('harga', '$1', '_format_angka(harga)')
                ->from("m_harga h")
//                ->join("m_bandara c", "c.kode=h.origin",'left')
//                ->join("m_bandara c2", "c2.kode=h.destination",'left')
                ->join("m_maskapai m", "m.kode=h.maskapai",'left');
//        if(!$this->is_nasional){
//            $this->datatables->where('h.origin', $this->data['cabang']);
//        }
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init();
        $data = array(
            "title" => "Rate / Pricelist",
            'subtitle' => 'List Data',
            'css' => array(
                base_url() . "assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css", 
                base_url() . "assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css", 
                base_url() . "assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css", 
                base_url() . "assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css", 
                base_url() . "assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css",
            ),
            'js' => array(
                base_url() . "assets/vendors/datatables.net/js/jquery.dataTables.min.js",
                base_url() . "assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js",
                base_url() . "assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js",
                base_url() . "assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js",
                base_url() . "assets/vendors/datatables.net-buttons/js/buttons.flash.min.js",
                base_url() . "assets/vendors/datatables.net-buttons/js/buttons.html5.min.js",
                base_url() . "assets/vendors/datatables.net-buttons/js/buttons.print.min.js",
                base_url() . "assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js",
                base_url() . "assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js",
                base_url() . "assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js",
                base_url() . "assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js",
                base_url() . "assets/vendors/datatables.net-scroller/js/datatables.scroller.min.js",
                base_url() . "assets/vendors/jszip/dist/jszip.min.js",
                base_url() . "assets/vendors/pdfmake/build/pdfmake.min.js",
                base_url() . "assets/vendors/pdfmake/build/vfs_fonts.js",
            ),
            'fields' => $this->field,
        );
        
        $column = "";
        $keys = array();
        $i=0;
        foreach($this->field as $key => $val){
            if(isset($val['hide'])&& $val['hide']==true) continue;
            $column .="{'data':'".$key."'},";
            $keys[] = $i++;
        }
        $column_export = implode(',', $keys);
        $data['js_init']="
            $('#table_data').dataTable({
                'processing': true,
                'serverSide': true,
                'fixedHeader': true,
                'ajax': {
                    'url': '".base_url().$this->class_name."/get_data',
                    'type': 'POST'
                },
                'columns': [
                    ".$column."
                    {'data': 'action'}
                ],
                'dom': '<\"row\"<\"col-sm-6\"B><\"col-sm-6 text-right\"f>><\"row\"<\"col-sm-12\"tr>><\"row\"<\"col-sm-5\"i><\"col-sm-7\"lp>>',
//                dom: 'Bfrtipl',
                buttons: [
                  {
                    extend: 'copy',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [".$column_export."]
                     }
                  },
                  {
                    extend: 'csv',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [".$column_export."]
                     }
                  },
                  {
                    extend: 'excel',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [".$column_export."]
                     }
                  },
                  {
                    extend: 'pdfHtml5',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [".$column_export."]
                     }
                  },
                  {
                    extend: 'print',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [".$column_export."]
                     }
                  },
                ]
            });
        ";
        $this->view($data);
    }
    function detail(){
        $this->init(false);
        $data = array(
            "title" => "Rate / Pricelist",
            'subtitle' => 'Detail Data',
            'fields' => $this->field
        );
        
        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->harga_model->get_data_detail($id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect($this->class);
        }
        
        $this->view($data);
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Rate",
            'subtitle' => 'Input Data',
            'css' => array(
                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.css",
                base_url() . "assets/vendors/select2/select2.css",
                base_url() . "assets/vendors/select2/select2-bootstrap.css",
            ),
            'js' => array(
                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.js",
                base_url() . "assets/vendors/select2/select2.min.js",
            ),
        );
        $form_input = new My_form();
        $form_input->set($this->field);
        $form_input->set_value($this->input->post());
        $data["form_element"] = $form_input->render_form();
        
        $this->view($data);
    }
    function edit() {
        $this->init();
        $data = array(
            "title" => "Edit Rate",
            'subtitle' => 'Edit Data',
            'css' => array(
                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.css",
                base_url() . "assets/vendors/select2/select2.css",
                base_url() . "assets/vendors/select2/select2-bootstrap.css",
            ),
            'js' => array(
                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.js",
                base_url() . "assets/vendors/select2/select2.min.js",
            ),
        );
        $code = $this->input->post('id');
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->harga_model->get_data($id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect($this->class);
        } else {
            $form_input = new My_form();
            $this->field = array_merge($this->field, array('id'=>array('type'=>'hidden')));
            $form_input->set($this->field);
            if(!empty($this->input->post())){
                $value = $this->input->post();
            }else{
                $value = array(
                    'origin'=>$res->origin,
                    'destination' => $res->destination,
                    'maskapai'=>$res->maskapai,
                    'harga'=>$res->harga,
                    'id'=>$id,
                );
            }
            $form_input->set_value($value);
            $data["form_element"] = $form_input->render_form("edit");
        }
        
        $this->view($data);
    }

    function delete() {
        $id = $this->security->xss_clean($this->uri->segment(3));
        $result = $this->harga_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data yang akan dihapus tidak ditemukan');
            redirect($this->class);
        } else {
            $delete = $this->harga_model->delete_data($id);
            if ($delete) {
                $this->session->set_flashdata('msg', 'Data berhasil dihapus');
            } else {
                $this->session->set_flashdata('msg_err', 'Data gagal dihapus');
            }
            redirect($this->class);
        }
    }

    function insert() {
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('origin', 'Origin', 'trim|required|xss_clean');
        $this->form_validation->set_rules('destination', 'Destination', 'trim|required|xss_clean');
        $this->form_validation->set_rules('maskapai', 'Maskapai', 'trim|required|xss_clean|callback_cek_double_entry');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $data = array(
                'origin' => $this->input->post('origin'),
                'destination' => $this->input->post('destination'),
                'maskapai' => $this->input->post('maskapai'),
                'harga' => floatval($this->input->post('harga')),
                'tgl_input' => date('Y-m-d H:i:s'),
                'user_input' => $this->data['username'],
            );
            $create = $this->harga_model->insert_data($data);
            if ($create) {
                $this->session->set_flashdata('msg', 'Data berhasil disimpan');
            } else {
                $this->session->set_flashdata('msg_err', 'Data gagal disimpan');
            }
            redirect($this->class);
        }
    }

    function update() {
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('origin', 'Origin', 'trim|required|xss_clean');
        $this->form_validation->set_rules('destination', 'Destination', 'trim|required|xss_clean');
        $this->form_validation->set_rules('maskapai', 'Maskapai', 'trim|required|xss_clean|callback_cek_double_entry');
        $this->form_validation->set_rules('harga', 'Harga', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $id = $this->input->post('id');
            $data = array(
                'origin' => $this->input->post('origin'),
                'destination' => $this->input->post('destination'),
                'maskapai' => $this->input->post('maskapai'),
                'harga' => floatval($this->input->post('harga')),
                'tgl_update' => date('Y-m-d H:i:s'),
                'user_update' => $this->data['username'],
            );
            $update = $this->harga_model->update_data($id, $data);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data berhasil diubah');
            } else {
                $this->session->set_flashdata('msg_err', 'Data gagal diubah ');
            }
            redirect($this->class);
        }
    }
    function cek_double_entry(){
        $origin=$this->input->post('origin');
        $destination=$this->input->post('destination');
        $maskapai=$this->input->post('maskapai');
        $id=$this->input->post('id');
        $res = $this->harga_model->get_total_data("(origin='$origin' AND destination='$destination' AND maskapai='$maskapai' AND id<>'$id')");
        if($res>0){
            $this->form_validation->set_message('cek_double_entry', 'Duplikat data harga, silahkan inputkan data dengan origin, destination, maskapai yang berbeda.');
            return false;
        }else{
            return true;
        }
    }
    private function init($with_value=true){
        $bandaralist = array();
        $maskapailist = array();
        if($with_value){
            $this->load->model('cabang_model');
            $bandaralist = $this->cabang_model->get_datalist(true);
            $this->load->model('maskapai_model');
            $maskapailist = $this->maskapai_model->get_datalist(true);
        }
        $this->field = array(
            'origin' => array(
                'label'=>'origin',
                'placeholder'=>'origin',
                'type'=> "select2",
                'required' => true,
                'data' => $bandaralist,
                'value' => $this->data['cabang'],
            ),
            'destination' => array(
                'label'=>'destination',
                'placeholder'=>'destination',
                'type'=> "select2",
                'required' => true,
                'data' => $bandaralist,
            ),
            'maskapai' => array(
                'label'=>'maskapai',
                'placeholder'=>'maskapai',
                'type'=> "select2",
                'required' => true,
                'data' => $maskapailist,
            ),
            'harga' => array(
                'label'=>'rate',
                'placeholder'=>'rate',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 9,
                'format' => 'n',
                'readonly' => false,
            ),
        );
    }
}
