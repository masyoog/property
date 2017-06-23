<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Group_user extends Site_Controller {
    protected $template_name = "default";
    
    private $field;
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('group_user_model');
        
    }

    function get_data(){
        $this->datatables->select('id as id, nama as nama, id AS action')
                ->unset_column('id')
                ->add_column('action', $this->get_action_button('$1'), 'id')
//                ->edit_column('is_nasional', '$1', '_get_yesno(is_nasional)')
                ->from('m_user_group');
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init();
        $data = array(
            "title" => "Data Group User",
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
            $('#table_data').DataTable({
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
        $data = array(
            "title" => "Data Group User",
            'subtitle' => 'Detail Data',
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->group_user_model->get_data($id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
            redirect($this->class);
        }
//        _var_dump($data);
        $this->load->model('menu_model');
        $menu_flat = $this->menu_model->get_data_menu();
        if(count($menu_flat) > 0){
            foreach ($menu_flat as &$node) {
                $node['child'] = array();
                $id = $node['id'];
                if(!empty($data['datalist']['menu'][$id])){
                    $node['value'] = '1';
                    $node['role'] = $data['datalist']['menu'][$id];
                }else{
                    $node['value'] = '0';
                }
                $parent = $node['parent'];
                $nodes[$id] = & $node;
                if (array_key_exists($parent, $nodes)) {
                    $nodes[$parent]['child'][] = & $node;
                } else {
                    $menu[] = & $node;
                }
            }
        }
        $data['datalist']['menu'] = $menu;
        
        $this->view($data);
        
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Data Group User",
            'subtitle' => 'Input Data',
            'css' => array(
//                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.css",
//                base_url() . "assets/vendors/select2/select2.css",
//                base_url() . "assets/vendors/select2/select2-bootstrap.css",
            ),
            'js' => array(
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
                base_url() . "assets/js/pages/".$this->class_name.".js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        $data['action'] = 'insert';
        $data['fields'] = $this->field;
        $this->load->model('menu_model');
        $menu_flat = $this->menu_model->get_data_menu();
        if(count($menu_flat) > 0){
            foreach ($menu_flat as &$node) {
                $node['child'] = array();
                $id = $node['id'];
                $parent = $node['parent'];
                $nodes[$id] = & $node;
                if (array_key_exists($parent, $nodes)) {
                    $nodes[$parent]['child'][] = & $node;
                } else {
                    $menu[] = & $node;
                }
            }
        }
//        _var_dump($menu);
        $data['fields']['menu'] = $menu;
        
        $this->view($data);
    }
    function edit() {
        $this->init();
        $data = array(
            "title" => "Edit Data Group User",
            'subtitle' => 'Edit Data',
            'css' => array(
                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.css",
                base_url() . "assets/vendors/select2/select2.css",
                base_url() . "assets/vendors/select2/select2-bootstrap.css",
            ),
            'js' => array(
                base_url() . "assets/vendors/bootstrapValidator/bootstrapValidator.min.js",
                base_url() . "assets/vendors/select2/select2.min.js",
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
        $res = $this->group_user_model->get_data($id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data tidak ditemukan');
//            redirect('group_user');
//            _var_dump($res);
        } else {
            $this->load->model('menu_model');
            $menu_flat = $this->menu_model->get_data_menu();
            if(count($menu_flat) > 0){
                foreach ($menu_flat as &$node) {
                    $node['child'] = array();
                    $nid = $node['id'];
                    if(!empty($res['menu'][$nid])){
                        $node['value'] = '1';
                        $node['role'] = $res['menu'][$nid];
                    }else{
                        $node['value'] = '0';
                    }
                    $parent = $node['parent'];
                    $nodes[$nid] = & $node;
                    if (array_key_exists($parent, $nodes)) {
                        $nodes[$parent]['child'][] = & $node;
                    } else {
                        $menu[] = & $node;
                    }
                }
            }
            $this->field = array_merge($this->field, array('id'=>array('type'=>'hidden')));
            $this->field['nama']['value'] = $res['nama'];
            $this->field['id']['value'] = $id;
            $this->field['menu'] = $menu;
            $this->field['outstanding'] = $res['outstanding'];
            $this->field['summary'] = $res['summary'];
            $this->field['panel'] = $res['panel'];
            $data['fields'] = $this->field;
        }
        $data['action'] = 'update';
        
        $this->view($data);
    }

    function delete() {
        $id = $this->security->xss_clean($this->uri->segment(3));
        $result = $this->group_user_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data yang akan dihapus tidak ditemukan');
            redirect($this->class);
        } else {
            $delete = $this->group_user_model->delete_data($id);
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
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean|callback_cek_double_nama');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $hak = $this->input->post('hak');
            $print = $this->input->post('print');
            $add = $this->input->post('add');
            $delete = $this->input->post('delete');
            $edit = $this->input->post('edit');
            $export = $this->input->post('export');
            $modul = array();
            if(!empty($hak) && count($hak)>0){
                foreach($hak as $key => $val){
                    $modul[$key] = array(
                        'print' => isset($print[$key])?$print[$key]:'0',
                        'add' => isset($add[$key])?$add[$key]:'0',
                        'delete' => isset($delete[$key])?$delete[$key]:'0',
                        'edit' => isset($edit[$key])?$edit[$key]:'0',
                        'export' => isset($export[$key])?$export[$key]:'0',
                    );
                }
            }
            $data = array(
                'nama' => strtoupper($this->input->post('nama')),
                'user_input' => $this->data['username'],
                'tgl_input' => date('Y-m-d H:i:s'),
                'modul' => $modul,
                'dashboard' => array(
                    'out_cn' => intval($this->input->post('out_cn')), 'out_outgoing' => intval($this->input->post('out_outgoing')), 
                    'out_incoming' => intval($this->input->post('out_incoming')), 'out_delivery' => intval($this->input->post('out_delivery')), 
                    'out_pod' => intval($this->input->post('out_pod')), 'out_dex' => intval($this->input->post('out_dex')), 
                    'out_invoice' => intval($this->input->post('out_invoice')), 'out_payment' => intval($this->input->post('out_payment')),
                    'summary_pickup' => intval($this->input->post('summary_pickup')), 'summary_cn' => intval($this->input->post('summary_cn')), 
                    'summary_outgoing' => intval($this->input->post('summary_outgoing')), 'summary_incoming' => intval($this->input->post('summary_incoming')), 
                    'summary_delivery' => intval($this->input->post('summary_delivery')), 'summary_pod' => intval($this->input->post('summary_pod')), 
                    'summary_dex' => intval($this->input->post('summary_dex')), 'summary_payment' => intval($this->input->post('summary_payment')), 
                    'panel_transaksi' => intval($this->input->post('panel_transaksi')), 'panel_revenue' => intval($this->input->post('panel_revenue')), 
                    'panel_tracing' => intval($this->input->post('panel_tracing')), 
                ),
            );
//            _var_dump($data);
//            die();
            $create = $this->group_user_model->insert_data($data);
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
        $this->form_validation->set_rules('nama', 'Nama group', 'trim|required|xss_clean|callback_cek_double_nama');
        
//        _var_dump($this->input->post());
//        die();
        
        if ($this->form_validation->run() == FALSE) {
//            _var_dump($this->input->post());
//            die();
            $this->edit();
        } else {
            $id = $this->input->post('id');
            $hak = $this->input->post('hak');
            $print = $this->input->post('print');
            $add = $this->input->post('add');
            $delete = $this->input->post('delete');
            $edit = $this->input->post('edit');
            $export = $this->input->post('export');
            $modul = array();
            if(!empty($hak) && count($hak)>0){
                foreach($hak as $key => $val){
                    $modul[$key] = array(
                        'print' => isset($print[$key])?$print[$key]:'0',
                        'add' => isset($add[$key])?$add[$key]:'0',
                        'delete' => isset($delete[$key])?$delete[$key]:'0',
                        'edit' => isset($edit[$key])?$edit[$key]:'0',
                        'export' => isset($export[$key])?$export[$key]:'0',
                    );
                }
            }
            $data = array(
                'nama' => strtoupper($this->input->post('nama')),
                'user_update' => $this->data['username'],
                'tgl_update' => date('Y-m-d H:i:s'),
                'modul' => $modul,
                'dashboard' => array(
                    'out_cn' => intval($this->input->post('out_cn')), 'out_outgoing' => intval($this->input->post('out_outgoing')), 
                    'out_incoming' => intval($this->input->post('out_incoming')), 'out_delivery' => intval($this->input->post('out_delivery')), 
                    'out_pod' => intval($this->input->post('out_pod')), 'out_dex' => intval($this->input->post('out_dex')), 
                    'out_invoice' => intval($this->input->post('out_invoice')), 'out_payment' => intval($this->input->post('out_payment')),
                    'summary_pickup' => intval($this->input->post('summary_pickup')), 'summary_cn' => intval($this->input->post('summary_cn')), 
                    'summary_outgoing' => intval($this->input->post('summary_outgoing')), 'summary_incoming' => intval($this->input->post('summary_incoming')), 
                    'summary_delivery' => intval($this->input->post('summary_delivery')), 'summary_pod' => intval($this->input->post('summary_pod')), 
                    'summary_dex' => intval($this->input->post('summary_dex')), 'summary_payment' => intval($this->input->post('summary_payment')), 
                    'panel_transaksi' => intval($this->input->post('panel_transaksi')), 'panel_revenue' => intval($this->input->post('panel_revenue')), 
                    'panel_tracing' => intval($this->input->post('panel_tracing')), 
                ),
            );
//            _var_dump($data);
//            die();
            $update = $this->group_user_model->update_data($id, $data);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data berhasil diubah');
            } else {
                $this->session->set_flashdata('msg_err', 'Data gagal diubah ');
            }
            redirect($this->class);
        }
    }
    function cek_double_nama(){
        $nama=$this->input->post('nama');
        $id=$this->input->post('id');
        $res = $this->group_user_model->get_total_data("(nama='$nama' AND id<>'$id')");
        if($res>0){
            $this->form_validation->set_message('cek_double_nama', 'Nama group sudah dipakai, silahkan menggunakan nama lain');
            return false;
        }else{
            return true;
        }        
    }
    private function init(){
        
        $this->field = array(
            'nama' => array(
                'label'=>'nama group',
                'placeholder'=>'nama',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 30,
                'format' => 'an',
                'readonly' => false,
                'value' => '',
            ),
        );
    }
}
