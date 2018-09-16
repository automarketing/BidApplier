    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Country List</h2>
                        </div>
                        <div class="body">

	                        <div id="countryListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="countryListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/channelvod/country'); ?>" name="countrySearchForm" id="countrySearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="countrySearchFormCountryInput" id="countrySearchFormCountryInput" class="form-control" style="width:100%;" value="<?php echo $countrySearchFormCountryInput; ?>" placeholder="Country"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="countrySearchFormSubmitBtn" id="countrySearchFormSubmitBtn" class="btn btn-success" onclick="countrySearchForm.event.value='countrySearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="countryAddBtn" id="countryAddBtn" class="btn btn-primary">Add Country</button>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Country</th>
                                        <th style="vertical-align:top">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($countryDataArr as $countryData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $countryData["country"]; ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary" name="countryEditBtn_<?php echo $countryData['id']; ?>" id="countryEditBtn_<?php echo $countryData['id']; ?>" data-uid="<?php echo $countryData['id']; ?>" title="Edit Country"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-primary" name="countryDeleteBtn_<?php echo $countryData['id']; ?>" id="countryDeleteBtn_<?php echo $countryData['id']; ?>" data-uid="<?php echo $countryData['id']; ?>" title="Delete Country"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Country Add Modal -->
                <div class="modal fade" id="countryAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Country</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="countryAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="countryAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="countryAddForm" id="countryAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="countryInput">Country <span>*</span></label>
                                                            <input type="text" name="countryInput" id="countryInput" class="form-control" value="" required="required" title="Country">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="countryAddFormCancelBtn" id="countryAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="countryAddFormSubmitBtn" id="countryAddFormSubmitBtn" class="btn btn-primary">Add Country</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Country Edit Modal -->
                <div class="modal fade" id="countryEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Country</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="countryEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="countryEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="countryEditForm" id="countryEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="countryEditInput">Country <span>*</span></label>
                                                            <input type="text" name="countryEditInput" id="countryEditInput" class="form-control" value="" required="required" title="Country">
                                                            <input type="hidden" name="countryID" id="countryID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="countryEditFormCancelBtn" id="countryEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="countryEditFormSubmitBtn" id="countryEditFormSubmitBtn" class="btn btn-primary">Update Country</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->



<script type="text/javascript">
    $(document).ready(function() {

        // to add country modal popup
        $("#countryAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#countryAddForm")[0].reset();
            $("#countryAddModal").modal("show");
        });

        // to save country to database 
        $("#countryAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#countryAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/addCountryData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#countryAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#countryAddFormSuccessAlert").css("display", "none");
                            $("#countryAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#countryAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#countryAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit country
        $("[id^=countryEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var countryID = $(this).data("uid");
            $("#countryEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/getCountryData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {countryID: countryID},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#countryEditInput").val(data.msgDetail[0].country);
                        $("#countryID").val(countryID);
                        $("#countryEditModal").modal("show");
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

        // to update country
        $("#countryEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#countryEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/updateCountryData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#countryEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#countryEditFormSuccessAlert").css("display", "none");
                            $("#countryEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#countryEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#countryEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit country
        $("[id^=countryDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var countryID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/channelvod/deleteCountryData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {countryID: countryID},
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