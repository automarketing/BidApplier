    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>VOD List</h2>
                        </div>
                        <div class="body">

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Category</th>
                                        <th style="vertical-align:top">Name</th>
                                        <th style="vertical-align:top">Image</th>
                                        <th style="vertical-align:top">Url</th>
                                        <th style="vertical-align:top">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1;
                                        foreach($vodDataArr as $vodData){
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $vodData["category"]; ?></td>
                                        <td><?php echo $vodData["name"]; ?></td>
                                        <td><img src="<?php echo $vodData["imgpath"]; ?>" style="width:120px;height:90px;padding:2px;border:#999 1px solid;"></td>
                                        <td><?php echo $vodData["url"]; ?></td>
                                        <td><?php echo $vodData["date"]; ?></td>
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
