    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Payment History List</h2>
                        </div>
                        <div class="body">

                            <form action="<?php echo site_url('admin/payment/payment_history'); ?>" name="paymentHistorySearchForm" id="paymentHistorySearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="paymentHistorySearchFormEmailInput" id="paymentHistorySearchFormEmailInput" class="form-control" style="width:100%;" value="<?php echo $paymentHistorySearchFormEmailInput; ?>" placeholder="Email"></td>
                                    <td><input name="paymentHistorySearchFormNameInput" id="paymentHistorySearchFormNameInput" class="form-control" style="width:100%;" value="<?php echo $paymentHistorySearchFormNameInput; ?>" placeholder="Name"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="paymentHistorySearchFormSubmitBtn" id="paymentHistorySearchFormSubmitBtn" class="btn btn-success" onclick="paymentHistorySearchForm.event.value='paymentHistorySearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Email</th>
                                        <th style="vertical-align:top">Name</th>
                                        <th style="vertical-align:top">Card</th>
                                        <th style="vertical-align:top">Current Subscriber Plan</th>
                                        <th style="vertical-align:top">Total Payment</th>
                                        <th style="vertical-align:top">Last Payment Date</th>
                                        <th style="vertical-align:top">Last Payment</th>
                                        <th style="vertical-align:top">Next Payment Date</th>
                                        <th style="vertical-align:top">Auto Pay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($paymentHistoryDataArr as $paymentHistoryData){ 
                                    ?>
                                    <tr class="tableDataTR" id="paymentHistoryTableDataTR_<?php echo $paymentHistoryData['uid']; ?>" data-uid="<?php echo $paymentHistoryData['uid']; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $paymentHistoryData['email']; ?></td>
                                        <td><?php echo $paymentHistoryData['first_name']." ".$paymentHistoryData['last_name']; ?></td>
                                        <td><?php echo $paymentHistoryData['card_no']." [".$paymentHistoryData['card_type']."]"; ?></td>
                                        <td><?php echo $paymentHistoryData['subscriber_plan_type']; ?></td>
                                        <td><?php echo "$".$paymentHistoryData['payment_total']; ?></td>
                                        <td><?php echo $paymentHistoryData['last_payment_date']; ?></td>
                                        <td><?php echo "$".$paymentHistoryData['last_payment']; ?></td>
                                        <td><?php echo $paymentHistoryData['next_payment_date']; ?></td>
                                        <td><?php echo $paymentHistoryData['autopay']; ?></td>
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
                            <div class="modal fade" id="subscriberPaymentHistoryModal">
                                <div class="modal-dialog modal-lg" tabindex="-1" role="dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">Subscriber's Payment History</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        
                                                        <div id="subscriberPlanEditFormUpdateSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                                        <div id="subscriberPlanEditFormUpdateErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>
                                                            <div class="row">

                                                                <div class="col-md-12" id="subscriberPaymentDataTableDiv">
                                                                    <table class="table table-bordered table-hover" id="subscriberPaymentDataTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Date</th>
                                                                                <th>Service Plan</th>
                                                                                <th>Card</th>
                                                                                <th>Amount</th>
                                                                                <th>Auto Pay</th>
                                                                                <th>Start Date</th>
                                                                                <th>End Date</th>
                                                                                <th>Invoice</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="subscriberPaymentDataTBody">
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                            <button type="button" name="subscriberPlanEditFormCancelBtn" id="subscriberPlanEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->



<script type="text/javascript">
    $(document).ready(function() {
        $("[id^=paymentHistoryTableDataTR_]").on('click', function(event) {
            var subscriberID = $(this).data("uid");
            if(subscriberID != ""){

	            $.ajax({
	                url: "<?php echo site_url('admin/payment/getSubscriberPayHistoryList'); ?>",
	                type: 'POST',
	                dataType: 'json',
	                data: {subscriberID: subscriberID},
	                success: function(data){

	                    var subscriberPaymentDataArr = data.msgDetail;
	                    if(subscriberPaymentDataArr.length > 0){
	                        $("#subscriberPaymentDataTBody").empty();

	                        var i = 1;
	                        var subscriberPaymentTableDataStr = "";
	                        $.each(subscriberPaymentDataArr, function(index, val) {
	                        	subscriberPaymentTableDataStr += "<tr>";
	                            subscriberPaymentTableDataStr += "<td>"+i+"</td>";
	                            subscriberPaymentTableDataStr += "<td>"+val.date+"</td>";
	                            subscriberPaymentTableDataStr += "<td>"+val.plan_type+"</td>";
	                            subscriberPaymentTableDataStr += "<td>"+val.card_no+" ["+val.card_type+"]</td>";
	                            subscriberPaymentTableDataStr += "<td>"+val.price+"</td>";
	                            if(val.autopay == 1){
		                            subscriberPaymentTableDataStr += "<td>Auto</td>";
	                            }
	                            else{
		                            subscriberPaymentTableDataStr += "<td></td>";	                            	
	                            }
	                            subscriberPaymentTableDataStr += "<td>"+val.startdate+"</td>";
	                            subscriberPaymentTableDataStr += "<td>"+val.enddate+"</td>";
	                            subscriberPaymentTableDataStr += "<td></td>";
		                        subscriberPaymentTableDataStr += "</tr>";
	                            i++;
	                        });
	                        $("#subscriberPaymentDataTBody").html(subscriberPaymentTableDataStr);
	                    }
	                    else{
	                        $("#subscriberPaymentDataTBody").empty();
	                        $("#subscriberPaymentDataTBody").html("<tr><td colspan='9' style='font-size:14px;text-align;center;'>No payment history found</div>");
	                    }
	                },
	                error: function(xhr, status, error){
	                    alert("Error: "+status);
	                }
	            });

            	$("#subscriberPaymentHistoryModal").modal("show");
            }
            else{
            	alert("No subscriber id found");
            }
        });
    });
</script>