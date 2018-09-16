<div class="menu">
    <ul class="list">
        <li>
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
        <li class="active">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">web</i>
                <span>Subscription</span>
            </a>
            <ul class="ml-menu">
                <li class="active">
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
﻿ <section class="content">
        <div class="container-fluid">
            <div align = 'center' class="block-header">
                <h1>
                   Service
                </h1>
            </div>
            <!-- Exportable Table -->
            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div align ="center" class="card">
                        <div class="body">
                          <div class="row clearfix">
                                  <div class="col-sm-6 col-md-1"></div>
                                  <div class="col-sm-6 col-md-4">
                                      <div class="thumbnail">
                                        <?php
                                           if($service_check == '1')
                                              echo "<div id='service_check'></div>";
                                           else
                                              echo "<div style='height:15px;'></div>";
                                        ?>
                                        <img src='/includes/kawnaintv/images/studio/iptv1.jpg' />
                                          <div class="caption">
                                            <?php
                                                echo"<h3>".$server_list[0]['type']."</h3>
                                                <p>
                                                  A monthly price of TV Box and VOD
                                                </p>
                                                <p>
                                                    <button onclick='price_service(1);' class='btn btn-primary btn-lg waves-effect' role='button'
                                                     id='price1' name='price1' value='".$server_list[0]['price']."' style='font-size:20px;'>".$server_list[0]['price']." $ Buy</button>
                                                </p>"
                                             ?>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6 col-md-2"></div>
                                  <div class="col-sm-6 col-md-4">
                                      <div class="thumbnail">
                                        <?php
                                           if($service_check == '2')
                                              echo "<div id='service_check'></div>";
                                           else
                                              echo "<div style='height:15px;'></div>";
                                        ?>
                                        <img src='/includes/kawnaintv/images/studio/iptv2.jpg' />
                                          <div class="caption">
                                            <?php
                                                echo"<h3>".$server_list[1]['type']."</h3>
                                                <p>
                                                  A monthly price of TV Box and VOD
                                                </p>
                                                <p>
                                                    <button onclick='price_service(2);' class='btn btn-primary btn-lg waves-effect' role='button'
                                                    id='price2' name='price2' value='".$server_list[1]['price']."' style='font-size:20px;'>".$server_list[1]['price']." $ Buy</button>
                                                </p>"
                                             ?>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-sm-6 col-md-1"></div>
                        </div>
                        <div class="row clearfix">
                                <div class="col-sm-6 col-md-1"></div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                      <?php
                                         if($service_check == '3')
                                            echo "<div id='service_check'></div>";
                                         else
                                            echo "<div style='height:15px;'></div>";
                                      ?>
                                      <img src='/includes/kawnaintv/images/studio/iptv1.jpg' />
                                        <div class="caption">
                                          <?php
                                              echo"<h3>".$server_list[2]['type']."</h3>
                                              <p>
                                                A monthly price of TV Box and VOD
                                              </p>
                                              <p>
                                                  <button onclick='price_service(3);' class='btn btn-primary btn-lg waves-effect' role='button'
                                                  id='price3' name='price3' value='".$server_list[2]['price']."' style='font-size:20px;'>".$server_list[2]['price']." $ Buy</button>
                                              </p>"
                                           ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-2"></div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                      <?php
                                         if($service_check == '4')
                                            echo "<div id='service_check'></div>";
                                         else
                                            echo "<div style='height:15px;'></div>";
                                      ?>
                                      <img src='/includes/kawnaintv/images/studio/iptv2.jpg' />
                                        <div class="caption">
                                          <?php
                                              echo"<h3>".$server_list[3]['type']."</h3>
                                              <p>
                                                A monthly price of TV Box and VOD
                                              </p>
                                              <p>
                                                  <button onclick='price_service(4);' class='btn btn-primary btn-lg waves-effect' role='button'
                                                  id='price4' name='price4' value='".$server_list[3]['price']."' style='font-size:20px;'>".$server_list[3]['price']." $ Buy</button>
                                              </p>"
                                           ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-1"></div>
                      </div>
                    </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
        <script type="text/javascript">
        function price_service(type)
        {
              if(type == '1') var pricevalue = document.getElementById('price1').value;
              if(type == '2') var pricevalue = document.getElementById('price2').value;
              if(type == '3') var pricevalue = document.getElementById('price3').value;
              if(type == '4') var pricevalue = document.getElementById('price4').value;
              var dataString = '&type=' + type + '&price=' + pricevalue;
              //  alert(dataString);
               $.ajax({
                   type: "post",
                   url:"/user/service/datasave",
                   data: dataString,
                   success: function(response){
                    //  alert("User service registered");
                     swal("User service registered");
                   }
               });
        }
        </script>
    </section>
