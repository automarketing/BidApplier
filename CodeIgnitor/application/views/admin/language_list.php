    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Language List</h2>
                        </div>
                        <div class="body">

	                        <div id="languageListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="languageListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/channelvod/language'); ?>" name="languageSearchForm" id="languageSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="languageSearchFormLanguageInput" id="languageSearchFormLanguageInput" class="form-control" style="width:100%;" value="<?php echo $languageSearchFormLanguageInput; ?>" placeholder="Language"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="languageSearchFormSubmitBtn" id="languageSearchFormSubmitBtn" class="btn btn-success" onclick="languageSearchForm.event.value='languageSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="languageAddBtn" id="languageAddBtn" class="btn btn-primary">Add Language</button>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Language</th>
                                        <th style="vertical-align:top">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($languageDataArr as $languageData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $languageData["language"]; ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary" name="languageEditBtn_<?php echo $languageData['uid']; ?>" id="languageEditBtn_<?php echo $languageData['uid']; ?>" data-uid="<?php echo $languageData['uid']; ?>" title="Edit Language"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-primary" name="languageDeleteBtn_<?php echo $languageData['uid']; ?>" id="languageDeleteBtn_<?php echo $languageData['uid']; ?>" data-uid="<?php echo $languageData['uid']; ?>" title="Delete Language"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Language Add Modal -->
                <div class="modal fade" id="languageAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Language</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="languageAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="languageAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="languageAddForm" id="languageAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="languageInput">Language <span>*</span></label>
                                                            <input type="text" name="languageInput" id="languageInput" class="form-control" value="" required="required" title="Language">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="languageAddFormCancelBtn" id="languageAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="languageAddFormSubmitBtn" id="languageAddFormSubmitBtn" class="btn btn-primary">Add Language</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Language Edit Modal -->
                <div class="modal fade" id="languageEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Language</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="languageEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="languageEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="languageEditForm" id="languageEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="languageEditInput">Language <span>*</span></label>
                                                            <input type="text" name="languageEditInput" id="languageEditInput" class="form-control" value="" required="required" title="Language">
                                                            <input type="hidden" name="languageID" id="languageID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="languageEditFormCancelBtn" id="languageEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="languageEditFormSubmitBtn" id="languageEditFormSubmitBtn" class="btn btn-primary">Update Language</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->



<script type="text/javascript">
    $(document).ready(function() {

        // to add language modal popup
        $("#languageAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#languageAddForm")[0].reset();
            $("#languageAddModal").modal("show");
        });

        // to save language to database 
        $("#languageAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#languageAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/addLanguageData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#languageAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#languageAddFormSuccessAlert").css("display", "none");
                            $("#languageAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#languageAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#languageAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit language
        $("[id^=languageEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var languageID = $(this).data("uid");
            $("#languageEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/getLanguageData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {languageID: languageID},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#languageEditInput").val(data.msgDetail[0].language);
                        $("#languageID").val(languageID);
                        $("#languageEditModal").modal("show");
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

        // to update language
        $("#languageEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#languageEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/updateLanguageData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#languageEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#languageEditFormSuccessAlert").css("display", "none");
                            $("#languageEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#languageEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#languageEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit language
        $("[id^=languageDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var languageID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/channelvod/deleteLanguageData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {languageID: languageID},
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