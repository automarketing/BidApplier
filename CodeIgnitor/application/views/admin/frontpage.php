<section class="content">
    <div class="container-fluid">

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header text-left">
                        <h2>Front Site Section Management</h2>
                    </div>
                    <div class="body">

                      <!-- <div id="channelListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                      <div id="channelListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div> -->

                        <form name="Sectionupdateform" id="Sectionupdateform" method="POST" class="form-inline" role="form">
                          <div class="row">
                             <div class="col-md-12">
                                <div class="col-md-4">
                                  <div class="form-group formHorizontalGroup">
                                    <select name="frontpage_part" id="frontpage_part" class="form-control">
                                      <option value="">--- Frontpage_part ---</option>
                                      <?php foreach($part as $partData){ ?>
                                      <option value="<?php echo $partData['uid']; ?>"<?php if($frontpage_part == $partData['uid']){ ?> selected="selected"<?php } ?>><?php echo $partData['part']; ?></option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-4">
                                   <div class="col-md-4">
                                     <input type="hidden" name="event" id="event" class="form-control" value="">
                                     <button type="submit" style="padding:10px 40px;" name="frontpage_save" id="frontpage_save" class="btn btn-lg waves-effect">Save</button>
                                   </div>
                                   <!-- <div class="col-md-1"></div> -->
                                   <div class="col-md-4">
                                     <input type="hidden" name="event" id="event" class="form-control" value="">
                                     <button type="submit" name="frontpage_add" style="padding:10px 40px;" id="frontpage_add" class="btn btn-lg waves-effect">Add</button>
                                   </div>
                                   <!-- <div class="col-md-1"></div> -->
                                   <div class="col-md-4">
                                     <input type="hidden" name="event" id="event" class="form-control" value="">
                                     <button type="submit" name="frontpage_remove" style="padding:10px 25px;" id="frontpage_remove" class="btn btn-lg waves-effect">Remove</button>
                                   </div>
                                   <!-- <div class="col-md-1"></div> -->
                                </div>
                                <div class="col-md-1"></div>
                             </div>
                          </div>
                          <div class="row">
                             <div class="col-md-12">
                                <div class="col-md-2">Selected Category</div>
                                <div class="col-md-3">
                                  <div class="form-group formHorizontalGroup">

                                      <select name="SearchCategoryInput" id="SearchCategoryInput" class="form-control" required="required">
                                          <option value="">--- Category ---</option>
                                          <?php foreach($categoryDataArr as $categoryData){ ?>
                                          <option value="<?php echo $categoryData['id']; ?>"><?php echo $categoryData['name']; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-1">
                                  <div class="form-group formHorizontalGroup">
                                    <select name="searchpartcnm" id="searchpartcnm" class="form-control">
                                        <option value="">--- Count ---</option>
                                        <option value="4"<?php if($partcnm == "4"){ ?> selected="selected"<?php } ?>>4</option>
                                        <option value="6"<?php if($partcnm == "6"){ ?> selected="selected"<?php } ?>>6</option>
                                        <option value="8"<?php if($partcnm == "8"){ ?> selected="selected"<?php } ?>>8</option>
                                        <option value="10"<?php if($partcnm == "10"){ ?> selected="selected"<?php } ?>>10</option>
                                        <option value="12"<?php if($partcnm == "12"){ ?> selected="selected"<?php } ?>>12</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group formHorizontalGroup">
                                    <select name="searchthsize" id="searchthsize" class="form-control">
                                        <option value="">--- Thumbnail Size ---</option>
                                        <option value="4"<?php if($thsize == "4"){ ?> selected="selected"<?php } ?>>4</option>
                                        <option value="6"<?php if($thsize == "6"){ ?> selected="selected"<?php } ?>>6</option>
                                        <option value="8"<?php if($thsize == "8"){ ?> selected="selected"<?php } ?>>8</option>
                                        <option value="10"<?php if($thsize == "10"){ ?> selected="selected"<?php } ?>>8</option>
                                        <option value="12"<?php if($thsize == "12"){ ?> selected="selected"<?php } ?>>12</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="col-md-2">
                                  <div class="form-group formHorizontalGroup">
                                    <select name="searchsortdata" id="searchsortdata" class="form-control">
                                        <option value="">--- Sort By ---</option>
                                        <option value="1"<?php if($sortdata == "1"){ ?> selected="selected"<?php } ?>>By Date</option>
                                        <option value="2"<?php if($sortdata == "2"){ ?> selected="selected"<?php } ?>>By Popular</option>
                                    </select>
                                  </div>
                                </div>
                                <!-- <div class="col-md-2">
                                  <input type="hidden" name="event" id="event" class="form-control" value="">
                                  <button type="submit" name="frontpage_search" id="frontpage_search" class="btn btn-primary">Search</button>
                                </div> -->
                             </div>
                          </div>
                          <!-- <div class="row">
                                <div class="col-md-12">
                                      <div class="col-md-2">
                                         <button type="button" name="previewBtn" id="previewBtn" class="btn bg-teal btn-block btn-lg waves-effect">Preview</button>
                                      </div>
                                      <div class="col-md-10"></div>
                                </div>
                          </div> -->
                        </form>

                        <div class="row">
                           <div class="col-md-12">
                               <div class="body row" id="previewdata" style="margin:0px 50px;">

                               </div>

                           </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="SectionAddModal">
    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Add Section</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                    <div class="row">
                        <div class="col-md-12">

                            <div id="channelAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                            <div id="channelAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="" name="SectionAddForm" id="SectionAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                <div class="row">
                                    <div class="col-md-12">
                                      <div class="form-group formHorizontalGroup">
                                          <label for="frontInput">Frontpage Section <span>*</span></label>
                                          <input name="frontInput" id="frontInput" class="form-control" style="width:100%;" value="" placeholder="Frontpage Section">
                                      </div>
                                        <div class="form-group formHorizontalGroup">
                                            <label for="addCategoryInput">Category <span>*</span></label>
                                            <select name="addCategoryInput" id="addCategoryInput" class="form-control" required="required">
                                                <option value="">--- Category ---</option>
                                                <?php foreach($categoryDataArr as $categoryData){ ?>
                                                <option value="<?php echo $categoryData['id']; ?>"><?php echo $categoryData['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group formHorizontalGroup">
                                            <label for="addpartcnm">Count<span>*</span></label>
                                            <select name="addpartcnm" id="addpartcnm" class="form-control">
                                                <option value="">--- Count ---</option>
                                                <option value="4"<?php if($partcnm == "4"){ ?> selected="selected"<?php } ?>>4</option>
                                                <option value="6"<?php if($partcnm == "6"){ ?> selected="selected"<?php } ?>>6</option>
                                                <option value="8"<?php if($partcnm == "8"){ ?> selected="selected"<?php } ?>>8</option>
                                                <option value="10"<?php if($partcnm == "10"){ ?> selected="selected"<?php } ?>>10</option>
                                                <option value="12"<?php if($partcnm == "12"){ ?> selected="selected"<?php } ?>>12</option>
                                            </select>
                                        </div>
                                        <div class="form-group formHorizontalGroup">
                                            <label for="addthsize">Thumbnail Size <span>*</span></label>
                                            <select name="addthsize" id="addthsize" class="form-control">
                                                <option value="">--- Thumbnail Size ---</option>
                                                <option value="4"<?php if($thsize == "4"){ ?> selected="selected"<?php } ?>>4</option>
                                                <option value="6"<?php if($thsize == "6"){ ?> selected="selected"<?php } ?>>6</option>
                                                <option value="8"<?php if($thsize == "8"){ ?> selected="selected"<?php } ?>>8</option>
                                                <option value="10"<?php if($thsize == "10"){ ?> selected="selected"<?php } ?>>8</option>
                                                <option value="12"<?php if($thsize == "12"){ ?> selected="selected"<?php } ?>>12</option>
                                            </select>
                                        </div>
                                        <div class="form-group formHorizontalGroup">
                                            <label for="addsortdata">Sort By<span>*</span></label>
                                            <select name="addsortdata" id="addsortdata" class="form-control">
                                                <option value="">--- Sort By ---</option>
                                                <option value="1"<?php if($sortdata == "1"){ ?> selected="selected"<?php } ?>>By Date</option>
                                                <option value="2"<?php if($sortdata == "2"){ ?> selected="selected"<?php } ?>>By Popular</option>
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
                <button type="button" name="frontAddFormCancelBtn" id="frontAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" name="frontAddFormSubmitBtn" id="frontAddFormSubmitBtn" class="btn btn-primary">Add Section</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
$(document).ready(function() {

  $("#frontpage_add").on('click', function(event) {
      event.preventDefault();

      $("#SectionAddForm")[0].reset();
      $("#SectionAddModal").modal("show");
  });

  $("#frontAddFormSubmitBtn").on('click', function(event) {
      event.preventDefault();

      var formData = $("#SectionAddForm").serialize();

      $.ajax({
          url: "<?php echo site_url('admin/frontpage/addData'); ?>",
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

     $("#frontpage_save").on('click', function(event) {
         event.preventDefault();
         var frontid = document.getElementById('frontpage_part').value;
         var Category = document.getElementById('SearchCategoryInput').value;
         var partnm = document.getElementById('searchpartcnm').value;
         var thsize = document.getElementById('searchthsize').value;
         var sortnm = document.getElementById('searchsortdata').value;

        //  var formData = $("#Sectionupdateform").serialize();
        // var sendata = formData + '&frontid='+ frontid;
         var senddata = { 'FrontID': frontid , 'categoryinput': Category ,'partcnm': partnm
                 , 'thsize': thsize , 'sortdata': sortnm};
         $.ajax({
             url: "<?php echo site_url('admin/frontpage/updateData'); ?>",
             type: 'POST',
             dataType: 'json',
             data: senddata,
             success: function(data){
                 if(data.msgType == "success"){
                    alert("This Section data updated Successfully");
                 }
                 else{
                     alert("This Section data don't update");
                 }
             },
             error: function(xhr, status, error){
                 alert("Error: "+status);
             }
         });

     });

     $("#frontpage_remove").on('click', function(event) {
         event.preventDefault();

         var frontid = document.getElementById('frontpage_part').value;
         var confirmMsg = confirm("Are you confirm to delete?");
         if(confirmMsg){
             $.ajax({
                 url: "<?php echo site_url('admin/frontpage/deleteData'); ?>",
                 type: 'POST',
                 dataType: 'json',
                 data: {FrontID: frontid},
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
    // to add channel modal popup
    $("#channelAddBtn").on('click', function(event) {
        event.preventDefault();

        $("#channelAddForm")[0].reset();
        $("#channelAddModal").modal("show");
    });

    $("#frontpage_part").on('change', function(event) {
        event.preventDefault();

        var frontid = document.getElementById('frontpage_part').value;
          var senddata = { 'FrontID': frontid };
            $.ajax({
                url: "<?php echo site_url('admin/frontpage/previewData'); ?>",
                type: 'POST',
                data: senddata,
                success: function(data){
                        $('#previewdata').html(data);
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });
    });

    // $("#SearchCategoryInput").on('change', function(event) {
    //     event.preventDefault();
    //
    //     var category = document.getElementById('SearchCategoryInput').value;
    //     var pagenum = document.getElementById('addpartcnm').value;
    //     var sortvalue = document.getElementById('addsortdata').value;
    //     var senddata = { 'category': category ,'pagenm': pagenum ,'sortvalue': sortvalue };
    //         $.ajax({
    //             url: "<?php echo site_url('admin/frontpage/selectData'); ?>",
    //             type: 'POST',
    //             data: senddata,
    //             success: function(data){
    //                     $('#previewdata').html(data);
    //             },
    //             error: function(xhr, status, error){
    //                 alert("Error: "+status);
    //             }
    //         });
    // });
    //
    // $("#addpartcnm").on('change', function(event) {
    //     event.preventDefault();
    //     var category = document.getElementById('SearchCategoryInput').value;
    //     var pagenum = document.getElementById('addpartcnm').value;
    //     var sortvalue = document.getElementById('addsortdata').value;
    //     var senddata = { 'category': category ,'pagenm': pagenum ,'sortvalue': sortvalue };
    //         $.ajax({
    //             url: "<?php echo site_url('admin/frontpage/selectData'); ?>",
    //             type: 'POST',
    //             data: senddata,
    //             success: function(data){
    //                     $('#previewdata').html(data);
    //             },
    //             error: function(xhr, status, error){
    //                 alert("Error: "+status);
    //             }
    //         });
    // });
    //
    // $("#addsortdata").on('change', function(event) {
    //     event.preventDefault();
    //     var category = document.getElementById('SearchCategoryInput').value;
    //     var pagenum = document.getElementById('addpartcnm').value;
    //     var sortvalue = document.getElementById('addsortdata').value;
    //     var senddata = { 'category': category ,'pagenm': pagenum ,'sortvalue': sortvalue };
    //         $.ajax({
    //             url: "<?php echo site_url('admin/frontpage/selectData'); ?>",
    //             type: 'POST',
    //             data: senddata,
    //             success: function(data){
    //                     $('#previewdata').html(data);
    //             },
    //             error: function(xhr, status, error){
    //                 alert("Error: "+status);
    //             }
    //         });
    // });
});
</script>
