    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Ticket Questions List</h2>
                        </div>
                        <div class="body">

	                        <div id="ticketQuestionListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="ticketQuestionListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/ticket/ticket_questions'); ?>" name="ticketQuestionSearchForm" id="ticketQuestionSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="ticketQuestionSearchFormQuestionInput" id="ticketQuestionSearchFormQuestionInput" class="form-control" style="width:100%;" value="<?php echo $ticketQuestionSearchFormQuestionInput; ?>" placeholder="Name"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="ticketQuestionSearchFormSubmitBtn" id="ticketQuestionSearchFormSubmitBtn" class="btn btn-success" onclick="ticketQuestionSearchForm.event.value='ticketQuestionSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="ticketQuestionAddBtn" id="ticketQuestionAddBtn" class="btn btn-primary">Add Question</button>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Question</th>
                                        <th style="vertical-align:top">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($ticketQuestionDataArr as $ticketQuestionData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $ticketQuestionData["question"]; ?></td>
                                        <td>
	                                        <?php if($ticketQuestionData["active_status"] == 1){ ?>
                                          	<button type="button" class="btn btn-default" name="ticketQuestionInactiveBtn_<?php echo $ticketQuestionData['uid']; ?>" id="ticketQuestionInactiveBtn_<?php echo $ticketQuestionData['uid']; ?>" data-uid="<?php echo $ticketQuestionData['uid']; ?>" title="Inactive Question"><i class="fa fa-check" aria-hidden="true"></i></button>
	                                        <?php }else{ ?>
                                          	<button type="button" class="btn btn-primary" name="ticketQuestionActiveBtn_<?php echo $ticketQuestionData['uid']; ?>" id="ticketQuestionActiveBtn_<?php echo $ticketQuestionData['uid']; ?>" data-uid="<?php echo $ticketQuestionData['uid']; ?>" title="Active Question"><i class="fa fa-check" aria-hidden="true"></i></button>
	                                        <?php } ?>
                                          	<button type="button" class="btn btn-primary" name="ticketQuestionEditBtn_<?php echo $ticketQuestionData['uid']; ?>" id="ticketQuestionEditBtn_<?php echo $ticketQuestionData['uid']; ?>" data-uid="<?php echo $ticketQuestionData['uid']; ?>" title="Edit Question"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Ticket Question Add Modal -->
                <div class="modal fade" id="questionAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Question</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="questionAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="questionAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="questionAddForm" id="questionAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="subsFirstNameInput">Question <span>*</span></label>
                                                            <textarea name="questionInput" id="questionInput" class="form-control" rows="5" required="required" style="resize:none;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="questionAddFormCancelBtn" id="questionAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="questionAddFormSubmitBtn" id="questionAddFormSubmitBtn" class="btn btn-primary">Add Question</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Ticket Question Edit Modal -->
                <div class="modal fade" id="questionEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Question</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="questionEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="questionEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="questionEditForm" id="questionEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="questionEditInput">Question <span>*</span></label>
                                                            <textarea name="questionEditInput" id="questionEditInput" class="form-control" rows="5" required="required" style="resize:none;"></textarea>
                                                            <input type="hidden" name="ticketQuestionID" id="ticketQuestionID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="questionEditFormCancelBtn" id="questionEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="questionEditFormSubmitBtn" id="questionEditFormSubmitBtn" class="btn btn-primary">Update Question</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->




<script type="text/javascript">
    $(document).ready(function() {

    	// to add ticket question modal popup
    	$("#ticketQuestionAddBtn").on('click', function(event) {
    		event.preventDefault();

            $("#questionAddForm")[0].reset();
    		$("#questionAddModal").modal("show");
    	});

    	// to save ticket question to database 
    	$("#questionAddFormSubmitBtn").on('click', function(event) {
    		event.preventDefault();

    		var formData = $("#questionAddForm").serialize();
            $.ajax({
                url: "<?php echo site_url('admin/ticket/addTicketQuestionData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#questionAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#questionAddFormSuccessAlert").css("display", "none");
                            $("#questionAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#questionAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#questionAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

    	});

    	// to inactivate ticket question
    	$("[id^=ticketQuestionInactiveBtn_]").on('click', function(event) {
    		event.preventDefault();

    		var ticketQuestionID = $(this).data("uid");
    		var titcketQuestionActiveStatus = 0;

            $.ajax({
                url: "<?php echo site_url('admin/ticket/updateTicketQuestionActiveData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {ticketQuestionID: ticketQuestionID, titcketQuestionActiveStatus: titcketQuestionActiveStatus},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#ticketQuestionListSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#ticketQuestionListSuccessAlert").css("display", "none");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#ticketQuestionListErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#ticketQuestionListErrorAlert").css("display", "none")}, 4000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

    	});

    	// to activate ticket question
    	$("[id^=ticketQuestionActiveBtn_]").on('click', function(event) {
    		event.preventDefault();

    		var ticketQuestionID = $(this).data("uid");
    		var titcketQuestionActiveStatus = 1;

            $.ajax({
                url: "<?php echo site_url('admin/ticket/updateTicketQuestionActiveData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {ticketQuestionID: ticketQuestionID, titcketQuestionActiveStatus: titcketQuestionActiveStatus},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#ticketQuestionListSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#ticketQuestionListSuccessAlert").css("display", "none");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#ticketQuestionListErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#ticketQuestionListErrorAlert").css("display", "none")}, 4000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

    	});

    	// to edit ticket question
    	$("[id^=ticketQuestionEditBtn_]").on('click', function(event) {
    		event.preventDefault();

    		var ticketQuestionID = $(this).data("uid");
    		$("#questionEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/ticket/getTicketQuestionData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {ticketQuestionID: ticketQuestionID},
                success: function(data){
                    if(data.msgType == "success"){
                    	$("#questionEditInput").val(data.msgDetail[0].question);
                    	$("#ticketQuestionID").val(ticketQuestionID);
                    	$("#questionEditModal").modal("show");
                    }
                    else{
                    	alert(data.mag);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

    	});

    	// to update ticket question
    	$("#questionEditFormSubmitBtn").on('click', function(event) {
    		event.preventDefault();

    		var formData = $("#questionEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/ticket/updateTicketQuestionData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#questionEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#questionEditFormSuccessAlert").css("display", "none");
                            $("#questionEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#questionEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#questionEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

    	});
	});
</script>