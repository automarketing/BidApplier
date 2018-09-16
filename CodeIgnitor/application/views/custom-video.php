<?php
$vdo_url = trim($_GET['vdo_url']);
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
// $iurl = "http://".$wowza_serverip.":1935/live/Bangla.stream/playlist.m3u8?".$wowzatoken."starttime=".$wowzastart."&".$wowzatoken."endtime=".$wowzaend."&".$wowzatoken."CustomParam=star&".$wowzatoken."hash=".$usableHash;
//HLS protocol for Iphone
if(!empty($vdo_url)){
	$iurl = $vdo_url;
}
else{
	$iurl = "http://".$wowza_serverip.":1935/live/Bangla.stream/playlist.m3u8?".$wowzatoken."starttime=".$wowzastart."&".$wowzatoken."endtime=".$wowzaend."&".$wowzatoken."CustomParam=star&".$wowzatoken."hash=".$usableHash;
}
?>

<html>
<link href="/includes/kawnaintv/videojs/video-js.css" rel="stylesheet">
<video id="example-video" width="650" height="350" class="video-js vjs-default-skin" controls>
  <source
     src="<?php echo $iurl; ?>"
     type="application/x-mpegURL">
</video>
<script src="/includes/kawnaintv/videojs/video.js"></script>
<script src="/includes/kawnaintv/videojs/videojs-contrib-hls.js"></script>
<script>

var player = videojs('example-video');
player.play();

</script>
