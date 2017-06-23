
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <h3 class="page-title">
                    <?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small>
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
                        </li>
                    </ul>
                    <?php
                    if($role['add']){
                    ?>
                    <div class="page-toolbar">
                        <div class="btn-group pull-right">
                            <a href="<?php echo base_url().$class_name; ?>/add" class="btn btn-info"><i class="fa fa-plus-circle"></i> Tambah Data</a>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row">
                    <div class="col-lg-12">
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
                        <table class="table table-bordered table-striped table-condensed table-hover table-responsive" id="table_data">
                            <thead>
                                <tr>
                                    <?php foreach ($fields as $key => $val): ?>
                                    <?php if(isset($val['hide'])&& $val['hide']==true) continue;?>
                                    <th><?php echo ucfirst($val['label']);?></th>
                                    <?php endforeach; ?>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <?php foreach ($fields as $key => $val): ?>
                                    <?php if(isset($val['hide'])&& $val['hide']==true) continue;?>
                                    <th><?php echo ucfirst($val['label']);?></th>
                                    <?php endforeach; ?>
                                    <th>&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>