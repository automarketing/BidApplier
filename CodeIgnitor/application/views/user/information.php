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
   <div><img src="/includes/kawnaintv/images/menu/inforheader.png"></div>
    <div class="login-box">
        <div class="card" style="border-radius: 0px 0px 8px 8px;background-color:#F5F5F5;">
            <div class="body">
              <div class="row clearfix"  style="margin-left:30px;margin-right:30px">

               <form id="secretform" name ="secretform" method="post" action="/user/address/infordata" >
                <input type="hidden" name="backvalue" id="backvalue" value="0">
                 <div class="row" style="margin-top:20px;" >
                   <div class="col-md-5">
                       <div>
                           <div class="form-line">
                               <input type="text" class="form-control date" id="firstname" name="firstname" placeholder="First Name" required>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-2"></div>
                   <div class="col-md-5">
                       <div>
                           <div class="form-line">
                               <input type="text" class="form-control date" id="lastname" name="lastname" placeholder="Last Name" required>
                           </div>
                       </div>
                   </div>
                 </div>

                 <div class="row" style="margin-top:10px;" >
                   <div class="col-md-5">
                       <div>
                         <select name="country" id="country" class="form-control" onchange="countrydatavalue();">
                             <option value="">--- Country ---</option>
                             <?php foreach($countryDataResult as $countryData){ ?>
                             <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                             <?php } ?>
                         </select>
                       </div>
                   </div>
                   <div class="col-md-2"></div>
                   <div class="col-md-5">
                       <div>
                         <select name="state" id="state" class="form-control" onchange="statedatavalue();">
                         </select>
                       </div>
                   </div>
                 </div>

                 <div class="row" style="margin-top:10px;" >
                   <div class="col-md-5">
                       <div>
                         <select name="city" id="city" class="form-control">
                         </select>
                       </div>
                   </div>
                   <div class="col-md-2"></div>
                   <div class="col-md-5">
                       <div>
                            <div class="form-line">
                                <input type="text"  class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode" >
                            </div>
                       </div>
                   </div>
                 </div>

                  <div class="row" style="margin-top:10px;" >
                    <div class="col-md-5">
                        <div>
                            <div class="form-line">
                                <input type="text" class="form-control date" id="biaddr" name="biaddr" placeholder="Billing Address" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                          <div>
                              <div class="form-line">
                                  <input type="text" class="form-control date" id="appart" name="appart" placeholder="Appartment" required>
                              </div>
                          </div>
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
         document.getElementById("backvalue").value ="1";
         document.getElementById("secretform").submit();
      }

      function countrydatavalue()
      {
        var countryID = $("#country").val();
        //  alert(countryID);
        if(countryID != ""){
              $.ajax({
                  url: "<?php echo site_url('user/address/getSateByCountry'); ?>",
                  type: 'POST',
                  dataType: 'json',
                  data: {countryID: countryID},
                  success: function(data){
                    var stateOptionStr = "<option value=''>--- State ---</option>";
                    $.each(data.stateDataArr, function(index, val) {
                       /* iterate through array or object */
                       stateOptionStr += "<option value='"+val.id+"'>"+val.state+"</option>";
                    });
                    $("#state").empty();
                    $("#state").html(stateOptionStr);
                        $("#state").selectpicker('refresh');
                  },
                  error: function(xhr, status, error){
                      alert("Error: "+status);
                  }
              });
        }
      }

        function statedatavalue()
        {
        var stateID = $("#state").val();

            if(stateID != ""){
                $.ajax({
                    url: "<?php echo site_url('user/address/getCityByState'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {stateID: stateID},
                    success: function(data){
                        var cityOptionStr = "<option value=''>--- City ---</option>";
                        $.each(data.cityDataArr, function(index, val) {
                             /* iterate through array or object */
                             cityOptionStr += "<option value='"+val.id+"'>"+val.city+"</option>";
                        });
                        $("#city").empty();
                        $("#city").html(cityOptionStr);
                        $("#city").selectpicker('refresh');
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
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
