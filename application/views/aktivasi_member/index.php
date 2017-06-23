
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
                            </div>
                        </div>
                    </div>
                </section>