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
        <li class="active">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">video_library</i>
                <span>Play</span>
            </a>
            <ul class="ml-menu">
                <li>
                    <a href="/user/play_live">Live</a>
                </li>
                <li class="active">
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
     <section class="content">
        <div class="container-fluid">

            <!-- <div align = 'center' class="block-header">
                <h1>
                    Play Masjid
                </h1>
            </div> -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2 style="font-size:28px;">
                                Masjid channel
                              </h2>
                        </div>
                        <div class="row" style="padding:50px 50px;">
                          <div class="row clearfix col-md-12 col-sm-12">
                              <div class="col-md-2 col-sm-12">
                                <?php
                                                    echo "<select name='country' id='country'  style='width:170px;' onchange=\"get_zone(this.value);\">
                                                            <option value='' selected>--Please select--</option>";
                                                            for( $j = 0 ; $j < count($countrylist) ; $j++ )
                                                            {
                                                                $uid = $countrylist[$j]['uid'];
                                                                $nm = $countrylist[$j]['description'];

                                                                echo "<option value='$uid'>$nm</option>";
                                                            }
                                                        echo "
                                                        </select> ";
                                ?>
                              </div>
                              <div class="col-md-2 col-sm-12">
                                <?php
                                                    echo "<select name='state' id='state'  style='width:170px;' onchange=\"get_zone(this.value);\">
                                                            <option value='' selected>--Please select--</option>";
                                                            for( $j = 0 ; $j < count($statelist) ; $j++ )
                                                            {
                                                                $uid = $statelist[$j]['uid'];
                                                                $nm = $statelist[$j]['description'];

                                                                echo "<option value='$uid'>$nm</option>";
                                                            }
                                                        echo "
                                                        </select> ";
                                ?>
                              </div>
                              <div class="col-md-2 col-sm-12">
                                <?php
                                                  echo "<select name='citys' id='citys' style='width:170px;' onchange=\"get_zone(this.value);\">
                                                          <option value='' selected>--Please select--</option>";
                                                          for( $j = 0 ; $j < count($citylist) ; $j++ )
                                                          {
                                                              $uid = $citylist[$j]['uid'];
                                                              $nm = $citylist[$j]['description'];

                                                              echo "<option value='$uid'>$nm</option>";
                                                          }
                                                      echo "
                                                      </select> ";
                              ?>
                            </div>
                              <div class="col-md-6 col-sm-12"></div>
                          </div>
                        </div>
                        <div class="row" style="padding-top:10px;padding-bottom:80px;padding-left:70px;">
                          <div class="row clearfix col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-12 row">
                                <div id="menubar" class='col-md-12 col-sm-12 row rightSidebarSingleContentOuterDivmasjid'>
                               </div>
                            </div>
                           <div class="col-md-1 col-sm-12 row"></div>
                            <div class="col-md-7 col-sm-12 row">
                              <video id="example-video" style="height:600px;" class="video-js vjs-default-skin col-md-12" controls>
                                 <!-- <source id="videosrc" src="" type="application/x-mpegURL"> -->
                               </video>
                            </div>
                         </div>
                       </div>
                   </div>
                 </div>
             </div>
         </div>
      <script src="/includes/kawnaintv/videojs/video.js"></script>
      <script src="/includes/kawnaintv/videojs/videojs-contrib-hls.js"></script>
      <script src="/includes/kawnaintv/js/lightslider.js" type="text/javascript"></script>
      <script>
            $("#rightSidebarLightSlider").lightSlider({
                 auto: true,
                 loop: true,
                 pager: false,
                 vertical: true,
                 verticalHeight:370,
                 item: 4,
                 pauseOnHover: true
             });
          function select_zone(suid)
          {
            var dataString = '&suid=' + suid;
              $.ajax({
                  type: "post",
                  url:"/user/play_masjid/getlocation",
                  data: dataString,
                  success: function(response){
                  //  alert("User information updated");
                  }
              });
          }

          function get_zone(suid)
          {
            var dataString = '&suid=' + suid;
              $.ajax({
                  type: "post",
                  url:"/user/play_masjid/get_list",
                  data: dataString,
                  success: function(response){
                    //  alert(response);
                    //  alert(suid);
                    $('#menubar').html(response);
                    // var list = document.getElementById('rightSidebarLightSlider'),
                    //     items = list.childNodes;
                    //     items.innerhtml = response;
                    // var modHeight = 400;
                    //     items.innerHeight( modHeight ).addClass( "rightSidebarLightSliderUL" );
                  }
              });
          }

          function play_change(iurl)
          {

              var player = videojs('example-video');
              var sources = [{"type": "application/x-mpegURL", "src": iurl}];
                player.pause();
                player.src(sources);
                player.load();
                player.play();
          }
    	</script>
    </section>
