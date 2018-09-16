<div class="menu">
    <ul class="list">
        <li class="active">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">person</i>
                <span>Account</span>
            </a>
            <ul class="ml-menu">
                <li class="active">
                    <a href="/user/address" >
                        <span>Address</span>
                    </a>
                </li>
                 <li>
                    <a href="/user/card">
                        <span>Card</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">video_library</i>
                <span>Play</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="/user/play_live">Live</a>
                </li>
                <li>
                    <a href="/user/play_masjid">Masjid</a>
                </li>
                <li>
                    <a href="/user/play_vod">VOD</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">web</i>
                <span>Subscription</span>
            </a>
            <ul class="ml-menu">
                <li>
                  <a href="/user/service">Service</a>
                </li>
                <li>
                    <a href="/user/history">History</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment</i>
                <span>Ticket</span>
            </a>
            <ul class="ml-menu">
              <li>
                  <a href="/user/openticket">Open Ticket</a>
              </li>
              <li>
                  <a href="/user/openticket/list_ticket">List Ticket</a>
              </li>
                <li>
                    <a href="/user/refund">Request refund</a>
                </li>
                <li>
                    <a href="/user/openticket/tvbox_exchang">TV Box Exchange</a>
                </li>
            </ul>
        </li>

    </ul>
</div>
<!-- #Menu -->
</aside>
  </section>
﻿    <section class="content">
        <div class="container-fluid">
          <div align = 'center' class="block-header">
              <h1>
                Contact Information
              </h1>
          </div>

            <div class="row clearfix">
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <!-- <div align = 'center' class="header">
                            <h2 style="color:#555555;">
                                Contact Information
                            </h2>
                        </div> -->
                        <div class="body">
                          <form action="<?php echo site_url('user/address'); ?>" name="masjidVideoListSearchForm" id="masjidVideoListSearchForm" method="POST" class="form-inline" role="form">
                            <div class="row clearfix">
                                <div class="col-md-5">
                                    <b>First Name*</b>

                                        <div class="form-line">
                                          <input type="text" value="<?php echo $firstnm;?>" id="firstnm" name="firstnm" class="form-control" style="width:100%;">
                                        </div>

                                </div>
                                 <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <b>Last Name*</b>

                                        <div class="form-line">
                                            <input type="text" value="<?php echo $lastnm;?>" id="lastnm" name="lastnm" class="form-control" style="width:100%;">
                                        </div>

                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-md-5">
                                    <b>Company</b>

                                        <div class="form-line">
                                            <input type="text" value="<?php echo $company;?>" class="form-control" id="company" name="company" style="width:100%;">
                                        </div>

                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <b>Fax</b>

                                        <div class="form-line">
                                            <input type="text" value="<?php echo $fax;?>" class="form-control" id="fax" name="fax" style="width:100%;">
                                        </div>

                                </div>
                                <div class="col-md-1"></div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-md-5">
                                    <b>*Telephone</b>

                                        <div class="form-line">
                                            <input type="text" value="<?php echo $telephone;?>" class="form-control" id="telephone" name="telephone" style="width:100%;">
                                        </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
            </div>
            <!-- #END# Multi Column -->

            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <!-- <div align = 'center' class="header">
                            <h2 style="color:#555555;">
                               Address
                            </h2>

                        </div> -->
                        <div class="body">
                            <div class="row clearfix">
                              <div class="col-md-5">
                                   <b>*Country</b>
                                   <select name="country" id="country" class="form-control">
                                       <option value="">--- Country ---</option>
                                       <?php foreach($countryDataResult as $countryData){ ?>
                                       <option value="<?php echo $countryData['id']; ?>"<?php if($country == $countryData['id']){ ?> selected="selected"<?php } ?>><?php echo $countryData['country']; ?></option>
                                       <?php } ?>
                                   </select>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-5">
                                  <b>*State/Province</b>
                                  <select name="state" id="state" class="form-control">
                                      <option value="">--- State ---</option>
                                      <?php foreach($stateDataResult as $stateData){ ?>
                                      <option value="<?php echo $stateData['id']; ?>"<?php if($state == $stateData['id']){ ?> selected="selected"<?php } ?>><?php echo $stateData['state']; ?></option>
                                      <?php } ?>
                                  </select>
                              </div>
                              <div class="col-md-1"></div>
                            </div>

                            <div class="row clearfix">
                              <div class="col-md-5">
                                  <b>*City</b>
                                  <select name="city" id="city" class="form-control">
                                      <option value="">--- City ---</option>
                                      <?php foreach($cityDataResult as $cityData){ ?>
                                      <option value="<?php echo $cityData['id']; ?>"<?php if($city == $cityData['id']){ ?> selected="selected"<?php } ?>><?php echo $cityData['city']; ?></option>
                                      <?php } ?>
                                  </select>

                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-5">
                                   <b>*Zip/Postal Code</b>

                                      <div class="form-line">
                                          <input type="text" value="<?php echo $zipcode;?>"  class="form-control" id="zipcode" name="zipcode">
                                      </div>

                              </div>
                              <div class="col-md-1"></div>

                            </div>

                            <div class="row clearfix">
                              <div class="col-md-5">
                                  <b>*Street Address</b>

                                      <div class="form-line">
                                          <input type="text" value="<?php echo $address1;?>"  class="form-control" id="address1" name="address1">
                                      </div>

                              </div>
                            </div>

                            <div class="row clearfix">
                              <div class="col-md-5">

                                      <div class="form-line">
                                          <input type="text" value="<?php echo $address2;?>"  class="form-control" id="address2" name="address2">
                                      </div>

                              </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-5">
                                <div align="center">
                                   <button  type="button" onclick="save();" class="btn btn-lg waves-effect"
                                   style="background:#FA9000;color:#FFFFFF;font-size:16px;"><b>SAVE ADDRESS</b></button>
                               </div>
                              </div>
                              <div class="col-md-1"></div>
                            </div>

                        </div>
                    </div>
                </div>
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {

            	$("#country").on('change', function(event) {
            		event.preventDefault();

            		var countryID = $("#country").val();

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
            	});


            	$("#state").on('change', function(event) {
            		event.preventDefault();

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
            	});

            });
        </script>
        <script type="text/javascript">
        function save()
        {
              var dataString = '&firstnm=' + document.getElementById('firstnm').value + '&lastnm=' + document.getElementById('lastnm').value +
                      '&company=' + document.getElementById('company').value + '&telephone=' + document.getElementById('telephone').value +
                      '&fax=' + document.getElementById('fax').value + '&address1=' + document.getElementById('address1').value
                      + '&address2=' + document.getElementById('address2').value + '&city=' + document.getElementById('city').value
                      + '&zipcode=' + document.getElementById('zipcode').value + '&state=' + document.getElementById('state').value
                      + '&country=' + document.getElementById('country').value;
              //  alert(dataString);
               $.ajax({
                   type: "post",
                   url:"/user/address/datasave",
                   data: dataString,
                   success: function(response){
                     alert("User information updated");
                   }
               });
        }
        </script>
    </section>
