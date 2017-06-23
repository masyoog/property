
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
                            <a>Detail</a>
                        </li>
                    </ul>
                    <div class="page-toolbar">
                        <div class="btn-group pull-right">
                            <a href="<?php echo base_url().$class_name; ?>" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</a>
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
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-condensed table-striped table-hover">
                                                <tr>
                                                    <td width="150">Nama Setting</td>
                                                    <td width="5">:</td>
                                                    <td><?php echo $datalist->setting;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nilai</td>
                                                    <td>:</td>
                                                    <td><?php echo $datalist->value;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Keterangan</td>
                                                    <td>:</td>
                                                    <td><?php echo $datalist->ket;?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>