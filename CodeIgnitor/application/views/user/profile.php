<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | Kawnain</title>
    <!-- Favicon-->
    <link rel="icon" href="/includes/AdminBSB/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="/includes/AdminBSB/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/includes/AdminBSB/plugins/node-waves/waves.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/morrisjs/morris.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/light-gallery/css/lightgallery.css" rel="stylesheet">
    <link href="/includes/AdminBSB/css/style.css" rel="stylesheet">
    <link href="/includes/AdminBSB/plugins/waitme/waitMe.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
    <link href="/includes/AdminBSB/plugins/nouislider/nouislider.min.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="/includes/AdminBSB/css/themes/all-themes.css" rel="stylesheet" />
    <link href="/includes/kawnaintv/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/includes/kawnaintv/css/nivo-slider.css" rel="stylesheet">
    <link href="/includes/kawnaintv/css/lightslider.css" rel="stylesheet">
    <link href="/includes/kawnaintv/videojs/video-js.css" rel="stylesheet">

    <!-- Add fancyBox main CSS files -->
    <link rel="stylesheet" type="text/css" href="/includes/kawnaintv/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link href="/includes/kawnaintv/css/style.css" rel="stylesheet">



  <!-- secret part css -->
 <link href="/includes/AdminBSB/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />
 <link href="/includes/AdminBSB/plugins/dropzone/dropzone.css" rel="stylesheet">
 <link href="/includes/AdminBSB/plugins/multi-select/css/multi-select.css" rel="stylesheet">
 <link href="/includes/AdminBSB/plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">
  <!-- -->

</head>

<body>

<section>
<form action="/user/login/update" method="post" enctype="multipart/form-data">
        <div class="row">
          <div align="center">
               <?php
               if($pro_image !="")
                  echo '<img id="image" name="image" align="center" style="margin-top:10px;" alt="User Image" width="250" height="250" src="data:image/jpeg;base64,'.base64_encode( $pro_image ).'"/>';
               else
                  echo '<img id="image" name="image" align="center" style="margin-top:10px;" alt="User Image" width="250" height="250" src="/images/default.png"/>';
               ?>
        </div>
      </div>
        <div class="row" style="padding-top:30px;">
             <div class="pull-left" style="padding-left:40px;">
                 <input type="file" id="photo_file" name="photo_file" class="btn btn-default waves-effect">
             </div>
             <div class="pull-right" style="padding-right:40px;">
                 <input class="btn bg-blue waves-effect" type="submit" value="Upload image" name="submit">
             </div>
        </div>
</form>
</section>

<script>
document.getElementById("photo_file").onchange = function () {
    var reader = new FileReader();
    reader.onload = function (e)
	  {
        document.getElementById("image").src = e.target.result;
    };
    reader.readAsDataURL(this.files[0]);
};

</script>
</body>
</html>
