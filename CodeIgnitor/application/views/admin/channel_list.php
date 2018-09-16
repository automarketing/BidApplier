    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Channel List</h2>
                        </div>
                        <div class="body">

	                        <div id="channelListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="channelListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/channelvod/channel'); ?>" name="channelSearchForm" id="channelSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td>
                                        <select name="channelSearchFormCategoryInput" id="channelSearchFormCategoryInput" class="form-control">
                                            <option value="">--- Category ---</option>
                                            <?php foreach($categoryDataResult as $categoryData){ ?>
                                            <option value="<?php echo $categoryData['uid']; ?>"<?php if($channelSearchFormCategoryInput == $categoryData['uid']){ ?> selected="selected"<?php } ?>><?php echo $categoryData['category']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="channelSearchFormCountryInput" id="channelSearchFormCountryInput" class="form-control">
                                            <option value="">--- Country ---</option>
                                            <?php foreach($countryDataResult as $countryData){ ?>
                                            <option value="<?php echo $countryData['id']; ?>"<?php if($channelSearchFormCountryInput == $countryData['id']){ ?> selected="selected"<?php } ?>><?php echo $countryData['country']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="channelSearchFormCompanyInput" id="channelSearchFormCompanyInput" class="form-control">
                                            <option value="">--- Company ---</option>
                                            <?php foreach($companyDataResult as $companyData){ ?>
                                            <option value="<?php echo $companyData['uid']; ?>"<?php if($channelSearchFormCompanyInput == $companyData['uid']){ ?> selected="selected"<?php } ?>><?php echo $companyData['company']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="channelSearchFormLanguageInput" id="channelSearchFormLanguageInput" class="form-control">
                                            <option value="">--- Language ---</option>
                                            <?php foreach($languageDataResult as $languageData){ ?>
                                            <option value="<?php echo $languageData['uid']; ?>"<?php if($channelSearchFormLanguageInput == $languageData['uid']){ ?> selected="selected"<?php } ?>><?php echo $languageData['language']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="channelSearchFormUrlInput" id="channelSearchFormUrlInput" class="form-control" style="width:100%;" value="<?php echo $channelSearchFormUrlInput; ?>" placeholder="URL"></td>
                                    <td>
                                        <select name="channelSearchFormLiveInput" id="channelSearchFormLiveInput" class="form-control">
                                            <option value="">--- Live Status ---</option>
                                            <option value="1"<?php if($channelSearchFormLiveInput == "1"){ ?> selected="selected"<?php } ?>>Live</option>
                                            <option value="0"<?php if($channelSearchFormLiveInput == "0"){ ?> selected="selected"<?php } ?>>Dead</option>
                                        </select>
                                    </td>
                                    <td><input name="channelSearchFormDateInput" id="channelSearchFormDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $channelSearchFormDateInput; ?>" placeholder="Date"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="channelSearchFormSubmitBtn" id="channelSearchFormSubmitBtn" class="btn btn-success" onclick="channelSearchForm.event.value='channelSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="channelAddBtn" id="channelAddBtn" class="btn btn-primary">Add Channel</button>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Category</th>
                                        <th style="vertical-align:top">Country</th>
                                        <th style="vertical-align:top">Company</th>
                                        <th style="vertical-align:top">Language</th>
                                        <th style="vertical-align:top">Url</th>
                                        <th style="vertical-align:top">Alive</th>
                                        <th style="vertical-align:top">Date</th>
                                        <th style="vertical-align:top">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($channelDataArr as $channelData){ 
                                    ?>
                                    <tr class="tableDataTR" id="channelListTableDataTR_<?php echo $channelData["uid"]; ?>">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $channelData["category_name"]; ?></td>
                                        <td><?php echo $channelData["country_name"]; ?></td>
                                        <td><?php echo $channelData["company_name"]; ?></td>
                                        <td><?php echo $channelData["language_name"]; ?></td>
                                        <td id="channelListTableDataTRChannelUrl_<?php echo $channelData["uid"]; ?>"><?php echo $channelData["url"]; ?></td>
                                        <td><?php if($channelData["alive"] == 1){ ?><span class="label label-success">Live</span><?php }else{ ?><span class="label label-danger">Dead</span><?php } ?></td>
                                        <td><?php echo $channelData["date"]; ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary" name="channelEditBtn_<?php echo $channelData['uid']; ?>" id="channelEditBtn_<?php echo $channelData['uid']; ?>" data-uid="<?php echo $channelData['uid']; ?>" title="Edit Channel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-primary" name="channelDeleteBtn_<?php echo $channelData['uid']; ?>" id="channelDeleteBtn_<?php echo $channelData['uid']; ?>" data-uid="<?php echo $channelData['uid']; ?>" title="Delete Channel"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Channel Add Modal -->
                <div class="modal fade" id="channelAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Channel</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="channelAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="channelAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="channelAddForm" id="channelAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelCategoryInput">Category <span>*</span></label>
                                                            <select name="channelCategoryInput" id="channelCategoryInput" class="form-control" required="required">
                                                                <option value="">--- Category ---</option>
                                                                <?php foreach($categoryDataResult as $categoryData){ ?>
                                                                <option value="<?php echo $categoryData['uid']; ?>"><?php echo $categoryData['category']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelCountryInput">Country <span>*</span></label>
                                                            <select name="channelCountryInput" id="channelCountryInput" class="form-control" required="required">
                                                                <option value="">--- Country ---</option>
                                                                <?php foreach($countryDataResult as $countryData){ ?>
                                                                <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelCompanyInput">Company <span>*</span></label>
                                                            <select name="channelCompanyInput" id="channelCompanyInput" class="form-control" required="required">
                                                                <option value="">--- Company ---</option>
                                                                <?php foreach($companyDataResult as $companyData){ ?>
                                                                <option value="<?php echo $companyData['uid']; ?>"><?php echo $companyData['company']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelLanguageInput">Language <span>*</span></label>
                                                            <select name="channelLanguageInput" id="channelLanguageInput" class="form-control" required="required">
                                                                <option value="">--- Language ---</option>
                                                                <?php foreach($languageDataResult as $languageData){ ?>
                                                                <option value="<?php echo $languageData['uid']; ?>"><?php echo $languageData['language']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelUrlInput">URL <span>*</span></label>
                                                            <input name="channelUrlInput" id="channelUrlInput" class="form-control" style="width:100%;" value="" placeholder="Url">
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelAliveInput">Alive <span>*</span></label>
                                                            <select name="channelAliveInput" id="channelAliveInput" class="form-control">
                                                                <option value="">--- Live Status ---</option>
                                                                <option value="1">Live</option>
                                                                <option value="0">Dead</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelDateInput">Date <span>*</span></label>
                                                            <input name="channelDateInput" id="channelDateInput" class="datePickerInput form-control" style="width:100%;" value="" placeholder="Date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="channelAddFormCancelBtn" id="channelAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="channelAddFormSubmitBtn" id="channelAddFormSubmitBtn" class="btn btn-primary">Add Channel</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Channel Edit Modal -->
                <div class="modal fade" id="channelEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Channel</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="channelEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="channelEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="channelEditForm" id="channelEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditCategoryInput">Category <span>*</span></label>
                                                            <select name="channelEditCategoryInput" id="channelEditCategoryInput" class="form-control" required="required">
                                                                <option value="">--- Category ---</option>
                                                                <?php foreach($categoryDataResult as $categoryData){ ?>
                                                                <option value="<?php echo $categoryData['uid']; ?>"><?php echo $categoryData['category']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditCountryInput">Country <span>*</span></label>
                                                            <select name="channelEditCountryInput" id="channelEditCountryInput" class="form-control" required="required">
                                                                <option value="">--- Country ---</option>
                                                                <?php foreach($countryDataResult as $countryData){ ?>
                                                                <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditCompanyInput">Company <span>*</span></label>
                                                            <select name="channelEditCompanyInput" id="channelEditCompanyInput" class="form-control" required="required">
                                                                <option value="">--- Company ---</option>
                                                                <?php foreach($companyDataResult as $companyData){ ?>
                                                                <option value="<?php echo $companyData['uid']; ?>"><?php echo $companyData['company']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditLanguageInput">Language <span>*</span></label>
                                                            <select name="channelEditLanguageInput" id="channelEditLanguageInput" class="form-control" required="required">
                                                                <option value="">--- Language ---</option>
                                                                <?php foreach($languageDataResult as $languageData){ ?>
                                                                <option value="<?php echo $languageData['uid']; ?>"><?php echo $languageData['language']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditUrlInput">URL <span>*</span></label>
                                                            <input name="channelEditUrlInput" id="channelEditUrlInput" class="form-control" style="width:100%;" value="" placeholder="Url">
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditAliveInput">Alive <span>*</span></label>
                                                            <select name="channelEditAliveInput" id="channelEditAliveInput" class="form-control">
                                                                <option value="">--- Live Status ---</option>
                                                                <option value="1">Live</option>
                                                                <option value="0">Dead</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="channelEditDateInput">Date <span>*</span></label>
                                                            <input name="channelEditDateInput" id="channelEditDateInput" class="datePickerInput form-control" style="width:100%;" value="" placeholder="Date">
                                                            <input type="hidden" name="channelID" id="channelID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="channelEditFormCancelBtn" id="channelEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="channelEditFormSubmitBtn" id="channelEditFormSubmitBtn" class="btn btn-primary">Update Channel</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Channel URL Video Show Modal -->
                <div class="modal fade" id="channelUrlVideoShowModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Live Channel Video</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <video id="channelUrlVideoPlayer" width="550" height="380" class="video-js vjs-default-skin" controls>
                                              <!-- <source src="" type="video/mp4"> -->
                                            </video>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <!-- <button type="button" name="channelUrlVideoShowModalCloseModal" id="channelUrlVideoShowModalCloseModal" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                                <button type="button" name="channelUrlVideoShowModalCloseModal" id="channelUrlVideoShowModalCloseModal" class="btn btn-secondary">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->




<script type="text/javascript">
    $(document).ready(function() {

        // $("#channelSearchFormDateInput").datepicker();

        // to add channel modal popup
        $("#channelAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#channelAddForm")[0].reset();
            $("#channelAddModal").modal("show");
        });

        // to save channel to database 
        $("#channelAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#channelAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/addChannelData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#channelAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#channelAddFormSuccessAlert").css("display", "none");
                            $("#channelAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#channelAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#channelAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit channel
        $("[id^=channelEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var channelID = $(this).data("uid");
            $("#channelEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/getChannelData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {channelID: channelID},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#channelEditCategoryInput").val(data.msgDetail[0].category).change();
                        $("#channelEditCountryInput").val(data.msgDetail[0].country).change();
                        $("#channelEditCompanyInput").val(data.msgDetail[0].company).change();
                        $("#channelEditLanguageInput").val(data.msgDetail[0].language).change();
                        $("#channelEditUrlInput").val(data.msgDetail[0].url);
                        $("#channelEditAliveInput").val(data.msgDetail[0].alive).change();
                        $("#channelEditDateInput").val(data.msgDetail[0].date);
                        $("#channelID").val(channelID);
                        $("#channelEditModal").modal("show");
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

        // to update channel
        $("#channelEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#channelEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/updateChannelData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#channelEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#channelEditFormSuccessAlert").css("display", "none");
                            $("#channelEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#channelEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#channelEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to delete channel
        $("[id^=channelDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var channelID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/channelvod/deleteChannelData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {channelID: channelID},
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