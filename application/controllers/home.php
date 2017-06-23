<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('home_model');
    }

    function get_action_button($param){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn btn-default btn-xs" href="'.base_url().$this->class.'/detail/'.$param.'"><i class="glyphicon glyphicon-eye-open"></i> Detail</a>';
            if($role['edit'] || $role['delete']){
                $ret.= '
                <a class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" href="#">&nbsp;<span class="caret"></span></a>
                <ul class="btn-xs dropdown-menu" role="menu">
                    '.($role['edit']?'<li><a href="'.  base_url().$this->class.'/edit/'.$param.'"><i class="glyphicon glyphicon-pencil"></i> Edit Data</a></li>':'').'
                    '.($role['delete']?'<li><a href="'.base_url().$this->class.'/delete/'.$param.'" onClick="return confirm(\'Apakah Anda yakin ingin menghapus data?\');"><i class="glyphicon glyphicon-trash"></i> Hapus Data</a></li>':'').'
                </ul>';
            }
        $ret.='
            </div>';
        return $ret;
    }
    
    function get_data_out_connote(){
        $this->datatables->select("tgl, no_connote no_cn, id_layanan layanan, nama_pengirim pengirim, id_cabang_tujuan tujuan, total_koli koli, total_kg berat, id AS action")
//                ->add_column('action', $this->get_action_button('$1'), 'no_connote')
                ->from("t_connote")
                ->where(array('status < ' => '2', 'id_cabang'=>$this->data['cabang']));

        echo $this->datatables->generate();
    }
    function out_connote(){
        $data['subtitle']="Data Outstanding CN (booking/request pickup)";
        $data['fields'] = array(
            'tgl' => array(
                'label' => 'tanggal'
            ),
            'no_cn' => array(
                'label' => 'no. connote'
            ),
            'layanan' => array(
                'label' => 'layanan'
            ),
            'pengirim' => array(
                'label' => 'pengirim'
            ),
            'tujuan' => array(
                'label' => 'tujuan'
            ),
            'koli' => array(
                'label' => 'koli'
            ),
            'berat' => array(
                'label' => 'berat'
            ),
        );
//        $data['role'] = $this->role;
        $data['datatable'] = true;
        $column = "";
        $n = 0;
        foreach ($data['fields'] as $key => $val) {
            if (isset($val['hide']) && $val['hide'] == true)
                continue;
            $column .="{'data':'" . $key . "'},";
            $n++;
        }
        $kolom = "[";
        for ($i = 0; $i < $n; $i++) {
            $kolom.=$i . ",";
        }
        $kolom .= "]";
        $kolom = str_replace(",]", "]", $kolom);
        $data['js_include'] = "
            $(document).ready(function() {
                $('#table-data').dataTable({
                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        'url': '" . base_url() . $this->class . "/get_data_out_connote',
                        'type': 'POST'
                    },
                    'columns': [
                        " . $column . "
                        {'data': 'action'}
                    ],
                    'dom': 'T<\"clear\">lfrtip',
                    'tableTools': {
			'sSwfPath': '" . base_url() . "asset/media/swf/copy_csv_xls_pdf.swf',
                        'aButtons': [
                            {
                                'sExtends': 'copy',
                                'mColumns': " . $kolom . "
                            },
                            {
                                'sExtends': 'csv',
                                'mColumns': " . $kolom . "
                            },
                            {
                                'sExtends': 'pdf',
                                'mColumns': '" . $kolom . "'
                            },
                        ]
                    },
                });
            });
        ";
        $this->template->load('template', 'dashboard/out_connote', array_merge($data, $this->data));
    }
    function index() {
        $data["css"]=array(
            base_url().'asset/css/plugins/timeline.css',
            base_url().'asset/css/plugins/morris.css',
        );

        $data['js']=array(
            base_url().'asset/js/plugins/morris/raphael.min.js',    //Morris Charts JavaScript
            base_url().'asset/js/plugins/morris/morris.min.js',     //Morris Charts JavaScript
            base_url().'asset/js/page/home.js',
        );
        $data['subtitle']="Dashboard";
		if($this->data['level']=="17"){
			$data['outstanding']=array();
			$data['summary']=array();
			$data['panel']=array();
		}else{
        $data['outstanding'] = array(
//            'pickup' => array(
//                'title' => 'outstanding pickup',
//                'count' => intval($this->home_model->get_jumlah('out_pickup')),
//                'link' => base_url().'home/out_pickup',
//            ),
            'connote' => array(
                'title' => 'outstanding connote',
                'count' => intval($this->home_model->get_jumlah('out_connote')),
                'link' => base_url().'home/out_connote',
            ),
            'outgoing' => array(
                'title' => 'outstanding outgoing',
                'count' => intval($this->home_model->get_jumlah('out_outgoing')),
                'link' => base_url().'home/out_outgoing',
            ),
            'incoming' => array(
                'title' => 'outstanding incoming',
                'count' => intval($this->home_model->get_jumlah('out_incoming')),
                'link' => base_url().'home/out_incoming',
            ), 
            'delivery' => array(
                'title' => 'outstanding delivery',
                'count' => intval($this->home_model->get_jumlah('out_delivery')),
                'link' => base_url().'home/out_delivery',
            ), 
            'pod' => array(
                'title' => 'outstanding POD',
                'count' => intval($this->home_model->get_jumlah('out_pod')),
                'link' => base_url().'home/out_pod',
            ), 
            'podbalik' => array(
                'title' => 'outstanding POD balik',
                'count' => intval($this->home_model->get_jumlah('out_podbalik')),
                'link' => base_url().'home/out_podbalik',
            ),
            'invoice' =>array(
                'title' => 'outstanding invoice',
                'count' => intval($this->home_model->get_jumlah('out_invoice')),
                'link' => base_url().'home/out_invoice',
            ),
            'payment' =>array(
                'title' => 'outstanding payment',
                'count' => intval($this->home_model->get_jumlah('out_payment')),
                'link' => base_url().'home/out_payment',
            ),
        );
        $data['summary'] = array(
            'pickup' => array(
                'title' => 'new pickup request',
                'count' => intval($this->home_model->get_jumlah('pickup')),
                'link' => base_url().'home/pickup',
            ),
            'connote' => array(
                'title' => 'new connote',
                'count' => intval($this->home_model->get_jumlah('connote')),
                'link' => base_url().'home/connote',
            ),
            'outgoing' => array(
                'title' => 'new outgoing',
                'count' => intval($this->home_model->get_jumlah('outgoing')),
                'link' => base_url().'home/outgoing',
            ),
            'incoming' => array(
                'title' => 'new incoming',
                'count' => intval($this->home_model->get_jumlah('incoming')),
                'link' => base_url().'home/incoming',
            ), 
            'delivery' => array(
                'title' => 'new delivery',
                'count' => intval($this->home_model->get_jumlah('delivery')),
                'link' => base_url().'home/delivery',
            ), 
            'pod' => array(
                'title' => 'new POD',
                'count' => intval($this->home_model->get_jumlah('pod')),
                'link' => base_url().'home/pod',
            ), 
            'podbalik' => array(
                'title' => 'new POD balik',
                'count' => intval($this->home_model->get_jumlah('podbalik')),
                'link' => base_url().'home/podbalik',
            ),
            'invoice' =>array(
                'title' => 'new invoice',
                'count' => intval($this->home_model->get_jumlah('invoice')),
                'link' => base_url().'home/invoice',
            ),
        );
        $data['panel'] = array(
            'transaction', 
//            'notification', 
            'revenue', 
//            'tracing'
        );
		}
        $this->template->load('template', 'dashboard', array_merge($data, $this->data));
    }

    function logout() {
        $this->session->sess_destroy();
        $this->nativesession->destroy();
        redirect('home', 'refresh');
    }
}
