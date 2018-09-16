<div class="menu">
    <ul class="list">
        <li class="active">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">person</i>
                <span>Account</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="/user/address" >
                        <span>Address</span>
                    </a>
                </li>
                 <li class="active">
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
            <!-- #END# Multi Column -->
            <div align = 'center' class="block-header">
                <h1>
                  Request Card
                </h1>
            </div>

            <div class="row clearfix">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <!-- <div align = 'center' class="header">
                            <h2 style="color:#555555;font-size:26px;">
                               Credit Card
                            </h2>

                        </div> -->
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-md-3">
                                    <b>Credit Card Type*</b>
                                    <select class="form-control show-tick" id="cardtype" name="cardtype" value="<?php echo $cardtype;?>" required>
                                        <option value="MasterCard"<?=$cardtype == 'MasterCard' ? ' selected="selected"' : '';?>>MasterCard</option>
                                        <option value="Visa"<?=$cardtype == 'Visa' ? ' selected="selected"' : '';?>>Visa</option>
                                        <option value="American Express"<?=$cardtype == 'American Express' ? ' selected="selected"' : '';?>>American Express</option>
                                        <option value="Discover"<?=$cardtype == 'Discover' ? ' selected="selected"' : '';?>>Discover</option>

                                    </select>

                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                  <b>Expiration Date*</b>
                                  <select class="form-control show-tick" value="<?php echo $exmonth;?>" id="exmonth" name="exmonth" required>

                                      <option value="1"<?=$exmonth == '1' ? ' selected="selected"' : '';?>>1</option>
                                      <option value="2"<?=$exmonth == '2' ? ' selected="selected"' : '';?>>2</option>
                                      <option value="3"<?=$exmonth == '3' ? ' selected="selected"' : '';?>>3</option>
                                      <option value="4"<?=$exmonth == '4' ? ' selected="selected"' : '';?>>4</option>
                                      <option value="5"<?=$exmonth == '5' ? ' selected="selected"' : '';?>>5</option>
                                      <option value="6"<?=$exmonth == '6' ? ' selected="selected"' : '';?>>6</option>
                                      <option value="7"<?=$exmonth == '7' ? ' selected="selected"' : '';?>>7</option>
                                      <option value="8"<?=$exmonth == '8' ? ' selected="selected"' : '';?>>8</option>
                                      <option value="9"<?=$exmonth == '9' ? ' selected="selected"' : '';?>>9</option>
                                      <option value="10"<?=$exmonth == '10' ? ' selected="selected"' : '';?>>10</option>
                                      <option value="11"<?=$exmonth == '11' ? ' selected="selected"' : '';?>>11</option>
                                      <option value="12"<?=$exmonth == '12' ? ' selected="selected"' : '';?>>12</option>
                                  </select>
                                </div>
                                <div class="col-md-2" style="padding-top:20px;">
                                  <?php $year = date("Y"); ?>
                                  <select class="form-control show-tick" value="<?php echo $exyear;?>" id="exyear" name="exyear" required>
                                      <option value="<?php echo $year - 1; ?>"<?=$exyear == '<?php echo $year - 1; ?>' ? ' selected="selected"' : '';?>>
                                        <?php echo $year - 1; ?></option>
                                      <option value="<?php echo $year; ?>"<?=$exyear == '<?php echo $year; ?>' ? ' selected="selected"' : '';?>>
                                        <?php echo $year; ?></option>
                                      <option value="<?php echo $year + 1; ?>"<?=$exyear == '<?php echo $year + 1; ?>' ? ' selected="selected"' : '';?>>
                                        <?php echo $year + 1; ?></option>
                                      <option value="<?php echo $year + 2; ?>"<?=$exyear == '<?php echo $year + 2; ?>' ? ' selected="selected"' : '';?>>
                                        <?php echo $year + 2; ?></option>
                                      <option value="<?php echo $year + 3; ?>"<?=$exyear == '<?php echo $year + 3; ?>' ? ' selected="selected"' : '';?>>
                                        <?php echo $year + 3; ?></option>

                                  </select>
                                </div>
                                  <div class="col-md-1"></div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-md-5">
                                    <b>Credit Card Number*</b>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">credit_card</i>
                                            </span>
                                            <div class="form-line">
                                                <input type="text" class="form-control date" value="<?php echo $cardnumber;?>" id="cardnumber" name="cardnumber" required>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                     <b>Card Verification Number*</b>
                                      <div class="input-group">
                                        <div class="form-line">
                                            <input type="password" class="form-control date" value="<?php echo $password;?>" id="password" name="password" required>
                                        </div>
                                      </div>

                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                  <input type="checkbox" id="md_checkbox_1" class="chk-col-green"/>
                                  <label for="md_checkbox_1">By checking and by clicking</label>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-8"></div>
                                <div class="col-md-3" align="right">
                                   <button type="button" onclick="save();" class="btn btn-lg waves-effect"
                                   style="background:#FA9000;color:#FFFFFF;font-size:16px;"><b>Save Card</b></button>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
            </div>

            <div class="row clearfix">
                 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <!-- <div align = 'center' class="header">
                            <h2 style="color:#555555;font-size:26px;">
                                Payment
                            </h2>
                        </div> -->
                        <div class="body">

                            <div class="row clearfix">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <img align="center" class="img-responsive" src="/includes/kawnaintv/images/paypal.png">
                                </div>
                                 <div class="col-md-1"></div>
                                <div class="col-md-5">
                                     <p>#B-0243656326965326(USD)</p>
                                     <p>#B-0243656326965326(USD)</p>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6"></div>
                                <div class="col-md-5" align="right">
                                   <button type="button" onclick="window.open('https://www.paypal.com/cgi-bin/webscr','_blank')" class="btn btn-lg waves-effect"
                                   style="background:#FA9000;color:#FFFFFF;font-size:16px;"><b>Add Another Payment Method</b></button>
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
     function save()
     {
           var dataString = '&cardtype=' + document.getElementById('cardtype').value + '&cardnumber=' + document.getElementById('cardnumber').value +
                   '&exmonth=' + document.getElementById('exmonth').value + '&exyear=' + document.getElementById('exyear').value +
                   '&password=' + document.getElementById('password').value + '&md_checkbox_1=' + document.getElementById('md_checkbox_1').value;

            $.ajax({
                type: "post",
                url:"/user/card/datasave",
                data: dataString,
                success: function(response){
                  alert("Card information updated");

                }
            });
     }
     </script>
    </section>
