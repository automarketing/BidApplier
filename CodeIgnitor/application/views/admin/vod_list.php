    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>VOD List</h2>
                        </div>
                        <div class="body">

	                        <div id="vodListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="vodListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/channelvod/vod'); ?>" name="vodSearchForm" id="vodSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td>
                                        <select name="vodSearchFormCategoryInput" id="vodSearchFormCategoryInput" class="form-control">
                                            <option value="">--- Category ---</option>
                                            <?php foreach($categoryDataResult as $categoryData){ ?>
                                            <option value="<?php echo $categoryData['uid']; ?>"<?php if($vodSearchFormCategoryInput == $categoryData['uid']){ ?> selected="selected"<?php } ?>><?php echo $categoryData['category']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="vodSearchFormCountryInput" id="vodSearchFormCountryInput" class="form-control">
                                            <option value="">--- Country ---</option>
                                            <?php foreach($countryDataResult as $countryData){ ?>
                                            <option value="<?php echo $countryData['id']; ?>"<?php if($vodSearchFormCountryInput == $countryData['id']){ ?> selected="selected"<?php } ?>><?php echo $countryData['country']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="vodSearchFormCompanyInput" id="vodSearchFormCompanyInput" class="form-control">
                                            <option value="">--- Company ---</option>
                                            <?php foreach($companyDataResult as $companyData){ ?>
                                            <option value="<?php echo $companyData['uid']; ?>"<?php if($vodSearchFormCompanyInput == $companyData['uid']){ ?> selected="selected"<?php } ?>><?php echo $companyData['company']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="vodSearchFormLanguageInput" id="vodSearchFormLanguageInput" class="form-control">
                                            <option value="">--- Language ---</option>
                                            <?php foreach($languageDataResult as $languageData){ ?>
                                            <option value="<?php echo $languageData['uid']; ?>"<?php if($vodSearchFormLanguageInput == $languageData['uid']){ ?> selected="selected"<?php } ?>><?php echo $languageData['language']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input name="vodSearchFormUrlInput" id="vodSearchFormUrlInput" class="form-control" style="width:100%;" value="<?php echo $vodSearchFormUrlInput; ?>" placeholder="URL"></td>
                                    <td>
                                        <select name="vodSearchFormLiveInput" id="vodSearchFormLiveInput" class="form-control">
                                            <option value="">--- Live Status ---</option>
                                            <option value="1"<?php if($vodSearchFormLiveInput == "1"){ ?> selected="selected"<?php } ?>>Live</option>
                                            <option value="0"<?php if($vodSearchFormLiveInput == "0"){ ?> selected="selected"<?php } ?>>Dead</option>
                                        </select>
                                    </td>
                                    <td><input name="vodSearchFormDateInput" id="vodSearchFormDateInput" class="datePickerInput form-control" style="width:100%;" value="<?php echo $vodSearchFormDateInput; ?>" placeholder="Date"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="vodSearchFormSubmitBtn" id="vodSearchFormSubmitBtn" class="btn btn-success" onclick="vodSearchForm.event.value='vodSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="vodAddBtn" id="vodAddBtn" class="btn btn-primary">Add VOD</button>
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
                                        foreach($vodDataArr as $vodData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $vodData["category_name"]; ?></td>
                                        <td><?php echo $vodData["country_name"]; ?></td>
                                        <td><?php echo $vodData["company_name"]; ?></td>
                                        <td><?php echo $vodData["language_name"]; ?></td>
                                        <td><?php echo $vodData["url"]; ?></td>
                                        <td><?php if($vodData["alive"] == 1){ ?><span class="label label-success">Live</span><?php }else{ ?><span class="label label-danger">Dead</span><?php } ?></td>
                                        <td><?php echo $vodData["date"]; ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary" name="vodEditBtn_<?php echo $vodData['uid']; ?>" id="vodEditBtn_<?php echo $vodData['uid']; ?>" data-uid="<?php echo $vodData['uid']; ?>" title="Edit Vod"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-danger" name="vodDeleteBtn_<?php echo $vodData['uid']; ?>" id="vodDeleteBtn_<?php echo $vodData['uid']; ?>" data-uid="<?php echo $vodData['uid']; ?>" title="Delete Vod"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Vod Add Modal -->
                <div class="modal fade" id="vodAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add VOD</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="vodAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="vodAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="vodAddForm" id="vodAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodCategoryInput">Category <span>*</span></label>
                                                            <select name="vodCategoryInput" id="vodCategoryInput" class="form-control" required="required">
                                                                <option value="">--- Category ---</option>
                                                                <?php foreach($categoryDataResult as $categoryData){ ?>
                                                                <option value="<?php echo $categoryData['uid']; ?>"><?php echo $categoryData['category']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodCountryInput">Country <span>*</span></label>
                                                            <select name="vodCountryInput" id="vodCountryInput" class="form-control" required="required">
                                                                <option value="">--- Country ---</option>
                                                                <?php foreach($countryDataResult as $countryData){ ?>
                                                                <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodCompanyInput">Company <span>*</span></label>
                                                            <select name="vodCompanyInput" id="vodCompanyInput" class="form-control" required="required">
                                                                <option value="">--- Company ---</option>
                                                                <?php foreach($companyDataResult as $companyData){ ?>
                                                                <option value="<?php echo $companyData['uid']; ?>"><?php echo $companyData['company']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodLanguageInput">Language <span>*</span></label>
                                                            <select name="vodLanguageInput" id="vodLanguageInput" class="form-control" required="required">
                                                                <option value="">--- Language ---</option>
                                                                <?php foreach($languageDataResult as $languageData){ ?>
                                                                <option value="<?php echo $languageData['uid']; ?>"><?php echo $languageData['language']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodUrlInput">URL <span>*</span></label>
                                                            <input name="vodUrlInput" id="vodUrlInput" class="form-control" style="width:100%;" value="" placeholder="Url">
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodAliveInput">Alive <span>*</span></label>
                                                            <select name="vodAliveInput" id="vodAliveInput" class="form-control">
                                                                <option value="">--- Live Status ---</option>
                                                                <option value="1">Live</option>
                                                                <option value="0">Dead</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodDateInput">Date <span>*</span></label>
                                                            <input name="vodDateInput" id="vodDateInput" class="datePickerInput form-control" style="width:100%;" value="" placeholder="Date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="vodAddFormCancelBtn" id="vodAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="vodAddFormSubmitBtn" id="vodAddFormSubmitBtn" class="btn btn-primary">Add Vod</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Vod Edit Modal -->
                <div class="modal fade" id="vodEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Vod</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            
                                            <div id="vodEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="vodEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="vodEditForm" id="vodEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditCategoryInput">Category <span>*</span></label>
                                                            <select name="vodEditCategoryInput" id="vodEditCategoryInput" class="form-control" required="required">
                                                                <option value="">--- Category ---</option>
                                                                <?php foreach($categoryDataResult as $categoryData){ ?>
                                                                <option value="<?php echo $categoryData['uid']; ?>"><?php echo $categoryData['category']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditCountryInput">Country <span>*</span></label>
                                                            <select name="vodEditCountryInput" id="vodEditCountryInput" class="form-control" required="required">
                                                                <option value="">--- Country ---</option>
                                                                <?php foreach($countryDataResult as $countryData){ ?>
                                                                <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditCompanyInput">Company <span>*</span></label>
                                                            <select name="vodEditCompanyInput" id="vodEditCompanyInput" class="form-control" required="required">
                                                                <option value="">--- Company ---</option>
                                                                <?php foreach($companyDataResult as $companyData){ ?>
                                                                <option value="<?php echo $companyData['uid']; ?>"><?php echo $companyData['company']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditLanguageInput">Language <span>*</span></label>
                                                            <select name="vodEditLanguageInput" id="vodEditLanguageInput" class="form-control" required="required">
                                                                <option value="">--- Language ---</option>
                                                                <?php foreach($languageDataResult as $languageData){ ?>
                                                                <option value="<?php echo $languageData['uid']; ?>"><?php echo $languageData['language']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditUrlInput">URL <span>*</span></label>
                                                            <input name="vodEditUrlInput" id="vodEditUrlInput" class="form-control" style="width:100%;" value="" placeholder="Url">
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditAliveInput">Alive <span>*</span></label>
                                                            <select name="vodEditAliveInput" id="vodEditAliveInput" class="form-control">
                                                                <option value="">--- Live Status ---</option>
                                                                <option value="1">Live</option>
                                                                <option value="0">Dead</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="vodEditDateInput">Date <span>*</span></label>
                                                            <input name="vodEditDateInput" id="vodEditDateInput" class="datePickerInput form-control" style="width:100%;" value="" placeholder="Date">
                                                            <input type="hidden" name="vodID" id="vodID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="vodEditFormCancelBtn" id="vodEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="vodEditFormSubmitBtn" id="vodEditFormSubmitBtn" class="btn btn-primary">Update Vod</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->



<script type="text/javascript">
    $(document).ready(function() {

        // $("#datePickerInput").datepicker();

        // to add vod modal popup
        $("#vodAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#vodAddForm")[0].reset();
            $("#vodAddModal").modal("show");
        });

        // to save vod to database 
        $("#vodAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#vodAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/addVodData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#vodAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#vodAddFormSuccessAlert").css("display", "none");
                            $("#vodAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#vodAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#vodAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit vod
        $("[id^=vodEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var vodID = $(this).data("uid");
            $("#vodEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/getVodData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {vodID: vodID},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#vodEditCategoryInput").val(data.msgDetail[0].category).change();
                        $("#vodEditCountryInput").val(data.msgDetail[0].country).change();
                        $("#vodEditCompanyInput").val(data.msgDetail[0].company).change();
                        $("#vodEditLanguageInput").val(data.msgDetail[0].language).change();
                        $("#vodEditUrlInput").val(data.msgDetail[0].url);
                        $("#vodEditAliveInput").val(data.msgDetail[0].alive).change();
                        $("#vodEditDateInput").val(data.msgDetail[0].date);
                        $("#vodID").val(vodID);
                        $("#vodEditModal").modal("show");
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

        // to update vod
        $("#vodEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#vodEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/updateVodData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#vodEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#vodEditFormSuccessAlert").css("display", "none");
                            $("#vodEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#vodEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#vodEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to delete vod
        $("[id^=vodDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var vodID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/channelvod/deleteVodData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {vodID: vodID},
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