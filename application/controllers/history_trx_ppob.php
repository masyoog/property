<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class History_trx_ppob extends Site_Controller {

    protected $template_name = "default";
    private $field;
    private $key_id = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('transaksi_ppob_model', 'trx_ppob');
    }

    function get_data() {
        $this->datatables->select('trx.id,
            trx.tgl,
            trx.id_member,
            trx.produk,
            trx.id_pel,
            trx.type,
            trx.status,
            trx.rc,
            trx.ket,
            trx.noresi,
            trx.nominal,
            trx.id as action,
            trx.status as status')
                ->add_column('action', $this->get_action_button('$1'), 'id')
                ->edit_column('status', '$1', '_get_status(status)')
                ->from("m_ppob_produk p")
                ->join('m_ppob_produk_group g', 'p.id_group=g.id', 'left')
        ;

        echo $this->datatables->generate();
    }

    /*
      function get_action_button($param){
      $role = $this->data["role"][$this->class];
      $ret='<div class="btn-group">
      <a class="btn ink-reaction btn-primary btn-xs" href="'.base_url().$this->class.'/detail/'.$param.'"><i class="fa fa-eye fa-fw"></i> Detail</a>';
      if($role['edit'] || $role['delete']){
      $ret.= '
      <button type="button" class="btn ink-reaction btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down"></i></button>
      <ul class="dropdown-menu dropdown-menu-right" role="menu">
      '.($role['edit']?'<li><a href="'.  base_url().$this->class.'/edit/'.$param.'"><i class="fa fa-edit"></i> Edit Data</a></li>':'').'
      </ul>';
      }
      $ret.='
      </div>';
      return $ret;
      }
     * 
     */

    function index() {
        $this->init(false);
        $data = array(
            "title" => "Histori Transaksi PPOB",
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
        $i = 0;
        foreach ($this->field as $key => $val) {
            if (isset($val['hide']) && $val['hide'] == true)
                continue;
            $column .= "{'data':'" . $key . "'},";
            $keys[] = $i++;
        }
        $column_export = implode(',', $keys);
        $data['js_init'] = "
            $('#table_data').dataTable({
                'processing': true,
                'serverSide': true,
                'fixedHeader': true,
                'ajax': {
                    'url': '" . base_url() . $this->class_name . "/get_data',
                    'type': 'POST'
                },
                'columns': [
                    " . $column . "
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
                         columns: [" . $column_export . "]
                     }
                  },
                  {
                    extend: 'csv',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [" . $column_export . "]
                     }
                  },
                  {
                    extend: 'excel',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [" . $column_export . "]
                     }
                  },
                  {
                    extend: 'pdfHtml5',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [" . $column_export . "]
                     }
                  },
                  {
                    extend: 'print',
                    className: 'btn-sm',
                    exportOptions: {
                         columns: [" . $column_export . "]
                     }
                  },
                ]
            });
        ";
        $this->view($data);
    }

    function detail() {
        $this->init(false);
        $data = array(
            "title" => "Data Produk & Fee PPOB",
            'subtitle' => 'Detail Data',
            'fields' => $this->field,
        );

        $id = $this->security->xss_clean($this->uri->segment(3));
        $data['datalist'] = $this->my_model->get_data($id);
        if ($data['datalist'] == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        }

        $this->view($data);
    }

    function add() {
        $this->init();
        $data = array(
            "title" => "Input Data Produk PPOB",
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
                base_url() . "assets/js/pages/" . $this->class_name . ".js",
            ),
            'js_init' => ucfirst($this->class_name) . ".init();",
        );
        $form_input = new My_form();
        $form_input->set($this->field);
        $data["form_element"] = $form_input->render_form('', true, false);

        $this->view($data);
    }

    function edit() {
        $this->init();
        $data = array(
            "title" => "Edit Data Produk & Fee PPOB",
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
            'js_init' => ucfirst($this->class_name) . ".init();",
        );
        $code = $this->input->post('id');
        if (!empty($code)) {
            $id = $code;
        } else {
            $id = $this->security->xss_clean($this->uri->segment(3));
        }
        $res = $this->my_model->get_data($id, $this->key_id);
        if ($res == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect('user');
        } else {
            $form_input = new My_form();
            $this->field = array_merge($this->field, array('id' => array('type' => 'hidden')));
            unset($this->field['jenis_member'], $this->field['id_upline'], $this->field['nama_upline']);

            $form_input->set($this->field);
            if (!empty($this->input->post())) {
                $value = $this->input->post();
            } else {
                $value = array(
                    'nama' => $res->nama,
                    'no_ktp' => $res->no_ktp,
                    'alamat' => $res->alamat,
                    'kota' => $res->kota,
                    'provinsi' => $res->provinsi,
                    'kodepos' => $res->kodepos,
                    'nohp' => $res->nohp,
                    'nohp_alt' => $res->nohp_alt,
                    'email' => $res->email,
                    'id' => $id,
                );
            }
            $form_input->set_value($value);
            $data["form_element"] = $form_input->render_form("edit");
        }

        $this->view($data);
    }

    function delete() {
        $id = $this->security->xss_clean($this->uri->segment(3));
        $result = $this->my_model->get_data($id);
        if ($result == null) {
            $this->session->set_flashdata('msg_err', 'Data not found');
            redirect($this->class);
        } else {
            $delete = $this->my_model->delete_data($id, $this->key_id);
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
            $now = date('Y-m-d H:i:s');
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
            $reg = $this->my_model->registrasi($data);
            if ($reg) {

                $this->session->set_flashdata('msg', 'Registrasi telah berhasil dilakukan. ' . $message);
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
            $now = date('Y-m-d H:i:s');
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
            $update = $this->my_model->update_data($id, $data, $this->key_id);
            if ($update) {
                $this->session->set_flashdata('msg', 'Data telah berhasil disimpan.');
            } else {
                $this->session->set_flashdata('msg_err', 'Gagal menyimpan data.');
            }
            redirect($this->class);
        }
    }

    function cek_duplikat_email() {
        $email = $this->input->post('email');
        $id = $this->input->post('id');
        $where = array('email' => $email);
        if (!empty($id)) {
            $where['id <> '] = $id;
        }
        if ($this->my_model->get_total_data($where) > 0) {
            $this->form_validation->set_message('cek_duplikat_email', 'Email sudah pernah didaftarkan. Silahkan menggunakan email lain.');
            return false;
        } else {
            return true;
        }
    }

    private function init($with_value = true) {
        $grouplist = array();
        if ($with_value) {
//            $grouplist = $this->group_model->get_datalist();
        }
        $this->field = array(
            'nama_group' => array(
                'label' => 'group',
                'type' => "select",
                'data' => $grouplist,
                'required' => true,
            ),
            'kode_produk' => array(
                'label' => 'kode produk',
                'type' => "text",
                'format' => 'an',
                'maxLength' => 20,
                'value' => '',
            ),
            'nama_produk' => array(
                'label' => 'nama produk',
                'type' => "text",
                'required' => true,
                'minLength' => 0,
                'maxLength' => 50,
                'format' => 'an',
            ),
            'denom' => array(
                'label' => 'denom',
                'type' => "text",
                'required' => true,
                'maxLength' => 12,
                'format' => 'n',
            ),
            'fee_member' => array(
                'label' => 'fee member',
                'type' => "text",
                'required' => true,
                'maxLength' => 8,
                'format' => 'n',
            ),
            'fee_upline1' => array(
                'label' => 'fee upline1',
                'type' => "text",
                'required' => true,
                'maxLength' => 5,
                'format' => 'n',
            ),
            'fee_upline2' => array(
                'label' => 'fee upline2',
                'type' => "text",
                'required' => true,
                'maxLength' => 5,
                'format' => 'n',
            ),
            'fee_upline3' => array(
                'label' => 'fee upline3',
                'type' => "text",
                'required' => true,
                'maxLength' => 5,
                'format' => 'n',
            ),
            'fee_upline4' => array(
                'label' => 'fee upline4',
                'type' => "text",
                'required' => true,
                'maxLength' => 5,
                'format' => 'n',
            ),
            'fee_upline5' => array(
                'label' => 'fee upline5',
                'type' => "text",
                'required' => true,
                'maxLength' => 5,
                'format' => 'n',
            ),
            'fee_biller' => array(
                'label' => 'fee dari biller',
                'type' => "text",
                'required' => true,
                'maxLength' => 8,
                'format' => 'n',
            ),
            'status' => array(
                'label' => 'status',
                'type' => 'hidden',
                'value' => '',
            ),
        );
    }

}
