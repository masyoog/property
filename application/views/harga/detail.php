            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><?php echo ucwords($title) ?> <small><?php echo ucfirst($subtitle) ?></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><button type="button" class="btn btn-round btn-sm btn-info" onclick="location.href='<?php echo base_url().$class_name; ?>'"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</button></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-hover">
                                            <?php
                                            $dt_user = array(
                                                'user_input' => $datalist->user_input,
                                                'tgl_input' => $datalist->tgl_input,
                                                'user_update' => $datalist->user_update,
                                                'tgl_update' => $datalist->tgl_update,
                                            );
                                            unset($datalist->id, $datalist->user_input, $datalist->tgl_input, $datalist->user_update, $datalist->tgl_update);
                                            $pertama = key($datalist);
                                            foreach($datalist as $key => $val){
                                                if($pertama === $key){
                                            ?>
                                            <tr>
                                                <td width="150"><?php echo isset($fields[$key]['label']) ? ucwords($fields[$key]['label']) : ucwords(str_replace('_', ' ', $key));?></td>
                                                <td width="5">:</td>
                                                <td><?php echo $val; ?></td>
                                            </tr>
                                            <?php
                                                }else{
                                            ?>
                                            <tr>
                                                <td><?php echo isset($fields[$key]['label']) ? ucwords($fields[$key]['label']) : ucwords(str_replace('_', ' ', $key));?></td>
                                                <td>:</td>
                                                <td><?php echo $val; ?></td>
                                            </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>User Input</td>
                                                <td>:</td>
                                                <td><?php echo $dt_user['user_input']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Input</td>
                                                <td>:</td>
                                                <td><?php echo _format_tgl($dt_user['tgl_input']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>User Update</td>
                                                <td>:</td>
                                                <td><?php echo $dt_user['user_update']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Update</td>
                                                <td>:</td>
                                                <td><?php echo _format_tgl($dt_user['tgl_update']); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>