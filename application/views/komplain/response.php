
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="location.href = '<?php echo base_url() . $class_name; ?>'"><i class="fa fa-eye fa-fw"></i> Lihat Data</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
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
                                <?php echo $form_element;?>
                            </div>
                        </div>
                    </div>
                </section>