<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Testimonial extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('testimonial_model');
        
    }
    
    function get_data(){
        $this->datatables->select("t.tgl as tgl, t.id_member as id_member, m.nama as nama, "
                . "t.testimonial as testimonial, t.status as status, t.id as action, IF(t.status=0,'Aktifkan','Non Aktifkan') as link", false)
                ->add_column('action', $this->get_action_button('$1', '$2'), 'action,link')
                ->edit_column('status', '$1', '_get_status(status)')
                ->from("m_testimonial t")
                ->join('m_member m', 't.id_member=m.id', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($id, $status=''){
//        return $id.' : '.$status;
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/toggle/'.$id.'"><i class="fa fa-check fa-fw"></i> '.$status.'</a>';
        $ret.= '
                <a class="btn ink-reaction btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a href="'.base_url().$this->class_name.'/delete/'.$id.'" onclick="return confirm(\'Apakah Anda yakin ingin menghapus testimonial?\')"><i class="fa fa-trash"></i> Delete</a></li>
                </ul>';
        $ret.='
            </div>';
        return $ret;
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Testimonial",
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
                'order': [[0, 'desc']],
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
    function toggle(){
        $id = $this->security->xss_clean($this->uri->segment(3));
        $testi = $this->testimonial_model->get_data($id);
        if($testi==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        if($testi->status=='0'){
            $this->testimonial_model->update_data($id, array(
                'status' => '1',
                'user_update' => $this->data['username'],
                'tgl_update' => date('Y-m-d H:i:s'),
            ));
        }else if($testi->status=='1'){
            $this->testimonial_model->update_data($id, array(
                'status' => '0',
                'user_update' => $this->data['username'],
                'tgl_update' => date('Y-m-d H:i:s'),
            ));
        }
        $this->session->set_flashdata('msg', 'Data saved successfully');
        redirect($this->class);
    }
    function delete(){
        $id = $this->security->xss_clean($this->uri->segment(3));
        $testi = $this->testimonial_model->get_data($id);
        if($testi==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        $delete = $this->testimonial_model->delete_data($id);
        if($delete){
            $this->session->set_flashdata('msg', 'Data deleted successfully');
        }else{
            $this->session->set_flashdata('msg_err', 'Delete failed');
        }
        redirect($this->class);
    }
    
    private function init($with_value = true){
        $provinsilist = array();
        if($with_value){
            $this->load->model('provinsi_model');
            $provinsilist = $this->provinsi_model->get_datalist();
        }
        $this->field = array(
            'tgl' => array(
                'label'=>'tgl. request',
                'type'=> "text",
                'required' => true,
                'format' => 'an',
            ),
            'id_member' => array(
                'label'=>'ID member',
                'type'=> "hidden",
                'format' => 'an',
                'value' => '',
            ),
            'nama' => array(
                'label'=>'nama',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'testimonial' => array(
                'label'=>'testimonial',
                'type'=> "text",
                'format' => 'an',
                'required' => true,
            ),
            'status' => array(
                'label' => 'status',
                'type' => 'hidden',
                'value' => '',
            ),
        );
    }
}
