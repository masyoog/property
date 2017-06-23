                <div class="row">
                    <div class="col-md-12">
                      <div class="col-middle">
                        <div class="text-center text-center">
                          <h1 class="error-number">404</h1>
                          <h2>Mohon maaf, halaman tidak ditemukan.</h2>
                          <p>
                              <?php echo (isset($message) && $message!="")?$message:'Halaman yang Anda cari tidak dapat ditemukan.'; ?>
                          </p>
                          <div class="mid_center">
                            <button class="btn btn-default btn-round btn-sm" onclick="window.history.back();"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>