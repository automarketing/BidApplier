    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Category List</h2>
                        </div>
                        <div class="body">

	                        <!-- <div id="categoryListSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
	                        <div id="categoryListErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                            <form action="<?php echo site_url('admin/channelvod/platformcategory'); ?>" name="categorySearchForm" id="categorySearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="categorySearchFormCategoryInput" id="categorySearchFormCategoryInput" class="form-control" style="width:100%;" value="<?php echo $categorySearchFormCategoryInput; ?>" placeholder="Category"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="categorySearchFormSubmitBtn" id="categorySearchFormSubmitBtn" class="btn btn-success" onclick="categorySearchForm.event.value='categorySearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form> -->

                            <!-- <div style="width:100%;padding-bottom:10px;">
                            	<button type="button" name="categoryAddBtn" id="categoryAddBtn" class="btn btn-primary">Add Category</button>
                            </div> -->
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Category</th>
                                        <!-- <th style="vertical-align:top">Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        foreach($categoryDataArr as $categoryData){
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $categoryData["name"]; ?></td>
                                        <!-- <td>

                                            <button type="button" class="btn btn-primary" name="categoryEditBtn_<?php echo $categoryData['uid']; ?>" id="categoryEditBtn_<?php echo $categoryData['uid']; ?>" data-uid="<?php echo $categoryData['uid']; ?>" title="Edit Category"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                          	<button type="button" class="btn btn-danger" name="categoryDeleteBtn_<?php echo $categoryData['uid']; ?>" id="categoryDeleteBtn_<?php echo $categoryData['uid']; ?>" data-uid="<?php echo $categoryData['uid']; ?>" title="Delete Category"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                                        </td> -->
                                    </tr>
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- <div class="paginationLinkDiv">
                                <?php echo $paginationLink; ?>
                            </div> -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                <!-- Category Add Modal -->
                <!-- <div class="modal fade" id="categoryAddModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Add Category</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="categoryAddFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="categoryAddFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="categoryAddForm" id="categoryAddForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="categoryInput">Category <span>*</span></label>
                                                            <input type="text" name="categoryInput" id="categoryInput" class="form-control" value="" required="required" title="Category">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="categoryAddFormCancelBtn" id="categoryAddFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="categoryAddFormSubmitBtn" id="categoryAddFormSubmitBtn" class="btn btn-primary">Add Category</button>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Category Edit Modal -->
                <!-- <div class="modal fade" id="categoryEditModal">
                    <div class="modal-dialog modal-md" tabindex="-1" role="dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom:#eeeeee 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h4 class="modal-title">Edit Category</h4>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid" style="padding-left:0px;padding-right:0px;">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div id="categoryEditFormSuccessAlert" class="alert alert-success" role="alert" style="display:none;"></div>
                                            <div id="categoryEditFormErrorAlert" class="alert alert-danger" role="alert" style="display:none;"></div>

                                            <form action="" name="categoryEditForm" id="categoryEditForm" method="POST" enctype="multipart/form-data" class="form-inline" role="form" onsubmit="return false;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group formHorizontalGroup">
                                                            <label for="categoryEditInput">Category <span>*</span></label>
                                                            <input type="text" name="categoryEditInput" id="categoryEditInput" class="form-control" value="" required="required" title="Category">
                                                            <input type="hidden" name="categoryID" id="categoryID" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:#eeeeee 1px solid;">
                                <button type="button" name="categoryEditFormCancelBtn" id="categoryEditFormCancelBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" name="categoryEditFormSubmitBtn" id="categoryEditFormSubmitBtn" class="btn btn-primary">Update Category</button>
                            </div>
                        </div>
                    </div>
                </div> -->



<!-- <script type="text/javascript">
    $(document).ready(function() {

        // to add category modal popup
        $("#categoryAddBtn").on('click', function(event) {
            event.preventDefault();

            $("#categoryAddForm")[0].reset();
            $("#categoryAddModal").modal("show");
        });

        // to save category to database
        $("#categoryAddFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#categoryAddForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/addCategoryData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#categoryAddFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#categoryAddFormSuccessAlert").css("display", "none");
                            $("#categoryAddModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#categoryAddFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#categoryAddFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit category
        $("[id^=categoryEditBtn_]").on('click', function(event) {
            event.preventDefault();

            var categoryID = $(this).data("uid");
            $("#categoryEditForm")[0].reset();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/getCategoryData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: {categoryID: categoryID},
                success: function(data){
                    if(data.msgType == "success"){
                        $("#categoryEditInput").val(data.msgDetail[0].category);
                        $("#categoryID").val(categoryID);
                        $("#categoryEditModal").modal("show");
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

        // to update category
        $("#categoryEditFormSubmitBtn").on('click', function(event) {
            event.preventDefault();

            var formData = $("#categoryEditForm").serialize();

            $.ajax({
                url: "<?php echo site_url('admin/channelvod/updateCategoryData'); ?>",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(data){
                    if(data.msgType == "success"){
                        $("#categoryEditFormSuccessAlert").html(data.msg).css("display", "block");
                        setInterval(function(){
                            $("#categoryEditFormSuccessAlert").css("display", "none");
                            $("#categoryEditModal").modal("hide");
                            window.location.href = window.location.href;
                        }, 2000);
                    }
                    else{
                        $("#categoryEditFormErrorAlert").html(data.msg).css("display", "block");
                        setInterval(function(){$("#categoryEditFormErrorAlert").css("display", "none")}, 6000);
                    }
                },
                error: function(xhr, status, error){
                    alert("Error: "+status);
                }
            });

        });

        // to edit category
        $("[id^=categoryDeleteBtn_]").on('click', function(event) {
            event.preventDefault();

            var categoryID = $(this).data("uid");
            var confirmMsg = confirm("Are you confirm to delete?");
            if(confirmMsg){
                $.ajax({
                    url: "<?php echo site_url('admin/channelvod/deleteCategoryData'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {categoryID: categoryID},
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
</script> -->
