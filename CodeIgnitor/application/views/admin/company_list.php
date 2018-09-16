    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Company List</h2>
                        </div>
                        <div class="body">

	                        <div id="companyListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="companyListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/channelvod/company'); ?>" name="companySearchForm" id="companySearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="companySearchFormCompanyInput" id="companySearchFormCompanyInput" class="form-control" style="width:100%;" value="<?php echo $companySearchFormCompanyInput; ?>" placeholder="Company"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="companySearchFormSubmitBtn" id="companySearchFormSubmitBtn" class="btn btn-success" onclick="companySearchForm.event.value='companySearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="companyAddBtn" id="companyAddBtn" class="btn btn-primary">Add Company</button>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Company</th>
                                        <th style="vertical-align:top">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($companyDataArr as $companyData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $companyData["company"]; ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary" name="companyEditBtn_<?php echo $companyData['uid']; ?>" id="companyEditBtn_<?php echo $companyData['uid']; ?>" data-uid="<?php echo $companyData['uid']; ?>" title="Edit Company"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-primary" name="companyDeleteBtn_<?php echo $companyData['uid']; ?>" id="companyDeleteBtn_<?php echo $companyData['uid']; ?>" data-uid="<?php echo $companyData['uid']; ?>" title="Delete Company"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Company Add Modal -->
                <div class="modal fade" id="companyAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Company</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="companyAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="companyAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="companyAddForm" id="companyAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="companyInput">Company <span>*</span></label>
                                                            <input type="text" name="companyInput" id="companyInput" class="form-control" value="" required="required" title="Company">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="companyAddFormCancelBtn" id="companyAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="companyAddFormSubmitBtn" id="companyAddFormSubmitBtn" class="btn btn-primary">Add Company</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Company Edit Modal -->
                <div class="modal fade" id="companyEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Company</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="companyEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="companyEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="companyEditForm" id="companyEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="companyEditInput">Company <span>*</span></label>
                                                            <input type="text" name="companyEditInput" id="companyEditInput" class="form-control" value="" required="required" title="Company">
                                                            <input type="hidden" name="companyID" id="companyID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="companyEditFormCancelBtn" id="companyEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="companyEditFormSubmitBtn" id="companyEditFormSubmitBtn" class="btn btn-primary">Update Company</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->



<script type="text/javascript">
    $(document).ready(function() {

        // to add company modal popup
        $("#companyAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#companyAddForm")[0].reset();
            $("#companyAddModal").modal("show");
        });

        // to save company to database 
        $("#companyAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#companyAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/addCompanyData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#companyAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#companyAddFormSuccessAlert").css("display", "none");
                            $("#companyAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#companyAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#companyAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit company
        $("[id^=companyEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var companyID = $(this).data("uid");
            $("#companyEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/getCompanyData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {companyID: companyID},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#companyEditInput").val(data.msgDetail[0].company);
                        $("#companyID").val(companyID);
                        $("#companyEditModal").modal("show");
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

        // to update company
        $("#companyEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#companyEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/updateCompanyData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#companyEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#companyEditFormSuccessAlert").css("display", "none");
                            $("#companyEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#companyEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#companyEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit company
        $("[id^=companyDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var companyID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/channelvod/deleteCompanyData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {companyID: companyID},
                    success: function(data){
                        if(data.msgType == "success"){
                            window.location.href = window.location.href;
                        }
                        else{
                            alert(data.mag);
                        }
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
        });

    
    });
</script>