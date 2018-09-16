    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>TVBox Subscribers</h2>
                        </div>
                        <div class="body">

                            <form action="<?php echo site_url('admin/subscriber/index'); ?>" name="subscriberInfoSearchForm" id="subscriberInfoSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="subscriberInfoSearchFormEmailInput" id="subscriberInfoSearchFormEmailInput" class="form-control" style="width:100%;" value="<?php echo $subscriberInfoSearchFormEmailInput; ?>" placeholder="Email"></td>
                                    <td><input name="subscriberInfoSearchFormNameInput" id="subscriberInfoSearchFormNameInput" class="form-control" style="width:100%;" value="<?php echo $subscriberInfoSearchFormNameInput; ?>" placeholder="Name"></td>
                                    <td><input name="subscriberInfoSearchFormTelInput" id="subscriberInfoSearchFormTelInput" class="form-control" style="width:100%;" value="<?php echo $subscriberInfoSearchFormTelInput; ?>" placeholder="Telephone"></td>
                                    <td><input name="subscriberInfoSearchFormAddressInput" id="subscriberInfoSearchFormAddressInput" class="form-control" style="width:100%;" value="<?php echo $subscriberInfoSearchFormAddressInput; ?>" placeholder="Address"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="subscriberInfoSearchFormSubmitBtn" id="subscriberInfoSearchFormSubmitBtn" class="btn btn-success" onclick="subscriberInfoSearchForm.event.value='subscriberInfoSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th>No</th>
                                        <th>Email</th>
                                        <th>Name</th>
                                        <th>Telephone</th>
                                        <th>Address</th>
                                        <th>Active Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($subscriberDataArr as $subscriberData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $subscriberData['email']; ?></td>
                                        <td><?php echo $subscriberData['first_name'].' '.$subscriberData['last_name']; ?></td>
                                        <td><?php echo $subscriberData['telephone']; ?></td>
                                        <td>
                                            <?php 
                                                if(!empty($subscriberData['address_street_1'])){
                                                    echo $subscriberData['address_street_1'];
                                                }
                                                if(!empty($subscriberData['address_street_2'])){
                                                    echo ", ".$subscriberData['address_street_2'];
                                                }
                                                if(!empty($subscriberData['city'])){
                                                    echo ", ".$subscriberData['city'];
                                                }
                                                if(!empty($subscriberData['state'])){
                                                    echo ", ".$subscriberData['state'];
                                                }
                                                if(!empty($subscriberData['zipcode'])){
                                                    echo ", ".$subscriberData['zipcode'];
                                                }
                                                if(!empty($subscriberData['country'])){
                                                    echo ", ".$subscriberData['country'];
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if(!strcmp($subscriberData['active_status'], 0)){
                                                    ?><span class="label label-success activeStatusLabel"> Active </span><?php
                                                }
                                                elseif (!strcmp($subscriberData['active_status'], 1)) {
                                                    ?><span class="label label-danger activeStatusLabel"> Suspend </span><?php
                                                }
                                                elseif (!strcmp($subscriberData['active_status'], 2)) {
                                                    ?><span class="label label-warning activeStatusLabel"> Stopped </span><?php
                                                }
                                            ?>
                                        </td>
                                        <td>

                                          <button type="button" class="btn btn-primary" name="subscriberInfoEditBtn_<?php echo $subscriberData['uid']; ?>" id="subscriberInfoEditBtn_<?php echo $subscriberData['uid']; ?>" style="margin:2px;" data-uid="<?php echo $subscriberData['uid']; ?>" title="Edit Information"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          <button type="button" class="btn btn-primary" name="subscriberPaymentBtn_<?php echo $subscriberData['uid']; ?>" id="subscriberPaymentBtn_<?php echo $subscriberData['uid']; ?>" style="margin:2px;" data-uid="<?php echo $subscriberData['uid']; ?>" title="Payment"><i class="fa fa-credit-card" aria-hidden="true"></i></button>
                                          <!-- <button type="button" class="btn btn-primary" name="subscriberTicketBtn_<?php echo $subscriberData['uid']; ?>" id="subscriberTicketBtn_<?php echo $subscriberData['uid']; ?>" data-uid="<?php echo $subscriberData['uid']; ?>" title="Ticket"><i class="fa fa-ticket" aria-hidden="true"></i></button> -->

                                        </td>
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


                            <!-- Subscriber Information Edit Modal -->
                            <div class="modal fade" id="subscriberInfoEditModal">
                                <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">TVBox Subscriber's Information</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        
                                                        <div id="subscriberInfoEditFormUpdateSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                                        <div id="subscriberInfoEditFormUpdateErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                                        <form action="" name="subscriberInfoEditForm" id="subscriberInfoEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsFirstNameInput">First Name <span>*</span></label>
                                                                        <input type="text" name="subsFirstNameInput" id="subsFirstNameInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsLastNameInput">Last Name <span>*</span></label>
                                                                        <input type="text" name="subsLastNameInput" id="subsLastNameInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCompanyInput">Company</label>
                                                                        <input type="text" name="subsCompanyInput" id="subsCompanyInput" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsTelInput">Telephone <span>*</span></label>
                                                                        <input type="text" name="subsTelInput" id="subsTelInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsEmailInput">Email <span>*</span></label>
                                                                        <input type="email" name="subsEmailInput" id="subsEmailInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsFaxInput">Fax</label>
                                                                        <input type="text" name="subsFaxInput" id="subsFaxInput" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsStreet1Input">Street Address #1 <span>*</span></label>
                                                                        <input type="text" name="subsStreet1Input" id="subsStreet1Input" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsStreet2Input">Street Address #2</label>
                                                                        <input type="text" name="subsStreet2Input" id="subsStreet2Input" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCityInput">City <span>*</span></label>
                                                                        <input type="text" name="subsCityInput" id="subsCityInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsStateInput">State</label>
                                                                        <input type="text" name="subsStateInput" id="subsStateInput" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsZipInput">Zip Code </label>
                                                                        <input type="text" name="subsZipInput" id="subsZipInput" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCountryInput">Country <span>*</span></label>
                                                                        <input type="text" name="subsCountryInput" id="subsCountryInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCardTypeInput">Credit Card Type <span>*</span></label>
                                                                        <select name="subsCardTypeInput" id="subsCardTypeInput" class="form-control" required="required">
                                                                            <option value="">-- Card Type --</option>
                                                                            <option value="Visa">Visa</option>
                                                                            <option value="MasterCard">Mastercard</option>
                                                                            <option value="Amex">American Express</option>
                                                                            <option value="Discover">Discover</option>
                                                                            <!-- <option value="paypal">Paypal</option> -->
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCardNoInput">Credit Card Number <span>*</span></label>
                                                                        <input type="text" name="subsCardNoInput" id="subsCardNoInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCardCVVNoInput">Credit Card CVV Number <span>*</span></label>
                                                                        <input type="text" name="subsCardCVVNoInput" id="subsCardCVVNoInput" class="form-control" required="required">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsCardExpMonthInput">Card Expire Date <span>*</span></label>
                                                                        <select name="subsCardExpMonthInput" id="subsCardExpMonthInput" class="form-control" required="required">
                                                                            <option value="">-- Month --</option>
                                                                            <option value="01">January</option>
                                                                            <option value="02">February</option>
                                                                            <option value="03">March</option>
                                                                            <option value="04">April</option>
                                                                            <option value="05">May</option>
                                                                            <option value="06">June</option>
                                                                            <option value="07">July</option>
                                                                            <option value="08">August</option>
                                                                            <option value="09">September</option>
                                                                            <option value="10">Octobar</option>
                                                                            <option value="11">November</option>
                                                                            <option value="12">December</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label>&nbsp;</label>
                                                                        <select name="subsCardExpYearInput" id="subsCardExpYearInput" class="form-control" required="required">
                                                                            <option value="">-- Year --</option>
                                                                            <?php foreach($yearDataArr as $key => $val){ ?>
                                                                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="hidden" name="subscriberInfoEditFormSubscriberId" id="subscriberInfoEditFormSubscriberId" value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                            <button type="button" name="subscriberInfoEditFormCancelBtn" id="subscriberInfoEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" name="subscriberInfoEditFormSubmitBtn" id="subscriberInfoEditFormSubmitBtn" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- Subscriber Payment Edit Modal -->
                            <div class="modal fade" id="subscriberPaymentEditModal">
                                <div class="modal-dialog modal-lg" tabindex="-1" role="dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                            <h4 class="modal-title">TVBox Subscriber's Payment Information</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        
                                                        <div id="subscriberPlanEditFormUpdateSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                                        <div id="subscriberPlanEditFormUpdateErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>
                                                            <div class="row">

                                                                <form action="" name="subscriberPlanEditForm" id="subscriberPlanEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form">
                                                                <div class="col-md-12" style="margin-bottom:20px !important;">
                                                                    <div class="form-group formHorizontalGroup">
                                                                        <label for="subsFirstNameInput">Selected Service Plan <span>*</span></label>
                                                                        <select name="subsServicePlanInput" id="subsServicePlanInput" class="form-control" required="required">
                                                                            <option value="">-- Service Plan --</option>
                                                                            <?php foreach($subscriberPlanDataArr as $key => $data){ ?>
                                                                            <option value="<?php echo $key; ?>"><?php echo $data; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <input type="hidden" name="subscriberPlanEditFormSubscriberId" id="subscriberPlanEditFormSubscriberId" value="">
                                                                    </div>
                                                                </div>
                                                                </form>

                                                                <div class="col-md-12" id="subscriberPaymentDataTableDiv">
                                                                    <table class="table table-bordered table-hover" id="subscriberPaymentDataTable">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Date</th>
                                                                                <th>Amount</th>
                                                                                <th>Service Plan</th>
                                                                                <th>Credit Card</th>
                                                                                <th>Auto Pay</th>
                                                                                <th>Duraion</th>
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
                                            <button type="button" name="subscriberPlanEditFormSubmitBtn" id="subscriberPlanEditFormSubmitBtn" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


<script type="text/javascript">
    $(document).ready(function() {

        $("[id^=subscriberPaymentBtn_]").on('click', function(event) {
            event.preventDefault();

            var subscriberPaymentEditBtnId = this.id;
            var selectedSubscriberUid = $("#"+subscriberPaymentEditBtnId).data("uid");

            $("#subscriberPlanEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/subscriber/getSubscriberAllPaymentData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {subscriberId: selectedSubscriberUid},
                success: function(data){
                    $("#subscriberPlanEditFormSubscriberId").val(selectedSubscriberUid);

                    var subscriberPlanID = data.subscriberPlanID;
                    if(subscriberPlanID != ""){
                        $("#subsServicePlanInput option[value="+subscriberPlanID+"]").prop('selected', 'selected').change();
                    }

                    var subscriberPaymentDataArr = data.subscriberPaymentDataArr;
                    if(subscriberPaymentDataArr.length != 0){
                        $("#subscriberPaymentDataTBody").empty();

                        var i = 1;
                        var subscriberPaymentTableDataStr = "";
                        $.each(subscriberPaymentDataArr, function(index, val) {
                            subscriberPaymentTableDataStr += "<tr>";
                            subscriberPaymentTableDataStr += "<td>"+i+"</td>";
                            subscriberPaymentTableDataStr += "<td>"+val.date+"</td>";
                            subscriberPaymentTableDataStr += "<td>"+val.price+"</td>";
                            subscriberPaymentTableDataStr += "<td>"+val.plan_type+"</td>";
                            subscriberPaymentTableDataStr += "<td>"+val.card_no+"</td>";
                            subscriberPaymentTableDataStr += "<td>"+val.autopay+"</td>";
                            subscriberPaymentTableDataStr += "<td>"+val.startdate+" to "+val.enddate+"</td>";
                            subscriberPaymentTableDataStr += "</tr>";
                            i++;
                        });
                        $("#subscriberPaymentDataTBody").html(subscriberPaymentTableDataStr);
                    }
                    else{
                        $("#subscriberPaymentDataTBody").empty();
                        $("#subscriberPaymentDataTBody").html("<tr><td colspan='6' style='font-size:14px;text-align;center;'>No payment history found</div>");
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

            $("#subscriberPaymentEditModal").modal("show");
        });

        $("#subscriberPlanEditFormSubmitBtn").on("click", function(event) {
            event.preventDefault();

            if($("#subsServicePlanInput").val() != ""){

                var formDataStr = $("#subscriberPlanEditForm").serialize();

                $.ajax({
                    url: "<?php echo site_url('admin/subscriber/saveSubscriberPlanData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: formDataStr,
                    success: function(data){
                        if(data.msgType == "success"){
                            $("#subscriberPlanEditFormUpdateSuccessAlert").html(data.msg).css("display", "block");
                            setInterval(function(){
                                $("#subscriberPlanEditFormUpdateSuccessAlert").css("display", "none");
                                $("#subscriberPaymentEditModal").modal("hide");
                                window.location.href = window.location.href;
                            }, 4000);
                        }
                        else{
                            $("#subscriberPlanEditFormUpdateErrorAlert").html(data.msg).css("display", "block");
                            setInterval(function(){$("#subscriberPlanEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                        }
                    },
                    error: function(xhr, status, error){
                        $("#subscriberPlanEditFormUpdateErrorAlert").html(error).css("display", "block");
                        setInterval(function(){$("#subscriberPlanEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                    }
                });
                
            }
            else{
                $("#subsServicePlanInput").focus();
                $("#subscriberPlanEditFormUpdateErrorAlert").html("First Name is empty.").css("display", "block");
                setInterval(function(){$("#subscriberPlanEditFormUpdateErrorAlert").css("display", "none")}, 6000);
            }
        });

        // Subscriber Info edit button click event
        $("[id^=subscriberInfoEditBtn_]").on("click", function(event) {
            event.preventDefault();

            var subscriberInfoEditBtnId = this.id;
            var selectedSubscriberUid = $("#"+subscriberInfoEditBtnId).data("uid");

            $("#subscriberInfoEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/subscriber/getSubscriberAllData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {subscriberId: selectedSubscriberUid},
                success: function(data){
                    $("#subscriberInfoEditFormSubscriberId").val(data.uid);
                    $("#subsFirstNameInput").val(data.first_name);
                    $("#subsLastNameInput").val(data.last_name);
                    $("#subsCompanyInput").val(data.company);
                    $("#subsTelInput").val(data.telephone);
                    $("#subsEmailInput").val(data.email);
                    $("#subsFaxInput").val(data.fax);
                    $("#subsStreet1Input").val(data.address_street_1);
                    $("#subsStreet2Input").val(data.address_street_2);
                    $("#subsCityInput").val(data.city);
                    $("#subsStateInput").val(data.state);
                    $("#subsZipInput").val(data.zipcode);
                    $("#subsCountryInput").val(data.country);
                    $("#subsCardTypeInput").val(data.card_type).change();
                    $("#subsCardNoInput").val(data.card_no);
                    $("#subsCardCVVNoInput").val(data.card_cvv);
                    $("#subsCardExpMonthInput").val(data.card_exp_month).change();
                    $("#subsCardExpYearInput").val(data.card_exp_year).change();

                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });
            
            $("#subscriberInfoEditModal").modal("show");
        });

        // Subscriber Info Edit Form Submit
        $("#subscriberInfoEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            if($("#subsFirstNameInput").val() != ""){
                if($("#subsLastNameInput").val() != ""){
                    if($("#subsTelInput").val() != ""){
                        if($("#subsEmailInput").val() != ""){
                            if($("#subsStreet1Input").val() != ""){
                                if($("#subsCityInput").val() != ""){
                                    if($("#subsCountryInput").val() != ""){
                                        if($("#subsCardTypeInput").val() != ""){
                                            if($("#subsCardNoInput").val() != ""){
                                                if($("#subsCardCVVNoInput").val() != ""){
                                                    if($("#subsCardExpMonthInput").val() != ""){
                                                        if($("#subsCardExpYearInput").val() != ""){

                                                            var formDataStr = $("#subscriberInfoEditForm").serialize();

                                                            $.ajax({
                                                                url: "<?php echo site_url('admin/subscriber/saveSubscriberAllData'); ?>",
                                                                type: 'POST',
                                                                dataType: 'json',
                                                                data: formDataStr,
                                                                success: function(data){
                                                                    if(data.msgType == "success"){
                                                                        $("#subscriberInfoEditFormUpdateSuccessAlert").html(data.msg).css("display", "block");
                                                                        setInterval(function(){
                                                                            $("#subscriberInfoEditFormUpdateSuccessAlert").css("display", "none");
                                                                            $("#subscriberInfoEditModal").modal("hide");
                                                                            window.location.href = window.location.href;
                                                                        }, 4000);
                                                                    }
                                                                    else{
                                                                        $("#subscriberInfoEditFormUpdateErrorAlert").html(data.msg).css("display", "block");
                                                                        setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                                                    }
                                                                },
                                                                error: function(xhr, status, error){
                                                                    $("#subscriberInfoEditFormUpdateErrorAlert").html(error).css("display", "block");
                                                                    setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                                                }
                                                            });
                                                            
                                                        }
                                                        else{
                                                            $("#subsCardExpYearInput").focus();
                                                            $("#subscriberInfoEditFormUpdateErrorAlert").html("Card Expiry Year is empty.").css("display", "block");
                                                            setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                                        }
                                                    }
                                                    else{
                                                        $("#subsCardExpMonthInput").focus();
                                                        $("#subscriberInfoEditFormUpdateErrorAlert").html("Card Expiry Month is empty.").css("display", "block");
                                                        setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                                    }
                                                }
                                                else{
                                                    $("#subsCardCVVNoInput").focus();
                                                    $("#subscriberInfoEditFormUpdateErrorAlert").html("Credit Card CVV Number is empty.").css("display", "block");
                                                    setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                                }
                                            }
                                            else{
                                                $("#subsCardNoInput").focus();
                                                $("#subscriberInfoEditFormUpdateErrorAlert").html("Credit Card Number is empty.").css("display", "block");
                                                setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                            }
                                        }
                                        else{
                                            $("#subsCardTypeInput").focus();
                                            $("#subscriberInfoEditFormUpdateErrorAlert").html("Credit Card Type is empty.").css("display", "block");
                                            setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                        }
                                    }
                                    else{
                                        $("#subsCountryInput").focus();
                                        $("#subscriberInfoEditFormUpdateErrorAlert").html("Country is empty.").css("display", "block");
                                        setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                    }
                                }
                                else{
                                    $("#subsCityInput").focus();
                                    $("#subscriberInfoEditFormUpdateErrorAlert").html("City is empty.").css("display", "block");
                                    setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                                }
                            }
                            else{
                                $("#subsStreet1Input").focus();
                                $("#subscriberInfoEditFormUpdateErrorAlert").html("Street Address #1 is empty.").css("display", "block");
                                setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                            }
                        }
                        else{
                            // alert("Email is empty.");
                            $("#subsEmailInput").focus();
                            $("#subscriberInfoEditFormUpdateErrorAlert").html("Email is empty.").css("display", "block");
                            setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                        }
                    }
                    else{
                        $("#subsTelInput").focus();
                        $("#subscriberInfoEditFormUpdateErrorAlert").html("Telephone is empty.").css("display", "block");
                        setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                    }
                }
                else{
                    $("#subsLastNameInput").focus();
                    $("#subscriberInfoEditFormUpdateErrorAlert").html("Last Name is empty.").css("display", "block");
                    setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
                }
            }
            else{
                $("#subsFirstNameInput").focus();
                $("#subscriberInfoEditFormUpdateErrorAlert").html("First Name is empty.").css("display", "block");
                setInterval(function(){$("#subscriberInfoEditFormUpdateErrorAlert").css("display", "none")}, 6000);
            }
        });

    });
</script>