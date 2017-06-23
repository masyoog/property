            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button type="button" class="btn btn-round btn-sm btn-info" onclick="location.href='<?php echo base_url().$class_name; ?>'"><i class="fa fa-eye"></i> Lihat Data</button></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
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
                            <p>
                                Silahkan isi form di bawah ini dengan baik
                            </p>
                            <?php echo $form_element;?>
                        </div>
                    </div>
                </div>
            </div>