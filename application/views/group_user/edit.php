
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
                            <div class="col-lg-12">
                                <?php
                                $msg = validation_errors();
                                if (!empty($msg)) {
                                    if (is_string($msg)) {
                                        echo '<div class="alert alert-dismissable alert-danger hidden-print">'
                                        . '<a class="close" data-dismiss="alert" href="#">&times;</a>' . $msg . '</div>';
                                    } else {
                                        if (count($msg) > 0) {
                                            echo '<div class="alert alert-dismissable alert-danger hidden-print">';
                                            echo '<a class="close" data-dismiss="alert" href="#">&times;</a>';
                                            foreach ($msg as $val) {
                                                echo $val . '<br />';
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
                                <form id="my_form" class="form-horizontal form-validate" novalidate="novalidate" method="post" action="<?php echo base_url() . $this->router->fetch_class() . "/" . $action; ?>">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="input-nama">Nama <span class="danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control" id="input-nama" name="nama" placeholder="Nama" minlength="0" data-rule-maxlength="30" 
                                                   required
                                                   value="<?php echo set_value('nama', $fields['nama']['value']); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Dashboard</label>
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-md-6 table-responsive">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="flat" id="outstanding_all"> Outstanding
                                                            </label>
                                                        </div>
                                                        </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_cn" id="input-out_cn" value="1"<?php echo (set_value("out_cn", $fields['outstanding']['cn']) == "1" ? ' checked="checked"' : ''); ?>> Connote / Pickup
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_outgoing" id="input-out_outgoing" value="1"<?php echo (set_value("out_outgoing", $fields['outstanding']['outgoing']) == "1" ? ' checked="checked"' : ''); ?>> Outgoing
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_incoming" id="input-out_incoming" value="1"<?php echo (set_value("out_incoming", $fields['outstanding']['incoming']) == "1" ? ' checked="checked"' : ''); ?>> Incoming
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_delivery" id="input-out_delivery" value="1"<?php echo (set_value("out_delivery", $fields['outstanding']['delivery']) == "1" ? ' checked="checked"' : ''); ?>> Delivery
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_pod" id="input-out_pod" value="1"<?php echo (set_value("out_pod", $fields['outstanding']['pod']) == "1" ? ' checked="checked"' : ''); ?>> POD
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_dex" id="input-out_dex" value="1"<?php echo (set_value("out_dex", $fields['outstanding']['dex']) == "1" ? ' checked="checked"' : ''); ?>> Delivery Exception
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_invoice" id="input-out_invoice" value="1"<?php echo (set_value("out_invoice", $fields['outstanding']['invoice']) == "1" ? ' checked="checked"' : ''); ?>> Invoice
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat out-item" name="out_payment" id="input-out_payment" value="1"<?php echo (set_value("out_payment", $fields['outstanding']['payment']) == "1" ? ' checked="checked"' : ''); ?>> Payment
                                                                            </label>
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
                                                                <th>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="flat" id="summary_all"> Summary
                                                            </label>
                                                        </div>
                                                        </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_pickup" id="input-summary_pickup" value="1"<?php echo (set_value("summary_pickup", $fields['summary']['pickup']) == "1" ? ' checked="checked"' : ''); ?>> Pickup
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_cn" id="input-summary_cn" value="1"<?php echo (set_value("summary_cn", $fields['summary']['cn']) == "1" ? ' checked="checked"' : ''); ?>> Connote
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_outgoing" id="input-summary_outgoing" value="1"<?php echo (set_value("summary_outgoing", $fields['summary']['outgoing']) == "1" ? ' checked="checked"' : ''); ?>> Outgoing
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_incoming" id="input-summary_incoming" value="1"<?php echo (set_value("summary_incoming", $fields['summary']['incoming']) == "1" ? ' checked="checked"' : ''); ?>> Incoming
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_delivery" id="input-summary_delivery" value="1"<?php echo (set_value("summary_delivery", $fields['summary']['delivery']) == "1" ? ' checked="checked"' : ''); ?>> Delivery
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_pod" id="input-summary_pod" value="1"<?php echo (set_value("summary_pod", $fields['summary']['pod']) == "1" ? ' checked="checked"' : ''); ?>> POD
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_dex" id="input-summary_dex" value="1"<?php echo (set_value("summary_dex", $fields['summary']['dex']) == "1" ? ' checked="checked"' : ''); ?>> Delivery Exception
                                                                            </label>
                                                                        </div>
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat summary-item" name="summary_payment" id="input-summary_payment" value="1"<?php echo (set_value("summary_payment", $fields['summary']['payment']) == "1" ? ' checked="checked"' : ''); ?>> Payment
                                                                            </label>
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
                                                                <th>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="flat" id="panel_all"> Report & Statistic
                                                            </label>
                                                        </div>
                                                        </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="col-md-4">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat panel-item" name="panel_transaksi" id="input-panel_transaksi" value="1"<?php echo (set_value("panel_transaksi", $fields['panel']['transaksi']) == "1" ? ' checked="checked"' : ''); ?>> Transaksi
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat panel-item" name="panel_revenue" id="input-panel_revenue" value="1"<?php echo (set_value("panel_revenue", $fields['panel']['revenue']) == "1" ? ' checked="checked"' : ''); ?>> Revenue
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="checkbox">
                                                                            <label>
                                                                                <input type="checkbox" class="flat panel-item" name="panel_tracing" id="input-panel_tracing" value="1"<?php echo (set_value("panel_tracing", $fields['panel']['tracing']) == "1" ? ' checked="checked"' : ''); ?>> Tracing
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label" for="hak-akses">Hak Akses</label>
                                        <div class="col-lg-10 table-responsive" id="hak-akses">
                                            <table class="table table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" width="50%">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="flat" id="modul_all"> <strong>Modul / Menu</strong>
                                                    </label>
                                                </div>
                                                </th>
                                                <th colspan="2">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="flat" id="action_all"> <strong>Action</strong>
                                                    </label>
                                                </div>
                                                </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($fields['menu'])) {
                                                        foreach ($fields['menu'] as $val) {
                                                            $value = set_value('hak[' . $val['id'] . ']', !empty($val['value']) ? $val['value'] : '');
                //                                                        $val_print = set_value('print['.$val['id'].']', !empty($val['role']['print'])?$val['role']['print']:'');
                                                            $val_add = set_value('add[' . $val['id'] . ']', !empty($val['role']['add']) ? $val['role']['add'] : '');
                                                            $val_delete = set_value('delete[' . $val['id'] . ']', !empty($val['role']['delete']) ? $val['role']['delete'] : '');
                                                            $val_edit = set_value('edit[' . $val['id'] . ']', !empty($val['role']['edit']) ? $val['role']['edit'] : '');
                //                                                        $val_export = set_value('export['.$val['id'].']', !empty($val['role']['export'])?$val['role']['export']:'');
                                                            ?>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" class="parent_all chk-menu<?php echo ($val['link'] == 'dashboard' ? ' chk-always' : ''); ?> flat" id="parent-<?php echo $val['id']; ?>" name="hak[<?php echo $val['id']; ?>]" value="<?php echo $val['id']; ?>" <?php echo ($val['link'] == 'dashboard' || $value == "1" ? ' checked="checked"' : '') . ($val['link'] == 'dashboard' ? ' onclick="return false"' : ''); ?>> <strong><?php echo $val['menu']; ?></strong>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td colspan="2">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" class="chk-action flat" id="add-<?php echo $val['id']; ?>" name="add[<?php echo $val['id']; ?>]" value="1" <?php echo $val_add == "1" ? 'checked="checked"' : ''; ?>> <strong>Add</strong>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" class="chk-action flat" id="delete-<?php echo $val['id']; ?>" name="delete[<?php echo $val['id']; ?>]" value="1" <?php echo $val_delete == "1" ? 'checked="checked"' : ''; ?>> <strong>Delete</strong>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" class="chk-action flat" id="edit-<?php echo $val['id']; ?>" name="edit[<?php echo $val['id']; ?>]" value="1" <?php echo $val_edit == "1" ? 'checked="checked"' : ''; ?>> <strong>Edit</strong>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" class="actionrow_all chk-action chk-action-parent flat" id="pilihsemua-<?php echo $val['id']; ?>" value="<?php echo $val['id']; ?>"> <strong>Semua</strong>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $id_parent = $val['id'];
                                                            if (count($val['child']) > 0) {
                                                                foreach ($val['child'] as $val) {
                                                                    $value = set_value('hak[' . $val['id'] . ']', !empty($val['value']) ? $val['value'] : '');
                //                                                            $val_print = set_value('print['.$val['id'].']', !empty($val['role']['print'])?$val['role']['print']:'');
                                                                    $val_add = set_value('add[' . $val['id'] . ']', !empty($val['role']['add']) ? $val['role']['add'] : '');
                                                                    $val_delete = set_value('delete[' . $val['id'] . ']', !empty($val['role']['delete']) ? $val['role']['delete'] : '');
                                                                    $val_edit = set_value('edit[' . $val['id'] . ']', !empty($val['role']['edit']) ? $val['role']['edit'] : '');
                //                                                            $val_export = set_value('export['.$val['id'].']', !empty($val['role']['export'])?$val['role']['export']:'');
                                                                    ?>
                                                                    <tr>
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <div class="checkbox">
                                                                                <label>
                                                                                    <input type="checkbox" class="childof-<?php echo $id_parent; ?> chk-menu<?php echo ($val['link'] == 'dashboard' ? ' chk-always' : ''); ?> flat" id="<?php echo $val['id'] . '-' . $id_parent; ?>" name="hak[<?php echo $val['id']; ?>]" value="1" <?php echo ($val['link'] == 'dashboard' || $value == "1" ? ' checked="checked"' : '') . ($val['link'] == 'dashboard' ? ' onclick="return false"' : ''); ?>> <?php echo $val['menu']; ?>
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                        <td>&nbsp;</td>
                                                                        <td>
                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input type="checkbox" class="chk-action flat chk-childof-<?php echo $id_parent; ?>" id="add-<?php echo $val['id']; ?>" name="add[<?php echo $val['id']; ?>]" value="1" <?php echo $val_add == "1" ? 'checked="checked"' : ''; ?>> Add
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input type="checkbox" class="chk-action flat chk-childof-<?php echo $id_parent; ?>" id="delete-<?php echo $val['id']; ?>" name="delete[<?php echo $val['id']; ?>]" value="1" <?php echo $val_delete == "1" ? 'checked="checked"' : ''; ?>> Delete
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input type="checkbox" class="chk-action flat chk-childof-<?php echo $id_parent; ?>" id="edit-<?php echo $val['id']; ?>" name="edit[<?php echo $val['id']; ?>]" value="1" <?php echo $val_edit == "1" ? 'checked="checked"' : ''; ?>> Edit
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input type="checkbox" class="actionrow_all chk-action chk-action-parent flat chk-childof-<?php echo $id_parent; ?>" id="pilihsemua-<?php echo $val['id']; ?>" value="<?php echo $val['id']; ?>"> Semua
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4">&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php if ($action == "update") { ?>
                                        <input type="hidden" name="id" value="<?php echo set_value('id', $fields['id']['value']); ?>" />
                                    <?php } ?>
                                    <hr style="border-color:#ddd" />
                                    <div class="form-group">
                                        <div class="col-lg-9 col-lg-offset-2">
                                            <button type="submit" class="btn btn-primary">Simpan</button> 
                                            <a href="<?php echo base_url() . $this->router->fetch_class(); ?>" role="button" class="btn btn-default">Batal</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>