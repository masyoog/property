
                <section class="style-default-bright">
                    <div class="section-header">
                        <h2 class="text-primary"><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                    </div>
                    <div class="section-body">
                        <div class="row">
                            <div class="col-lg-12">                                                                   
                                <form id="my_form" class="form form-validate" novalidate="novalidate">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group col-md-6">
                                                <input type="text"  class="form-control" id="input-id_member" name="id_member" data-rule-minlength="0" maxlength="50" value="" />
                                                <label for="input-id_member">ID Member </label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text"  class="form-control" id="input-nama_member" name="nama_member" readonly="readonly" />
                                                <label for="input-nama_member">Nama </label>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button type="button" id="btn-all" class="btn btn-raised btn-primary ink-reaction">Tampilkan Semua Jaringan</button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="tree"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>