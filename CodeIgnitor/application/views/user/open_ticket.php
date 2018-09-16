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
        <li class="active">
            <a href="javascript:void(0);" class="menu-toggle">
                <i class="material-icons">assignment</i>
                <span>Ticket</span>
            </a>
            <ul class="ml-menu">
              <li class="active">
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
                    Ticket
                </h1>
        </div>
            <div class="row clearfix">

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="card">
                      <div class="header text-left">
                          <h2>Open Ticket</h2>
                      </div>
                      <div class="body">

                          <?php if(!empty($msgType) && !strcmp($msgType, "success") && !empty($msg)){ ?>
                          <div id="openTicketFormSuccessAlert" class="alert alert-success" role="alert"><?php echo $msg; ?></div>
                          <?php } ?>
                          <?php if(!empty($msgType) && !strcmp($msgType, "error") && !empty($msg)){ ?>
                          <div id="openTicketFormErrorAlert" class="alert alert-danger" role="alert"><?php echo $msg; ?></div>
                          <?php } ?>

                          <form action="" name="openTicketForm" id="openTicketForm" method="POST" class="form-horizontal" role="form">

                              <!-- <div class="form-group">
                                  <label for="openTicketSubscriberEmailInput" class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:5px !important;">Subscriber Email</label>
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                      <select name="openTicketSubscriberEmailInput[]" id="openTicketSubscriberEmailInput" class="form-control" required="required" multiple>
                                          <?php foreach($subscriberDataResult as $subscriberData){ ?>
                                          <option value="<?php echo $subscriberData['uid']; ?>"<?php if(in_array($subscriberData['uid'], $openTicketSubscriberEmailInput)){ ?> selected="selected"<?php } ?>><?php echo $subscriberData['first_name']." ".$subscriberData['last_name']." [ ".$subscriberData['email']." ]"; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div> -->

                              <div class="form-group">
                                  <label for="openTicketQuestionInput" class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:5px !important;">Question</label>
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                      <select name="openTicketQuestionInput" id="openTicketQuestionInput" class="form-control" required="required">
                                          <option value=""></option>
                                          <?php foreach($ticketQuestionDataResult as $ticketQuestionData){ ?>
                                          <option value="<?php echo $ticketQuestionData['uid']; ?>"<?php if($openTicketQuestionInput==$ticketQuestionData['uid']){ ?> selected="selected"<?php } ?>><?php echo $ticketQuestionData['question']; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="openTicketDetailInput" class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:5px !important;">Detail</label>
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                      <textarea name="openTicketDetailInput" id="openTicketDetailInput" class="form-control" rows="8" required="required" style="resize:none;"><?php echo $openTicketDetailInput; ?></textarea>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-lg-12 col-md-12 col-sm-12">
                                      <input type="hidden" name="event" id="event" value="">
                                      <button type="submit" name="openTicketFormSubmitBtn" id="openTicketFormSubmitBtn" class="btn btn-primary" onclick="openTicketForm.event.value='openTicketFormSubmit';">Save</button>
                                  </div>
                              </div>
                          </form>

                      </div>

              </div>
            </div>
                <!-- Tags Input -->

                <!-- #END# Tags Input -->
            </div>
        </div>
        <script type="text/javascript">
            function save()
            {
                  var dataString = '&qtype=' + document.getElementById('qtype').value + '&description=' + document.getElementById('description').value;
                  //  alert(dataString);
                   $.ajax({
                       type: "post",
                       url:"/user/openticket/datasave",
                       data: dataString,
                       success: function(response){
                         alert("Tickets sended");
                       }
                   });
            }
        </script>

    </section>
