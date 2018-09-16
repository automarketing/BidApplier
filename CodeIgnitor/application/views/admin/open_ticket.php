    <section class="content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" style="margin-top:0px !important;">
                        <div class="header text-left">
                            <h2>Open Ticket</h2>
                        </div>
                        <div class="body">

                            <?php if(!empty($msgType) && !strcmp($msgType, "success") && !empty($msg)){ ?>
                            <div id="openTicketFormSuccessAlert" class="alert alert-success" role="alert"><?php echo $msg; ?></div>
                            <?php } ?>
                            <?php if(!empty($msgType) && !strcmp($msgType, "error") && !empty($msg)){ ?>
                            <div id="openTicketFormErrorAlert" class="alert alert-danger" role="alert"><?php echo $msg; ?></div>
                            <?php } ?>

                            <form action="" name="openTicketForm" id="openTicketForm" method="POST" class="form-horizontal" role="form">

                                <div class="form-group">
                                    <label for="openTicketSubscriberEmailInput" class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:5px !important;">Subscriber Email</label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="openTicketSubscriberEmailInput[]" id="openTicketSubscriberEmailInput" class="form-control selectpicker" data-live-search="true" required="required" multiple>
                                            <?php foreach($subscriberDataResult as $subscriberData){ ?>
                                            <option value="<?php echo $subscriberData['uid']; ?>"<?php if(in_array($subscriberData['uid'], $openTicketSubscriberEmailInput)){ ?> selected="selected"<?php } ?>><?php echo $subscriberData['first_name']." ".$subscriberData['last_name']." [ ".$subscriberData['email']." ]"; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="openTicketQuestionInput" class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:5px !important;">Question</label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <select name="openTicketQuestionInput" id="openTicketQuestionInput" class="form-control selectpicker" data-live-search="true" required="required">
                                            <option value=""></option>
                                            <?php foreach($ticketQuestionDataResult as $ticketQuestionData){ ?>
                                            <option value="<?php echo $ticketQuestionData['uid']; ?>"<?php if($openTicketQuestionInput==$ticketQuestionData['uid']){ ?> selected="selected"<?php } ?>><?php echo $ticketQuestionData['question']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="openTicketDetailInput" class="col-lg-12 col-md-12 col-sm-12" style="margin-bottom:5px !important;">Detail</label>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <textarea name="openTicketDetailInput" id="openTicketDetailInput" class="form-control" rows="8" required="required" style="resize:none;"><?php echo $openTicketDetailInput; ?></textarea>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <input type="hidden" name="event" id="event" value="">
                                        <button type="submit" name="openTicketFormSubmitBtn" id="openTicketFormSubmitBtn" class="btn btn-primary" onclick="openTicketForm.event.value='openTicketFormSubmit';">Save</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>