<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | Kawnain</title>

   <link rel="icon" href="<?php echo base_url(); ?>includes/AdminBSB/favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
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
    <div class="container-fluid headerTopDiv">
        <div class="row">
            <div class="headerMenuColDiv">
                <button type="button" class="btn headerMenuHideBtn" id="headerMenuHideBtn" data-toggle="button" aria-pressed="false" autocomplete="off">  &#9776; </button>
                <ul id="headerMenuUL" class="headerMenuUL">
                    <li><a href="/user/login/homeload">Home</a></li>
                    <li><a href="/user/login/masjid_view">Connect to your Masjid</a></li>
                    <li><a href="#">Partners</a></li>
                    <li><a href="#">Kawnain TV</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="/user/login/signup">SignUp</a></li>
                </ul>

            </div>
        </div>
    </div>
 <div class="login-page">
    <div class="login-box">
        <div class="card">
            <div class="body">
                <form id="loginform" name ="loginform" method="post" action="/user/login/menu" >
              <!--  <form id="sign_in" method="POST">  -->
                    <div class="msg">Sign in to start your session</div>
                    <div class="input-group" style="margin-bottom: 20px">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="username" placeholder="Username" type="text" />
                <span class="text-danger"><?php echo form_error('username'); ?></span>
                        </div>
                    </div>
                    <div class="input-group" style="margin-bottom: 20px">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password" type="text" />
                <span class="text-danger"><?php echo form_error('password'); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="/user/login/signup">Register Now!</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="/user/login/fotget">Forgot Password?</a>
                        </div>
                    </div>

            </form>
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
