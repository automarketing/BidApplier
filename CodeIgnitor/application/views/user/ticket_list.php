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
              <li>
                  <a href="/user/openticket">Open Ticket</a>
              </li>
              <li class="active">
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
                            <h2>List Ticket</h2>
                        </div>
                        <div class="body">

                            <form action="<?php echo site_url('user/openticket/list_ticket') ?>" name="activeTicketForm" id="activeTicketForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <!-- <td><input type="text" name="activeTicketSearchFormEmailInput" id="activeTicketSearchFormEmailInput" class="form-control" style="width:100%;" value="<?php echo $activeTicketSearchFormEmailInput; ?>" placeholder="Sender/Receiver Email"></td> -->
                                    <td><input type="text" name="activeTicketSearchFormFromDateInput" id="activeTicketSearchFormFromDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $activeTicketSearchFormFromDateInput; ?>" placeholder="From Date"></td>
                                    <td><input type="text" name="activeTicketSearchFormToDateInput" id="activeTicketSearchFormToDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $activeTicketSearchFormToDateInput; ?>" placeholder="To Date"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <!-- <button type="submit" name="activeTicketFormSubmitBtn" id="activeTicketFormSubmitBtn" class="btn btn-success" onclick="activeTicketForm.event.value='activeTicketFormSubmit';">Search</button> -->
                                        <a href="/user/openticket" class="btn btn-success">Open a new Ticket</a>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Open Date</th>
                                        <th style="vertical-align:top">title</th>
                                        <th style="vertical-align:top">State</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        foreach($activeTicketDataArr as $activeTicketData){
                                    ?>
                                    <tr class="tableDataTR" id="activeTicketTableDataTR_<?php echo $activeTicketData['uid']; ?>" data-uid="<?php echo $activeTicketData['uid']; ?>">

                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $activeTicketData['open_datetime']; ?></td>
                                        <td><?php echo $activeTicketData['question']; ?></td>
                                        <?php
                                        if($activeTicketData['close_datetime'] != "0000-00-00 00:00:00")
                                              echo "<td style='color:red'>Closed</td>";
                                        else
                                              echo "<td>Opened</td>";
                                               ?>
                                    </tr>
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="paginationLinkDiv">
                                <?php echo $paginationLink; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



                <!-- Subscriber Payment Edit Modal -->
                <div class="modal fade" id="ticketHistoryModal">
                    <div class="modal-dialog modal-lg" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <p id="modaltitle" style="text-align:center;font-size:22px;"></p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>

                                <!-- <h4 class="modal-title">Active Ticket History</h4> -->
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12" id="ticketHistoryDiv" style="max-height:450px;overflow:auto;">



                                        </div>
                                        <div class="col-md-12" style="padding-top:30px;">
                                            <input type="hidden" name="sendid_value" id="sendid_value">
                                            <input type="hidden" name="ticketID_value" id="ticketID_value">
                                            <textarea name="messagebox" id="messagebox" class="form-control" rows="8" ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" style="float: right;margin-left:20px;" name="activeTicketModalCancelBtn" id="activeTicketModalCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" style="float: right;" name="activeTicketSend" id="activeTicketSend" class="btn btn-success" data-dismiss="modal">Send</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <script type="text/javascript">

                $("#activeTicketSend").bind("click", sendmsg);

                function sendmsg() {
  //$("#result").text("");
  var message = $("#messagebox").val();
  var dataString = '&message=' + message + '&ticketID=' + document.getElementById('ticketID_value').value + '&adminID=' + document.getElementById('sendid_value').value;
     $.ajax({
        type: "post",
         url: "<?php echo site_url('user/openticket/resendticket'); ?>",
        data: dataString,
        success: function(response){
          // alert("Your require is sended");
          document.getElementById('messagebox').value = "";
          swal("Your require is sended");
        }
    });

  return true;

}
                    $(document).ready(function() {

                        $("[id^=activeTicketTableDataTR_]").on('click', function(event) {
                            event.preventDefault();

                    		var ticketID = $(this).data("uid");

                            if(ticketID != ""){

                	            $.ajax({
                	                url: "<?php echo site_url('user/openticket/getTicketDetailHistoryList'); ?>",
                	                type: 'POST',
                	                dataType: 'json',
                	                data: {ticketID: ticketID},
                	                success: function(data){

                	                    var ticketDetailDataResult = data.ticketDetailDataResult;

                	                    var singleTicketHistoryDiv = "";
                	                    if(ticketDetailDataResult.length > 0){
                	                    	$.each(ticketDetailDataResult, function(index, val) {
                                          $("#modaltitle").html(val.question);
                                          document.getElementById('sendid_value').value = val.sendid_value;
                                          document.getElementById('ticketID_value').value = ticketID;
                                          if(val.close_datetime != "0000-00-00 00:00:00")
                                          {
                                            document.getElementById('activeTicketSend').style.display = "none";
                                            // document.getElementById('activeTicketModalCancelBtn').style.display = "block";
                                          }

                                          else
                                          {
                                            document.getElementById('activeTicketSend').style.display = "block";
                                            // document.getElementById('activeTicketModalCancelBtn').style.display = "none";
                                          }
                		                    	singleTicketHistoryDiv += "<div style='width:100%;padding:14px;margin-bottom:10px;border:#dddddd 1px solid;'>";
                		                    	singleTicketHistoryDiv += "<div style='width:100%;font-size:14px;'>"+val.datetime+"</div>";
                		                    	singleTicketHistoryDiv += "<div style='width:100%;font-size:16px;padding-bottom:6px;border-bottom:#eeeeee 1px solid;'>";
                		                    	singleTicketHistoryDiv += "From: "+val.sender_name+" ["+val.sender_email+"] ";
                		                    	if(val.sender_type){
                		                    		singleTicketHistoryDiv += "Administrator";
                		                    	}else{
                		                    		singleTicketHistoryDiv += "Subscriber";
                		                    	}
                		                    	singleTicketHistoryDiv += "</div>";
                		                    	singleTicketHistoryDiv += "<div style='width:100%;font-size:15px;padding:15px 0px;'>"+val.description+"</div>";
                		                    	singleTicketHistoryDiv += "</div>";
                	                    	});
                	                    }
                	                    else{
                	                    	singleTicketHistoryDiv += "<div style='width:100%;font-size:14px;text-align;center;'>No ticket history found</div>";
                	                    }

                						$("#ticketHistoryDiv").empty();
                						$("#ticketHistoryDiv").html(singleTicketHistoryDiv);


                	                },
                	                error: function(xhr, status, error){
                	                    alert("Error: "+status);
                	                }
                	            });

                	    		$("#ticketHistoryModal").modal("show");
                            }
                            else{
                            	alert("No Active Ticket id found");
                            }

                    	});
                    });
                </script>
