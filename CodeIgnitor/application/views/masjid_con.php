<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Kawnain TV | Welcome to Kawnain TV</title>

	<!-- Style sheet -->
	<link rel="icon" href="/includes/AdminBSB/favicon.ico" type="image/x-icon">
	<link href="/includes/kawnaintv/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/includes/kawnaintv/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="/includes/kawnaintv/css/nivo-slider.css" rel="stylesheet">
	<link href="/includes/kawnaintv/css/lightslider.css" rel="stylesheet">
	<link href="/includes/kawnaintv/videojs/video-js.css" rel="stylesheet">

	<!-- Add fancyBox main CSS files -->
	<link rel="stylesheet" type="text/css" href="/includes/kawnaintv/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<link href="/includes/kawnaintv/css/style.css" rel="stylesheet">
	<link href="/includes/kawnaintv/css/main.css" rel="stylesheet">


</head>
<body style="font-size:18px;">

 	<div class="container-fluid headerTopDiv">
		<div class="row">
 			<div class="headerMenuColDiv">
				<button type="button" class="btn headerMenuHideBtn" id="headerMenuHideBtn" data-toggle="button" aria-pressed="false" autocomplete="off">  &#9776; </button>
				<ul id="headerMenuUL" class="headerMenuUL">
										<!-- <li><a href="/user/login/masjid_view">Home</a></li> -->
                    <li><a href="/user/login/masjid_con" style="color:#FA9000;">Connect to your Masjid</a></li>
										<li><a href="/user/login/masjid_product">Products</a></li>
                    <li><a href="/user/login/user_register">My Account</a></li>
                    <li><a href="#">Help</a></li>
										<li><a href="/user/custom/contactpage">Contact US</a></li>
                    <!-- <li><a href="#">Kawnain Box</a></li>
                    <li><a href="/user/login/index">Login</a></li>
                    <li><a href="/user/login/signup">SignUp</a></li> -->
				</ul>
			</div>
		</div>
	</div>
	<div class="row" style="border-top:1px solid #8B8B8B;">
		<div align = 'center'>
				<img align = 'center' src="/includes/kawnaintv/images/masjid/topimg.jpg" class="img-responsive">
		</div>
	</div>
	<div class="row" style="background:#F3F3F3;">
		<div class="bordermasjidDiv"></div>
     <!-- <div class="container" style="padding:30px 0px;"> -->
         <div class="col-md-12 col-sm-12" style="padding:30px 5%;">
            <div class="col-md-5 col-sm-12">
							<!-- <div class="col-md-2 col-sm-12"></div>
							<div class="col-md-8 col-sm-12"> -->
                <div class="col-md-12 col-sm-2">
									<h2 align = 'center' style="color:#666666;font-size:30px;"><b>Abailave Masjid</b></h2>
								</div>
								<div class="col-md-12 col-sm-5" style="padding-top:20px;">
									<div align = 'center'>
								   <img align = 'center' src="/includes/kawnaintv/images/masjid/masjid_room.png" class="img-responsive">
								 </div>
								</div>
								<div class="col-md-12 col-sm-5" style="padding-top:30px;">
										<p style="text-align: justify;">
		                    A mosque is the building in which Muslims worship God.  Throughout Islamic history, the
												mosque was the centre of the community and towns formed around this pivotal building.
												Nowadays, especially in Muslim countries mosques are found on nearly every street
												corner, making it a simple matter for Muslims to attend the five daily prayers.
												In the West mosques are integral parts of Islamic centers that also contain teaching and community facilities.
												Mosques come in all shapes and sizes; they differ from region to region based on the density of the Muslim population in a certain area.
												Muslims in the past and even today have made use of local artisans and architects to create beautiful, magnificent mosques.
												There are however, certain features that are common to all mosques.
												Every mosque has a mihrab, a niche in the wall that indicates the direction of Mecca; the direction towards which Muslims pray.
												Most mosques have a minbar (or pulpit) from which an Islamic scholar is able to deliver a sermon or speech.
										</p>
								</div>
							<!-- </div>
							<div class="col-md-2 col-sm-12"></div> -->
						</div>
						<!-- <div class="col-md-2 col-sm-12"></div> -->
						<div class="col-md-7 col-sm-12">
							<!-- <div class="col-md-2 col-sm-12"></div>
							<div class="col-md-8 col-sm-12"> -->
								<div class="col-md-12 col-sm-2">
									<h2 align = 'center' style="color:#666666;font-size:30px;"><b>Add Your Masjid</b></h2>
								</div>
								<div class="col-md-6 col-sm-10">
									<label style="padding-right:10px;padding-left:35px;color:#888888;">First Name*</label><input class="masjidcontact" required="required" align="center" name="text" id="text"><br>
									<label style="padding-right:10px;padding-left:38px;color:#888888;">Last Name*</label><input  class="masjidcontact" required="required" align="center" name="text" id="text"><br>
									<label style="padding-right:10px;padding-left:80px;color:#888888;">Email*</label><input class="masjidcontact" required="required" align="center" name="text" id="text"><br>
									<label style="padding-right:10px;padding-left:80px;color:#888888;">Phone</label><input class="masjidcontact" align="center" name="text" id="text"><br>
									<label style="padding-right:10px;color:#888888;">Company Name</label><input class="masjidcontact" align="center" name="text" id="text"><br>
									<label style="padding-right:10px;padding-left:63px;color:#888888;">Subject*</label><input class="masjidcontact" required="required" align="center" name="text" id="text"><br>
								</div><div class="col-md-6 col-sm-10">
									<label style="padding-top:30px;color:#888888; padding-right:10px;padding-left:45px;vertical-align:top;">Message*</label>
									<textarea class="masjidcontact_text" name="message" align="center" id="messagebox1" required="required" rows="17" ></textarea><br>
								</div>
								<div class="col-md-12 col-sm-2">
									<button align = 'center' type="button" class="btn btn-block btn-lg waves-effect" style="border-radius: 1px;background:#FA9000;color:#FFF;width:200px;font-size:20px;margin-top:100px;margin-left:40%;">
										Submit Message
									</button>
								</div>
							<!-- </div>
							<div class="col-md-2 col-sm-12"></div> -->
						</div>
				 </div>
		 <!-- </div> -->
	</div>
	<div class="row">
		<div align = 'center'>
				<img align = 'center' src="/includes/kawnaintv/images/masjid/liveprogram.jpg" class="img-responsive">
		</div>
	</div>

  <div class="row" style="background:#EDEFEE;">
     <div class="container" style="padding:50px 0px;">
			 <div class="col-md-12">
          <div class="col-md-4">
						<div class="col-md-1"></div>
						<div class="col-md-10">
                <img align = 'center' src="/includes/kawnaintv/images/masjid/serverimg1.jpg" class="img-responsive">
            </div>
						<div class="col-md-1"></div>
					</div>
					<div class="col-md-4">
						<div class="col-md-1"></div>
						<div class="col-md-10">
                <img align = 'center' src="/includes/kawnaintv/images/masjid/serverimg2.jpg" class="img-responsive">
            </div>
						<div class="col-md-1"></div>
					</div>
					<div class="col-md-4">
						<div class="col-md-1"></div>
						<div class="col-md-10">
                <img align = 'center' src="/includes/kawnaintv/images/masjid/serverimg3.jpg" class="img-responsive">
            </div>
						<div class="col-md-1"></div>
					</div>
			 </div>
		 </div>
	</div>
	<div class="row masjidbody" style="background:#F2F2F2;" onclick="menuhidden();">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12">
 	 						 <!-- <div class="col-md-1 col-sm-12"></div>
 	 						 <div class="col-md-10 col-sm-12"> -->
 	 							 <div class="col-md-3" >
 	 								 <h2 align="center" style="font-size:22px;color:#666666;">Menu items</h2>
 	 								 <ul class="masjid_footerMenuListUL" style="padding-left:15%; border-right: 1px dotted #D7D7D7;">
 	 									 <li><a href="/user/login/masjid_view">Connect to Masjid</a></li>
 	 									 <li><a href="/user/login/masjid_product">Products</a></li>
 	 									 <li><a href="/user/login/user_register">My Account</a></li>
 	 									 <li><a href="#">Help</a></li>
 	 									 <li><a href="/user/custom/contactpage">Contact US</a></li>
 	 								 </ul>
 	 							 </div>
 	 							 <div class="col-md-3" >
 	 								 <h2 align="center" style="font-size:22px;color:#666666;">Career</h2>
 	 								 <ul class="masjid_footerMenuListUL" style="padding-left:15%;border-right: 1px dotted #D7D7D7;">
 	 										<li><a href="#">Job oppertunity</a></li>
 	 										<li><a href="#">Volunteers club</a></li>
 	 								 </ul>
 	 							 </div>
 	 							 <!-- <div class="col-md-2">
 	 								 <h2 style="font-size:22px;color:#666666;">Advertisement</h2>
 	 								 <ul class="masjid_footerMenuListUL" style="border-right: 1px dotted #D7D7D7;">
 	 									<li><a href="#">Contact from</a></li>
 	 									<li><a href="#">Menu items</a></li>
 	 									<li><a href="#">Menu items</a></li>
 	 									<li><a href="#">Menu items</a></li>
 	 								</ul>
 	 							 </div> -->
 	 							 <div class="col-md-3">
 	 								 <h2 align="center" style="font-size:22px;color:#666666;">Privacy Policy</h2>
 	 								 <ul class="masjid_footerMenuListUL" style="padding-left:15%; border-right: 1px dotted #D7D7D7;">
 	 									 <li><a style="cursor:pointer;" onclick="window.open('/user/custom/privacypage', '_blank');">Terms and conditions</a></li>

 	 								</ul>
 	 							 </div>
 	 							 <div class="col-md-3">
 	 								 <h2 align="center" style="font-size:22px;color:#666666;">Company</h2>
 									 <ul class="masjid_footerMenuListUL">
 										 <li>
 																<!-- <div class="col-md-12"> -->
 																	 <div class="col-md-1"><img src="/includes/kawnaintv/images/menu/phone.png">
 																	 </div>
 																	 <div class="col-md-10" align="left"><p style="font-size:16px;">+1-212-380-7548</p></div></li>
 															 <li>
 																 <!-- <div class="col-md-12"> -->
 																	 <div class="col-md-1"><img src="/includes/kawnaintv/images/menu/location.png" style="padding-top:15px;">
 																	 </div>
 																	 <div class="col-md-10" align="left"><p style="font-size:16px;">401 Par Ave South 10Th Floor, New York, NY 10016</p></div>
 																   <!-- </div> -->
 															 </li>
 															 <li>
 																	<!-- <div class="col-md-12"> -->
 																 <a href="mailto:info@kawnain.com">
 																	 <div class="col-md-1"><img src="/includes/kawnaintv/images/menu/mail.png">
 																	 </div>
 																	 <div class="col-md-10" align="left"><p style="font-size:16px;">info@kawnain.com</p></div></a>
 																 <!-- </div> -->
 															 </li>
 									</ul>
 	 							 </div>
 	 						 <!-- </div>
 	 						 <div class="col-md-1 col-sm-12"></div> -->
 	 				 </div>
				 </div>
				 <div class="row" style="padding:30px 0px;">
	 				 <div class="col-md-12 col-sm-12">
	 						<div class="col-md-1 col-sm-12"></div>
	 						<div class="col-md-10 col-sm-12">
	 							<img align="center" src="/includes/kawnaintv/images/masjid/bottom-border.png" class="img-responsive">

								<div align="center">
	 									<!-- <p onclick="window.open('/user/custom/contactpage', '_blank');" align="left" style="cursor: pointer;color:#FE9000">
	 										Contact US</p> -->
											<p>Kawnain TV © 2017 Kawnain Inc. All rights reserved.</p>
	 							</div>
	 						</div>
	 						<div class="col-md-1 col-sm-12"></div>
	 				 </div>
	 			 </div>
			</div>
	</div>




	<!-- Script -->
	<script src="/includes/kawnaintv/js/jquery-1.7.1.min.js"></script>
	<script src="/includes/kawnaintv/bootstrap/js/bootstrap.min.js"></script>
	<script src="/includes/kawnaintv/js/jquery.nivo.slider.js" type="text/javascript"></script>
	<script src="/includes/kawnaintv/js/lightslider.js" type="text/javascript"></script>
	<script src="/includes/kawnaintv/videojs/video.js"></script>
	<script src="/includes/kawnaintv/videojs/videojs-contrib-hls.js"></script>
	<!-- Add fancyBox main JS files -->
	<script type="text/javascript" src="/includes/kawnaintv/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script src="/includes/kawnaintv/js/script.js"></script>

</body>
</html>
