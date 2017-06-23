<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends Site_Controller {
    protected $template_name = "default";

    private $field;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('user_model');
        
    }
    
    function get_data(){
        $this->datatables->select('u.id_user AS user, u.nama AS nama, b.nama AS cabang, u.status AS status, g.nama AS group_user, u.id_user AS action')
                ->add_column('action', $this->get_action_button('$1'), 'user')
                ->edit_column('status', '$1', '_get_status(status)')
                ->from("m_user u")
                ->join("m_user_group g", "g.id=u.id_user_group",'left')
                ->join("m_cabang b", "u.id_cabang=b.id",'left')
                ;
        if(!$this->is_pusat){
            $this->datatables->where('u.id_cabang', $this->data['broker']);
        }
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Data User",
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
            "title" => "Data User",
            'subtitle' => 'Detail Data',
            'fields' => $this->field,
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->user_model->get_data($id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect($this->class);
        }
        
        $this->view($data);
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Data User",
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
            "title" => "Edit Data User",
            'subtitle' => 'Edit Data',
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
        $code = $this->input->post('id');
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->user_model->get_data_join_group(array('u.id_user'=>$id));
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect('user');
        } else {
            $form_input = new My_form();
            $this->field['user']['readonly']=true;
            $this->field = array_merge($this->field, array('id'=>array('type'=>'hidden')));
            
            $dealer = $res->id_cabang;
            if($this->input->post('cabang')){
                $dealer=$this->input->post('cabang');
            }
            
            $form_input->set($this->field);
            if(!empty($this->input->post())){
                $value = $this->input->post();
            }else{
                $value = array(
                    'cabang'=>$res->id_cabang,
                    'user'=>$res->id_user,
                    'nama'=>$res->nama,
                    'status'=>$res->status,
                    'group_user'=>$res->id_user_group,
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
        $result = $this->user_model->get_data($id, 'id_user');
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data yang akan dihapus tidak ditemukan');
            redirect($this->class);
        } else {
            $delete = $this->user_model->delete_data($id, 'id_user');
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
        $this->form_validation->set_rules('user', 'Username', 'trim|required|xss_clean|callback_cek_double_username');
        $this->form_validation->set_rules('pass', 'Password', 'trim|xss_clean|matches[pass_confirm]');
        $this->form_validation->set_rules('pass_confirm', 'Password Konfirmasi', 'trim|xss_clean');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
        $this->form_validation->set_rules('group_user', 'Group User', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id_user' => $this->input->post('user'),
                'password' => md5($this->input->post('pass')),
                'nama' => $this->input->post('nama'),
                'status' => $this->input->post('status'),
                'id_user_group' => $this->input->post('group_user'),
                'id_cabang' => $this->input->post('cabang'),
                'tgl_input' => $now,
                'user_input' => $this->data['username'],
            );
            $create = $this->user_model->insert_data($data);
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
        $this->form_validation->set_rules('user', 'Username', 'trim|required|xss_clean|callback_cek_double_username');
        $this->form_validation->set_rules('pass', 'Password', 'trim|xss_clean|matches[pass_confirm]');
        $this->form_validation->set_rules('pass_confirm', 'Password Konfirmasi', 'trim|xss_clean');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|xss_clean');
        $this->form_validation->set_rules('group_user', 'Group User', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $id = $this->input->post('id');
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id_user' => $this->input->post('user'),
                'password' => md5($this->input->post('pass')),
                'nama' => $this->input->post('nama'),
                'status' => $this->input->post('status'),
                'id_user_group' => $this->input->post('group_user'),
                'id_cabang' => $this->input->post('cabang'),
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            if(empty($this->input->post('pass')) && empty($this->input->post('pass_confirm'))){
                unset($data['pass']);
            }
            $update = $this->user_model->update_data($id, $data, 'id_user');
            if ($update) {
                $this->session->set_flashdata('msg', 'Data berhasil diubah');
            } else {
                $this->session->set_flashdata('msg_err', 'Data gagal diubah ');
            }
            redirect($this->class);
        }
    }
    function cek_double_username(){
        $user=$this->input->post('user');
        $id=$this->input->post('id');
        if($user==$id){
            return true;
        }
        $res = $this->user_model->get_total_data("(id_user='$user')", 'id_user');
        if($res>0){
            $this->form_validation->set_message('cek_double_username', 'Username sudah dipakai, silahkan menggunakan username lain');
            return false;
        }else{
            return true;
        }        
    }
    function cek_password_beda(){
        $pass1=$this->input->post('pass');
        $pass2=$this->input->post('pass_confirm');
        if($pass1!=$pass2){
            $this->form_validation->set_message('cek_password_beda', 'Field Password Konfirmasi tidak sama dengan field Password');
            return false;
        }else{
            return true;
        }
    }
    private function init($with_value = true){
        if($with_value){
            $this->load->model('group_user_model');
            $grouplist = $this->group_user_model->get_datalist();
            $this->load->model('cabang_model');
            $cabanglist = $this->cabang_model->get_datalist();
        }else{
            $grouplist = array();
            $cabanglist = array();
        }
        $this->field = array(
            'user' => array(
                'label'=>'username',
                'placeholder'=>'username',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 15,
                'format' => 'an',
                'readonly' => false,
            ),
            'pass' => array(
                'label'=>'password',
                'placeholder'=>'password',
                'type'=> "password",
                'minLength' => 0,
                'maxLength'=> 32,
                'format' => 'an',
                'hide'=>true,
            ),
            'pass_confirm' => array(
                'label'=>'ulangi password',
                'placeholder'=>'ulangi password',
                'type'=> "password",
                'minLength' => 0,
                'maxLength'=> 32,
                'format' => 'an',
                'hide'=>true,
            ),
            'nama' => array(
                'label'=>'nama user',
                'type'=>'text',
                'required'=>true,
                'placeholder'=>'nama user',
                'max_length'=>48,
                'format' => 'an',
            ),
            'cabang' => array(
                'label'=>'cabang',
                'placeholder'=>'cabang',
                'type'=> "select2",
                'required' => false,
                'data' => $cabanglist,
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
            'group_user' => array(
                'label'=>'group user',
                'placeholder'=>'group user',
                'type'=> "select2",
                'required' => true,
                'data' => $grouplist,
            ),
        );
        if($this->is_pusat){
            $this->field['cabang']['hide']=false;
            $this->field['cabang']['value'] = $this->data['cabang'];
        }else{
            unset($this->field['cabang']);
            $this->field['cabang']['hide']=true;
            $this->field['cabang']['type']='hidden';
            $this->field['cabang']['value']=$this->data['cabang'];
        }
    }
}
