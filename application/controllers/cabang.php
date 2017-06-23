<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cabang extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'kode';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('cabang_model');
        
    }
    
    function get_data(){
        $this->datatables->select('kode as kode, nama as nama, alamat as alamat, email as email, '
                . 'notelp as notelp, fax as fax, status as status, lat as lat, lng as lng, kode AS action')
                ->add_column('action', $this->get_action_button('$1'), 'kode')
//                ->add_column('gps', '$1,$2', 'lat, lng')
                ->edit_column('status', '$1', '_get_status(status)')
                ->from("m_cabang")
                ;
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Data Cabang",
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
            "title" => "Data Cabang",
            'subtitle' => 'Detail Data',
            'fields' => $this->field,
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->cabang_model->get_data($id, $this->key_id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        $this->view($data);
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Data Cabang",
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
            "title" => "Edit Data Cabang",
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
        $res = $this->cabang_model->get_data($id, $this->key_id);
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
                    'kode'=>$res->kode,
                    'nama'=>$res->nama,
                    'alamat'=>$res->alamat,
                    'email'=>$res->email,
                    'notelp'=>$res->notelp,
                    'fax'=>$res->fax,
                    'status'=>$res->status,
                    'gps'=>$res->lat.','.$res->lng,
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
        $result = $this->cabang_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $delete = $this->cabang_model->delete_data($id, $this->key_id);
            if ($delete) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed delete data');
            }
            redirect($this->class);
        }
    }

    function insert() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required|xss_clean|callback_cek_double_id');
        $this->form_validation->set_rules('nama', 'Nama Cabang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Eemail', 'trim|required|xss_clean');
        $this->form_validation->set_rules('notelp', 'No. Telp', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $now=date('Y-m-d H:i:s');
            $input['lat'] = '';
            $input['lng'] = '';
            if(strpos($input['gps'], ',')){
                $gps = split(",", $input['gps']);
                $input['lat'] = isset($gps[0])?trim($gps[0]):'';
                $input['lng'] = isset($gps[1])?trim($gps[1]):'';
            }
            $data = array(
                'kode' => strtoupper($input['kode']),
                'nama' => strtoupper($input['nama']),
                'alamat' => strtoupper($input['alamat']),
                'email' => $input['email'],
                'notelp' => $input['notelp'],
                'fax' => $input['fax'],
                'status' => $input['status'],
                'lat' => $input['lat'],
                'lng' => $input['lng'],
                'tgl_input' => $now,
                'user_input' => $this->data['username'],
            );
            $create = $this->cabang_model->insert_data($data);
            if ($create) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed to save data');
            }
            redirect($this->class);
        }
    }

    function update() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('kode', 'Kode', 'trim|required|xss_clean|callback_cek_double_id');
        $this->form_validation->set_rules('nama', 'Nama Cabang', 'trim|required|xss_clean');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('email', 'Eemail', 'trim|required|xss_clean');
        $this->form_validation->set_rules('notelp', 'No. Telp', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $id = $input['id'];
            $now=date('Y-m-d H:i:s');
            $input['lat'] = '';
            $input['lng'] = '';
            if(strpos($input['gps'], ',')){
                $gps = split(",", $input['gps']);
                $input['lat'] = isset($gps[0])?trim($gps[0]):'';
                $input['lng'] = isset($gps[1])?trim($gps[1]):'';
            }
            $data = array(
                'kode' => strtoupper($input['kode']),
                'nama' => strtoupper($input['nama']),
                'alamat' => strtoupper($input['alamat']),
                'email' => $input['email'],
                'notelp' => $input['notelp'],
                'fax' => $input['fax'],
                'status' => $input['status'],
                'lat' => $input['lat'],
                'lng' => $input['lng'],
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            $update = $this->cabang_model->update_data($id, $data, $this->key_id);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed to save data');
            }
            redirect($this->class);
        }
    }
    function cek_double_id(){
        $broker_id=$this->input->post('kode');
        $id=$this->input->post('id');
        if($broker_id==$id){
            return true;
        }
        $res = $this->cabang_model->get_total_data("(kode='$broker_id')", $this->key_id);
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
                'maxLength'=> 10,
                'format' => 'an',
            ),
            'nama' => array(
                'label'=>'nama cabang',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'alamat' => array(
                'label'=>'alamat',
                'type'=> "textarea",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 100,
                'format' => 'an',
            ),
            'email' => array(
                'label'=>'email',
                'type'=> "email",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 30,
            ),
            'notelp' => array(
                'label'=>'no. telp',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'fax' => array(
                'label'=>'fax',
                'type'=> "text",
                'required' => false,
                'minLength' => 0,
                'maxLength'=> 25,
                'format' => 'an',
            ),
            'status' => array(
                'label'=>'status',
                'placeholder'=>'status',
                'type'=>'select',
                'required'=>true,
                'data'=> array(
                    '0' => 'NON AKTIF',
                    '1' => 'AKTIF'
                ),
                'value' => '1',
            ),
            'gps' => array(
                'label'=>'GPS Position',
                'type'=> "text",
                'required' => false,
                'format' => 'an',
                'hide' => true,
                'help' => '(lattitude, longitude)'
            ),
        );
    }
}
