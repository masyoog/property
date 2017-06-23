<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Produk extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('produk_model');
        
    }
    
    function get_data(){
        $this->datatables->select('p.id as id, p.nama as nama, p.lokasi as lokasi, p.lt as lt, p.lb as lb, '
                . 'j.nama as jenis_produk, pr.nama as project, p.id AS action')
                ->unset_column('id')
                ->add_column('action', $this->get_action_button('$1'), 'id')
                ->from("m_produk p")->join('r_jenis_produk j', 'p.jenis_produk=j.id','left')->join('m_project pr', 'p.project=pr.id', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Data Produk",
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
            "title" => "Data Produk",
            'subtitle' => 'Detail Data',
            'fields' => $this->field,
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->produk_model->get_data($id, $this->key_id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        $this->view($data);
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Data Produk",
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
            "title" => "Edit Data Produk",
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
        $res = $this->produk_model->get_data($id, $this->key_id);
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
        $result = $this->produk_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $delete = $this->produk_model->delete_data($id, $this->key_id);
            if ($delete) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
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
                'tgl_input' => $now,
                'user_input' => $this->data['username'],
            );
            $create = $this->produk_model->insert_data($data);
            if ($create) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed to save data');
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
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            $update = $this->produk_model->update_data($id, $data, $this->key_id);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed to save data');
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
        $res = $this->produk_model->get_total_data("(id='$kode')", $this->key_id);
        if($res>0){
            $this->form_validation->set_message('cek_double_id', 'ID telah dipakai. Silahkan menggunakan ID yang lain');
            return false;
        }else{
            return true;
        }        
    }
    private function init($with_value = true){
        
        if($with_value){
            $this->load->model('jenis_produk_model');
            $jenislist = $this->jenis_produk_model->get_datalist();
            $this->load->model('project_model');
            $projectlist = $this->project_model->get_datalist();
        }else{
            $jenislist = array();
            $projectlist = array();
        }
        $this->field = array(
            'nama' => array(
                'label'=>'nama',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'lokasi' => array(
                'label'=>'lokasi',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 100,
                'format' => 'an',
            ),
            'lb' => array(
                'label'=>'luas bangunan',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 5,
                'format' => 'n',
            ),
            'lt' => array(
                'label'=>'luas tanah',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 5,
                'format' => 'n',
            ),
            'jenis_produk' => array(
                'label'=>'jenis produk',
                'placeholder'=>'jenis produk',
                'type'=> "select2",
                'required' => true,
                'data' => $jenislist,
            ),
            'project' => array(
                'label'=>'project',
                'placeholder'=>'project',
                'type'=> "select2",
                'required' => true,
                'data' => $projectlist,
            ),
        );
    }
}
