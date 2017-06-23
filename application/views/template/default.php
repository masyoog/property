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
    <body class="menubar-hoverable header-fixed menubar-pin">

        <!-- BEGIN HEADER-->
        <header id="header" class="header-inverse">
            <div class="headerbar">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="headerbar-left">
                    <ul class="header-nav header-nav-options">
                        <li class="header-nav-brand" >
                            <div class="brand-holder">
                                <a href="<?php echo base_url(); ?>">
                                    <span class="text-lg text-bold text-primary"><?php echo $this->config->item('lisensi');?></span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="headerbar-right">
                    <ul class="header-nav header-nav-options">
                        <li class="dropdown hidden-xs">
                            <a href="<?php echo base_url(); ?>konfirmasi_aktivasi" class="btn btn-icon-toggle btn-default" title="Konfirmasi Aktivasi">
                                <i class="fa fa-check-square-o"></i><sup class="badge style-danger" id="total_aktivasi"></sup>
                            </a>
                        </li><!--end .dropdown -->
                        <li class="dropdown hidden-xs">
                            <a href="<?php echo base_url(); ?>withdraw" class="btn btn-icon-toggle btn-default" title="Request Withdraw">
                                <i class="fa fa-credit-card"></i><sup class="badge style-danger" id="total_withdraw"></sup>
                            </a>
                        </li><!--end .dropdown -->
                        <li class="dropdown hidden-xs">
                            <a href="<?php echo base_url(); ?>topup" class="btn btn-icon-toggle btn-default" title="Konfirmasi Topup Saldo">
                                <i class="fa fa-money"></i><sup class="badge style-danger" id="total_topup"></sup>
                            </a>
                        </li><!--end .dropdown -->
                        <li class="dropdown hidden-xs">
                            <a href="<?php echo base_url(); ?>testimonial" class="btn btn-icon-toggle btn-default" title="Pending Testimonial">
                                <i class="fa fa-comments"></i><sup class="badge style-danger" id="total_testimonial"></sup>
                            </a>
                        </li><!--end .dropdown -->
                        <li class="dropdown hidden-xs">
                            <a href="<?php echo base_url(); ?>komplain" class="btn btn-icon-toggle btn-default" title="Komplain Member">
                                <i class="fa fa-warning"></i><sup class="badge style-danger" id="total_komplain"></sup>
                            </a>
                        </li><!--end .dropdown -->
                    </ul><!--end .header-nav-options -->
                    <ul class="header-nav header-nav-profile">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                                <span class="profile-info">
                                    <strong><?php echo ucwords($nama);?></strong>
                                    <small><?php echo ucwords($nama_group);?></small>
                                </span>
                            </a>
                            <ul class="dropdown-menu animation-dock">
                                <li><a href="<?php echo base_url().'profile'; ?>">My Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url()?>index/logout"><i class="fa fa-fw fa-power-off text-danger"></i> Log Out</a></li>
                            </ul><!--end .dropdown-menu -->
                        </li><!--end .dropdown -->
                    </ul><!--end .header-nav-profile -->
                </div><!--end #header-navbar-collapse -->
            </div>
        </header>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">

            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">
            </div><!--end .offcanvas-->
            <!-- END OFFCANVAS LEFT -->

            <!-- BEGIN CONTENT-->
            <div id="content">
                <?php echo $contents; ?>
            </div><!--end #content-->
            <!-- END CONTENT -->

            <!-- BEGIN MENUBAR-->
            <div id="menubar" class="menubar-inverse ">
                <div class="menubar-fixed-panel">
                    <div>
                        <a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="expanded">
                        <a href="<?php echo base_url(); ?>">
                            <span class="text-lg text-bold text-primary "><?php echo ucwords(strtolower($this->config->item('lisensi')));?></span>
                        </a>
                    </div>
                </div>
                <div class="menubar-scroll-panel">

                    <!-- BEGIN MAIN MENU -->
                    <ul id="main-menu" class="gui-controls">
                    <?php 
                    if(!empty($menu)) echo $menu;
                    ?>
                    </ul>
                    <!-- END MAIN MENU -->
                    <div class="menubar-foot-panel">
                        <small class="no-linebreak hidden-folded">
                            <span class="opacity-75">&copy; 2016 <strong><?php echo $this->config->item('lisensi'); ?></strong></span>
                        </small>
                    </div>
                </div>
            </div>
            <!-- END MENUBAR -->

        </div><!--end #base-->
        <!-- END BASE -->

        <!-- BEGIN JAVASCRIPT -->
        <script src="<?php echo base_url("assets/js/libs/jquery/jquery-1.11.2.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/jquery/jquery-migrate-1.2.1.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/bootstrap/bootstrap.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/spin.js/spin.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/autosize/jquery.autosize.min.js");?>"></script>
        <script src="<?php echo base_url("assets/js/libs/nanoscroller/jquery.nanoscroller.min.js");?>"></script>
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
        <script src="<?php echo base_url("assets/js/pages/default.js");?>"></script>
        <script>
            jQuery(document).ready(function() {
                My.init();
                Default.init();
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
