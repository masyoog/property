
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="location.href='<?php echo base_url().$class_name; ?>'"><i class="fa fa-eye fa-fw"></i> Lihat Data</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
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
                                <table class="table table-condensed table-striped table-hover">
                                    <tr>
                                        <td width="200">Nama Group</td>
                                        <td width="5">:</td>
                                        <td><?php echo $datalist['nama'];?></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Dashboard</td>
                                        <td>:</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6 table-responsive">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th><strong>Outstanding</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-md-6">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['cn']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Connote/Pickup
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['outgoing']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Outgoing
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['incoming']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Incoming
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['delivery']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Delivery
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['pod']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            POD
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['dex']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Delivery Exception
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['invoice']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Invoice
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['outstanding']['payment']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Payment
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6 table-responsive">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th><strong>Summary</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-md-6">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['pickup']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Pickup
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['cn']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Connote
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['outgoing']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Outgoing
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['incoming']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Incoming
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['delivery']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Delivery
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['pod']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            POD
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['dex']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Delivery Exception
                                                                        </div>
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['summary']['payment']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Payment
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 table-responsive">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th><strong>Report & Statistic</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-md-4">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['panel']['transaksi']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Transaksi
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['panel']['revenue']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Revenue
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="md-checkbox">
                                                                            <?php echo ($datalist['panel']['tracing']=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?>
                                                                            Tracing
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Hak Akses</td>
                                        <td>:</td>
                                        <td>
                                            <div class="table-responsive">
                                                <table class="table table-condensed table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2">Modul / Menu</th>
                                                            <th width="10%">Add</th>
                                                            <th width="10%">Delete</th>
                                                            <th width="10%">Edit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if(!empty($datalist['menu'])){
                                                            foreach($datalist['menu'] as $val){
                                                                $value = set_value('hak['.$val['id'].']', !empty($val['value'])?$val['value']:'');
                                                                $val_add = set_value('add['.$val['id'].']', !empty($val['role']['add'])?$val['role']['add']:'');
                                                                $val_delete = set_value('delete['.$val['id'].']', !empty($val['role']['delete'])?$val['role']['delete']:'');
                                                                $val_edit = set_value('edit['.$val['id'].']', !empty($val['role']['edit'])?$val['role']['edit']:'');
                                                        ?>
                                                        <tr>
                                                            <td colspan="2"><strong><?php echo ($val['link']=='home' || $value=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?> <?php echo $val['menu']; ?></strong></td>
                                                            <td><?php echo $val_add=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>'; ?></td>
                                                            <td><?php echo $val_delete=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>'; ?></td>
                                                            <td><?php echo $val_edit=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>'; ?></td>
                                                        </tr>
                                                        <?php
                                                            $id_parent = $val['id'];
                                                            if(count($val['child'])>0){
                                                                foreach($val['child'] as $val){
                                                                    $value = set_value('hak['.$val['id'].']', !empty($val['value'])?$val['value']:'');
                                                                    $val_add = set_value('add['.$val['id'].']', !empty($val['role']['add'])?$val['role']['add']:'');
                                                                    $val_delete = set_value('delete['.$val['id'].']', !empty($val['role']['delete'])?$val['role']['delete']:'');
                                                                    $val_edit = set_value('edit['.$val['id'].']', !empty($val['role']['edit'])?$val['role']['edit']:'');
                                                        ?>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td><?php echo ($val['link']=='home' || $value=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>');?> <?php echo $val['menu']; ?></td>
                                                            <td><?php echo $val_add=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>'; ?></td>
                                                            <td><?php echo $val_delete=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>'; ?></td>
                                                            <td><?php echo $val_edit=="1"?'<i class="fa fa-check" style="color:blue"></i>':'<i class="fa fa-times" style="color:red"></i>'; ?></td>
                                                        </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>