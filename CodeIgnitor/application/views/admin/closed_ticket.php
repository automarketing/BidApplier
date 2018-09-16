    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Closed Ticket</h2>
                        </div>
                        <div class="body">

                            <form action="<?php echo site_url('admin/ticket/closed'); ?>" name="closedTicketForm" id="closedTicketForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input type="text" name="closedTicketSearchFormEmailInput" id="closedTicketSearchFormEmailInput" class="form-control" style="width:100%;" value="<?php echo $closedTicketSearchFormEmailInput; ?>" placeholder="Sender/Receiver Email"></td>
                                    <td><input type="text" name="closedTicketSearchFormFromDateInput" id="closedTicketSearchFormFromDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $closedTicketSearchFormFromDateInput; ?>" placeholder="From Date"></td>
                                    <td><input type="text" name="closedTicketSearchFormToDateInput" id="closedTicketSearchFormToDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $closedTicketSearchFormToDateInput; ?>" placeholder="To Date"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="closedTicketFormSubmitBtn" id="closedTicketFormSubmitBtn" class="btn btn-success" onclick="closedTicketForm.event.value='closedTicketFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Question</th>
                                        <th style="vertical-align:top">Sender</th>
                                        <th style="vertical-align:top">Receiver</th>
                                        <th style="vertical-align:top">Open Date</th>
                                        <th style="vertical-align:top">Last Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($closedTicketDataArr as $closedTicketData){ 
                                    ?>
                                    <tr class="tableDataTR" id="closedTicketTableDataTR_<?php echo $closedTicketData['uid']; ?>" data-uid="<?php echo $closedTicketData['uid']; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $closedTicketData['question']; ?></td>
                                        <td><?php echo $closedTicketData['sender_email']; if($closedTicketData['sender_type'] == 'subscriber'){echo " [Subscriber]";}else{echo " [Admin]";} ?></td>
                                        <td><?php echo $closedTicketData['receiver_email']; if($closedTicketData['receiver_type'] == 'subscriber'){echo " [Subscriber]";}else{echo " [Admin]";} ?></td>
                                        <td><?php echo $closedTicketData['open_datetime']; ?></td>
                                        <td><?php echo $closedTicketData['close_datetime']; ?></td>
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
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Closed Ticket History</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12" id="ticketHistoryDiv" style="max-height:450px;overflow:auto;">
                                            


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="closedTicketModalCancelBtn" id="closedTicketModalCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->




<script type="text/javascript">
    $(document).ready(function() {
    	$("[id^=closedTicketTableDataTR_]").on('click', function(event) {
    		event.preventDefault();

    		var ticketID = $(this).data("uid");

            if(ticketID != ""){

	            $.ajax({
	                url: "<?php echo site_url('admin/ticket/getTicketDetailHistoryList'); ?>",
	                type: 'POST',
	                dataType: 'json',
	                data: {ticketID: ticketID},
	                success: function(data){

	                    var ticketDetailDataResult = data.ticketDetailDataResult;

	                    var singleTicketHistoryDiv = "";
	                    if(ticketDetailDataResult.length > 0){
	                    	$.each(ticketDetailDataResult, function(index, val) {
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
            	alert("No Closed Ticket id found");
            }

    	});
    });
</script>