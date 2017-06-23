<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Validasi_topup_sipro extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('topup_sipro_model', 'my_model');
        
    }
    
    function get_data(){
        $this->datatables->select('k.id_member as id_member, m.nama as nama, k.id_bank as bank, b.nama as nama_bank, b.norek as norek, '
                . 'k.atas_nama as atas_nama, k.tgl as tgl, K.status as status, k.ket as ket, k.nominal as nominal, k.id as action')
                ->add_column('action', $this->get_action_button('$1'), 'action')
                ->edit_column('status', '$1', '_get_status_pending(status)')
                ->edit_column('nominal', '$1', '_format_angka(nominal)')
                ->edit_column('bank', '$1 - $2', 'nama_bank, norek')
                ->from("v_konfirmasi_sipro k")
                ->where('k.status', '0')
                ->join('m_bank b', 'k.id_bank=b.id', 'left')
                ->join('m_member m', 'k.id_member=m.id', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/validasi/'.$param.'"><i class="fa fa-check fa-fw"></i> Validasi</a>';
        $ret.='
            </div>';
        return $ret;
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Validasi Konfirmasi Topup Dana SIPRO",
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
    function validasi(){
        $this->init();
        $data = array(
            "title" => "Validasi Topup Dana SIPRO",
            'subtitle' => 'Validasi Topup',
            'fields' => $this->field,
            'css' => array(
                base_url() . "assets/css/theme-default/libs/select2/select2.css",
            ),
            'js' => array(
                base_url() . "assets/js/libs/select2/select2.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
            ),
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->my_model->get_data($id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        $this->load->model('bank_model');
        $data['bank_list'] = $this->bank_model->get_datalist();
        
        $this->view2($data);
    }
    
    function validate() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('bank', 'Bank', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nominal', 'Nominal Pembayaran', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('ket', 'Keterangan / Bukti Transfer', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->validasi();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id' => $input['id'],
                'id_member' => $input['id_member'],
                'id_bank' => $input['bank'],
                'nominal' => floatval($input['nominal']),
                'ket' => $input['ket'],
                'user_input' => $this->data['username'],
                'tgl_input' => $now,
            );
            $create = $this->my_model->validasi($data);
            if ($create) {
                $this->load->model('member_model');
                $member = $this->member_model->get_data($data['id_member']);
                //send email
                $config = array(
                    'smtp_crypto' => 'tls',
                    'protocol' => 'smtp',
                    'smtp_host' => $this->config->item('smtp_host'),
                    'smtp_user' => $this->config->item('smtp_user'),
                    'smtp_pass' => $this->config->item('smtp_pass'),
                    'smtp_port' => $this->config->item('smtp_port'),
                    'mailtype' => 'text',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'crlf' => "\r\n",
                    'newline' => "\r\n"
                );
                $this->load->library('email', $config);

                $this->email->to($member->email);
                $this->email->from($this->config->item('smtp_user'), 'PRO2M');

                $this->email->subject('[PRO2M] KONFIRMASI TOPUP DANA SIPRO');
                $msg = '
                    Dear '.$member->nama.' ('.$member->id.'),
                        
                    Selamat saldo rekening SIPRO Anda telah berhasil ditambahkan sebesar Rp '._format_angka($data['nominal']).'.

                    Terima kasih.

                    Regards,
                    PRO2M
                    ';
                $this->email->message($msg);
                $msgs = array();
                $err_msgs = array();
                if($this->email->send()){
                    $msgs[] = 'Email telah berhasil dikirimkan ke '.$member->email;
                }else{
                    $err_msgs[] = 'GAGAL mengirimkan email ke '.$member->email.'.';
                }
                
                //send sms
                $this->load->model('outbox_model');
                $this->outbox_model->send_sms(array(
                    'nomor' => $member->nohp,
                    'id_member' => $member->id,
                    'nama' => $member->nama,
                    'tgl' => date('Y-m-d H:i:s'),
                    'pesan' => 'Yth.'.$member->nama.' ('.$member->id.'), selamat saldo rekening SIPRO Anda telah berhasil ditambahkan sebesar Rp '._format_angka($data['nominal']),
                    'type' => '1',
                    'port' => '0',
                    'status' => '0'
                ));
                $msgs[] = 'Data telah berhasil disimpan.';
                
                if(!empty($msgs)){
                    $this->session->set_flashdata('msg', implode('<br>', $msgs));
                }
                if(!empty($err_msgs)){
                    $this->session->set_flashdata('msg_err', implode('<br>', $err_msgs));
                }
                
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }    
    
    private function init(){
        $this->field = array(
            'tgl' => array(
                'label'=>'tanggal',
            ),
            'id_member' => array(
                'label'=>'ID member',
            ),
            'nama' => array(
                'label'=>'nama',
            ),
            'bank' => array(
                'label'=>'bank',
            ),
            'atas_nama' => array(
                'label'=>'atas nama pengirim',
            ),
            'nominal' => array(
                'label' => 'nominal',
            ),
            'status' => array(
                'label' => 'status',
            ),
        );
    }
}
