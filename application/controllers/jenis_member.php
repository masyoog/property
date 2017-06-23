<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Jenis_member extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('jenis_member_model');
        
    }
    
    function get_data(){
        $this->datatables->select('id as kode, nama, ket, id AS action')
                ->add_column('action', $this->get_action_button('$1'), 'kode')
                ->from("m_jenis_program")
                ;
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Data Jenis Program",
            'subtitle' => 'List Data',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/DataTables/jquery.dataTables.css", 
                base_url() . "assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css", 
                base_url() . "assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css", 
            ),
            'js' => array(
                base_url() . "assets/js/libs/DataTables/jquery.dataTables.min.js",
                base_url() . "assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js",
                base_url() . "assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js",
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
                'dom': 'lCfrtip',
                'colVis': {
                    'buttonText': 'Columns',
                    'overlayFade': 0,
                    'align': 'right'
                },
                'language': {
                    'lengthMenu': '_MENU_ entries per page',
                    'search': '<i class=\"fa fa-search\"></i>',
                    'paginate': {
                        'previous': '<i class=\"fa fa-angle-left\"></i>',
                        'next': '<i class=\"fa fa-angle-right\"></i>'
                    }
                },
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
            "title" => "Data Jenis Program",
            'subtitle' => 'Detail Data',
            'fields' => $this->field,
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->jenis_member_model->get_data($id, $this->key_id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        $this->view($data);
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Data Jenis Program",
            'subtitle' => 'Input Data',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/select2/select2.css",
            ),
            'js' => array(
                base_url() . "assets/js/libs/select2/select2.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
                base_url() . "assets/js/pages/".$this->class_name.".js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        $form_input = new My_form();
        $form_input->set($this->field);
        $data["form_element"] = $form_input->render_form();
        
        $this->view($data);
    }
    function edit() {
        $this->init();
        $data = array(
            "title" => "Edit Data Jenis Program",
            'subtitle' => 'Edit Data',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/select2/select2.css",
            ),
            'js' => array(
                base_url() . "assets/js/libs/select2/select2.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        $code = $this->input->post('id');
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->jenis_member_model->get_data($id, $this->key_id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect('user');
        } else {
            $form_input = new My_form();
            $this->field = array_merge($this->field, array('id'=>array('type'=>'hidden')));
            
            $form_input->set($this->field);
            if(!empty($this->input->post())){
                $value = $this->input->post();
            }else{
                $value = array(
                    'kode'=>$res->id,
                    'nama'=>$res->nama,
                    'ket'=>$res->ket,
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
        $result = $this->jenis_member_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $delete = $this->jenis_member_model->delete_data($id, $this->key_id);
            if ($delete) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed delete data');
            }
            redirect($this->class);
        }
    }

    function insert() {
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required|xss_clean|callback_cek_double_id');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id' => strtoupper($this->input->post('kode')),
                'nama' => strtoupper($this->input->post('nama')),
                'ket' => $this->input->post('ket'),
                'tgl_input' => $now,
                'user_input' => $this->data['username'],
            );
            $create = $this->jenis_member_model->insert_data($data);
            if ($create) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan');
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data');
            }
            redirect($this->class);
        }
    }

    function update() {
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required|xss_clean|callback_cek_double_id');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $id = $this->input->post('id');
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id' => strtoupper($this->input->post('kode')),
                'nama' => strtoupper($this->input->post('nama')),
                'ket' => $this->input->post('ket'),
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            $update = $this->jenis_member_model->update_data($id, $data, $this->key_id);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan');
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data');
            }
            redirect($this->class);
        }
    }
    function cek_double_id(){
        $kode=$this->input->post('kode');
        $id=$this->input->post('id');
        if($kode==$id){
            return true;
        }
        $res = $this->jenis_member_model->get_total_data("(id='$kode')", $this->key_id);
        if($res>0){
            $this->form_validation->set_message('cek_double_id', 'ID telah dipakai. Silahkan menggunakan ID yang lain');
            return false;
        }else{
            return true;
        }        
    }
    private function init($with_value = true){
        
        $this->field = array(
            'kode' => array(
                'label'=>'kode',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 3,
                'format' => 'an',
            ),
            'nama' => array(
                'label'=>'nama',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 30,
                'format' => 'an',
            ),
            'ket' => array(
                'label'=>'keterangan',
                'type'=> "textarea",
                'minLength' => 0,
                'maxLength'=> 150,
                'format' => 'an',
            ),
        );
    }
}
