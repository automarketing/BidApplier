<?php

$t_url=url("/viewpublic/gettournamentdetails/{$tournamentInfo[0]['id']}");
$t_text=   (string)"{$tournamentInfo[0]['name']} is a match tournament with {$tournamentInfo[0]['prize_money']} worth. {$tournamentInfo[0]['name']} starts from {$tournamentInfo[0]['start_date']} to {$tournamentInfo[0]['end_date']} at {$tournamentInfo[0]['location']}  {$tournamentInfo[0]['description']}";

$t_title="Tournament Details for {$tournamentInfo[0]['name']}";

$fb_url = 'https://www.facebook.com/dialog/share?app_id=' . env('FACEBOOK_APP_ID') . '&amp;display=popup&amp;href=' .$t_url. '&amp;redirect_uri=' . url('js_close');
//$tw_url = 'https://twitter.com/intent/tweet?url=' . $t_url. '&amp;text=' . str_limit($t_text,80) . '&amp;title=' . $t_title . '&amp;via=sj_sportsjun';
$tw_url = 'https://twitter.com/intent/tweet?url=' . $t_url;
$gp_url = 'https://plus.google.com/share?url=' . $t_url;
$t_img_path=!empty($left_menu_data['logo'])?$left_menu_data['logo']:'';
$data_image=url("/uploads/tournaments/$t_img_path");
   

?>

<div>
<div class=" col-md-4 col-md-offset-6 " >

    <div class="">
        <table class="sj-social">
            <tbody>
            <tr>
                <td class="sj-social-td">
                   <a href="javascript:void(0);" onclick='SJ.GLOBAL.shareFacebook("{{$t_url}}","{{$t_title}}","{{$data_image}}", "{{$t_text}}");' class="sj-social-ancr sj-social-ancr-fb" rel="noreferrer">
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
</div>

</div>