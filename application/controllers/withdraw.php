<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Withdraw extends Site_Controller {
    protected $template_name = "default";

    private $field;
    private $key_id = 'id';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('withdraw_model');
        
    }
    
    function get_data(){
        $this->datatables->select('w.tgl as tgl, w.jenis_rekening as jenis_rekening, w.id_member as id_member, m.nama as nama, '
                . 'w.nominal as nominal, w.nama_bank as nama_bank, w.norek as norek, w.atas_nama as atas_nama, w.status as status, w.id as action')
                ->add_column('action', $this->get_action_button('$1'), 'action')
                ->edit_column('nominal', '$1', '_format_angka(nominal)')
                ->edit_column('status', '$1', '_get_status_pending_transfer(status)')
                ->from("t_request_withdraw w")
                ->join('m_member m', 'w.id_member=m.id')
                ->where('w.status', '0')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param, $args=null){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <button type="button" class="btn ink-reaction btn-primary btn-xs btn_transfer" data-toggle="modal" data-target="#modal_transfer" data-id_request="'.$param.'">'
                . '<i class="fa fa-check fa-fw"></i> Transfer'
                . '</button>';
//            if($role['edit'] || $role['delete']){
                $ret.= '
                <a class="btn ink-reaction btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></a>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a class="btn_cancel" data-toggle="modal" data-target="#modal_cancel" data-id_request="'.$param.'"><i class="fa fa-minus-circle"></i> Batalkan / Refund</a></li>
                </ul>';
//            }
        $ret.='
            </div>';
        return $ret;
    }
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Pending Request Withdraw",
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
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
                base_url() . "assets/js/pages/withdraw.js",
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
        $data['js_init'] = ucfirst($this->class_name).".init();
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
    
    function execute() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('ket', 'Keterangan / Bukti Transfer', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'status' => '1',
                'ket' => $input['ket'],
                'user_update' => $this->data['username'],
                'tgl_update' => $now,
            );
            $this->load->model('member_model');
            $update = $this->withdraw_model->update_data($input['id'], $data);
            if ($update) {
                $req = $this->withdraw_model->get_data($input['id']);
                $member = $this->member_model->get_data($req->id_member);
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

                $this->email->subject('[PRO2M] Order Withdraw Anda Telah BERHASIL Dilakukan');
                $msg = '
                    Dear '.$member->nama.' ('.$member->id.'), <br><br>
                        
                    Permintaan withdraw Anda, <br><br>
                    
                    No. Order : '.$req->id.' <br>
                    Tgl. Order : '.  _format_tgl($req->tgl).' <br>
                    Nominal : Rp '._format_angka($req->nominal).' <br>
                    <br>
                    
                    Telah selesai ditransfer ke : <br>
                    Bank : '.$req->nama_bank.' <br>
                    Nomor Rekening : '.$req->norek.' <br>
                    Atas Nama : '.$req->atas_nama.' <br>
                    <br>
                    
                    Keterangan / Bukti Transfer : <br>
                    '.str_replace("\r", "<br>", $input['ket']).' <br><br>
                    
                    Silahkan Anda cek saldo rekening bank Anda. <br><br><br>


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
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $now=date('Y-m-d H:i:s');
            
            $this->load->model('member_model');
            $req = $this->withdraw_model->get_data($input['id']);
            if($req != null){
                $data = array(
                    'id' => $input['id'],
                    'status' => '2',
                    'ket' => $input['ket'],
                    'user_input' => $this->data['username'],
                    'tgl_input' => $now,
                    'id_member' => $req->id_member,
                    'nominal' => $req->nominal,
                    'jenis_rekening' => $req->jenis_rekening,
                );
                $update = $this->withdraw_model->cancel_withdraw($data);
                if ($update) {
                    $member = $this->member_model->get_data($req->id_member);
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

                    $this->email->subject('[PRO2M] Order Withdraw Anda GAGAL Dilakukan');
                    $msg = '
                        Dear '.$member->nama.' ('.$member->id.'), <br><br>

                        Permintaan withdraw Anda tidak dapat diproses. <br><br>

                        No. Order : '.$req->id.' <br>
                        Tgl. Order : '.  _format_tgl($req->tgl).' <br>
                        Nominal : Rp '._format_angka($req->nominal).' <br>
                        <br>

                        Keterangan / alasan gagal : <br>
                        '.str_replace("\r", "<br>", $input['ket']).' <br><br>

                        Silahkan menghubungi customer service untuk informasi lebih lanjut. <br><br><br>


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
            }else{
                $this->session->set_flashdata('msg_err', 'Data not found');
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
            'tgl' => array(
                'label'=>'tgl. request',
                'type'=> "text",
                'required' => true,
                'format' => 'an',
            ),
            'jenis_rekening' => array(
                'label'=>'jenis withdraw',
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
            'nominal' => array(
                'label'=>'nominal',
                'type'=> "text",
                'format' => 'n',
                'maxLength' => 16,
                'required' => true,
            ),
            'nama_bank' => array(
                'label'=>'transfer ke bank',
                'type'=> "text",
                'required' => true,
                'minLength' => 0,
                'maxLength'=> 50,
                'format' => 'an',
            ),
            'norek' => array(
                'label'=>'norek',
                'type'=> "text",
                'format' => 'an',
                'maxLength' => 20,
                'required' => true,
            ),
            'atas_nama' => array(
                'label'=>'rek. atas nama',
                'type'=> "text",
                'maxLength'=> 50,
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
