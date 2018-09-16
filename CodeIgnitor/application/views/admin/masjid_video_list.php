    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Masjid Video List</h2>
                        </div>
                        <div class="body">

	                        <div id="masjidVideoListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="masjidVideoListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/masjid/video_list'); ?>" name="masjidVideoListSearchForm" id="masjidVideoListSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="masjidVideoListSearchFormNameInput" id="masjidVideoListSearchFormNameInput" class="form-control" style="width:100%;" value="<?php echo $masjidVideoListSearchFormNameInput; ?>" placeholder="Name"></td>
                                    <td>
                                        <select name="masjidVideoListSearchFormCountryInput" id="masjidVideoListSearchFormCountryInput" class="form-control">
                                            <option value="">--- Country ---</option>
                                            <?php foreach($countryDataResult as $countryData){ ?>
                                            <option value="<?php echo $countryData['id']; ?>"<?php if($masjidVideoListSearchFormCountryInput == $countryData['id']){ ?> selected="selected"<?php } ?>><?php echo $countryData['country']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="masjidVideoListSearchFormStateInput" id="masjidVideoListSearchFormStateInput" class="form-control">
                                            <option value="">--- State ---</option>
                                            <?php foreach($stateDataResult as $stateData){ ?>
                                            <option value="<?php echo $stateData['id']; ?>"<?php if($masjidVideoListSearchFormStateInput == $stateData['id']){ ?> selected="selected"<?php } ?>><?php echo $stateData['state']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="masjidVideoListSearchFormCityInput" id="masjidVideoListSearchFormCityInput" class="form-control">
                                            <option value="">--- City ---</option>
                                            <?php foreach($cityDataResult as $cityData){ ?>
                                            <option value="<?php echo $cityData['id']; ?>"<?php if($masjidVideoListSearchFormCityInput == $cityData['id']){ ?> selected="selected"<?php } ?>><?php echo $cityData['city']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="masjidVideoListSearchFormSubmitBtn" id="masjidVideoListSearchFormSubmitBtn" class="btn btn-success" onclick="masjidVideoListSearchForm.event.value='masjidVideoListSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="masjidVideoListAddBtn" id="masjidVideoListAddBtn" class="btn btn-primary">Add Video</button>
                            </div>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Name</th>
                                        <th style="vertical-align:top">Address</th>
                                        <th style="vertical-align:top">URL</th>
                                        <th style="vertical-align:top">Alive</th>
                                        <th style="vertical-align:top">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($masjidVideoListDataArr as $masjidVideoListData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $masjidVideoListData["name"]; ?></td>
                                        <td>
                                        	<?php 
                                        		if (!empty($masjidVideoListData["city_name"])) {
	                                        		echo $masjidVideoListData["city_name"].", ";
                                        		}
                                        		if (!empty($masjidVideoListData["state_name"])) {
	                                        		echo $masjidVideoListData["state_name"].", ";
                                        		}
                                        		if (!empty($masjidVideoListData["country_name"])) {
	                                        		echo $masjidVideoListData["country_name"];
                                        		}
                                        	?>
                                        </td>
                                        <td><?php echo $masjidVideoListData["homeurl"]; ?></td>
                                        <td><?php if($masjidVideoListData["alive"] == 1){ ?><span class="label label-success">Live</span><?php }else{ ?><span class="label label-danger">Dead</span><?php } ?></td>
                                        <td>

                                            <button type="button" class="btn btn-primary" name="masjidVideoListEditBtn_<?php echo $masjidVideoListData['uid']; ?>" id="masjidVideoListEditBtn_<?php echo $masjidVideoListData['uid']; ?>" data-uid="<?php echo $masjidVideoListData['uid']; ?>" title="Edit Video"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-primary" name="masjidVideoListDeleteBtn_<?php echo $masjidVideoListData['uid']; ?>" id="masjidVideoListDeleteBtn_<?php echo $masjidVideoListData['uid']; ?>" data-uid="<?php echo $masjidVideoListData['uid']; ?>" title="Delete Video"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                        	
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


                <!-- Masjid Video Add Modal -->
                <div class="modal fade" id="masjidVideoListAddModal">
                    <div class="modal-dialog modal-lg" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Masjid Video</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <video id="masjidVideoListAddVideoPlayer" width="350" height="240" class="video-js vjs-default-skin" controls>
                                              <!-- <source src="" type="video/mp4"> -->
                                            </video>
                                        </div>
                                        <div class="col-md-7">
                                            
                                            <div id="masjidVideoListAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="masjidVideoListAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="masjidVideoListAddForm" id="masjidVideoListAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListAddNameInput">Name <span>*</span></label>
                                                            <input name="masjidVideoListAddNameInput" id="masjidVideoListAddNameInput" class="form-control" style="width:100%;" value="" placeholder="Name">
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListAddCountryInput">Country <span>*</span></label>
                                                            <select name="masjidVideoListAddCountryInput" id="masjidVideoListAddCountryInput" class="form-control" required="required">
                                                                <option value="">--- Country ---</option>
                                                                <?php foreach($countryDataResult as $countryData){ ?>
                                                                <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListAddStateInput">State <span>*</span></label>
                                                            <select name="masjidVideoListAddStateInput" id="masjidVideoListAddStateInput" class="form-control" required="required">
                                                                <option value="">--- State ---</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListAddCityInput">City <span>*</span></label>
                                                            <select name="masjidVideoListAddCityInput" id="masjidVideoListAddCityInput" class="form-control" required="required">
                                                                <option value="">--- City ---</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListAddUrlInput">URL <span>*</span></label>
                                                            <div class="input-group custom-input-group">
                                                                <input name="masjidVideoListAddUrlInput" id="masjidVideoListAddUrlInput" class="form-control" style="width:100%;" value="http://34.195.115.143/p/101/sp/10100/serveFlavor/entryId/0_4l5lgk1x/v/2/flavorId/0_3us7oj5q/forceproxy/true/name/a.mp4" placeholder="Masjid Video Url">
                                                                <span class="input-group-btn">
                                                                    <button type="button" name="masjidVideoListAddUrlVideoCheckBtn" id="masjidVideoListAddUrlVideoCheckBtn" class="btn btn-success" style="padding-top:8px;padding-bottom:8px;box-shadow:none !important;border:0px !important;border-radious:0px !important;">
                                                                        <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <span style="font-size:12px;color:red;">* Only .mp4 video link is allowed *</span>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListAddAliveInput">Alive <span>*</span></label>
                                                            <select name="masjidVideoListAddAliveInput" id="masjidVideoListAddAliveInput" class="form-control">
                                                                <option value="">--- Live Status ---</option>
                                                                <option value="1">Live</option>
                                                                <option value="0">Dead</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="masjidVideoListAddFormCancelBtn" id="masjidVideoListAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="masjidVideoListAddFormSubmitBtn" id="masjidVideoListAddFormSubmitBtn" class="btn btn-primary">Add Video</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <!-- Masjid Video Edit Modal -->
                <div class="modal fade" id="masjidVideoListEditModal">
                    <div class="modal-dialog modal-lg" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Masjid Video</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <video id="masjidVideoListEditVideoPlayer" width="350" height="280" class="video-js vjs-default-skin" controls>
                                            </video>
                                        </div>
                                        <div class="col-md-7">
                                            
                                            <div id="masjidVideoListEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="masjidVideoListEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="masjidVideoListEditForm" id="masjidVideoListEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListEditNameInput">Name <span>*</span></label>
                                                            <input name="masjidVideoListEditNameInput" id="masjidVideoListEditNameInput" class="form-control" style="width:100%;" value="" placeholder="Name">
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListEditCountryInput">Country <span>*</span></label>
                                                            <select name="masjidVideoListEditCountryInput" id="masjidVideoListEditCountryInput" class="form-control" required="required">
                                                                <option value="">--- Country ---</option>
                                                                <?php foreach($countryDataResult as $countryData){ ?>
                                                                <option value="<?php echo $countryData['id']; ?>"><?php echo $countryData['country']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListEditStateInput">State <span>*</span></label>
                                                            <select name="masjidVideoListEditStateInput" id="masjidVideoListEditStateInput" class="form-control" required="required">
                                                                <option value="">--- State ---</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListEditCityInput">City <span>*</span></label>
                                                            <select name="masjidVideoListEditCityInput" id="masjidVideoListEditCityInput" class="form-control" required="required">
                                                                <option value="">--- City ---</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListEditUrlInput">URL <span>*</span></label>
                                                            <div class="input-group custom-input-group">
                                                                <input name="masjidVideoListEditUrlInput" id="masjidVideoListEditUrlInput" class="form-control" style="width:100%;" value="" placeholder="Masjid Video Url">
                                                                <span class="input-group-btn">
                                                                    <button type="button" name="masjidVideoListEditUrlVideoCheckBtn" id="masjidVideoListEditUrlVideoCheckBtn" class="btn btn-success" style="padding-top:8px;padding-bottom:8px;box-shadow:none !important;border:0px !important;border-radious:0px !important;">
                                                                        <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <span style="font-size:12px;color:red;">* Only .mp4 video link is allowed *</span>
                                                        </div>
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="masjidVideoListEditAliveInput">Alive <span>*</span></label>
                                                            <select name="masjidVideoListEditAliveInput" id="masjidVideoListEditAliveInput" class="form-control">
                                                                <option value="">--- Live Status ---</option>
                                                                <option value="1">Live</option>
                                                                <option value="0">Dead</option>
                                                            </select>
                                                            <input type="hidden" name="masjidVideoID" id="masjidVideoID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="masjidVideoListEditFormCancelBtn" id="masjidVideoListEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="masjidVideoListEditFormSubmitBtn" id="masjidVideoListEditFormSubmitBtn" class="btn btn-primary">Update Video</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->



<script type="text/javascript">
    $(document).ready(function() {

    	$("#masjidVideoListSearchFormCountryInput").on('change', function(event) {
    		event.preventDefault();
	    	
    		var countryID = $("#masjidVideoListSearchFormCountryInput").val();

	    	if(countryID != ""){
	            $.ajax({
	                url: "<?php echo site_url('admin/masjid/getSateByCountry'); ?>",
	                type: 'POST',
	                dataType: 'json',
	                data: {countryID: countryID},
	                success: function(data){
	                	var masjidVideoListSearchFormStateInputOptionStr = "<option value=''>--- State ---</option>";
	                	$.each(data.stateDataArr, function(index, val) {
	                		 /* iterate through array or object */
	                		 masjidVideoListSearchFormStateInputOptionStr += "<option value='"+val.id+"'>"+val.state+"</option>";
	                	});
	                	$("#masjidVideoListSearchFormStateInput").empty();
	                	$("#masjidVideoListSearchFormStateInput").html(masjidVideoListSearchFormStateInputOptionStr);
                        $("#masjidVideoListSearchFormStateInput").selectpicker('refresh');
	                },
	                error: function(xhr, status, error){
	                    alert("Error: "+status);
	                }
	            });
	    	}
    	});


    	$("#masjidVideoListSearchFormStateInput").on('change', function(event) {
    		event.preventDefault();
	    	
    		var stateID = $("#masjidVideoListSearchFormStateInput").val();

            if(stateID != ""){
                $.ajax({
                    url: "<?php echo site_url('admin/masjid/getCityByState'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {stateID: stateID},
                    success: function(data){
                        var masjidVideoListSearchFormCityInputOptionStr = "<option value=''>--- City ---</option>";
                        $.each(data.cityDataArr, function(index, val) {
                             /* iterate through array or object */
                             masjidVideoListSearchFormCityInputOptionStr += "<option value='"+val.id+"'>"+val.city+"</option>";
                        });
                        $("#masjidVideoListSearchFormCityInput").empty();
                        $("#masjidVideoListSearchFormCityInput").html(masjidVideoListSearchFormCityInputOptionStr);
                        $("#masjidVideoListSearchFormCityInput").selectpicker('refresh');
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });                    
            }
    	});


    	// to add masjid video modal popup
        $("#masjidVideoListAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#masjidVideoListAddForm")[0].reset();
            $("#masjidVideoListAddModal").modal("show");
        });


        $("#masjidVideoListAddCountryInput").on('change', function(event) {
            event.preventDefault();

            var countryID = $("#masjidVideoListAddCountryInput").val();

            if(countryID != ""){
                $.ajax({
                    url: "<?php echo site_url('admin/masjid/getSateByCountry'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {countryID: countryID},
                    success: function(data){
                        var masjidVideoListAddStateInputOptionStr = "<option value=''>--- State ---</option>";
                        $.each(data.stateDataArr, function(index, val) {
                             /* iterate through array or object */
                             masjidVideoListAddStateInputOptionStr += "<option value='"+val.id+"'>"+val.state+"</option>";
                        });
                        $("#masjidVideoListAddStateInput").empty();
                        $("#masjidVideoListAddStateInput").html(masjidVideoListAddStateInputOptionStr);
                        $("#masjidVideoListAddStateInput").selectpicker('refresh');
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
        });


        $("#masjidVideoListAddStateInput").on('change', function(event) {
            event.preventDefault();

            var stateID = $("#masjidVideoListAddStateInput").val();

            if(stateID != ""){
                $.ajax({
                    url: "<?php echo site_url('admin/masjid/getCityByState'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {stateID: stateID},
                    success: function(data){
                        var masjidVideoListAddCityInputOptionStr = "<option value=''>--- City ---</option>";
                        $.each(data.cityDataArr, function(index, val) {
                             /* iterate through array or object */
                             masjidVideoListAddCityInputOptionStr += "<option value='"+val.id+"'>"+val.city+"</option>";
                        });
                        $("#masjidVideoListAddCityInput").empty();
                        $("#masjidVideoListAddCityInput").html(masjidVideoListAddCityInputOptionStr);
                        $("#masjidVideoListAddCityInput").selectpicker('refresh');
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
        });


        $("#masjidVideoListAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#masjidVideoListAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/masjid/addMasjidVideo'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#masjidVideoListAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#masjidVideoListAddFormSuccessAlert").css("display", "none");
                            $("#masjidVideoListAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#masjidVideoListAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#masjidVideoListAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });
        });


        $("#masjidVideoListEditCountryInput").on('change', function(event) {
            event.preventDefault();

            var countryID = $("#masjidVideoListEditCountryInput").val();

            if(countryID != ""){
                $.ajax({
                    url: "<?php echo site_url('admin/masjid/getSateByCountry'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {countryID: countryID},
                    success: function(data){
                        var masjidVideoListEditStateInputOptionStr = "<option value=''>--- State ---</option>";
                        $.each(data.stateDataArr, function(index, val) {
                             /* iterate through array or object */
                             masjidVideoListEditStateInputOptionStr += "<option value='"+val.id+"'>"+val.state+"</option>";
                        });
                        $("#masjidVideoListEditStateInput").empty();
                        $("#masjidVideoListEditStateInput").html(masjidVideoListEditStateInputOptionStr);
                        $("#masjidVideoListEditStateInput").selectpicker('refresh');
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
        });


        $("#masjidVideoListEditStateInput").on('change', function(event) {
            event.preventDefault();

            var stateID = $("#masjidVideoListEditStateInput").val();

            if(stateID != ""){
                $.ajax({
                    url: "<?php echo site_url('admin/masjid/getCityByState'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {stateID: stateID},
                    success: function(data){
                        var masjidVideoListEditCityInputOptionStr = "<option value=''>--- City ---</option>";
                        $.each(data.cityDataArr, function(index, val) {
                             masjidVideoListEditCityInputOptionStr += "<option value='"+val.id+"'>"+val.city+"</option>";
                        });
                        $("#masjidVideoListEditCityInput").empty();
                        $("#masjidVideoListEditCityInput").html(masjidVideoListEditCityInputOptionStr);
                        $("#masjidVideoListEditCityInput").selectpicker('refresh');
                    },
                    error: function(xhr, status, error){
                        alert("Error: "+status);
                    }
                });
            }
        });


        // to edit masjid video modal popup
        $("[id^=masjidVideoListEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var masjidVideoID = $(this).data("uid");
            $("#masjidVideoListEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/masjid/getMasjidVideoData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {masjidVideoID: masjidVideoID},
                success: function(data){
                    if(data.msgType == "success"){
                        var masjidVideoListEditStateInputOptionStr = "<option value=''>--- State ---</option>";
                        $.each(data.stateDataArr, function(index, val) {
                            masjidVideoListEditStateInputOptionStr += "<option value='"+val.id+"'>"+val.state+"</option>";
                        });
                        $("#masjidVideoListEditStateInput").empty();
                        $("#masjidVideoListEditStateInput").html(masjidVideoListEditStateInputOptionStr);
                        $("#masjidVideoListEditStateInput").selectpicker('refresh');


                        var masjidVideoListEditCityInputOptionStr = "<option value=''>--- City ---</option>";
                        $.each(data.cityDataArr, function(index, val) {
                            masjidVideoListEditCityInputOptionStr += "<option value='"+val.id+"'>"+val.city+"</option>";
                        });
                        $("#masjidVideoListEditCityInput").empty();
                        $("#masjidVideoListEditCityInput").html(masjidVideoListEditCityInputOptionStr);
                        $("#masjidVideoListEditCityInput").selectpicker('refresh');


                        $("#masjidVideoListEditNameInput").val(data.masjidVideoDataResult[0].name);
                        $("#masjidVideoListEditCountryInput").val(data.masjidVideoDataResult[0].country_id);
                        $("#masjidVideoListEditCountryInput").selectpicker('refresh');
                        $("#masjidVideoListEditStateInput").val(data.masjidVideoDataResult[0].state_id);
                        $("#masjidVideoListEditStateInput").selectpicker('refresh');
                        $("#masjidVideoListEditCityInput").val(data.masjidVideoDataResult[0].city_id);
                        $("#masjidVideoListEditCityInput").selectpicker('refresh');
                        $("#masjidVideoListEditUrlInput").val(data.masjidVideoDataResult[0].homeurl);
                        $("#masjidVideoListEditAliveInput").val(data.masjidVideoDataResult[0].alive);
                        $("#masjidVideoListEditAliveInput").selectpicker('refresh');
                        $("#masjidVideoID").val(masjidVideoID);
                        $("#masjidVideoListEditModal").modal("show");
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


        // to update masjid video 
        $("#masjidVideoListEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#masjidVideoListEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/masjid/updateMasjidVideoData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#masjidVideoListEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#masjidVideoListEditFormSuccessAlert").css("display", "none");
                            $("#masjidVideoListEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#masjidVideoListEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#masjidVideoListEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });


        // to delete Masjid Video Data
        $("[id^=masjidVideoListDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var masjidVideoID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/masjid/deleteMasjidVideoData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {masjidVideoID: masjidVideoID},
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