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
                <li>
                    <a href="/user/play_masjid">Masjid</a>
                </li>
                <li class="active">
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
                 Play Live
             </h1>
         </div> -->
         <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12">
                 <div class="card" id="allresult" style="padding-bottom:30px;">
                   <div class="row">
                     <div class="col-md-12" style="padding-top:30px;">
                       <div class="col-md-3 col-sm-6 col-xs-6">
                         <h2 style="font-size:34px;color:#555555;">
                             Video on Demand
                           </h2>
                       </div>
                       <div class="col-md-6"></div>
                         <div class="col-md-3 col-sm-6 col-xs-6">
                              <input class="form-control input-sm headerBottomsearch" align="right" onchange="get_search();" name="textid" id="textid">
                         </div>
                       </div>
                     </div>
                   <?php if(count($data1) != '0') {?>
                     <div class="row">
                       <div align="center" class="col-md-12" style="padding:0% 2%;">
                           <div class="homepageBottomContentTitleDiv"><p style="text-align:left;width:150px;"><?php echo $category_data[0]['name'];?></p></div>
                            <div align="center" class="row playborder"  style="width:99%;padding-bottom:30px;">
                              <?php
                               // if($menuflag == '1') $resultvalue = $data;
                               //        else          $resultvalue = $data1;
                              foreach ($data1 as $row) {  ?>
                                    <!-- <div class='col-lg-3 col-md-4 col-sm-6 col-xs-12 homepageMiddleContentLeftTextDiv showVideoPopup'
                                             data-url='<?php echo $row["url"];?>' style='padding:10px 40px;cursor:pointer;'>
                                      <img src='<?php echo $row["imgpath"];?>' class='homepageMiddleContentLeftTextThumbImgDiv'
                                             style='-webkit-border-radius: 0.6em;' />
                                       <span style='text-align: center;font-size:18px;' class='homepageMiddleContentLeftText1Span'><?php echo $row["name"];?></span>
                                       <div id='play'></div>

                                    </div> -->
                                    <div class='vi_item showVideoPopup'
                                             data-url='<?php echo $row["url"];?>' style='padding:10px 0px;cursor:pointer;'>
                                      <img src='<?php echo $row["imgpath"];?>'  style="height:120px;" class='img-responsive' />
                                             <span style='text-align:center;font-size:16px;'><?php echo $row["name"];?></span>
                                       <!-- <div id='play'></div> -->

                                    </div>

                                <?php } ?>
                                 <div style="padding-top:20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div align="center" class="paginationLinkDiv">
                                        <?php echo $paginationLink1; ?>
                                    </div>
                                </div>
                            </div>


                        </div>
                     </div>
                   <?php } else{} ?>
                     <?php if(count($data2) != '0') {?>
                       <div class="row">
                         <div align="center" class="col-md-12" style="padding:0% 2%;">
                             <div class="homepageBottomContentTitleDiv"><p style="text-align:left;width:150px;"><?php echo $category_data[1]['name'];?></p></div>
                              <div align="center" class="row playborder"  style="width:99%;padding-bottom:30px;">
                                <?php
                                foreach ($data2 as $row) {  ?>
                                      <div class='vi_item showVideoPopup'
                                               data-url='<?php echo $row["url"];?>' style='padding:10px 0px;cursor:pointer;'>
                                        <img src='<?php echo $row["imgpath"];?>'  style="height:120px;" class='img-responsive' />
                                               <span style='text-align:center;font-size:16px;'><?php echo $row["name"];?></span>
                                         <!-- <div id='play'></div> -->

                                      </div>

                                  <?php } ?>
                                   <div style="padding-top:20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <div align="center" class="paginationLinkDiv">
                                          <?php echo $paginationLink2; ?>
                                      </div>
                                  </div>
                              </div>


                          </div>
                       </div>
                   <?php } else{} ?>
                     <?php if(count($data3) != '0') {?>
                       <div class="row">
                         <div align="center" class="col-md-12" style="padding:0% 2%;">
                             <div class="homepageBottomContentTitleDiv"><p style="text-align:left;width:150px;"><?php echo $category_data[2]['name'];?></p></div>
                              <div align="center" class="row playborder"  style="width:99%;padding-bottom:30px;">
                                <?php
                                foreach ($data3 as $row) {  ?>
                                      <div class='vi_item showVideoPopup'
                                               data-url='<?php echo $row["url"];?>' style='padding:10px 0px;cursor:pointer;'>
                                        <img src='<?php echo $row["imgpath"];?>'  style="height:120px;" class='img-responsive' />
                                               <span style='text-align:center;font-size:16px;'><?php echo $row["name"];?></span>
                                         <!-- <div id='play'></div> -->

                                      </div>

                                  <?php } ?>
                                   <div style="padding-top:20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                      <div align="center" class="paginationLinkDiv">
                                          <?php echo $paginationLink3; ?>
                                      </div>
                                  </div>
                              </div>


                          </div>
                       </div>
                     <?php } else{} ?>
                    <?php if(count($data4) != '0') {?>
                      <div class="row">
                        <div align="center" class="col-md-12" style="padding:0% 2%;">
                            <div class="homepageBottomContentTitleDiv"><p style="text-align:left;width:150px;"><?php echo $category_data[3]['name'];?></p></div>
                             <div align="center" class="row playborder"  style="width:99%;padding-bottom:30px;">
                               <?php
                               foreach ($data4 as $row) {  ?>
                                     <div class='vi_item showVideoPopup'
                                              data-url='<?php echo $row["url"];?>' style='padding:10px 0px;cursor:pointer;'>
                                       <img src='<?php echo $row["imgpath"];?>'  style="height:120px;" class='img-responsive' />
                                              <span style='text-align:center;font-size:16px;'><?php echo $row["name"];?></span>
                                        <!-- <div id='play'></div> -->

                                     </div>

                                 <?php } ?>
                                  <div style="padding-top:20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                     <div align="center" class="paginationLinkDiv">
                                         <?php echo $paginationLink4; ?>
                                     </div>
                                 </div>
                             </div>


                         </div>
                      </div>
                  <?php } else{} ?>

                  <?php if(count($data5) != '0') {?>
                    <div class="row">
                      <div align="center" class="col-md-12" style="padding:0% 2%;">
                          <div class="homepageBottomContentTitleDiv"><p style="text-align:left;width:150px;"><?php echo $category_data[4]['name'];?></p></div>
                           <div align="center" class="row playborder"  style="width:99%;padding-bottom:30px;">
                             <?php
                             foreach ($data5 as $row) {  ?>
                                   <div class='vi_item showVideoPopup'
                                            data-url='<?php echo $row["url"];?>' style='padding:10px 0px;cursor:pointer;'>
                                     <img src='<?php echo $row["imgpath"];?>'  style="height:120px;" class='img-responsive' />
                                            <span style='text-align:center;font-size:16px;'><?php echo $row["name"];?></span>
                                      <!-- <div id='play'></div> -->

                                   </div>

                               <?php } ?>
                                <div style="padding-top:20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                   <div align="center" class="paginationLinkDiv">
                                       <?php echo $paginationLink5; ?>
                                   </div>
                               </div>
                           </div>


                       </div>
                    </div>
                <?php } else{} ?>
                     <!--   template test   -->
                 </div>

                 <div class="card" id="searchresult" style="display: none;">
                   <div class="header col-md-12">
                     <div class="col-md-3">
                       <h2 style="font-size:28px;">
                           VOD Channel
                         </h2>
                     </div>
                     <div class="col-md-6"></div>
                       <div class="col-md-3">
                            <input class="form-control input-sm" align="right" onchange="get_search_option();" name="textsearch" id="textsearch">
                       </div>
                     </div>

                     <div class="row">
                        <div class="col-md-12">
                            <!-- <div class="homepageBottomContentTitleDiv" style="margin-top:30px;padding-left:70px;font-size:30px;">News TV</div> -->
                            <div class="row" id="searchid">

                            </div>

                        </div>
                     </div>
                   </div>

             </div>
         </div>
     </div>
 <script>
    function get_search()
    {
      var dataString = '&term=' + document.getElementById('textid').value;
      $.ajax({
          type: "post",
          url:"/user/play_vod/getname",
          data: dataString,
          success: function(response){
           //  alert(response);
             $("#allresult").hide();
             $("#searchresult").show();
             $('#searchid').html(response);
                       }
             });

     }

     function get_search_option()
     {
       var dataString = '&term=' + document.getElementById('textsearch').value;
       // alert(dataString);
       $.ajax({
           type: "post",
           url:"/user/play_vod/getname",
           data: dataString,
           success: function(response){
             // alert(response);
             if(document.getElementById('textsearch').value ==""){
               $("#allresult").show();
               $("#searchresult").hide();
             }else{
               $("#allresult").hide();
               $("#searchresult").show();
               $('#searchid').html(response);
             }
                        }
              });

      }

   function get_input(catalog , pagecalc )
   {
     var dataString = '&catalog=' + catalog + '&pagecalc=' + pagecalc;
     $.ajax({
         type: "post",
         url:"/user/play_live/search_func",
         data: dataString,
         success: function(response){
           // alert(response);
           if(catalog =='1')  $('#newdiv').html(response);
           if(catalog =='2')  $('#moviediv').html(response);
           if(catalog =='3')  $('#kidsdiv').html(response);
           if(catalog =='4')  $('#sportdiv').html(response);
                     }
           });
   }
 </script>
 </section>
