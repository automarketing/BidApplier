    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Mobile Payment List</h2>
                        </div>
                        <div class="body">

                            <form action="<?php echo site_url('admin/payment/mobile_payment'); ?>" name="tvboxReqSearchForm" id="tvboxReqSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="tvboxReqSearchFormEmailInput" id="tvboxReqSearchFormEmailInput" class="form-control" style="width:100%;" value="<?php echo $tvboxReqSearchFormEmailInput; ?>" placeholder="Email"></td>
                                    <td><input name="tvboxReqSearchFormDateInput" id="tvboxReqSearchFormDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $tvboxReqSearchFormDateInput; ?>" placeholder="Date"></td>
                                    <td><input name="tvboxReqSearchFormAddressInput" id="tvboxReqSearchFormAddressInput" class="form-control" style="width:100%;" value="<?php echo $tvboxReqSearchFormAddressInput; ?>" placeholder="Address"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="tvboxReqSearchFormSubmitBtn" id="tvboxReqSearchFormSubmitBtn" class="btn btn-success" onclick="tvboxReqSearchForm.event.value='tvboxReqSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Date</th>
                                        <th>Address</th>
                                        <th>Payment</th>
                                        <!-- <th>Request Status</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($tvboxReqDataArr as $tvboxReqData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $tvboxReqData['email']; ?></td>
                                        <td><?php echo $tvboxReqData['date']; ?></td>
                                        <td><?php echo $tvboxReqData['address']; ?></td>
                                        <td><?php echo "$".$tvboxReqData['price']." [".$tvboxReqData['card_type']."]"; ?></td>
<!-- 
                                        <td>
                                            <select name="tvboxReqSelect_<?php echo $tvboxReqData['uid']; ?>" id="tvboxReqSelect_<?php echo $tvboxReqData['uid']; ?>" data-uid="<?php echo $tvboxReqData['uid']; ?>" class="form-control" required="required">
                                                <option value="">--- Request Status ---</option>
                                                <option value="1"<?php if($tvboxReqData['req_status'] == "1"){ ?> selected="selected"<?php } ?>>New Request</option>
                                                <option value="2"<?php if($tvboxReqData['req_status'] == "2"){ ?> selected="selected"<?php } ?>>Processed</option>
                                                <option value="3"<?php if($tvboxReqData['req_status'] == "3"){ ?> selected="selected"<?php } ?>>On Delivery</option>
                                            </select>
                                        </td>
 -->                                        
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

<script type="text/javascript">
    $(document).ready(function() {
        $("[id^=tvboxReqSelect_]").on('change', function(event) {
            event.preventDefault();
            
            var tvboxReqID = $(this).data("uid");
            var tvboxReqStatusVal = $(this).val();

            if( tvboxReqStatusVal != "" ){
                $.ajax({
                    url: "<?php echo site_url('admin/payment/saveTvboxRequestStatus'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {tvboxReqID: tvboxReqID, tvboxReqStatusVal: tvboxReqStatusVal},
                    success: function(data){
                        if(data.msgType == "success"){
                            window.location.href = window.location.href;
                        }
                        else{
                            alert(data.msg);
                        }
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
            else{
                alert("Request Status cannot be empty.");
            }
        });
    });
</script>