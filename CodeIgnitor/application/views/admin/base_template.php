<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome | Kawnain Admin Panel</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url(); ?>includes/AdminBSB/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">

    <!-- Font-Awesome Css -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/light-gallery/css/lightgallery.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/waitme/waitMe.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/nouislider/nouislider.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/css/themes/all-themes.css" rel="stylesheet" />
    <!-- Add fancyBox main CSS files -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>includes/AdminBSB/plugins/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <!-- VideoJS -->
    <link href="<?php echo base_url(); ?>includes/kawnaintv/videojs/video-js.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>includes/AdminBSB/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/kawnaintv/css/style.css" rel="stylesheet">

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery/jquery.min.js"></script>
    <!--<script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery/jquery-1.7.1.min.js"></script>-->

</head>

<body class="theme-black">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
           <?php //echo $banner ; ?>
        <section>
        <!-- Left Sidebar -->
           <?php echo $menu ; ?>
        <!-- Right Sidebar -->
           <?php echo $sider ; ?>
        </section>
        <!-- #END# Right Sidebar -->
        <?php echo $content ; ?>
    <!-- footer start  -->
        <?php echo $footer ; ?>
    <!-- footer end  -->

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <!-- Select Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/node-waves/waves.js"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-countto/jquery.countTo.js"></script>
    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/morrisjs/morris.js"></script>
    <!-- ChartJs -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/chartjs/Chart.bundle.js"></script>
    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/flot-charts/jquery.flot.time.js"></script>
    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-sparkline/jquery.sparkline.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/light-gallery/js/lightgallery-all.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/pages/medias/image-gallery.js"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/pages/tables/jquery-datatable.js"></script>
    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/pages/index.js"></script>
    <!-- Moment Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/momentjs/moment.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!--<script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-select/js/bootstrap-select.js"></script>-->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/nouislider/nouislider.js"></script>
    <!--<script src="<?php echo base_url(); ?>includes/AdminBSB/js/pages/forms/basic-form-elements.js"></script>-->
    <!-- card js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/waitme/waitMe.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/pages/cards/colored.js"></script>
    <!-- Demo Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/demo.js"></script>
    <!-- Add fancyBox main JS files -->
    <script type="text/javascript" src="<?php echo base_url(); ?>includes/AdminBSB/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <!-- VideoJS -->
    <script src="<?php echo base_url(); ?>includes/kawnaintv/videojs/video.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/videojs/videojs-contrib-hls.js"></script>
    <!-- my custom js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/script.js"></script>

</html>
