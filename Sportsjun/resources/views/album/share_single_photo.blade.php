<?php

switch ($action) {
	case 'tournaments':
		$sharingKit=Helper::getTournamentDetails($action_id);
		break;
	case 'team':
		$sharingKit=Helper::getTeamDetails($action_id);
		break;
	case 'organization':
		$sharingKit=Helper::getOrganisationDetails($action_id);
		break;
	case 'user':
		$sharingKit=Helper::getUserDetails($action_id);
		break;
	default:
		$sharingKit=(object)['sharingString'=>'','logo'=>'', 'name'=>''];
		break;
}
$data_url='';
$data_text=$sharingKit->sharingString;
$data_title="$sharingKit->name Added a new photo to his Album";
$data_image=url("/uploads/gallery_$action/$action_id/$sharingKit->logo");


$t_url=url('/viewpublic/createphoto/'.$album_id.'/'.$user_id.'/0/'.$action.'/'.$action_id);
$t_text="$data_text";

$t_title="$data_title";
$photo_url=url("uploads/gallery/gallery_$action/$action_id/{$album['url']}");

$fb_url = 'https://www.facebook.com/dialog/share?app_id=' . env('FACEBOOK_APP_ID') .'&amp;image=' . $photo_url .'&amp;display=popup&amp;href=' .$t_url. '&amp;redirect_uri=' . url('js_close');
$tw_url = 'https://twitter.com/intent/tweet?url=' . $t_url. '&amp;text=' . str_limit($t_text,80) . '&amp;title=' . $t_title . '&amp;via=sj_sportsjun';
$gp_url = 'https://plus.google.com/share?url=' . $t_url;
?>

<ul class="ssk-group col-md-10 col-md-offset-1 dropdown-menu ">


	<div class="">
		<table class="sj-social">
			<tbody>
			<tr>
				<td class="sj-social-td">
					<a href="javascript:void(0);" onclick="SJ.GLOBAL.shareFacebook('{{$t_url}}','{{$t_title}}','{{$photo_url}}', '{{$t_text}}');" class="sj-social-ancr sj-social-ancr-fb" rel="noreferrer">
						<span class="sj-ico sj-fb-share "></span>
						<span class="sj-font-12">Share</span>
					</a>
				</td>
				<td class="sj-social-td">
					<a href="javascript:void(0);" onclick="SJ.GLOBAL.share('{{$tw_url}}', 'sjtw');" class="sj-social-ancr sj-social-ancr-twt" rel="noreferrer">
						<span class="sj-ico sj-twt-share"></span>
						<span class="sj-font-12">Tweet</span>
					</a>
				</td>
				<td class="sj-social-td">
					<a href="javascript:void(0);" onclick="SJ.GLOBAL.share('{{$gp_url}}', 'sjgp');" class="sj-social-ancr sj-social-ancr-gplus" rel="noreferrer">
						<span class="sj-ico sj-gplus-share"></span>
						<span class="sj-font-12">Share</span>
					</a>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</ul>