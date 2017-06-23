<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Komplain extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('komplain_model');        
    }
    
    function get_data(){
        $this->datatables->select('k.id as id_k, k.*, k.status as statuslala, m.nama')
                ->add_column('action', $this->get_action_button('$1'), 'id_k')
                ->edit_column('status', '$1', '_get_status_komplain(statuslala)')
                ->from("t_komplain k")
                //->where('status', '0')
                ->join('m_member m', 'm.id=k.id_member', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param, $args=''){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/response/'.$param.'"><i class="fa fa-check fa-fw"></i> Jawab</a>';
        $ret.='
            </div>';
        return $ret;
    }
    
    function response($id){
        $this->init();
        unset($this->field["tgl"]);
        unset($this->field["nama"]);
        unset($this->field["status"]);
        $data = array(
            "title" => "Komplain",
            'subtitle' => 'Jawab Komplain',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/select2/select2.css",
                base_url() . "assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css",
            ),
            'js' => array(
                base_url() . "assets/js/libs/select2/select2.min.js",
                base_url() . "assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
            ),
            
        );
        $code = $id;
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->komplain_model->get_data($id);
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
                    'id'=>$res->id,
                    'id_member' => $res->id_member,
                    'ket'=>$res->ket,
                    'response'=>$res->response,                    
                );
            }
            $form_input->set_value($value);
            $data["form_element"] = $form_input->render_form("edit");
        }
        
        $this->view($data);
    }
    
    function update() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('response', 'Response', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->response();
        } else {
            
            $id = $this->input->post('id');
            
            $data = array(
                'response' => $input['response'],
                'status' => 'TERJAWAB'
            );
            $update = $this->komplain_model->update_data($id, $data, $this->key_id);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan.');
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }
    
    function index() {
        $this->init(false);
        unset($this->field["response"]);
        $data = array(
            "title" => "Komplain",
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
    
    private function init($with_value = true){
        
        $this->field = array(
            'tgl' => array(
                'label'=>'tanggal',
                'type'=> "date",
                'required' => true,
            ),
            'id_member' => array(
                'label'=>'ID member',
                'readonly' => true,
                'type'=> "text",
                'format' => 'an',
                'required' => true,
            ),
            'nama' => array(
                'label'=>'nama',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'ket' => array(
                'label'=>'isi',
                'type'=> "text",
                'required' => true,
                'readonly' => true,
                'minLength' => 0,
                'maxLength'=> 200,
                'format' => 'an'                
            ),
            'response' => array(
                'label'=>'response',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 150,
                'format' => 'an'                
            ),
            'status' => array(
                'label'=>'status',
                'placeholder'=>'status',
                'type'=>'select',
                'required'=>true,
                'data'=> array(
                    '0' => 'BARU',
                    '1' => 'TERJAWAB'
                ),
                
            ),
            
        );
    }
}
