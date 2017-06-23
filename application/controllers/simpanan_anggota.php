<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Simpanan_anggota extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        
    }
    
    function get_data(){
        $this->datatables->select('m.id as id_member, m.nama as nama, r.saldo as saldo_wallet, r2.saldo as saldo_sipro')
                ->edit_column('saldo_wallet', '$1', '_format_angka(saldo_wallet)')
                ->edit_column('saldo_sipro', '$1', '_format_angka(saldo_sipro)')
                ->from("m_member m")
//                ->where('m.status ', '1')
                ->join('v_rekening_wallet r', 'm.id=r.id_member', 'left')
                ->join('v_rekening_sipro r2', 'm.id=r2.id_member', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function index() {
        $this->init();
        $data = array(
            "title" => "Simpanan Anggota",
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
            'saldo_wallet' => array(
                'label'=>'saldo wallet',
            ),
            'saldo_sipro' => array(
                'label' => 'saldo SIPRO',
            ),
        );
    }
}
