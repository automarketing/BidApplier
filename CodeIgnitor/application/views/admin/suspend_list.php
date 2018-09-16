    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header text-left">
                            <h2>Suspend List</h2>
                        </div>
                        <div class="body">

                            <form action="<?php echo site_url('admin/payment/suspend'); ?>" name="suspendSearchForm" id="suspendSearchForm" method="POST" class="form-inline" role="form">
                            <table class="table" border="0px" cellpadding="5px" cellspacing="0px">
                                <tr>
                                    <td><input name="suspendSearchFormEmailInput" id="suspendSearchFormEmailInput" class="form-control" style="width:100%;" value="<?php echo $suspendSearchFormEmailInput; ?>" placeholder="Email"></td>
                                    <td><input name="suspendSearchFormNameInput" id="suspendSearchFormNameInput" class="form-control" style="width:100%;" value="<?php echo $suspendSearchFormNameInput; ?>" placeholder="Name"></td>
                                    <td>
                                        <input type="hidden" name="event" id="event" class="form-control" value="">
                                        <button type="submit" name="suspendSearchFormSubmitBtn" id="suspendSearchFormSubmitBtn" class="btn btn-success" onclick="suspendSearchForm.event.value='suspendSearchFormSubmit';">Search</button>
                                    </td>
                                </tr>
                            </table>
                            </form>

                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="tableHeaderTR">
                                        <th style="vertical-align:top">No</th>
                                        <th style="vertical-align:top">Email</th>
                                        <th style="vertical-align:top">Name</th>
                                        <th style="vertical-align:top">Current Subscriber Plan</th>
                                        <th style="vertical-align:top">Total Payment</th>
                                        <th style="vertical-align:top">Last Payment Date</th>
                                        <th style="vertical-align:top">Last Payment</th>
                                        <th style="vertical-align:top">Pending Payment Date</th>
                                        <th style="vertical-align:top">Pending Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $i=1;
                                        foreach($suspendDataArr as $suspendData){ 
                                    ?>
                                    <tr class="tableDataTR">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $suspendData['email']; ?></td>
                                        <td><?php echo $suspendData['first_name']." ".$suspendData['last_name']; ?></td>
                                        <td><?php echo $suspendData['subscriber_plan_type']; ?></td>
                                        <td><?php echo "$".$suspendData['payment_total']; ?></td>
                                        <td><?php echo "$".$suspendData['last_payment']; ?></td>
                                        <td><?php echo $suspendData['last_payment_date']; ?></td>
                                        <td><?php echo $suspendData['next_payment_date']; ?></td>
                                        <td><?php echo $suspendData['pending_duration']." Days"; ?></td>
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
