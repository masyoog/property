<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->config->item("app_name").' - '.$title; ?></title>

        <!-- BEGIN META -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="your,keywords">
        <meta name="description" content="Short explanation about this website">
        <!-- END META -->

        <!-- BEGIN STYLESHEETS -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/theme-default/bootstrap.css");?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/theme-default/materialadmin.css");?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/theme-default/font-awesome.min.css");?>" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/theme-default/material-design-iconic-font.min.css");?>" />
        <?php
        if(!empty($css)){
            foreach($css as $val){
        ?>
        <link href="<?php echo $val ?>" rel="stylesheet" type="text/css"/>
        <?php
            }
        }
        ?>
        <!-- END STYLESHEETS -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script type="text/javascript" src="<?php echo base_url("assets/js/libs/utils/html5shiv.js");?>"></script>
        <script type="text/javascript" src="<?php echo base_url("assets/js/libs/utils/respond.min.js");?>"></script>
        <![endif]-->
    </head>
    <body class="menubar-hoverable header-fixed ">

        <!-- BEGIN LOGIN SECTION -->
        <section class="section-account">
            <div class="spacer"></div>
            <div class="card contain-sm style-transparent">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-md-offset-3">
                            <br/>
                            <span class="text-lg text-bold text-primary">LOGIN <?php echo $this->config->item('lisensi');?></span>
                            <br/>
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
                            <br/>
                            <form class="form floating-label form-validate" novalidate="novalidate" action="<?php echo base_url("index");?>" accept-charset="utf-8" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="username" name="username" autocomplete="off" required>
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password" autocomplete="off" required>
                                    <label for="password">Password</label>
                                </div>
                                <br/>
                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                        &nbsp;
                                    </div><!--end .col -->
                                    <div class="col-xs-6 text-right">
                                        <button class="btn btn-primary btn-raised ink-reaction" type="submit">Login</button>
                                    </div><!--end .col -->
                                </div><!--end .row -->
                            </form>
                        </div><!--end .col -->
                    </div><!--end .row -->
                </div><!--end .card-body -->
            </div><!--end .card -->
        </section>
        <!-- END LOGIN SECTION -->

        <!-- BEGIN JAVASCRIPT -->
        <script src="<?php echo base_url("assets/js/libs/jquery/jquery-1.11.2.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/jquery/jquery-migrate-1.2.1.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/bootstrap/bootstrap.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/spin.js/spin.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/autosize/jquery.autosize.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/nanoscroller/jquery.nanoscroller.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/jquery-validation/dist/jquery.validate.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/jquery-validation/dist/additional-methods.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/App.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/AppNavigation.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/AppOffcanvas.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/AppCard.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/AppForm.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/AppNavSearch.js");?>"></script>
        <script src="<?php echo base_url("assets/js/core/source/AppVendor.js");?>"></script>
        <?php
        if(!empty($js)){
            foreach($js as $val){
        ?>
        <script src="<?php echo $val ?>" type="text/javascript"></script>
        <?php
            }
        }
        ?>
        <script src="<?php echo base_url("assets/js/my.js");?>"></script>
        <script>
            jQuery(document).ready(function() {
                My.init();
                <?php
                if(!empty($js_init)){
                    echo $js_init;
                }
                ?>
            });
            var site = "<?php echo base_url();?>";
        </script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
