<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Konfirmasi_aktivasi extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('konfirmasi_model');
        
    }
    
    function get_data(){
        $this->datatables->select('k.id_member as id_member, k.nama as nama, k.nominal as nominal, b.nama as nama_bank, '
                . 'k.atas_nama as atas_nama, k.nomor as nomor, k.tgl as tgl, k.status as status, k.ket as ket,  k.id as action')
                ->add_column('action', $this->get_action_button('$1'), 'action')
                ->edit_column('nominal', '$1', '_format_angka(nominal)')
                ->edit_column('status', '$1', '_get_status_pending(status)')
                ->from("t_konfirmasi k")
                ->where('k.status', '0')->where('k.jenis_konfirmasi', '1')
                ->join('m_bank b', 'b.id=k.id_bank', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param, $args=null){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/aktivasi/'.$param.'"><i class="fa fa-check fa-fw"></i> Aktivasi</a>';
//            if($role['edit'] || $role['delete']){
                $ret.= '
                <button type="button" class="btn ink-reaction btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a href="'.base_url().$this->class.'/cancel/'.$param.'" onClick="return confirm(\'Apakah Anda yakin ingin membatalkan konfirmasi?\');"><i class="fa fa-minus-circle"></i> Batalkan</a></li>
                </ul>';
//            }
        $ret.='
            </div>';
        return $ret;
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Pending Konfirmasi Aktivasi",
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

        $this->load->model('member_model');
        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['konfirmasi'] = $this->konfirmasi_model->get_data($id);
        $data['datalist'] = $this->member_model->get_data($data['konfirmasi']->id_member);
        if($data['datalist']==null || $data['konfirmasi']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class_name);
        }
        if($data['datalist']->status == '1'){
            $this->session->set_flashdata('msg_err', 'Member already active. Can not be activated.');
//            redirect('konfirmasi_aktivasi');
            redirect($this->class_name);
        }
        
        $this->load->model('bank_model');
        $data['bank_list'] = $this->bank_model->get_datalist();
        //set form value
        $data['id_konfirmasi'] = $id;
        $data['atas_nama'] = $data['konfirmasi']->atas_nama;
        $data['bank'] = $data['konfirmasi']->id_bank;
        $data['nominal'] = $data['konfirmasi']->nominal;
        $data['berita'] = $data['konfirmasi']->ket;
        
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
            $this->load->model('member_model');
            $create = $this->member_model->aktivasi($data);
            if ($create) {
                $this->konfirmasi_model->update_data($input['id_konfirmasi'], array(
                    'status'=>'1',
                    'ket' => $input['ket'],
                    'user_update' => $this->data['username'],
                    'tgl_update' => date('Y-m-d H:i:s'),
                ));
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
    
    function cancel() {
        $id = $this->security->xss_clean($this->uri->segment(3));
        $result = $this->konfirmasi_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $cancel = $this->konfirmasi_model->cancel_konfirmasi($id, array(
                'status'=>'2', 
                'tgl_update' => date('Y-m-d H:i:s'), 
                'user_update' => $this->data['username'],
            ));
            if ($cancel) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Fail canceling confirmation request');
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
            'tgl' => array(
                'label'=>'tgl. transfer',
                'type'=> "text",
                'required' => true,
                'format' => 'an',
            ),
            'nama_bank' => array(
                'label'=>'transfer ke bank',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'nominal' => array(
                'label'=>'nominal',
                'type'=> "text",
                'format' => 'n',
                'maxLength' => 16,
                'required' => true,
            ),
            'atas_nama' => array(
                'label'=>'atas nama',
                'type'=> "text",
                'maxLength'=> 50,
                'format' => 'an',
                'required' => true,
            ),
//            'ket' => array(
//                'label'=>'berita transfer',
//                'type'=> "text",
//                'maxLength'=> 50,
//                'format' => 'an',
//                'required' => true,
//            ),
            'status' => array(
                'label' => 'status',
                'type' => 'hidden',
                'value' => '',
            ),
        );
    }
}
