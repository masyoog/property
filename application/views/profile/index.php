
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?></h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="form_input" method="POST" action="<?php echo base_url() ?>profile/update" 
                                          class="form floating-label form-validate" novalidate="novalidate">
                                    <div class="card card-bordered style-default-bright">
                                        <div class="card-head">
                                            <header><i class="fa fa-fw fa-user"></i> <?php echo ucfirst($subtitle) ?></header>
                                        </div><!--end .card-head -->
                                        <div class="card-body style-default-bright">
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
                                            <?php if($this->session->flashdata('msg')):?>
                                            <div class="alert alert-dismissable alert-success">
                                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                            <?php echo $this->session->flashdata('msg');?>
                                            </div>
                                            <?php endif?>
                                            <?php if($this->session->flashdata('msg_err')):?>
                                            <div class="alert alert-dismissable alert-danger">
                                                <a class="close" data-dismiss="alert" href="#">&times;</a>
                                            <?php echo $this->session->flashdata('msg_err');?>
                                            </div>
                                            <?php endif?>
                                            <!-- BEGIN FORM-->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" id="input-user" name="user" required class="form-control" value="<?php echo set_value("user", $value['user'])?>">
                                                        <label for="input-user">Username</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="password" id="input-pass_old" required name="pass_old" class="form-control">
                                                        <label for="input-pass_old">Password Lama</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" id="input-nama" name="nama" required class="form-control" value="<?php echo set_value("nama", $value['nama'])?>">
                                                        <label for="input-nama">Nama</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="password" id="input-pass" name="pass" class="form-control">
                                                        <label for="input-pass">Password Baru</label>
                                                        <span class="help-block">Kosongi saja bila tidak ingin mengubah password</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="password" id="input-pass_confirm" name="pass_confirm" class="form-control">
                                                        <label for="input-pass_confirm">Konfirmasi Password Baru</label>
                                                        <span class="help-block">Kosongi saja bila tidak ingin mengubah password</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                        <div class="card-actionbar">
                                            <div class="card-actionbar-row">
                                                <input type="hidden" name="id" id="input-id" value="<?php echo set_value("id", $value['id'])?>">
                                                <button type="submit" class="btn btn-raised btn-info ink-reaction">Simpan</button>
                                            </div>
                                        </div><!--end .card-actionbar -->
                                    </div><!--end .card -->
                                </form>
                            </div>
                        </div>
                    </div>
                </section>