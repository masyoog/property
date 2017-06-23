
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                    </div>
                    <div class="section-body">
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
                                <!--modal transfer-->
                                <div class="modal fade" id="modal_transfer" role="dialog" aria-labelledby="modal_transfer_label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form id="my_form" method="post" action="<?php echo base_url().$class_name ?>/execute" class="form form-validate" novalidate="novalidate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="modal_input_akun">Withdraw Saldo</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <textarea class="form-control" id="input-ket" name="ket" required rows="5"></textarea>
                                                                <label for="input-ket">Bukti Transfer / Keterangan<span class="danger">*</span></label>
                                                                <div class="help-block">Copy-paste bukti pembayaran di sini.</div>
                                                            </div>
                                                        </div>
                                                        <div class="card-actionbar">
                                                            <div class="card-actionbar-row">
                                                                <input type="hidden" name="id" id="input-id" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-raised btn-primary ink-reaction">Simpan</button>&nbsp;
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--//modal transfer -->
                                
                                <!--modal cancel-->
                                <div class="modal fade" id="modal_cancel" role="dialog" aria-labelledby="modal_cancel_label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form id="my_form" method="post" action="<?php echo base_url().$class_name ?>/cancel" class="form form-validate" novalidate="novalidate">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="modal_input_akun">Apakah Anda yakin ingin membatalkan? Saldo Member akan dikembalikan.</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <textarea class="form-control" id="input-ket" name="ket" required rows="5"></textarea>
                                                                <label for="input-ket">Keterangan / Alasan Batal<span class="danger">*</span></label>
                                                            </div>
                                                        </div>
                                                        <div class="card-actionbar">
                                                            <div class="card-actionbar-row">
                                                                <input type="hidden" name="id" id="input-id" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-raised btn-primary ink-reaction">Simpan</button>&nbsp;
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--//modal cancel -->
                            </div>
                        </div>
                    </div>
                </section>