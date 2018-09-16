<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Sign In | Bootstrap Based Admin Template - Material Design</title>

   <link rel="icon" href="/includes/AdminBSB/favicon.ico" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">


    <link href="/includes/AdminBSB/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/includes/AdminBSB/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <link href="/includes/AdminBSB/plugins/node-waves/waves.css" rel="stylesheet" />


    <link href="/includes/AdminBSB/plugins/animate-css/animate.css" rel="stylesheet" />
    <link href="/includes/AdminBSB/css/style.css" rel="stylesheet">



   <link href="/includes/AdminBSB/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />
   <link href="/includes/AdminBSB/plugins/dropzone/dropzone.css" rel="stylesheet">
   <link href="/includes/AdminBSB/plugins/multi-select/css/multi-select.css" rel="stylesheet">
   <link href="/includes/AdminBSB/plugins/jquery-spinner/css/bootstrap-spinner.css" rel="stylesheet">
   <link href="/includes/AdminBSB/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">
   <link href="/includes/AdminBSB/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
   <link href="/includes/AdminBSB/plugins/nouislider/nouislider.min.css" rel="stylesheet" />
   <link href="/includes/AdminBSB/css/themes/all-themes.css" rel="stylesheet" />



    <link href="/includes/kawnaintv/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/includes/kawnaintv/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/includes/kawnaintv/css/nivo-slider.css" rel="stylesheet">
    <link href="/includes/kawnaintv/css/lightslider.css" rel="stylesheet">
    <link href="/includes/kawnaintv/css/style.css" rel="stylesheet">
    <link href="/includes/kawnaintv/css/animate.min.css" rel="stylesheet">
</head>

<body class="loginbody">
 <div class="secret-page">
    <div class="login-box">
        <div class="card">
            <div class="body" style="padding:50px;50px;">
               <form id="secretform" name ="secretform" method="post" action="/user/card/secretcard" >
                 <input type="hidden" name="backvalue" id="backvalue" value="0">
              <div class="row" style="font-size:20px;">
                <div class="col-md-3"></div>
                <div class="col-md-6"><p align='center'>Verify your account</p></div>
                <div class="col-md-3"></div>
              </div>
                    <div class="row" style="padding-top:10px;"><p>Your card information is used for the account verification purposes only.
                      It will not be charged now or in the future.</p> </div>


                  <div class="row" style="margin-top:20px;" >
                    <div class="col-md-6">
                                    <div>
                                      <p><b>Credit Card Number*</b></p>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" id="cardnumber" name="cardnumber" required onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                    </div>
                    <div class="col-md-6">
                                   <p>
                                       <b>Credit Card Type*</b>
                                   </p>
                                   <select class="form-control show-tick" id="cardtype" name="cardtype" required>
                                       <option>MasterCard</option>
                                       <option>Visa</option>
                                       <option>American Express</option>
                                       <option>Discover</option>
                                   </select>

                    </div>
                  </div>

                  <div class="row" style="margin-top:20px;" >
                    <div class="col-md-3">
                                        <b>Expiration</b>
                                        <select class="form-control show-tick" id="exmonth" name="exmonth" required>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                        </select>
                    </div>
                    <div class="col-md-3">
                                    <b>Date*</b>
                                        <select class="form-control show-tick" id="exyear" name="exyear" required>
                                            <option><?php echo date("Y") - 1; ?></option>
                                            <option><?php echo date("Y"); ?></option>
                                            <option><?php echo date("Y") + 1; ?></option>
                                            <option><?php echo date("Y") + 2; ?></option>
                                            <option><?php echo date("Y") + 3; ?></option>
                                        </select>
                    </div>

                    <div class="col-md-6">
                                    <!-- <div> -->
                                      <b>Secret code*</b>
                                        <div class="form-line">
                                            <input type="password" class="form-control date" id="password" name="password" required>
                                        </div>
                                    <!-- </div> -->
                    </div>
                  </div>

                    <div style="margin-top:25px" >

                    <table width="100%">
                        <tr>
                          <td width="33%"><button type="button" class="loginbackbtn" onclick="register_step();"></button></td>
                          <td width="34%" align="center"><button type="submit" class="registerbtn" style="background-color:#0000FF;align:center"></button></td>
                          <td width="33%" align="right"></td>
                        </tr>

                    </table>

                  </div>


           </form>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
            <a href="/user/login/masjid_view">
              <p align="center" style="font-size:20px;color:#FFF;">Back to website</p>
            </a>
      </div>
      <div class="col-md-4"></div>
    </div>
</div>
<script type="text/javascript">
   function register_step(){
         document.getElementById("backvalue").value = "1";
         document.getElementById("secretform").submit();
      }
      function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
          }
          return true;
      }
</script>
<!--
<script type="text/javascript">
function save()
{
      var dataString = '&cardnumber=' + document.getElementById('cardnumber').value + '&cardtype=' + document.getElementById('cardtype').value +
              '&firstname=' + document.getElementById('firstname').value + '&lastname=' + document.getElementById('lastname').value +
              '&exmonth=' + document.getElementById('exmonth').value + '&exyear=' + document.getElementById('exyear').value
              + '&password=' + document.getElementById('password').value;

       $.ajax({
           type: "post",
           url:"/index.php/user/login/creditinfo",
           data: dataString,
           success: function(response){
             alert("Card information is register");

           }
       });
}
</script>  -->
    <!-- Jquery Core Js -->
    <script src="/includes/AdminBSB/plugins/jquery/jquery.min.js"></script>
    <script src="/includes/AdminBSB/plugins/bootstrap/js/bootstrap.js"></script>
    <script src="/includes/AdminBSB/plugins/node-waves/waves.js"></script>
    <script src="/includes/AdminBSB/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script src="/includes/AdminBSB/plugins/jquery-validation/jquery.validate.js"></script>
    <script src="/includes/AdminBSB/js/pages/forms/advanced-form-elements.js"></script>
    <script src="/includes/AdminBSB/js/admin.js"></script>
    <script src="/includes/AdminBSB/js/pages/examples/sign-in.js"></script>

    <script src="/includes/AdminBSB/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <script src="/includes/AdminBSB/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
    <script src="/includes/AdminBSB/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <script src="/includes/AdminBSB/plugins/dropzone/dropzone.js"></script>
    <script src="/includes/AdminBSB/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script src="/includes/AdminBSB/plugins/multi-select/js/jquery.multi-select.js"></script>
    <script src="/includes/AdminBSB/plugins/jquery-spinner/js/jquery.spinner.js"></script>
    <script src="/includes/AdminBSB/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
    <script src="/includes/AdminBSB/plugins/nouislider/nouislider.js"></script>
    <script src="/includes/AdminBSB/js/demo.js"></script>


    <script src="/includes/kawnaintv/js/jquery-1.7.1.min.js"></script>
    <script src="/includes/kawnaintv/bootstrap/js/bootstrap.min.js"></script>
    <script src="/includes/kawnaintv/js/jquery.nivo.slider.js" type="text/javascript"></script>
    <script src="/includes/kawnaintv/js/lightslider.js" type="text/javascript"></script>
    <!-- <script src="js/script.js"></script> -->
    <script src="/includes/kawnaintv/js/jquery.js"></script>
    <script src="/includes/kawnaintv/js/bootstrap.min.js"></script>
    <script src="/includes/kawnaintv/js/jquery.prettyPhoto.js"></script>
    <script src="/includes/kawnaintv/js/jquery.isotope.min.js"></script>
    <script src="/includes/kawnaintv/js/main.js"></script>
    <script src="/includes/kawnaintv/js/wow.min.js"></script>

</body>

</html>
