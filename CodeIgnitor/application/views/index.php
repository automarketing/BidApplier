<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Kawnain TV | Welcome to Kawnain TV</title>

	<!-- Style sheet -->
	<link href="/includes/kawnaintv/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/includes/kawnaintv/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="/includes/kawnaintv/css/nivo-slider.css" rel="stylesheet">
	<link href="/includes/kawnaintv/css/lightslider.css" rel="stylesheet">
	<link href="/includes/kawnaintv/videojs/video-js.css" rel="stylesheet">

	<!-- Add fancyBox main CSS files -->
	<link rel="stylesheet" type="text/css" href="/includes/kawnaintv/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

	<link href="/includes/kawnaintv/css/style.css" rel="stylesheet">
</head>
<body>

 	<div class="container-fluid headerTopDiv">
		<div class="row">
 			<div class="headerMenuColDiv">
				<button type="button" class="btn headerMenuHideBtn" id="headerMenuHideBtn" data-toggle="button" aria-pressed="false" autocomplete="off">  &#9776; </button>
				<ul id="headerMenuUL" class="headerMenuUL">
										<!-- <li><a href="#">Home</a></li> -->
										<li><a href="/user/login/masjid_view">Connect to your Masjid</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">My Account</a></li>
                    <li><a href="#">Help</a></li>
                    <!-- <li><a href="#">Kawnain Box</a></li>
                    <li><a href="/user/login/index">Login</a></li>
                    <li><a href="/user/login/signup">SignUp</a></li> -->

				</ul>

			</div>
			<!-- <div class="col-md-3">
  	            <div id="custom-search-input">
	                <div class="input-group col-md-12">
	                    <input type="text" class="form-control input-md" placeholder="Search" />
	                    <span class="input-group-btn">
	                        <button class="btn btn-info btn-lg" type="button">
	                            <i class="glyphicon glyphicon-search"></i>
	                        </button>
	                    </span>
	                </div>
	            </div>
			</div> -->
		</div>
	</div>

	<div class="container-fluid headerBottomDiv">
		<div class="row">
			<div class="col-md-5" style="padding-top:8px;padding-left:120px;">
				<img src="/includes/kawnaintv/images/kawnain-logo-text1.png" class="img-responsive logo-text-img" alt="Kawnain Logo" style="margin:10px 0px 10px 0px;">
			</div>
			<div class="col-md-3">

			</div>
			<div class="col-md-4 headerBottomRightDiv">
				<select name="" id="" class="headerBottomRightProgramSelect">
					<option value="">WATCH NOW 16.40 - The Daily Reminder New Series</option>
				</select>
			</div>
		</div>
	</div>

	<div class="container headerBannerContainerDiv">
		<div class="row">
			<div class="col-md-8" style="text-align:center;">

			<?php

				date_default_timezone_set('Asia/Dhaka');//set the time zone if server time-zone is not correct

				$wowza_serverip = "34.192.42.3"; // your ip/host
				$wowzatoken = 'wowzatoken';

				$wowzastart = 0;
				$validity = 180000; // validity in seconds
				$wowzaend = strtotime(date('d-m-Y H:i')) + $validity;
				$secret = "b42f6556619a3149"; // your secret
				$stream_name = "live/Bangla.stream";// your stream myStream is default steaming

				$hashstr = hash('sha256', $stream_name.'?'.$secret.'&'.$wowzatoken.'CustomParam=star&'.$wowzatoken.'endtime='.$wowzaend.'&'.$wowzatoken.'starttime='.$wowzastart, true);
				$usableHash = strtr(base64_encode($hashstr), '+/', '-_');

				$url = "rtmp://".$wowza_serverip.":1935/live/Bangla.stream?".$wowzatoken."endtime=".$wowzaend."&".$wowzatoken."starttime=".$wowzastart."&".$wowzatoken."hash=".$usableHash."";
				//RTMP protocol usable for flash player and android
				$iurl = "http://".$wowza_serverip.":1935/live/Bangla.stream/playlist.m3u8?".$wowzatoken."starttime=".$wowzastart."&".$wowzatoken."endtime=".$wowzaend."&".$wowzatoken."CustomParam=star&".$wowzatoken."hash=".$usableHash;
				//HLS protocol for Iphone
			?>

			<video id="example-video" height="420" class="video-js vjs-default-skin col-md-12" controls>
			  <source
			     src="<?php echo $iurl; ?>"
			     type="application/x-mpegURL">
			</video>

<!--
 				<div class="headerBannerDiv nivoSlider" id="slider">
					<img src="images/banner-test-img-1.png" data-thumb="images/banner-test-img-1.png" alt="Banner Image 1" title="#bannerImageCaption1" />
					<img src="images/banner-test-img-2.png" data-thumb="images/banner-test-img-2.png" alt="Banner Image 2" title="#bannerImageCaption2" />
					<img src="images/banner-test-img-3.png" data-thumb="images/banner-test-img-3.png" alt="Banner Image 3" title="#bannerImageCaption3" />
					<img src="images/banner-test-img-4.png" data-thumb="images/banner-test-img-4.png" alt="Banner Image 4" title="#bannerImageCaption4" />
				</div>
				<div id="bannerImageCaption1" class="nivo-html-caption">
					<div style="padding:8px 15px;color:#1b3f89;font-size:16px;">This is an example of a html caption for Banner Image 1.</div>
				</div>
				<div id="bannerImageCaption2" class="nivo-html-caption">
					<div style="padding:8px 15px;color:#de1a51;font-size:16px;">This is an example of a html caption for Banner Image 2.</div>
				</div>
				<div id="bannerImageCaption3" class="nivo-html-caption">
					<div style="padding:8px 15px;color:#47bc13;font-size:16px;">This is an example of a html caption for Banner Image 3.</div>
				</div>
				<div id="bannerImageCaption4" class="nivo-html-caption">
					<div style="padding:8px 15px;color:#dad42b;font-size:16px;">This is an example of a html caption for Banner Image 4.</div>
				</div>
 -->
			</div>

			<div class="col-md-4 rightSidebarDiv">
				<div class="col-md-12 col-sm-12 col-xs-12 rightSidebarTitleDiv">News</div>
				<div class="col-md-12 col-sm-12 col-xs-12 rightSidebarSingleContentOuterDiv">
					<ul id="rightSidebarLightSlider" class="rightSidebarLightSliderUL">
						<?php
						foreach ($part1 as $row) {  ?>
							<li class="rightSidebarSingleContentLI showVideoPopup" data-url='<?php echo $row['url'];?>'>
								<img src="<?php echo $row['imgpath'];?>" class="rightSidebarSingleContentThumbImg" alt="">
								<div class="rightSidebarSingleContentTextDiv">
									<a href="#" class="rightSidebarSingleContentTextTitleLink"><?php echo $row['name'];?></a>
									<!-- <span class="rightSidebarSingleContentText1Span">United States</span>
									<span class="rightSidebarSingleContentText2Span">Films</span>
									<span class="rightSidebarSingleContentTextDateSpan"><?php echo $row['name'];?></span> -->
								</div>
							</li>
							<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container homepageMiddleContentContainerDiv">
		<div class="row">
			<div class="col-md-7">
				<div class="col-md-12 col-sm-12 col-xs-12 homepageMiddleContentLeftTitleDiv">Latest Programs</div>
				<?php
				foreach ($part2 as $row) {  ?>
					<div class="col-md-4 col-sm-4 col-xs-6 homepageMiddleContentLeftTextDiv showVideoPopup" data-url='<?php echo $row['url'];?>'>
						<img src="<?php echo $row['imgpath'];?>" class="img-responsive homepageMiddleContentLeftTextThumbImgDiv" alt="">

						<a href="#" align="center" class="homepageMiddleContentLeftTextTitleLink"><?php echo $row['name'];?></a>
					</div>
					<?php } ?>


			</div>
			<div class="col-md-5">
				<div class="col-md-12 col-sm-12 col-xs-12 homepageMiddleContentRightTitleDiv">Most Popular Videos</div>
				<div class="homepageMiddleContentRightOuterDiv">

					<?php
					foreach ($part3 as $row) {  ?>
						<div class="col-md-12 homepageMiddleContentRightTextDiv showVideoPopup" data-url='<?php echo $row['url'];?>'>
							<img src="<?php echo $row['imgpath'];?>" class="img-responsive homepageMiddleContentRightTextThumbImgDiv" alt="">
							<a href="#" class="homepageMiddleContentRightTextTitleLink"><?php echo $row['name'];?></a>
						</div>
						<?php } ?>

				</div>
			</div>
		</div>
	</div>

	<div class="container homepageBottomContentContainerDiv">
		<div class="row">
			<div class="col-md-12">
				<div class="homepageBottomContentTitleDiv">Latest Business News</div>
				<div class="homepageBottomContentOuterDiv">
					<ul id="homepageBottomContentLightSlider" class="homepageBottomContentLightSliderUL">

						<?php
						foreach ($part4 as $row) {  ?>
							<li class="homepageBottomContentSingleContentLI showVideoPopup" data-url='<?php echo $row['url'];?>'>
								<img src="<?php echo $row['imgpath'];?>" class="img-responsive homepageBottomContentSingleContentThumbImgDiv" alt="">
							</li>
							<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="container footerTopContainerDiv">
		<div class="row">
			<div class="col-md-12" style="padding:0px 80px;background-color:#cfcfcf;">
				<div class="continer footerTopContainerMenuHeadingDiv">
					<div class="row">
						<!-- <div class="col-md-3"><span class="footerTopContainerMenuHeadingTitleSpan">Community</span></div> -->
						<div class="col-md-3"><span class="footerTopContainerMenuHeadingTitleSpan">About us</span></div>
						<div class="col-md-3"><span class="footerTopContainerMenuHeadingTitleSpan">Career</span></div>
						<div class="col-md-3"><span class="footerTopContainerMenuHeadingTitleSpan">Privacy Policy</span></div>
						<div class="col-md-3"><span class="footerTopContainerMenuHeadingTitleSpan">Advertise</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="padding:0px 80px;">
				<div class="continer footerTopContainerMenuListDiv">
					<div class="row">
						<!-- <div class="col-md-3">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Zakah calculator</a></li>
								<li><a href="#">Inheritance calculator</a></li>
							</ul>
						</div> -->
						<div class="col-md-3">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Who are we?</a></li>
								<!-- <li><a href="#">Events</a></li> -->
								<li><a href="#">Contact us</a></li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Job oppertunity</a></li>
								<li><a href="#">Volunteers club</a></li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Terms and conditions</a></li>
								<li><a href="#">Cookies policy</a></li>
							</ul>
						</div>
						<div class="col-md-3">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Contact Form</a></li>
								<!-- <li><a href="#">Testimonials</a></li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container footerTopContainerResponsiveDiv">
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-12" style="padding:0px 80px;background-color:#cfcfcf;">
				<div class="continer footerTopContainerMenuHeadingDiv">
					<div class="row">
						<div class="col-md-12"><span class="footerTopContainerMenuHeadingTitleSpan">Community</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="padding:0px 80px;">
				<div class="continer footerTopContainerMenuListDiv">
					<div class="row">
						<div class="col-md-12">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Zakah calculator</a></li>
								<li><a href="#">Inheritance calculator</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12" style="padding:0px 80px;background-color:#cfcfcf;">
				<div class="continer footerTopContainerMenuHeadingDiv">
					<div class="row">
 						<div class="col-md-12"><span class="footerTopContainerMenuHeadingTitleSpan">About us</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="padding:0px 80px;">
				<div class="continer footerTopContainerMenuListDiv">
					<div class="row">
						<div class="col-md-12">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Who are we?</a></li>
								<li><a href="#">Events</a></li>
								<li><a href="#">Contact us</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12" style="padding:0px 80px;background-color:#cfcfcf;">
				<div class="continer footerTopContainerMenuHeadingDiv">
					<div class="row">
						<div class="col-md-12"><span class="footerTopContainerMenuHeadingTitleSpan">Join us</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="padding:0px 80px;">
				<div class="continer footerTopContainerMenuListDiv">
					<div class="row">
						<div class="col-md-12">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Job vacancies</a></li>
								<li><a href="#">Volunteers club</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12" style="padding:0px 80px;background-color:#cfcfcf;">
				<div class="continer footerTopContainerMenuHeadingDiv">
					<div class="row">
						<div class="col-md-12"><span class="footerTopContainerMenuHeadingTitleSpan">Privacy Policy</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="padding:0px 80px;">
				<div class="continer footerTopContainerMenuListDiv">
					<div class="row">
						<div class="col-md-12">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Terms and conditions</a></li>
								<li><a href="#">Cookies policy</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top: 10px;">
			<div class="col-md-12" style="padding:0px 80px;background-color:#cfcfcf;">
				<div class="continer footerTopContainerMenuHeadingDiv">
					<div class="row">
						<div class="col-md-12"><span class="footerTopContainerMenuHeadingTitleSpan">Advertise</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="padding:0px 80px;">
				<div class="continer footerTopContainerMenuListDiv">
					<div class="row">
						<div class="col-md-12">
							<ul class="footerTopContainerMenuListUL">
								<li><a href="#">Clients</a></li>
								<li><a href="#">Testimonials</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container footerMiddleContainerDiv">
		<div class="row">
			<div class="col-md-2 col-sm-1 col-xs-12"></div>
			<div class="col-md-3 col-sm-4 col-xs-12 footerMiddleContainerSubscribeTextDiv">
				<span class="footerMiddleContainerSubscribeTitleTextSpan">Subscribe with us</span>
				<span class="footerMiddleContainerSubscribeDetailTextSpan">Don't miss out on all of our events and activities</span>
			</div>
			<div class="col-md-5 col-sm-6 col-xs-12 footerMiddleContainerSubscribeFormDiv">
				<input type="text" name="subscribeEmailInput" id="subscribeEmailInput" class="subscribeEmailInput" value="" placeholder="E-Mail">
				<input type="button" name="subscribeSubmitBtn" id="subscribeSubmitBtn" class="subscribeSubmitBtn" value="Subscribe">
			</div>
			<div class="col-md-2 col-sm-1 col-xs-12"></div>
		</div>
	</div>

	<div class="container-fluid footerBottomContainerDiv">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-4 footerBottomContainerLeftDiv"></div>
			<div class="col-md-4 col-sm-4 col-xs-4 footerBottomContainerMiddleDiv">
				<a href="#"><img src="/includes/kawnaintv/images/social-facebook.png" alt="facebook"></a>
				<a href="#"><img src="/includes/kawnaintv/images/social-twitter.png" alt="twitter"></a>
				<a href="#"><img src="/includes/kawnaintv/images/social-linkedin.png" alt="linkedin"></a>
				<a href="#"><img src="/includes/kawnaintv/images/social-google-plus.png" alt="google plus"></a>
				<a href="#"><img src="/includes/kawnaintv/images/social-pinterest.png" alt="pinterest"></a>
				<a href="#"><img src="/includes/kawnaintv/images/social-rss.png" alt="rss"></a>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 footerBottomContainerRightDiv"></div>
		</div>
	</div>

	<!-- Script -->
	<script src="/includes/kawnaintv/js/jquery-3.2.1.min.js"></script>
	<script src="/includes/kawnaintv/bootstrap/js/bootstrap.min.js"></script>
	<script src="/includes/kawnaintv/js/jquery.nivo.slider.js" type="text/javascript"></script>
	<script src="/includes/kawnaintv/js/lightslider.js" type="text/javascript"></script>
	<script src="/includes/kawnaintv/videojs/video.js"></script>
	<script src="/includes/kawnaintv/videojs/videojs-contrib-hls.js"></script>
	<script>

	var player = videojs('example-video');
	player.play();

	</script>
	<!-- Add fancyBox main JS files -->
	<script type="text/javascript" src="/includes/kawnaintv/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		// for facybox
	    // $("#showVideoPopup").click(function(event) {
	    //     $.fancybox.open(exampleVideoHtml);
	    // });
      // var urlData = "";
			function popular(url)
      {
        var dataString = '&videourl=' + url;
				// alert(url);
        $.ajax({
            type: "post",
            url:"/index.php/user/login/increase_num",
            data: dataString,
            success: function(response){
              // alert(response);
                        }
              });
      }

	    $(".showVideoPopup").click(function() {
			var urlData = $(this).data("url");
			popular(urlData);
			$.fancybox.open({
				href : "/user/custom/platform?vdo_url="+urlData,
				type : 'iframe',
				padding : 5,
				width: 650,
				height: 350,
				fitToView: true
			});
		});
	});
	</script>
	<script src="/includes/kawnaintv/js/script.js"></script>

</body>
</html>
