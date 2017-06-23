
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="location.href='<?php echo base_url().$class_name; ?>'"><i class="fa fa-arrow-left fa-fw"></i> Kembali</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                $msg =  validation_errors();
                                if(!empty($msg)){
                                    if(is_string($msg)){
                                        echo '<div class="alert alert-dismissable alert-danger hidden-print">'
                                        . '<a class="close" data-dismiss="alert" href="#">&times;</a>'.$msg.'</div>';
                                    }else{
                                        if(count($msg)>0){
                                            echo '<div class="alert alert-dismissable alert-danger hidden-print">';
                                            echo '<a class="close" data-dismiss="alert" href="#">&times;</a>';
                                            foreach($msg as $val){
                                                echo $val.'<br />';
                                            }
                                            echo '</div>';
                                        }
                                    }
                                }
                                ?>
                                <?php if ($this->session->flashdata('msg')): ?>
                                    <div class="alert alert-dismissable alert-success">
                                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                                        <?php echo $this->session->flashdata('msg'); ?>
                                    </div>
                                <?php endif ?>
                                <?php if ($this->session->flashdata('msg_err')): ?>
                                    <div class="alert alert-dismissable alert-danger">
                                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                                        <?php echo $this->session->flashdata('msg_err'); ?>
                                    </div>
                                <?php endif ?>

                                <form id="my_form" method="post" action="<?php echo base_url().$class_name ?>/validate" class="form form-validate" novalidate="novalidate">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="control-label">Bank <span class="danger">*</span></label>
                                                <select class="form-control select2 select2me" id="input-bank" required name="bank" style="width:100%;">
                                                    <option></option>
                                                    <?php
                                                    $id = 'bank';
                                                    if(!empty($bank_list)){
                                                        foreach($bank_list as $key => $val){
                                                            echo '<option value="'.$key.'"'.(set_value($id, $datalist->id_bank)==$key?' selected="selected"':'').'>'.$val.'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">Rp</span>
                                                    <div class="input-group-content">
                                                        <input type="text" class="form-control" id="input-nominal" name="nominal" 
                                                            data-rule-minlength="0" maxlength="50" required value="<?php echo $datalist->nominal;?>" />
                                                        <label for="input-nominal">Nominal Pembayaran / Transfer <span class="danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="input-ket" name="ket" required rows="5"></textarea>
                                                <label for="input-ket">Keterangan / Bukti Transfer <span class="danger">*</span></label>
                                                <div class="help-block">Copy-paste bukti pembayaran di sini.</div>
                                            </div>
                                        </div>
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <input type="hidden" name="id" id="input-id" value="<?php echo $datalist->id;?>">
                                                <input type="hidden" name="id_member" id="input-id_member" value="<?php echo $datalist->id_member;?>">
                                                <button type="submit" class="btn btn-raised btn-primary ink-reaction">Validasi</button>&nbsp;
                                                <a href="<?php echo base_url().$class_name;?>" role="button" class="btn btn-raised ink-reaction btn-default">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Detail Data Konfirmasi : </h4>
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-striped table-hover">
                                                <?php
                                                $dt_user = array(
                                                    'user_input' => $datalist->user_input,
                                                    'tgl_input' => $datalist->tgl_input,
                                                    'user_update' => $datalist->user_update,
                                                    'tgl_update' => $datalist->tgl_update,
                                                );
                                                unset($datalist->id, $datalist->user_input, $datalist->tgl_input, $datalist->user_update, $datalist->tgl_update);
                                                $pertama = key($datalist);
                                                foreach($datalist as $key => $val){
                                                    if($pertama === $key){
                                                ?>
                                                <tr>
                                                    <td width="150"><?php echo isset($fields[$key]['label']) ? ucwords($fields[$key]['label']) : ucwords(str_replace('_', ' ', $key));?></td>
                                                    <td width="5">:</td>
                                                    <td><?php echo $val; ?></td>
                                                </tr>
                                                <?php
                                                    }else{
                                                ?>
                                                <tr>
                                                    <td><?php echo isset($fields[$key]['label']) ? ucwords($fields[$key]['label']) : ucwords(str_replace('_', ' ', $key));?></td>
                                                    <td>:</td>
                                                    <td><?php echo ($key=='status'?_get_status_pending($val):$val); ?></td>
                                                </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>User Input</td>
                                                    <td>:</td>
                                                    <td><?php echo $dt_user['user_input']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Input</td>
                                                    <td>:</td>
                                                    <td><?php echo _format_tgl($dt_user['tgl_input']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>User Update</td>
                                                    <td>:</td>
                                                    <td><?php echo $dt_user['user_update']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tgl Update</td>
                                                    <td>:</td>
                                                    <td><?php echo _format_tgl($dt_user['tgl_update']); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>