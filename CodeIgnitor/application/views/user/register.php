<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Register | Kawnain</title>

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
 <div class="register-page">
   <div><img src="/includes/kawnaintv/images/menu/topheader.png"></div>
    <div class="login-box">
        <div class="card" style="border-radius: 0px 0px 8px 8px;background-color:#F5F5F5;">
            <div class="body" style="padding:50px;50px;">
              <div class="row clearfix">
                <div class="col-md-6" style="padding-right:50px;border-right:1px solid #C9C9C9;">
                  <form id="loginform" name ="loginform" method="post" action="/user/login/menu" >

                      <!-- <div class="input-group" > -->
                          <div class="form-line" style="margin-bottom: 40px;margin-top:20px;">
                              <input type="text" class="form-control date" name="username" placeholder="Username" type="text" required/>
                  <span class="text-danger"><?php echo form_error('username'); ?></span>
                          </div>
                      <!-- </div> -->
                      <!-- <div class="input-group" > -->
                          <div class="form-line" style="margin-bottom: 20px">
                              <input type="password" class="form-control date" name="password" placeholder="Password" type="text" required/>
                  <span class="text-danger"><?php echo form_error('password'); ?></span>
                          </div>
                      <!-- </div> -->
                      <div class="row">
                          <div class="col-xs-8 p-t-5">
                              <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-orange">
                              <label for="rememberme">Remember Me</label>
                          </div>
                          <div class="col-xs-4">
                              <!-- <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button> -->
                          </div>
                      </div>
                      <div class="row m-t-15 m-b--20" style="padding-top:20px;">
                          <div class="col-xs-6">
                              <!-- <a href="/user/login/signup" style="color:#FA9000;">Register Now!</a> -->
                          </div>
                          <div class="col-xs-6 align-right">
                              <a href="/user/login/fotget" style="color:#FA9000;">Forgot Password?</a>
                          </div>
                      </div>
                      <div class="row" style="padding-top:35px;">
                        <div class="col-md-3"></div>
                              <button type="submit" class="loginbtn"></button>
                      </div>

              </form>
                </div>
                <div class="col-md-6" style="border-left:1px solid #FFF;padding-left:50px;">
               <form id="secretform" name ="secretform" method="post" action="/user/login/creditinfo" >

              <!-- <div class="row" style="font-size:20px;">
                <div class="col-md-3"></div>
                <div class="col-md-6"><p align='center'>Verify your account</p></div>
                <div class="col-md-3"></div>
              </div> -->
                    <!-- <div class="row" style="padding-top:20px;"></div> -->

                      <!-- <div class="row" style="margin-top:20px;" >
                        <div class="col-md-6"> -->
                                <div class="form-line" style="margin-top:20px;">
                                    <input type="text" class="form-control date" id="username" name="username" placeholder="Username" required>
                                </div>
                        <!-- </div>
                        <div class="col-md-6"> -->
                          <div class="form-line" style="margin-top:20px;">
                              <input type="password" class="form-control date" id="password" name="password" placeholder="Password" required>
                          </div>
                          <div class="form-line" style="margin-top:20px;">
                              <input type="password" class="form-control date" id="repassword" name="repassword" placeholder="Confirm Password" required>
                          </div>
                          <div id="errortext" style="display:none;">Please enter the same value again.</div>
                        <!-- </div>
                      </div>
                      <div class="row" style="margin-top:20px;">
                         <div class="col-md-6"> -->
                             <div class="form-line" style="margin-top:20px;">
                                 <input type="text" class="form-control email" id="email" name="email" placeholder="Email" required>
                             </div>
                             <div class="form-line" style="margin-top:20px;">
                                   <!-- <div class="form-line" style="margin-top:20px;"> -->
                                       <input type="text" class="form-control mobile-phone-number" id="phone" name="phone" placeholder="Phone Number" required onkeypress="return isNumber(event)">
                                   <!-- </div> -->
                             </div>
                         <!-- </div>
                         <div class="col-md-6">
                                <div class="form-line">
                                    <input type="text" class="form-control date" id="cardnumber" name="cardnumber" placeholder="Cardnumber" required>
                                </div>
                         </div>
                      </div>
                  <div class="row" style="margin-top:20px;" >
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
                    <div class="col-md-6">
                                    <div>
                                      <p><b>Secret code*</b></p>
                                        <div class="form-line">
                                            <input type="password" class="form-control date" id="secretcode" name="secretcode" required>
                                        </div>
                                    </div>
                    </div>
                  </div>
                  <div class="row" style="margin-top:20px;" >
                    <div class="col-md-6">
                                    <div>
                                      <p><b>First Name*</b></p>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" id="firstname" name="firstname" required>
                                        </div>
                                    </div>
                    </div>
                    <div class="col-md-6">
                                    <div>
                                      <p><b>Last Name*</b></p>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" id="lastname" name="lastname" required>
                                        </div>
                                    </div>
                    </div>
                  </div>
                  <div class="row" style="margin-top:20px;" >
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                                    <b>Date*</b>
                                        <select class="form-control show-tick" id="exyear" name="exyear" required>
                                            <option><?php echo date("Y") - 1; ?></option>
                                            <option><?php echo date("Y"); ?></option>
                                            <option><?php echo date("Y") + 1; ?></option>
                                            <option><?php echo date("Y") + 2; ?></option>
                                            <option><?php echo date("Y") + 3; ?></option>
                                        </select>
                    </div>


                  </div> -->

                    <div class="row" style="padding-top:30px;">
                      <div class="col-md-3"></div>
                      <div>
                            <button type="button" onclick="signup_result();" class="registerbtn"></button>
                      </div>
                    </div>


           </form>
         </div>
     </div>
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

function signup_result(){

    var x = document.getElementById('errortext');
    var userName = document.getElementById('username').value;
    var userPassword = document.getElementById('password').value;
    var confirmPassword = document.getElementById('repassword').value;
    var userMail = document.getElementById('email').value;
    var userPhoneNum = document.getElementById('phone').value;


    if(userName =="" ||  userPassword ==""  ||  confirmPassword =="" ||  userMail ==""  ||  userPhoneNum ==""){
        alert("Please enter user data.");
        return false;
    }

    if (!checkPassword(userPassword , confirmPassword)) {
        x.style.display = "block";
        return false;
    };

    if (!checkMail(userMail)) {
        alert("Your mail is not correct. Please try again.");
        return false;
    };
    document.getElementById("secretform").submit();
}

function checkMail(){

    var mailStr = document.getElementById('email').value;
    //return mailStr.includes("@") > 0 ? true: false;

    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(mailStr);
}

function checkPassword(pass , confirmpassword){

    if (pass.length < 8) {
        alert("Password length is less than 8. Please try again.");
        return false;
    }
    if (pass != confirmpassword) {
        alert("Your password and confirmation password do not match. Please try again.");
        return false;
    };
    return true;
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
