
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <h3 class="page-title">
                    <?php echo $title ?> <small><?php echo $subtitle ?></small>
                </h3>
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo base_url()?>dashboard">Home</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a>Setting</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a>Global Setting</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <a>Edit</a>
                        </li>
                    </ul>
                    <div class="page-toolbar">
                        <div class="btn-group pull-right">
                            <a href="<?php echo base_url().$class_name; ?>" class="btn btn-info"><i class="fa fa-eye"></i> Lihat Data</a>
                        </div>
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-note font-blue-hoki"></i>
                                    <span class="caption-subject font-blue-hoki bold uppercase"><?php echo $title; ?></span>
                                    <span class="caption-helper">Silahkan isi form di bawah ini dengan baik</span>
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body form">
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
                                <?php echo $form_element;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>