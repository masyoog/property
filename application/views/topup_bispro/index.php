
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                    </div>
                    <div class="section-body">
                        <br>
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

                                <form id="my_form" method="post" action="<?php echo base_url().$class_name ?>/insert" class="form form-validate" novalidate="novalidate">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="input-id_member" name="id_member" 
                                                    data-rule-minlength="0" maxlength="10" required value="<?php echo set_value('id_member');?>" />
                                                <label for="input-id_member">ID Member <span class="danger">*</span></label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="input-nama" name="nama" value="<?php echo set_value('nama');?>" readonly />
                                                <label for="input-nama">Nama Member</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Topup Dari <span class="danger">*</span></label>
                                                <select class="form-control select2 select2me" id="input-bank" required name="bank" style="width:100%;">
                                                    <option value="WALLET">E-WALLET</option>
                                                    <?php
                                                    $id = 'bank';
                                                    if(!empty($bank_list)){
                                                        foreach($bank_list as $key => $val){
                                                            echo '<option value="'.$key.'"'.(set_value($id)==$key?' selected="selected"':'').'>'.$val.'</option>';
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
                                                            data-rule-minlength="0" maxlength="16" required value="<?php echo set_value('nominal');?>" />
                                                        <label for="input-nominal">Nominal <span class="danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="input-ket" name="ket"></textarea>
                                                <label for="input-ket">Keterangan / Bukti Transfer </label>
                                                <div class="help-block">Copy-paste bukti pembayaran di sini (bila ada).</div>
                                            </div>
                                        </div>
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <button type="submit" class="btn btn-raised btn-primary ink-reaction">Submit</button>&nbsp;
                                                <a href="<?php echo base_url().$class_name;?>" role="button" class="btn btn-raised ink-reaction btn-default">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>