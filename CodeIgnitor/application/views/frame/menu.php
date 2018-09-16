<section>
﻿      <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
              <!-- <div class="col-md-12"> -->
                <div class="col-md-4" style="cursor:pointer;">
                  <div>
                      <!-- <div class="image user-helper-dropdown" style="board:1px solid #BBBCB7;" > -->
                    <?php
                         if($userimg !="")
                             echo' <img width="72" height="72" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                  src="data:image/jpeg;base64,'.base64_encode( $userimg ).'" alt="User"/>';
                         else
                         echo" <img width='72' height='72' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true'
                              src='/images/default.png' alt='User' />";
                    ?>
                               <ul class="dropdown-menu pull-left">
                                   <li class="user-header">
                                      <!-- <img src="data:image/jpeg;base64,'.base64_encode( $userimg ).'"/> -->
                                      <?php
                                      $defaultimg = 'images/default.png';
                                      if($userimg !="")
                                          echo '<img style="margin-top:10px;" class="img-circle" alt="User Image" width="80" height="80" src="data:image/jpeg;base64,'.base64_encode( $userimg ).'"/>';
                                      else
                                          echo "<img style='margin-top:10px;' class='img-circle' alt='User Image' width='80' height='80' src='/images/default.png'/>";
                                      ?>
                                      <!-- <img style="margin-top:40px;" src="data:image/jpeg;base64,'.base64_encode($userimg).'" class="img-circle" alt="User Image" /> -->
                                      <p>

                                          <small>Member since <?php //echo $this->session->userdata('created_on'); ?></small>
                                      </p>
                                  </li>
                                   <li role="seperator" class="divider"></li>
                                   <li>
                                     <div class="pull-left" style="padding-left:10px;">
                                        <a onclick="open_profile();" class="btn btn-default waves-effect">Profile</a>
                                        <!-- <a href="javascript:void(0);">Profile</a> -->
                                      </div>
                                      <div class="pull-right" style="padding-right:10px;">
                                        <a href="/user/login/logout" class="btn btn-default waves-effect">Sign Out</a>
                                        <!-- <a href="javascript:void(0);">Sign Out</a> -->
                                       </div>
                                   </li>
                               </ul>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="info-container">
                      <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#000;">
                        <p style="font-size:16px;"><?php echo $username; ?></p></div>
                      <div class="email" style="color:#000;">
                        <p style="font-size:14px;"><?php echo $useremail; ?></p></div>

                  </div>
                </div>
              <!-- </div> -->


            </div>
            <!-- #User Info -->
            <!-- Menu -->
