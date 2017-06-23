            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button type="button" class="btn btn-round btn-sm btn-info" onclick="location.href='<?php echo base_url().$class_name; ?>/add'"><i class="fa fa-plus-circle fa-fw"></i> Tambah Baru</button></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
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
                            <table class="table table-striped table-bordered table-hover table-condensed" id="table_data">
                                <thead>
                                    <tr>
                                        <?php foreach ($fields as $key => $val): ?>
                                            <?php if (isset($val['hide']) && $val['hide'] == true) continue; ?>
                                            <th><?php echo ucwords($val['label']); ?></th>
                                        <?php endforeach; ?>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <?php foreach ($fields as $key => $val): ?>
                                            <?php if (isset($val['hide']) && $val['hide'] == true) continue; ?>
                                            <th><?php echo ucwords($val['label']); ?></th>
                                        <?php endforeach; ?>
                                        <th>&nbsp;</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>