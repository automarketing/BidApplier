<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | Kawnain Admin Panel</title>

   <link rel="icon" href="<?php echo base_url(); ?>includes/AdminBSB/favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">


    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">


    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/node-waves/waves.css" rel="stylesheet" />


    <link href="<?php echo base_url(); ?>includes/AdminBSB/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>includes/AdminBSB/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>includes/kawnaintv/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/kawnaintv/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/kawnaintv/css/nivo-slider.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/kawnaintv/css/lightslider.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/kawnaintv/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>includes/kawnaintv/css/animate.min.css" rel="stylesheet">
</head>

<body class="loginbody">
    <!-- <div class="container-fluid headerTopDiv">
        <div class="row">
            <div class="col-md-9 headerMenuColDiv">
                <button type="button" class="btn headerMenuHideBtn" id="headerMenuHideBtn" data-toggle="button" aria-pressed="false" autocomplete="off">  &#9776; </button>
                <ul id="headerMenuUL" class="headerMenuUL">
                    <li><a href="<?php echo site_url('admin/login/homeload'); ?>">Home</a></li>
                    <li><a href="#">Studies</a></li>
                    <li><a href="#">Partners</a></li>
                    <li><a href="#">Kawnain TV</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="<?php echo site_url('admin/login/signup'); ?>">SignUp</a></li>
                </ul>

            </div>
            <div class="col-md-3">
                <div id="custom-search-input">
                    <div class="input-group col-md-12">
                        <input type="text" class="form-control input-md" placeholder="Search" />
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="button">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
 <div class="login-page">
    <div class="login-box">
        <div class="login-box-title"><i class="fa fa-key"></i>Login</div>
        <div class="card">
            <div class="body">
                <?php

                    $attributes = array("name" => "loginform");
                    echo form_open("/admin/login", $attributes);
                ?>

              <!--  <form id="sign_in" method="POST">  -->
                    <!-- <div class="msg">Sign in to start your session</div> -->
                    <div class="input-group" style="margin-bottom: 20px">
                        <!-- <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span> -->
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" type="text" value="<?php echo set_value('username'); ?>" />
                <span class="text-danger"><?php echo form_error('username'); ?></span>
                        </div>
                    </div>
                    <div class="input-group" style="margin-bottom: 20px">
                        <!-- <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span> -->
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" type="text" value="<?php echo set_value('password'); ?>" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12 align-right">
                            <a href="<?php echo site_url('admin/login/fotget'); ?>">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- <button class="btn btn-lg bg-orange waves-effect" type="submit">SIGN IN</button> -->
                            <button class="btn btn-lg login-btn" type="submit"></button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
              <!--  </form>  -->
            </div>
        </div>
    </div>
</div>
    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>includes/AdminBSB/js/pages/examples/sign-in.js"></script>

    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/jquery.nivo.slider.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/lightslider.js" type="text/javascript"></script>
    <!-- <script src="js/script.js"></script> -->
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/jquery.isotope.min.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/main.js"></script>
    <script src="<?php echo base_url(); ?>includes/kawnaintv/js/wow.min.js"></script>
</body>

</html>
