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
