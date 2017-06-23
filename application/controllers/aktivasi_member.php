<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Aktivasi_member extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('member_model');
        
    }
    
    function get_data(){
        $this->datatables->select('m.id as id_member, m.nama as nama, m.kota as kota, m.provinsi as provinsi, l.kode as level, '
                . 'm.jenis_member as jenis_member, m.status as status, m.id_upline1 as id_upline, m.id as action')
                ->add_column('action', $this->get_action_button('$1'), 'id_member')
                ->edit_column('status', '$1', '_get_status(status)')
                ->from("m_member m")
                ->where('status', '0')
                ->join('m_level l', 'l.level=m.level', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param, $args=''){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/aktivasi/'.$param.'"><i class="fa fa-check fa-fw"></i> Aktivasi</a>';
        $ret.='
            </div>';
        return $ret;
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Pending Aktivasi Member",
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
    function aktivasi(){
        $this->init(false);
        $data = array(
            "title" => "Aktivasi Member",
            'subtitle' => 'Detail Data',
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
        $data['datalist'] = $this->member_model->get_data($id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        $this->load->model('bank_model');
        $data['bank_list'] = $this->bank_model->get_datalist();
        
        $this->view2($data);
    }
    
    function activate() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('nominal', 'Nominal Pembayaran', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('ket', 'Keterangan / Bukti Transfer', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->aktivasi();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'id_member' => $input['id'],
                'id_bank' => $input['bank'],
                'nominal' => floatval($input['nominal']),
                'ket' => $input['ket'],
                'user_input' => $this->data['username'],
                'tgl_input' => $now,
            );
            $create = $this->member_model->aktivasi($data);
            if ($create) {
                $password = _generatePassword();
                $this->member_model->update_data($data['id_member'], array('pass'=>md5($password)));
                $member = $this->member_model->get_data($data['id_member']);
                //send email
                $config = array(
//                    'smtp_crypto' => 'tls',
                    'protocol' => 'smtp',
                    'smtp_host' => $this->config->item('smtp_host'),
                    'smtp_user' => $this->config->item('smtp_user'),
                    'smtp_pass' => $this->config->item('smtp_pass'),
                    'smtp_port' => $this->config->item('smtp_port'),
                    'mailtype' => 'html',
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE,
                    'crlf' => "\r\n",
                    'newline' => "\r\n"
                );
                $this->load->library('email', $config);

                $this->email->to($member->email);
                $this->email->from($this->config->item('smtp_user'), 'PRO2M');

                $this->email->subject('[PRO2M] Member PRO2M Anda Telah Aktif');
                $msg = '
                    Dear '.$member->nama.' ('.$member->id.'), <br><br>
                        
                    Selamat ID Member PRO2M Anda telah aktif. <br>
                    Silahkan menggunakan data berikut untuk melakukan login ke aplikasi PRO2M. <br><br>

                    ID Member : '.$member->id.' <br>
                    Password : '.$password.' <br><br>

                    Anda dapat install aplikasi Android PRO2M di Google Play melalui link di bawah ini. <br>
                    https://goo.gl/PVWABu <br><br><br>


                    Terima kasih.<br><br>

                    Regards,<br>
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
                    'pesan' => 'Yth.'.$member->nama.' ('.$member->id.'), selamat ID Member PRO2M Anda telah aktif. Password Anda adalah '.$password.'. Download Mobile App PRO2M di https://goo.gl/PVWABu',
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
    
    private function init($with_value = true){
        $provinsilist = array();
        if($with_value){
            $this->load->model('provinsi_model');
            $provinsilist = $this->provinsi_model->get_datalist();
        }
        $this->field = array(
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
            'no_ktp' => array(
                'label'=>'no. KTP',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 20,
                'format' => 'an',
                'hide' => true,
            ),
            'alamat' => array(
                'label'=>'alamat',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 100,
                'format' => 'an',
                'hide' => true,
            ),
            'kota' => array(
                'label'=>'kota',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => 30,
                'required' => true,
            ),
            'provinsi' => array(
                'label'=>'provinsi',
                'type'=> "select",
                'format' => 'an',
                'data' => $provinsilist,
                'required' => true,
            ),
            'kodepos' => array(
                'label'=>'kode POS',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => 5,
                'hide' => true,
            ),
            'nohp' => array(
                'label'=>'no. HP',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => 16,
                'hide' => true,
                'required' => true,
            ),
            'nohp_alt' => array(
                'label'=>'no. HP alternatif',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => 16,
                'hide' => true,
            ),
            'email' => array(
                'label'=>'email',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => 30,
                'required' => true,
                'hide' => true,
            ),
            'jenis_member' => array(
                'label' => 'member',
                'type' => 'select',
                'required' => true,
                'data'=> array(
                    'SIPRO' => 'SIPRO',
                    'BISPRO' => 'BISPRO'
                ),
            ),
            'id_upline' => array(
                'label'=>'ID upline',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => '10',
                'required' => true
            ),
            'status' => array(
                'label' => 'status',
                'type' => 'hidden',
                'value' => '',
            ),
        );
    }
}
