<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Member extends Site_Controller {
    
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
                ->join('m_level l', 'l.level=m.level', 'left')
                ;
        
        echo $this->datatables->generate();
    }
    function get_action_button($param, $args=""){
        $role = $this->data["role"][$this->class];
        $ret='<div class="btn-group">
                <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/detail/'.$param.'"><i class="fa fa-eye fa-fw"></i> Detail</a>';
            if ($role['edit'] || $role['delete']) {
            $ret .= '
                <button type="button" class="btn ink-reaction btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></button>
                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    ' . ($role['edit'] ? '<li><a href="' . base_url() . $this->class . '/edit/' . $param . '"><i class="fa fa-edit"></i> Edit Data</a></li>' : '') . '
                    ' . ($role['edit'] ? '<li><a href="' . base_url() . $this->class . '/edit_upline/' . $param . '"><i class="fa fa-exchange"></i> Edit Upline</a></li>' : '') . '
                    ' . ($role['edit'] ? '<li><a href="' . base_url() . $this->class . '/status/' . $param . '" onClick="return confirm(\'Apakah Anda yakin ingin mengubah status member ini ?\');"><i class="fa fa-check"></i> Edit Status</a></li>' : '') . '
                </ul>';
            }
        $ret.='
            </div>';
        return $ret;
    }
    
    
    function index() {
        $this->init(false);
        $data = array(
            "title" => "Data Member",
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
    function detail(){
        $this->init(false);
        $data = array(
            "title" => "Data Member",
            'subtitle' => 'Detail Data',
            'fields' => $this->field,
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->member_model->get_data($id);
        if($data['datalist']==null){
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }
        
        $this->view($data);
    }

    function add(){
        $this->init();
        $data = array(
            "title" => "Input Data Member",
            'subtitle' => 'Input Data',
            'css' => array(
                base_url() . "assets/css/theme-default/libs/select2/select2.css",
                base_url() . "assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css",
                base_url() . "assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css", 
            ),
            'js' => array(
                base_url() . "assets/js/libs/jquery-ui/jquery-ui.min.js",
                base_url() . "assets/js/libs/select2/select2.min.js",
                base_url() . "assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
                base_url() . "assets/js/pages/".$this->class_name.".js",
            ),
            'js_init' => ucfirst($this->class_name).".init();",
        );
        $form_input = new My_form();
        $form_input->set($this->field);
        $data["form_element"] = $form_input->render_form('', true, false);
        
        $this->view($data);
    }
    
    public function edit_upline() {
        $this->field = array(
            'id_member' => array(
                'label' => 'ID member',
                'type' => "hidden",
                'format' => 'an',
                'value' => '',
            ),
            'nama' => array(
                'label' => 'nama member',
                'type' => "text",
                'required' => true,
                'minLength' => 0,
                'maxLength' => 50,
                'format' => 'an',
            ),
            'id_upline' => array(
                'label' => 'ID upline baru',
                'type' => "text",
                'format' => 'an',
                'maxLength' => '10',
                'required' => true,
            ),
            'nama_upline' => array(
                'label' => 'Nama upline baru',
                'type' => "text",
                'format' => 'an',
                'readonly' => true,
                'hide' => true,                
            ),
            'id_upline_old' => array(
                'label' => 'ID upline lama',
                'type' => "text",
                'format' => 'an',
                'maxLength' => '10',
                'readonly' => true,
                'required' => true
            ),
            'nama_upline_old' => array(
                'label' => 'nama upline lama',
                'type' => "text",
                'format' => 'an',
                'readonly' => true,
                'hide' => true,
            )
        );
        $data = array(
            "title" => "Edit Upline Member",
            'subtitle' => 'Edit Data',
            'css' => array(
//                base_url() . "assets/css/theme-default/libs/select2/select2.css",
                base_url() . "assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css",
            // base_url() . "assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css",
            ),
            'js' => array(
//                base_url() . "assets/js/libs/select2/select2.min.js",
                // base_url() . "assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js",
                base_url() . "assets/js/libs/jquery-ui/jquery-ui.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/jquery.validate.min.js",
                base_url() . "assets/js/libs/jquery-validation/dist/additional-methods.min.js",
                base_url() . "assets/js/pages/" . $this->class_name . ".js",
            ),
            'js_init' => ucfirst($this->class_name) . ".init();",
        );

        $code = $this->input->post('id');

        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }

        $res = $this->member_model->get_data($id, $this->key_id);


        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect('user');
        } else {
            $resUpline = $this->member_model->get_data($res->id_upline1);

            $form_input = new My_form();
            $this->field = array_merge($this->field, array('id' => array('type' => 'hidden')));


            $form_input->set($this->field);
            if (!empty($this->input->post())) {
                $value = $this->input->post();
            } else {
                $value = array(
                    'nama' => $res->nama,
                    'id' => $id,
                    'id_upline_old' => $res->id_upline1,
                    'nama_upline_old' => $resUpline->nama,
                    'nama_upline' => '-',
                );
            }
            $form_input->set_value($value);
            $data["form_element"] = $form_input->render_form(base_url().$this->router->fetch_class()."/update_upline");
        }

        $this->view($data);
    }
    
    function edit() {
        $this->init();
        $data = array(
            "title" => "Edit Data Member",
            'subtitle' => 'Edit Data',
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
            'js_init' => ucfirst($this->class_name).".init();",
        );
        $code = $this->input->post('id');
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->member_model->get_data($id, $this->key_id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect('user');
        } else {
            $form_input = new My_form();
            $this->field = array_merge($this->field, array('id'=>array('type'=>'hidden')));
            unset($this->field['jenis_member'], $this->field['id_upline'], $this->field['nama_upline']);
            
            $form_input->set($this->field);
            if(!empty($this->input->post())){
                $value = $this->input->post();
            }else{
                $value = array(
                    'nama'=>$res->nama,
                    'no_ktp'=>$res->no_ktp,
                    'alamat'=>$res->alamat,
                    'kota'=>$res->kota,
                    'provinsi'=>$res->provinsi,
                    'kodepos'=>$res->kodepos,
                    'nohp'=>$res->nohp,
                    'nohp_alt'=>$res->nohp_alt,
                    'email'=>$res->email,
                    'id'=>$id,
                );
            }
            $form_input->set_value($value);
            $data["form_element"] = $form_input->render_form("edit");
        }
        
        $this->view($data);
    }

    function delete() {
        $id = $this->security->xss_clean($this->uri->segment(3));
        $result = $this->member_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $delete = $this->member_model->delete_data($id, $this->key_id);
            if ($delete) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed delete data');
            }
            redirect($this->class);
        }
    }
    
    function status() {
        $id = $this->security->xss_clean($this->uri->segment(3));
        $result = $this->member_model->get_data($id);
        $status = intval($result->status) == 1 ? 0 : 1; 
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $delete = $this->member_model->update_data($id, ['status'=>$status], $this->key_id);
            if ($delete) {
                $this->session->set_flashdata('msg', 'Data saved successfully');
            } else {
                $this->session->set_flashdata('msg_err', 'Failed delete data');
            }
            redirect($this->class);
        }
    }

    function insert() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_ktp', 'No. KTP', 'trim|required|xss_clean|callback_cek_duplikat_ktp');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required|xss_clean');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nohp', 'No. HP', 'trim|required|xss_clean|callback_cek_duplikat_nohp');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_cek_duplikat_email');
        $this->form_validation->set_rules('jenis_member', 'Member', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_upline', 'ID Upline', 'trim|required|xss_clean|callback_cek_upline');
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            $now=date('Y-m-d H:i:s');
            $data = array(
                'nama' => strtoupper($input['nama']),
                'no_ktp' => $input['no_ktp'],
                'alamat' => strtoupper($input['alamat']),
                'kota' => strtoupper($input['kota']),
                'provinsi' => strtoupper($input['provinsi']),
                'kodepos' => $input['kodepos'],
                'nohp' => $input['nohp'],
                'nohp_alt' => $input['nohp_alt'],
                'email' => $input['email'],
                'jenis_member' => strtoupper($input['jenis_member']),
                'id_upline1' => $input['id_upline'],
                'user_input' => $this->data['username'],
                'tgl_input' => $now,
            );
            $reg = $this->member_model->registrasi($data);
            if ($reg) {
                //send email
                $config = array(
    //                'smtp_crypto' => 'tls',
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

                $this->email->to($data['email']);
                $this->email->from($this->config->item('smtp_user'), 'PRO2M');

                $this->email->subject('[PRO2M] Registrasi Member PRO2M');
                $this->load->model('bank_model');
                $bank = $this->bank_model->read_data('','',array('id <> '=>'1'));
                $norek_bank = '';
                foreach($bank as $val){
                    $norek_bank.='Nomor Rekening: '.$val->norek.'<br>';
                    $norek_bank.='Atas Nama: '.$val->atas_nama.'<br>';
                    $norek_bank.='Nama Bank: '.$val->nama.'<br>';
                    $norek_bank.='<br>';
                }
                $biaya_aktivasi = 0;
                $this->load->model('setting_model');
                if($data['jenis_member']=='SIPRO'){
                    $biaya_aktivasi = floatval($this->setting_model->get_biaya_aktivasi_sipro());
                }else if($data['jenis_member']=='BISPRO'){
                    $biaya_aktivasi = floatval($this->setting_model->get_biaya_aktivasi_bispro());
                }

                $msg = '
                    Yth. '.$data['nama'].',<br><br>

                    Selamat, Anda telah terdaftar menjadi member PRO2M. <br><br>

                    ID Member Anda: '.$reg['id'].'<br><br>

                    Namun status keanggotaan Anda saat ini masih belum aktif, 
                    silahkan melakukan aktivasi dengan melakukan transfer ke rekening berikut: <br><br>

                    '.$norek_bank.'
                    Nominal: Rp '._format_angka($biaya_aktivasi).'<br><br>

                    Bila sudah melakukan transfer, silahkan klik URL di bawah ini untuk konfirmasi:<br>
                    https://pro2m.co.id/konfirmasi?id='.$reg['id'].'<br><br>

                    Segera aktivasi ID Anda dan nikmati berbagai fasilitas PRO2M.<br>
                    Download Aplikasi mobile PRO2M di https://goo.gl/PVWABu <br><br><br>


                    Terima kasih.<br><br>

                    Regards,<br>
                    PRO2M
                    ';
                $this->email->message($msg);
                $msgs = array();
                if($this->email->send()){
                    $msgs[] = 'Email telah berhasil dikirimkan ke '.$data['email'].'.';
                }else{
                    $msgs[] = 'GAGAL mengirimkan email ke '.$data['email'].'. Silahkan hubungi Customer Service kami.';
                }
                //send sms
                $this->load->model('outbox_model');
                $this->outbox_model->send_sms(array(
                    'nomor' => $data['nohp'],
                    'id_member' => $reg['id'],
                    'nama' => $data['nama'],
                    'tgl' => date('Y-m-d H:i:s'),
                    'pesan' => 'Yth.'.$data['nama'].', Selamat Anda terdaftar menjadi member PRO2M dg ID '.$reg['id'].'. Silahkan aktivasi dg trf '._format_angka($biaya_aktivasi).' ke rek PRO2M. Info norek ada di website https://pro2m.co.id. Download App di https://goo.gl/PVWABu',
                    'type' => '1',
                    'port' => '0',
                    'status' => '0'
                ));
                $message = implode(" ", $msgs);
                
                $this->session->set_flashdata('msg', 'Registrasi telah berhasil dilakukan. '.$message);
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }

    function update() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('no_ktp', 'No. KTP', 'trim|required|xss_clean|callback_cek_duplikat_ktp');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required|xss_clean');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'trim|required|xss_clean');
        $this->form_validation->set_rules('nohp', 'No. HP', 'trim|required|xss_clean|callback_cek_duplikat_nohp');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|callback_cek_duplikat_email');
        if ($this->form_validation->run() == FALSE) {
            $this->edit();
        } else {
            $id = $this->input->post('id');
            $now=date('Y-m-d H:i:s');
            $data = array(
                'nama' => strtoupper($input['nama']),
                'no_ktp' => $input['no_ktp'],
                'alamat' => strtoupper($input['alamat']),
                'kota' => strtoupper($input['kota']),
                'provinsi' => strtoupper($input['provinsi']),
                'kodepos' => $input['kodepos'],
                'nohp' => $input['nohp'],
                'nohp_alt' => $input['nohp_alt'],
                'email' => $input['email'],
                'tgl_update' => $now,
                'user_update' => $this->data['username'],
            );
            $update = $this->member_model->update_data($id, $data, $this->key_id);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan.');
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }
    
    public function update_upline() {
        $input = $this->input->post();
        $this->form_validation->set_error_delimiters('', '<br />');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
        $this->form_validation->set_rules('id_upline', 'ID Upline Baru', 'trim|required|xss_clean');        
        if ($this->form_validation->run() == false) {
            $this->edit_upline();
        } else {
            $id = $this->input->post('id');
            
            $data = $this->input->post();
            
            $update = $this->member_model->update_upline($data);
            
            if ($update) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan.');
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }
    
    function cek_duplikat_ktp(){
        $no_ktp=$this->input->post('no_ktp');
        $id = $this->input->post('id');
        $where = array('no_ktp' => $no_ktp);
        if(!empty($id)){
            $where['id <> '] = $id;
        }
        if($this->member_model->get_total_data($where)>0){
            $this->form_validation->set_message('cek_duplikat_ktp', 'Nomor KTP sudah pernah didaftarkan. Silahkan menggunakan nomor identitas yang lain.');
            return false;
        }else{
            return true;
        }
    }
    function cek_duplikat_nohp(){
        $nohp=$this->input->post('nohp');
        $id = $this->input->post('id');
        $where = array('nohp' => $nohp);
        if(!empty($id)){
            $where['id <> '] = $id;
        }
        if($this->member_model->get_total_data($where)>0){
            $this->form_validation->set_message('cek_duplikat_nohp', 'Nomor HP sudah pernah didaftarkan. Silahkan menggunakan nomor lain.');
            return false;
        }else{
            return true;
        }
    }
    function cek_duplikat_email(){
        $email=$this->input->post('email');
        $id = $this->input->post('id');
        $where = array('email' => $email);
        if(!empty($id)){
            $where['id <> '] = $id;
        }
        if($this->member_model->get_total_data($where)>0){
            $this->form_validation->set_message('cek_duplikat_email', 'Email sudah pernah didaftarkan. Silahkan menggunakan email lain.');
            return false;
        }else{
            return true;
        }
    }
    function cek_upline(){
        $id_upline=$this->input->post('id_upline');
        $upline = $this->member_model->get_data($id_upline);
        //cek upline
        if($upline==null){
            $this->form_validation->set_message('cek_upline', 'ID Upline tidak dikenali.');
            return false;
        }else{
            return true;
        }
    }
    
    function get_member_tree(){
        $id_member = $this->input->get('id_member');
        $data = $this->member_model->get_member_tree($id_member);
        $nodes = array();
        $member = array();
        if(count($data) > 0){
            foreach ($data as &$node) {
//                $node['nodes'] = array();
                $id = $node['id'];
                $parent = $node['parent'];
                $nodes[$id] = & $node;
                if (array_key_exists($parent, $nodes)) {
                    $nodes[$parent]['nodes'][] = & $node;
                    $nodes[$parent]['tags'] = array(count($nodes[$parent]['nodes']));
                } else {
                    $member[] = & $node;
                }
            }
        }
        echo json_encode($member);
    }
    
    //auatocomplete
    function get_member_list(){
        $key = $this->input->get('term');
        $data = $this->member_model->get_member_list($key);
        $ret=array();
        if(count($data)>0){
            foreach($data as $row){
                $ret[] = array(
                    'value' => $row->id,
                    'label' => $row->id.' - '.$row->nama,
                    'id_member' => $row->id,
                    'nama' => $row->nama,
                );
            }
        }
        echo json_encode($ret);
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
                'maxLength' => 40,
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
            'nama_upline' => array(
                'label'=>'nama upline',
                'type'=> "text",
                'format' => 'an',
                'readonly' => true,
                'hide' => true,
            ),
            'status' => array(
                'label' => 'status',
                'type' => 'hidden',
                'value' => '',
            ),
        );
    }
}

