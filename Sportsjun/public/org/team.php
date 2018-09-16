<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hyderabad Corporate Olympics: Sportsjun</title>
    <!-- CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap-select.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
	<div class="wrap">
		<!-- Page Head -->
		<div class="page-head jumbotron">
			<!-- Hero Panel -->
			<div data-include="hero-panel"></div>
			<!-- Header -->
			<div data-include="header"></div>
		</div>
		<!-- Body Section -->
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="page-header"><div class="ph-mark"><div class="glyphicon glyphicon-menu-right"></div></div> Team (Groups)</h2>
					<div class="create-btn-link"><a href="" class="wg-cnlink" data-toggle="modal" data-target="#create_group" style="margin-right: 150px;">Create New Team Group</a> <a href="" class="wg-cnlink">List All Teams</a></div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-2 col-md-8 bg-white text-center pdtb-30">
					<div id="groups_empty">
						<div> Team Groups for Group Competation in the Organization </div>
						<br>
						<h3><b>Steps to follow</b></h3>
						<div class="text-left">
							<br> <b>1.</b> Create Team Groups if organization want to group multi sport teams into Specific groups. (Ex. to create group competation in the organization and points need to role up from multi events.)
							<div id="text-center text-centered">You have not created any team groups yet</div>
							<br> <b>2. </b> Make sure to create Staff members. Staff members will need to be linked with every Team Group. (Ex: Manager, Coach, Physio etc) </div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="create_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form method="POST" action="http://dev.sportsjun.com/organization/33/staff" accept-charset="UTF-8" class="form form-horizontal">
						<input name="_token" type="hidden" value="bTCpsu1Uw3wX62asuYCTi28kBaPMCTWTaFyD4fRa">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3>TEAM GROUP DETAILS</h3> </div>
						<div class="modal-body">
							<div class="content">
								<div class="input-container">
									<input type="text" id="group_name" required="required" />
									<label for="Username">Enter Your Group Name</label>
									<div class="bar"></div>
								</div>
								<div class="input-container select">
									<div>
										<label>Group Manager</label>
										<select class="" name="staff_role">
											<option value="1">Manager One</option>
											<option value="2">Manager Two</option>
											<option value="3">Manager Three</option>
										</select>
									</div>
								</div>
								<div class="input-container file">
									<label>Group Logo</label>
									<input type="file" id="staff_email" required="" /> </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</form>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- Footer -->
		<div data-include="footer"></div>
	</div>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script>
        $(document).on("pageload", function () {
            alert("pageload event fired!");
        });

        // Page Active
        jQuery(function () {
            var page = location.pathname.split('/').pop();
            $('#nav li a[href="' + page + '"]').addClass('active')
        });
    </script>
</body>

</html>