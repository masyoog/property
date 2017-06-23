<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mutasi_wallet extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        
    }
    
    function get_data(){
        $this->datatables->select('m.id as id_member, m.nama as nama, r.norek as norek, r.saldo as saldo, r.norek as action')
                ->edit_column('saldo', '$1', '_format_angka(saldo)')
                ->add_column('action', $this->get_action_button('$1'), 'action')
                ->from("t_rek_wallet ")
//                ->where('m.status ', '1')
                ->join('v_rekening_wallet r', 'm.id=r.id_member', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param, $args=''){
        $role = $this->data["role"][$this->class];
        $ret='<a title="Lihat Mutasi" class="btn btn-primary btn-xs btn-floating-action" href="'.base_url().$this->class_name.'/mutasi/'.$param.'"><i class="glyphicon glyphicon-list"></i></a>
        ';
        return $ret;
    }
    function index() {
        $this->init();
        $data = array(
            "title" => "Mutasi E-Wallet",
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
            if($key=='komisi'){
                $column .="{'data':'".$key."','searchable':false},";
            }else{
                $column .="{'data':'".$key."'},";
            }
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
    
    private function init(){
        $this->field = array(
            'id_member' => array(
                'label'=>'ID member',
            ),
            'nama' => array(
                'label'=>'nama',
            ),
            'norek' => array(
                'label' => 'nomor rekening',
            ),
            'saldo' => array(
                'label'=>'saldo E-Wallet',
            ),
        );
    }
}
