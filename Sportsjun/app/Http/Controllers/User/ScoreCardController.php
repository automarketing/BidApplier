<?php
namespace App\Http\Controllers\User;
use App\Helpers\AllRequests;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Model\BasketballPlayerMatchwiseStats;
use App\Model\BasketballStatistic;
use App\Model\CricketPlayerMatchwiseStats;
use App\Model\CricketStatistic;
use App\Model\HockeyPlayerMatchwiseStats;
use App\Model\HockeyStatistic;
use App\Model\MatchSchedule;
use App\Model\MatchScheduleRubber;
use App\Model\Photo;
use App\Model\SoccerPlayerMatchwiseStats;
use App\Model\SoccerStatistic;
use App\Model\Sport;
use App\Model\Team;
use App\Model\TeamPlayers;
use App\Model\TennisPlayerMatchScore;
use App\Model\TennisPlayerRubberScore;
use App\Model\TennisStatistic;
use App\Model\TournamentGroupTeams;
use App\Model\Tournaments;
use App\Model\TtPlayerMatchScore;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Request;
use Response;
use ScoreCard as ScoreCardHelper;
use Session;

class ScoreCardController extends Controller {
	//function to create score card
	public function createScorecard($match_id)
	{
		//get scheduled matches data data
		$match_data=array();
		$match_details = MatchSchedule::where('id',$match_id)->get();
		if(count($match_details)>0)
			$match_data = $match_details->toArray();
		$upload_folder = '';
		$is_singles = '';
		if(!empty($match_data))
		{
			$tournamentDetails = [];
			//if bye match, b_id is null

			//if b_id is null update a_id as winner
			if(!empty($match_data[0]['tournament_id']) && $match_data[0]['winner_id']=='' && $match_data[0]['b_id']=='') {
				$matchScheduleDetails = MatchSchedule::where('id',$match_id)->first();
				$tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
				if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {

					// If not Archery, end match 
				if($match_data[0]['sports_category']!='athletics')
					MatchSchedule::where('id',$match_id)->update(['match_status'=>'completed',
						'winner_id'=>$match_data[0]['a_id'] ]);

					if(!empty($matchScheduleDetails['tournament_round_number'])) {
                        $matchScheduleDetails->updateBracketDetails();
					}

				}

			}


			$match_details = MatchSchedule::where('id',$match_id)->get();
			if(count($match_details)>0)
				$match_data = $match_details->toArray();

			//new tournament details for the new sports. soccer, 
			if(!is_null($match_details[0]['tournament_id'])){
				$tournamentDetails=Tournaments::find($match_details[0]['tournament_id'])->toArray();
			}

			$sport_id = $match_data[0]['sports_id'];//get sport id
			$sportsDetails = Sport::where('id',$sport_id)->get()->toArray();//get sports details

			if(!empty($sportsDetails))
			{

				$sport_name = $sportsDetails[0]['sports_name'];
				if(strtolower($sport_name)==strtolower('Tennis'))//if match is related to tennis
				{
					//return  $this->tennisOrTableTennisScoreCard($match_data,$match='Tennis',$sportsDetails,$tournamentDetails);
					$tt= new ScoreCard\TennisScoreCardController;
					return $tt->tennisScoreCard($match_data,$match='Tennis',$sportsDetails,$tournamentDetails);
				}else if(strtolower($sport_name)==strtolower('Table Tennis'))//if match is related to table tennis
				{
					//return $this->tennisOrTableTennisScoreCard($match_data,$match='Table Tennis',$sportsDetails,$tournamentDetails);
					$tt= new ScoreCard\TabletennisScoreCardController;
					return $tt->tabletennisScoreCard($match_data,$match='Table Tennis',$sportsDetails,$tournamentDetails);
				}else if(strtolower($sport_name)==strtolower('Cricket'))
				{
					$tt = new ScoreCard\CricketScoreCardController;
					return $tt->cricketScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('soccer'))
				{
                    $tt = new ScoreCard\SoccerScoreCardController;
					return $tt->soccerScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('badminton'))
				{
					$badminton= new ScoreCard\BadmintonScoreCardController;
					return $badminton->badmintonScoreCard($match_data,$match='Badminton',$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('squash')){
					$squash= new ScoreCard\SquashScoreCardController;
					return $squash->squashScoreCard($match_data,$match='Squash',$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('hockey'))
				{
						$hockey= new ScoreCard\HockeyScorecardController;
					return $hockey->hockeyScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('Ultimate Frisbee'))
				{
						$hockey= new ScoreCard\UltimateFrisbeeScorecardController;
					return $hockey->ultimateFrisbeeScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('Water Polo'))
				{
						$hockey= new ScoreCard\WaterPoloScorecardController;
				  return $hockey->waterpoloScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('volleyball'))
				{
					$volleyball = new ScoreCard\VolleyballScoreCardController;
					return $volleyball->volleyballScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('Throw ball'))
				{
					$volleyball = new ScoreCard\ThrowballScoreCardController;
					return $volleyball->throwballScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}
				else if(strtolower($sport_name)==strtolower('Kabaddi'))
				{
					$volleyball = new ScoreCard\KabaddiScoreCardController;
					return $volleyball->kabaddiScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}

				else if(strtolower($sport_name)==strtolower('basketball'))
				{
					$basketball = new ScoreCard\BasketballScoreCardController;
					return $basketball->basketballScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}

				else if(strtolower($sport_name)==strtolower('archery'))
				{
					$archery = new ScoreCard\ArcheryController;
					return $archery->archeryScoreCard($match_data,$sportsDetails,$tournamentDetails);
				}

				else if(strtolower($sport_name) == strtolower('smite'))
                {
                    $smite = new Esports\SmiteController;
                    return $smite->smiteScoreCard($match_data, $sportsDetails, $tournamentDetails);
                }
			}
		}
	}

	//function to display tennis score card form
	public function tennisOrTableTennisScoreCard($match_data,$match,$sportsDetails=[],$tournamentDetails=[],$is_from_view=0)
	{

		$score_a_array=array();
		$score_b_array=array();

		$loginUserId = '';
		$loginUserRole = '';

		if(isset(Auth::user()->id))
			$loginUserId = Auth::user()->id;

		if(isset(Auth::user()->role))
			$loginUserRole = Auth::user()->role;

		 $game_type=$match_data[0]['game_type'];
            if($game_type=='rubber'){              
                $rubbers=MatchscheduleRubber::whereMatchId($match_data[0]['id'])->get();

                if(!count($rubbers)){
                    $scheduleController = new ScheduleController;
                    $rubbers            = $scheduleController->insertGroupRubber($match_data[0]['id']);
                }

                $active_rubber=$this->getActiveRubber($match_data[0]['id']);

                if(count($active_rubber)){
                   
                    $rubber_details=$active_rubber;
                     $active_rubber=$active_rubber->rubber_number;
                }
                else {
                    $active_rubber=null;
                    $rubber_details = null;
                }

            }
            else{
                $active_rubber=null;
                $rubber_details=null;
                $rubbers=[];
            }

		//!empty($matchScheduleDetails['tournament_id'])
		//if($match_data[0]['match_status']=='scheduled')//match should be already scheduled
		//{
		$player_a_ids = $match_data[0]['player_a_ids'];
		$player_b_ids = $match_data[0]['player_b_ids'];

		$decoded_match_details = array();
		if($match_data[0]['match_details']!='')
		{
			$decoded_match_details = json_decode($match_data[0]['match_details'],true);
		}

		$a_players = array();

		$team_a_playerids = (!empty($decoded_match_details[$match_data[0]['a_id']]) && !($match_data[0]['scoring_status']=='' || $match_data[0]['scoring_status']=='rejected'))?$decoded_match_details[$match_data[0]['a_id']]:explode(',',$player_a_ids);

		$a_team_players = User::select('id','name')->whereIn('id',$team_a_playerids)->get();

		if (count($a_team_players)>0)
			$a_players = $a_team_players->toArray();

		$b_players = array();

		$team_b_playerids = (!empty($decoded_match_details[$match_data[0]['b_id']]) && !($match_data[0]['scoring_status']=='' || $match_data[0]['scoring_status']=='rejected'))?$decoded_match_details[$match_data[0]['b_id']]:explode(',',$player_b_ids);


		$b_team_players = User::select('id','name')->whereIn('id',$team_b_playerids)->get();

		if (count($b_team_players)>0)
			$b_players = $b_team_players->toArray();

		$team_a_player_images = array();
		$team_b_player_images = array();

		//team a player images
		if(count($a_players)>0)
		{
			foreach($a_players as $a_player)
			{
				$team_a_player_images[$a_player['id']]=Photo::select()->where('imageable_id', $a_player['id'])->where('imageable_type',config('constants.PHOTO.USER_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
			}
		}

		//team b player images
		if(count($b_players)>0)
		{
			foreach($b_players as $b_player)
			{
				$team_b_player_images[$b_player['id']]=Photo::select()->where('imageable_id', $b_player['id'])->where('imageable_type',config('constants.PHOTO.USER_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
			}
		}
		if($match_data[0]['schedule_type'] == 'player')//&& $match_data[0]['schedule_type'] == 'player'
		{
			$user_a_name = User::where('id',$match_data[0]['a_id'])->pluck('name');
			$user_b_name = User::where('id',$match_data[0]['b_id'])->pluck('name');
			$user_a_logo = Photo::select()->where('imageable_id', $match_data[0]['a_id'])->where('imageable_type',config('constants.PHOTO.USER_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
			$user_b_logo = Photo::select()->where('imageable_id', $match_data[0]['b_id'])->where('imageable_type',config('constants.PHOTO.USER_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
			$upload_folder = 'user_profile';
			$is_singles = 'yes';
			if($match=='Tennis')//tennis
			{
				$scores_a = TennisPlayerMatchScore::select()->where('user_id_a',$match_data[0]['a_id'])->where('match_id',$match_data[0]['id'])->get();
				$scores_b = TennisPlayerMatchScore::select()->where('user_id_a',$match_data[0]['b_id'])->where('match_id',$match_data[0]['id'])->get();
			}
			else //table tennis
			{
				$scores_a = TtPlayerMatchScore::select()->where('user_id_a',$match_data[0]['a_id'])->where('match_id',$match_data[0]['id'])->get();
				$scores_b = TtPlayerMatchScore::select()->where('user_id_a',$match_data[0]['b_id'])->where('match_id',$match_data[0]['id'])->get();
			}
			if(count($scores_a)>0)
				$score_a_array = $scores_a->toArray();

			if(count($scores_b)>0)
				$score_b_array = $scores_b->toArray();

			$team_a_city = Helper::getUserCity($match_data[0]['a_id']);
			$team_b_city = Helper::getUserCity($match_data[0]['b_id']);
		}else
		{
			$user_a_name = Team::where('id',$match_data[0]['a_id'])->pluck('name');//team details
			$user_b_name = Team::where('id',$match_data[0]['b_id'])->pluck('name');//team details
			$user_a_logo = Photo::select()->where('imageable_id', $match_data[0]['a_id'])->where('imageable_type',config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
			$user_b_logo = Photo::select()->where('imageable_id', $match_data[0]['b_id'])->where('imageable_type',config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
			$upload_folder = 'teams';
			$is_singles = 'no';
			if($match=='Tennis')//TENNIS
			{
				$scores_a = TennisPlayerMatchScore::select()->where('team_id',$match_data[0]['a_id'])->where('match_id',$match_data[0]['id'])->get();
				$scores_b = TennisPlayerMatchScore::select()->where('team_id',$match_data[0]['b_id'])->where('match_id',$match_data[0]['id'])->get();
			}
			else //table tennis
			{
				$scores_a = TtPlayerMatchScore::select()->where('team_id',$match_data[0]['a_id'])->where('match_id',$match_data[0]['id'])->get();
				$scores_b = TtPlayerMatchScore::select()->where('team_id',$match_data[0]['b_id'])->where('match_id',$match_data[0]['id'])->get();
			}
			if(count($scores_a)>0)
				$score_a_array = $scores_a->toArray();

			if(count($scores_b)>0)
				$score_b_array = $scores_b->toArray();

			$team_a_city = Helper::getTeamCity($match_data[0]['a_id']);
			$team_b_city = Helper::getTeamCity($match_data[0]['b_id']);
		}

		//bye match
		if($match_data[0]['b_id']=='' && $match_data[0]['match_status']=='completed')
		{
			$sport_class = 'tennis_scorcard';
			return view('scorecards.byematchview',array('team_a_name'=>$user_a_name,'team_a_logo'=>$user_a_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'sport_class'=>$sport_class));
		}



		//score status
		$score_status_array = json_decode($match_data[0]['score_added_by'],true);


		$rej_note_str='';
		if($score_status_array['rejected_note']!='')
		{
			$rejected_note_array = explode('@',$score_status_array['rejected_note']);
			$rejected_note_array = array_filter($rejected_note_array);
			foreach($rejected_note_array as $note)
			{
				$rej_note_str = $rej_note_str.$note.' ,';
			}
		}
		$rej_note_str = trim($rej_note_str, ",");


		//is valid user for score card enter or edit
		$isValidUser = 0;
		$isApproveRejectExist = 0;
		$isForApprovalExist = 0;
		if(isset(Auth::user()->id)){
			$isValidUser = Helper::isValidUserForScoreEnter($match_data);
			//is approval process exist
			$isApproveRejectExist = Helper::isApprovalExist($match_data);
			$isForApprovalExist = Helper::isApprovalExist($match_data,$isForApproval='yes');
		}

		//ONLY FOR VIEW SCORE CARD
   $isAdminEdit = 0;
        if(Session::has('is_allowed_to_edit_match')){
            $session_data = Session::get('is_allowed_to_edit_match');

            if($isValidUser && ($session_data[0]['id']==$match_data[0]['id'])){
                $isAdminEdit=1;
            }
        }


        if(($is_from_view==1 || (!empty($score_status_array['added_by']) && $score_status_array['added_by']!=$loginUserId && $match_data[0]['scoring_status']!='rejected') || $match_data[0]['match_status']=='completed' || $match_data[0]['scoring_status']=='approval_pending' || $match_data[0]['scoring_status']=='approved' || !$isValidUser) && !$isAdminEdit)
		{
			if($match=='Tennis')
			{
				return view('scorecards.tennisscorecardview',array('tournamentDetails' => $tournamentDetails, 'sportsDetails'=> $sportsDetails, 'user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str,'loginUserRole'=>$loginUserRole,'isValidUser'=>$isValidUser,'isApproveRejectExist'=>$isApproveRejectExist,'isForApprovalExist'=>$isForApprovalExist,'action_id'=>$match_data[0]['id'],'team_a_city'=>$team_a_city,'team_b_city'=>$team_b_city,'rubbers'=>$rubbers,'active_rubber'=>$active_rubber, 'rubber_details'=>$rubber_details));
			}else
			{

				return view('scorecards.tabletennisscorecardview',array('tournamentDetails' => $tournamentDetails, 'sportsDetails'=> $sportsDetails, 'user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str,'loginUserRole'=>$loginUserRole,'isValidUser'=>$isValidUser,'isApproveRejectExist'=>$isApproveRejectExist,'isForApprovalExist'=>$isForApprovalExist,'action_id'=>$match_data[0]['id'],'team_a_city'=>$team_a_city,'team_b_city'=>$team_b_city,'rubbers'=>$rubbers,'active_rubber'=>$active_rubber, 'rubber_details'=>$rubber_details));
			}
		}
		else //to view and edit tennis/table tennis score card
		{
			if($match=='Tennis')
			{
				//for form submit pass id from controller
				$form_id = 'tennis';
				return view('scorecards.tennisscorecard',array('tournamentDetails' => $tournamentDetails, 'sportsDetails'=> $sportsDetails, 'user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str,'loginUserRole'=>$loginUserRole,'isValidUser'=>$isValidUser,'isApproveRejectExist'=>$isApproveRejectExist,'isForApprovalExist'=>$isForApprovalExist,'action_id'=>$match_data[0]['id'],'team_a_city'=>$team_a_city,'team_b_city'=>$team_b_city,'form_id'=>$form_id,'rubbers'=>$rubbers,'active_rubber'=>$active_rubber, 'rubber_details'=>$rubber_details));
			}else
			{
				//for form submit pass id from controller
				$form_id = 'tabletennis';
				return view('scorecards.tabletennisscorecard',array('tournamentDetails' => $tournamentDetails, 'sportsDetails'=> $sportsDetails, 'user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str,'loginUserRole'=>$loginUserRole,'isValidUser'=>$isValidUser,'isApproveRejectExist'=>$isApproveRejectExist,'isForApprovalExist'=>$isForApprovalExist,'action_id'=>$match_data[0]['id'],'team_a_city'=>$team_a_city,'team_b_city'=>$team_b_city,'form_id'=>$form_id,'rubbers'=>$rubbers,'active_rubber'=>$active_rubber, 'rubber_details'=>$rubber_details));
			}
		}

		//}
	}
	//function to insert tennis score card
	public function insertTennisScoreCard()
	{
		$loginUserId = Auth::user()->id;
		$match_id = !empty(Request::get('match_id'))?Request::get('match_id'):NULL;
		$isValid = $this->checkScoreEnterd($match_id);
		$message = '';
		if($isValid==0)
		{
			$user_name = $this->scoreAddedByUserName($match_id);
			$message = 'Scorecard already entered by '.$user_name;
		}

		$request = Request::all();
		$tournament_id = !empty(Request::get('tournament_id'))?Request::get('tournament_id'):NULL;
		$match_id = !empty(Request::get('match_id'))?Request::get('match_id'):NULL;
		$match_type = !empty(Request::get('match_type'))?Request::get('match_type'):NULL;
		$player_ids_a = !empty(Request::get('player_ids_a'))?Request::get('player_ids_a'):NULL;
		$player_ids_b= !empty(Request::get('player_ids_b'))?Request::get('player_ids_b'):NULL;
		$player_ids_a_array = explode(',',$player_ids_a);
		$is_singles = !empty(Request::get('is_singles'))?Request::get('is_singles'):NULL;
		$is_winner_inserted = !empty(Request::get('is_winner_inserted'))?Request::get('is_winner_inserted'):NULL;
		$winner_team_id = !empty(Request::get('winner_team_id'))?Request::get('winner_team_id'):$is_winner_inserted;//winner_id

		$team_a_players = !empty(Request::get('a_player_ids'))?Request::get('a_player_ids'):array();//player id if match type is singles
		$team_b_players = !empty(Request::get('b_player_ids'))?Request::get('b_player_ids'):array();//player id if match type is singles

		//shedule type
		$schedule_type = !empty(Request::get('schedule_type'))?Request::get('schedule_type'):NULL;

		//match a Details
		$user_id_a = !empty(Request::get('user_id_a'))?Request::get('user_id_a'):NULL;
		$player_name_a = !empty(Request::get('player_name_a'))?Request::get('player_name_a'):NULL;
		$set1_a = !empty(Request::get('set_1_a'))?Request::get('set_1_a'):NULL;
		$set2_a = !empty(Request::get('set_2_a'))?Request::get('set_2_a'):NULL;
		$set3_a = !empty(Request::get('set_3_a'))?Request::get('set_3_a'):NULL;
		$set4_a = !empty(Request::get('set_4_a'))?Request::get('set_4_a'):NULL;
		$set5_a = !empty(Request::get('set_5_a'))?Request::get('set_5_a'):NULL;
		$set1_tie_breaker_a = !empty(Request::get('set_1_tiebreaker_a'))?Request::get('set_1_tiebreaker_a'):NULL;
		$set2_tie_breaker_a = !empty(Request::get('set_2_tiebreaker_a'))?Request::get('set_2_tiebreaker_a'):NULL;
		$set3_tie_breaker_a = !empty(Request::get('set_3_tiebreaker_a'))?Request::get('set_3_tiebreaker_a'):NULL;
		$set4_tie_breaker_a = !empty(Request::get('set_4_tiebreaker_a'))?Request::get('set_4_tiebreaker_a'):NULL;
		$set5_tie_breaker_a = !empty(Request::get('set_5_tiebreaker_a'))?Request::get('set_5_tiebreaker_a'):NULL;
		$aces_a = !empty(Request::get('aces_a'))?Request::get('aces_a'):NULL;
		$double_faults_a = !empty(Request::get('double_faults_a'))?Request::get('double_faults_a'):NULL;

		//match a Details
		$user_id_b = !empty(Request::get('user_id_b'))?Request::get('user_id_b'):NULL;
		$player_name_b = !empty(Request::get('player_name_b'))?Request::get('player_name_b'):NULL;
		$set1_b = !empty(Request::get('set_1_b'))?Request::get('set_1_b'):NULL;
		$set2_b = !empty(Request::get('set_2_b'))?Request::get('set_2_b'):NULL;
		$set3_b = !empty(Request::get('set_3_b'))?Request::get('set_3_b'):NULL;
		$set4_b = !empty(Request::get('set_4_b'))?Request::get('set_4_b'):NULL;
		$set5_b = !empty(Request::get('set_5_b'))?Request::get('set_5_b'):NULL;
		$set1_tie_breaker_b = !empty(Request::get('set_1_tiebreaker_b'))?Request::get('set_1_tiebreaker_b'):NULL;
		$set2_tie_breaker_b = !empty(Request::get('set_2_tiebreaker_b'))?Request::get('set_2_tiebreaker_b'):NULL;
		$set3_tie_breaker_b = !empty(Request::get('set_3_tiebreaker_b'))?Request::get('set_3_tiebreaker_b'):NULL;
		$set4_tie_breaker_b = !empty(Request::get('set_4_tiebreaker_b'))?Request::get('set_4_tiebreaker_b'):NULL;
		$set5_tie_breaker_b = !empty(Request::get('set_5_tiebreaker_b'))?Request::get('set_5_tiebreaker_b'):NULL;
		$aces_b = !empty(Request::get('aces_b'))?Request::get('aces_b'):NULL;
		$double_faults_b = !empty(Request::get('double_faults_b'))?Request::get('double_faults_b'):NULL;

		$match_model=Matchschedule::find($match_id);
        $game_type = $match_model->game_type; 
		 if($game_type=='rubber'){
            $number_of_rubber = $match_model->number_of_rubber;
            $active_rubber = $match_model->getActiveRubber();
            $rubber_number= $active_rubber->rubber_number;

            if($number_of_rubber==$rubber_number) $rubber_completed=1;
            else $rubber_completed=0;
            $rubber_id=$active_rubber->id;
        }        
        else {
            $rubber_completed=0;
            $rubber_id=1;
            $active_rubber=0;
        }

		//get previous scorecard status data
		if($game_type=='normal')  $scorecardDetails = MatchSchedule::where('id',$match_id)->pluck('score_added_by');
        else  $scorecardDetails = MatchScheduleRubber::where('id',$rubber_id)->pluck('score_added_by');


       if($game_type=='normal'){
		if($is_singles=='yes')
		{
			$team_a_records = TennisPlayerMatchScore::select()->where('match_id',$match_id)->where('user_id_a',$user_id_a)->get();
			$team_b_records = TennisPlayerMatchScore::select()->where('match_id',$match_id)->where('user_id_a',$user_id_b)->get();
			$users_a = $user_id_a; //if singles
			$users_b = $user_id_b;
		}else
		{
			$team_a_records = TennisPlayerMatchScore::select()->where('match_id',$match_id)->where('team_id',$user_id_a)->get();
			$team_b_records = TennisPlayerMatchScore::select()->where('match_id',$match_id)->where('team_id',$user_id_b)->get();
			$users_a = $player_ids_a;
			$users_b = $player_ids_b;
		}
	}

	 else{
	 	$team_a_records = TennisPlayerRubberScore::select()->where('rubber_id',$rubber_id)->where('team_id',$user_id_a)->get();
			$team_b_records = TennisPlayerRubberScore::select()->where('rubber_id',$rubber_id)->where('team_id',$user_id_b)->get();
			$users_a = $player_ids_a;
			$users_b = $player_ids_b;
	 }


		//insert match a details
		if(count($team_a_records)>0)//if team a record is already exist
		{
			$this->updateTennisScore($user_id_a,$match_id,$set1_a,$set2_a,$set3_a,$set4_a,$set5_a,$set1_tie_breaker_a,$set2_tie_breaker_a,$set3_tie_breaker_a,$set4_tie_breaker_a,$set5_tie_breaker_a,$is_singles,$aces_a,$double_faults_a,$team_a_players,$schedule_type,$match_type, $game_type, $rubber_id);

		}else
		{
			$this->insertTennisScore($user_id_a,$tournament_id,$match_id,$player_name_a,$set1_a,$set2_a,$set3_a,$set4_a,$set5_a,$set1_tie_breaker_a,$set2_tie_breaker_a,$set3_tie_breaker_a,$set4_tie_breaker_a,$set5_tie_breaker_a,$is_singles,$aces_a,$double_faults_a,$team_a_players,$schedule_type,$match_type,$game_type, $rubber_id, $rubber_number);

		}


		//insert match b details
		if(count($team_b_records)>0)//if team b record is already exist
		{
			$this->updateTennisScore($user_id_b,$match_id,$set1_b,$set2_b,$set3_b,$set4_b,$set5_b,$set1_tie_breaker_b,$set2_tie_breaker_b,$set3_tie_breaker_b,$set4_tie_breaker_b,$set5_tie_breaker_b,$is_singles,$aces_b,$double_faults_b,$team_b_players,$schedule_type,$match_type ,$game_type, $rubber_id);

		}else
		{
			$this->insertTennisScore($user_id_b,$tournament_id,$match_id,$player_name_b,$set1_b,$set2_b,$set3_b,$set4_b,$set5_b,$set1_tie_breaker_b,$set2_tie_breaker_b,$set3_tie_breaker_b,$set4_tie_breaker_b,$set5_tie_breaker_b,$is_singles,$aces_b,$double_faults_b,$team_b_players,$schedule_type,$match_type,$game_type, $rubber_id, $rubber_number);

		}


		//match details clmn
		$team_a_details[$user_id_a] = $team_a_players;
		$team_b_details[$user_id_b] = $team_b_players;

		if($schedule_type=='player' && $match_type=='singles')
		{
			$team_a_details[$user_id_a] = array($user_id_a);
			$team_b_details[$user_id_b] = array($user_id_b);
		}

		$match_details = $team_a_details+$team_b_details;
		$json_match_details_array = json_encode($match_details);

		

		
		$decode_scorecard_data = json_decode($scorecardDetails,true);

		$modified_users = !empty($decode_scorecard_data['modified_users'])?$decode_scorecard_data['modified_users']:'';

		$modified_users = $modified_users.','.$loginUserId;//scorecard changed users

		$added_by = !empty($decode_scorecard_data['added_by'])?$decode_scorecard_data['added_by']:$loginUserId;

		//score card approval process
		$score_status = array('added_by'=>$added_by,'active_user'=>$loginUserId,'modified_users'=>$modified_users,'rejected_note'=>'');

		$json_score_status = json_encode($score_status);


        if($game_type=='normal')$matchScheduleDetails = MatchSchedule::where('id',$match_id)->first();
        else $matchScheduleDetails = MatchScheduleRubber::where('id',$rubber_id)->first();

		//update winner id
	
// 		if(count($matchScheduleDetails)) {
// 			$looser_team_id = NULL;
// 			$match_status = 'scheduled';
// 			$approved = '';
// 			if(isset($winner_team_id)) {
// 				if($winner_team_id==$matchScheduleDetails['a_id']) {
// 					$looser_team_id=$matchScheduleDetails['b_id'];
// 				}else{
// 					$looser_team_id=$matchScheduleDetails['a_id'];
// 				}
// 				$match_status = 'completed';
// 				$approved = 'approved';
// 			}

// 			if(!empty($matchScheduleDetails['tournament_id'])) {
// 				$tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
// 				if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {
// 					MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'match_status'=>$match_status,
// 						'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
// 						'score_added_by'=>$json_score_status]);
// //                                Helper::printQueries();

// 					if(!empty($matchScheduleDetails['tournament_round_number'])) {
// 						$matchScheduleDetails->updateBracketDetails();
// 					}
// 					if($match_status=='completed')
// 					{
// 						$sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
// 						$this->insertPlayerStatistics($sportName,$match_id);

// 						Helper::sendEmailPlayers($matchScheduleDetails, 'Tennis');	

// 						//notification code
// 					}

// 				}

// 			}else if(Auth::user()->role=='admin')
// 			{

// 				MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'match_status'=>$match_status,
// 					'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
// 					'score_added_by'=>$json_score_status,'scoring_status'=>$approved]);
// 				if($match_status=='completed')
// 				{
// 					$sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
// 					$this->insertPlayerStatistics($sportName,$match_id);

// 					Helper::sendEmailPlayers($matchScheduleDetails, 'Tennis');	

// 					//notification code
// 				}

// 			}
// 			else
// 			{
// 				MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'winner_id'=>$winner_team_id ,
// 					'looser_id'=>$looser_team_id,'score_added_by'=>$json_score_status]);
// 			}
// 		}

		 if(count($matchScheduleDetails)) {
            $looser_team_id = NULL;
            $match_status = 'scheduled';
            $approved='';
                   
                        if(isset($winner_team_id )) {
                            if($winner_team_id==$matchScheduleDetails['a_id']) {
                                $looser_team_id=$matchScheduleDetails['b_id'];
                            }else{
                                $looser_team_id=$matchScheduleDetails['a_id'];
                            }
                            $match_status = 'completed';
                            $approved = 'approved';
                     
                    }

            if(!empty($matchScheduleDetails['tournament_id'])) {
                $tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
                //  $match_status = 'completed';
                if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {

                if($game_type=='normal'){
                    MatchSchedule::where('id',$match_id)->update([
                        'match_status'=>$match_status,
                        'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,                       
                          'match_result'   => $match_result,
                        'score_added_by'=>$json_score_status]);
                    if(!empty($matchScheduleDetails['tournament_round_number'])) {
                        $matchScheduleDetails->updateBracketDetails();
                    }
                     if($match_status=='completed')            {

                    $sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
                    $this->insertPlayerStatistics($sportName,$match_id);
                  //  $this->updateStatitics($match_id, $winner_team_id, $looser_team_id); 
                     }

                    }
                else {
                                        MatchScheduleRubber::where('id',$rubber_id)->update([
                                            'match_status'=>$match_status,
                                            'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                            
                                             //'match_result'   => $match_result,
                                            'score_added_by'=>$json_score_status]);
                    
//                                Helper::printQueries();
               
                if($rubber_completed && $match_status=='completed'){
                    $winners_from_rubber = ScoreCardHelper::getWinnerInRubber($match_id,$match_model->sports_id);             
                    $winner_team_id = $winners_from_rubber['winner'];
                    $looser_team_id = $winners_from_rubber['looser'];

                                    MatchSchedule::where('id',$match_id)->update([
                                    'match_status'=>$match_status,
                                    'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                   
                                    //'match_result'   => $match_result,
                                    'score_added_by'=>$json_score_status]);

                    if(!empty($matchScheduleDetails['tournament_round_number'])) {
                        $matchScheduleDetails->updateBracketDetails();
                    }
                     
                        $sportName = Sport::where('id',$match_model->sports_id)->pluck('sports_name');
                        $this->insertPlayerStatistics($sportName,$match_id);
                       // $this->updateStatitics($match_id, $winner_team_id, $looser_team_id);                      
                    }   
                }         


                }


            }
            else if(Auth::user()->role=='admin')
            {


                 if($game_type=='normal'){
                    MatchSchedule::where('id',$match_id)->update([
                        'match_status'=>$match_status,
                        'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                        //'match_result'   => $match_result,
                        'score_added_by'=>$json_score_status, 'scoring_status'=>$approved]);
                   
                        if($match_status=='completed')
                        {
                            $sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
                            $this->insertPlayerStatistics($sportName,$match_id);
                          //  $this->updateStatitics($match_id, $winner_team_id, $looser_team_id); 

                        }
                 }
                else {
                                        MatchScheduleRubber::where('id',$rubber_id)->update([
                                            'match_status'=>$match_status,
                                            'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                            
                                             //'match_result'   => $match_result,
                                            'score_added_by'=>$json_score_status]);                    

                    if($rubber_completed && $match_status=='completed'){
                     $winners_from_rubber = ScoreCardHelper::getWinnerInRubber($match_id, $match_model->sports_id);
                        $winner_team_id = $winners_from_rubber['winner'];
                        $looser_team_id = $winners_from_rubber['looser'];
                                        MatchSchedule::where('id',$match_id)->update([
                                            'match_status'=>$match_status,
                                            'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                             
                                            // 'match_result'   => $match_result,
                                            'score_added_by'=>$json_score_status, 
                                            'scoring_status'=>$approved]);


                       
                        if(!empty($matchScheduleDetails['tournament_round_number'])) {
                            $matchScheduleDetails->updateBracketDetails();
                        }
                     
                        $sportName = Sport::where('id',$match_model->sports_id)->pluck('sports_name');
                        $this->insertPlayerStatistics($sportName,$match_id);
                      //  $this->updateStatitics($match_id, $winner_team_id, $looser_team_id);                      
                    }
                 }
            }
            else
            {
                MatchSchedule::where('id',$match_id)->update(['winner_id'=>$winner_team_id ,
                    'looser_id'=>$looser_team_id,
                  
                    // 'match_result'   => $match_result,
                     'score_added_by'=>$json_score_status]);

                   //$this->updateStatitics($match_id,$winner_team_id, $looser_team_id);
            }
        }
        //MatchSchedule::where('id',$match_id)->update(['winner_id'=>$winner_team_id,'match_details'=>$json_match_details_array,'score_added_by'=>$json_score_status ]);
        //if($winner_team_id>0)
        //return redirect()->route('match/scorecard/view', [$match_id])->with('status', trans('message.scorecard.scorecardmsg'));

        ScoreCardHelper::getWinnerInRubber($match_id, $sports_id=5);
	
		return redirect()->back()->with('status', trans('message.scorecard.scorecardmsg'));
	}

	//function to insert tennis score card
	public function insertTennisScore($user_id,$tournament_id,$match_id,$player_name,$set1,$set2,$set3,$set4,$set5,$set1_tie_breaker,$set2_tie_breaker,$set3_tie_breaker,$set4_tie_breaker,$set5_tie_breaker,$is_singles,$aces,$double_faults,$team_players,$schedule_type,$match_type, $game_type, $rubber_id, $rubber_number)
	{
		if($game_type=='normal')		$model = new TennisPlayerMatchScore();
		else 							$model = new TennisPlayerRubberScore();

		if($is_singles=='yes')
		{
			$model->user_id_a = $user_id;

		}else
		{
			$model->team_id = $user_id;
			if($schedule_type=='team' && $match_type=='singles')
			{
				$model->user_id_a = (!empty($team_players[0]))?$team_players[0]:'';
			}

		}
		$model->tournamet_id = $tournament_id;
		$model->match_id = $match_id;
		$model->player_name_a = $player_name;
		$model->set1 = $set1;
		$model->set2 = $set2;
		$model->set3 = $set3;
		$model->set4 = $set4;
		$model->set5 = $set5;
		$model->set1_tie_breaker = $set1_tie_breaker;
		$model->set2_tie_breaker = $set2_tie_breaker;
		$model->set3_tie_breaker = $set3_tie_breaker;
		$model->set4_tie_breaker = $set4_tie_breaker;
		$model->set5_tie_breaker = $set5_tie_breaker;
		$model->aces = $aces;
		$model->double_faults = $double_faults;

		if($game_type=='rubber'){
			$model->rubber_id=$rubber_id;
			$model->rubber_number=$rubber_number;
		}
		$model->save();
	}
	//function to update tennis score
	public function updateTennisScore($user_id,$match_id,$set1,$set2,$set3,$set4,$set5,$set1_tie_breaker,$set2_tie_breaker,$set3_tie_breaker,$set4_tie_breaker,$set5_tie_breaker,$is_singles,$aces,$double_faults,$team_players,$schedule_type,$match_type,$game_type='normal', $rubber_id=0)
	{
	  if($game_type=='normal'){
		if($is_singles=='yes')
		{
			TennisPlayerMatchScore::where('match_id',$match_id)->where('user_id_a',$user_id)->update(['set1'=>$set1,'set2'=>$set2,'set3'=>$set3,'set4'=>$set4,'set5'=>$set5,'set1_tie_breaker'=>$set1_tie_breaker,'set2_tie_breaker'=>$set2_tie_breaker,'set3_tie_breaker'=>$set3_tie_breaker,'set4_tie_breaker'=>$set4_tie_breaker,'set5_tie_breaker'=>$set5_tie_breaker,'aces'=>$aces,'double_faults'=>$double_faults]);
		}else
		{
			$user_id_a='';
			if($schedule_type=='team' && $match_type=='singles')
			{
				$user_id_a = (!empty($team_players[0]))?$team_players[0]:'';
			}
			TennisPlayerMatchScore::where('match_id',$match_id)->where('team_id',$user_id)->update(['set1'=>$set1,'set2'=>$set2,'set3'=>$set3,'set4'=>$set4,'set5'=>$set5,'set1_tie_breaker'=>$set1_tie_breaker,'set2_tie_breaker'=>$set2_tie_breaker,'set3_tie_breaker'=>$set3_tie_breaker,'set4_tie_breaker'=>$set4_tie_breaker,'set5_tie_breaker'=>$set5_tie_breaker,'aces'=>$aces,'double_faults'=>$double_faults,'user_id_a'=>$user_id_a]);
		}
	  }

	  else{
	  		$user_id_a='';
			if($schedule_type=='team' && $match_type=='singles')
			{
				$user_id_a = (!empty($team_players[0]))?$team_players[0]:'';
			}
	  		TennisPlayerRubberScore::where('rubber_id',$rubber_id)->where('team_id',$user_id)->update(['set1'=>$set1,'set2'=>$set2,'set3'=>$set3,'set4'=>$set4,'set5'=>$set5,'set1_tie_breaker'=>$set1_tie_breaker,'set2_tie_breaker'=>$set2_tie_breaker,'set3_tie_breaker'=>$set3_tie_breaker,'set4_tie_breaker'=>$set4_tie_breaker,'set5_tie_breaker'=>$set5_tie_breaker,'aces'=>$aces,'double_faults'=>$double_faults,'user_id_a'=>$user_id_a]);
	  }

	}
	//function to insert tennis statitistics
	public function tennisStatisticsOld($player_ids_a_array,$match_type,$is_win='', $schedule_type='normal')
	{
		//$player_ids_a_array = explode(',',$player_ids);
		foreach($player_ids_a_array as $user_id)
		{
			//check already user id exists or not
			$tennis_statistics_array = array();
			$tennisStatistics = TennisStatistic::select()->where('user_id',$user_id)->where('match_type',$match_type)->get();

			$aces_count = '';
			$double_faults_count = '';

			$player_match_details = TennisPlayerMatchScore::selectRaw('sum(aces) as aces_count')->selectRaw('sum(double_faults) as double_faults_count')->where('user_id_a',$user_id)->groupBy('user_id_a')->get();

			if($match_type=='singles')
			{
				$aces_count = (!empty($player_match_details[0]['aces_count']))?$player_match_details[0]['aces_count']:'';
				$double_faults_count = (!empty($player_match_details[0]['double_faults_count']))?$player_match_details[0]['double_faults_count']:'';
			}

			if(count($tennisStatistics)>0)
			{
				$tennis_statistics_array = $tennisStatistics->toArray();
				$matches = !empty($tennis_statistics_array[0]['matches'])?$tennis_statistics_array[0]['matches']:0;
				$won = !empty($tennis_statistics_array[0]['won'])?$tennis_statistics_array[0]['won']:0;
				$lost = !empty($tennis_statistics_array[0]['lost'])?$tennis_statistics_array[0]['lost']:0;


				TennisStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['matches'=>$matches+1,'aces'=>$aces_count,'double_faults'=>$double_faults_count]);

				if($is_win=='yes') //win count
				{
					$won_percentage = number_format((($won+1)/($matches+1))*100,2);
					TennisStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['won'=>$won+1,'won_percentage'=>$won_percentage]);

				}else if($is_win=='no')//loss count
				{
					TennisStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['lost'=>$lost+1]);
				}

			}else
			{
				$won='';
				$won_percentage='';
				$lost='';
				if($is_win=='yes') //win count
				{
					$won = 1;
					$won_percentage = number_format(100,2);
				}else if($is_win=='no') //lost count
				{
					$lost=1;
				}
				$tennisStatisticsModel = new TennisStatistic();
				$tennisStatisticsModel->user_id = $user_id;
				$tennisStatisticsModel->match_type = $match_type;
				$tennisStatisticsModel->matches = 1;
				$tennisStatisticsModel->won_percentage = $won_percentage;
				$tennisStatisticsModel->won = $won;
				$tennisStatisticsModel->lost = $lost;
				$tennisStatisticsModel->aces = $aces_count;
				$tennisStatisticsModel->double_faults = $double_faults_count;
				$tennisStatisticsModel->save();
			}
		}

	}


	//function to get player names
	public function getplayers()
	{
		$player_a_ids = Request::get('player_a_ids');
		$team_a_playerids = explode(',',$player_a_ids);
		$a_team_players = User::select('id','name')->whereIn('id',$team_a_playerids)->get();

		if (count($a_team_players)>0)
			$players = $a_team_players->toArray();

		return Response::json(!empty($players) ? $players : []);
	}
	public function get_outas_enum()
	{
		$enum = config('constants.ENUM.SCORE_CARD.OUT_AS');
		return Response::json(!empty($enum ) ? $enum  : []);
	}
	//function to add players to team
	public function addPlayertoTeam()
	{
		$request = Request::all();
		$team_id = Request::get('team_id');
		$player_id = Request::get('response');
		$match_id = Request::get('match_id');
		$selected_team = Request::get('selected_team');

		if($team_id>0 && $player_id>0)
		{
			$role = 'player';
			$user_id = Request::get('response');
			$TeamPlayer = new TeamPlayers();
			$TeamPlayer->team_id = $team_id;
			$TeamPlayer->user_id = $player_id;
			$TeamPlayer->role = $role;
			if($TeamPlayer->save())
			{
				if($selected_team=='a')//if team a selected
				{
					$get_a_player_ids = MatchSchedule::where('id',$match_id)->where('a_id',$team_id)->pluck('player_a_ids');//get team a players
					$get_a_player_ids = $get_a_player_ids.$player_id.',';
					MatchSchedule::where('id',$match_id)->where('a_id',$team_id)->update(['player_a_ids'=>$get_a_player_ids]);
				}else
				{
					$get_b_player_ids = MatchSchedule::where('id',$match_id)->where('b_id',$team_id)->pluck('player_b_ids');//get team a players
					$get_b_player_ids = $get_b_player_ids.$player_id.',';
					MatchSchedule::where('id',$match_id)->where('b_id',$team_id)->update(['player_b_ids'=>$get_b_player_ids]);
				}

			}
			return Response()->json( array('success' => trans('message.sports.teamplayer')) );
		}else
		{
			return Response()->json( array('failure' => trans('message.sports.teamvalidation')) );
		}
	}


	//check is score enter for match
	public function isScoreEntered($user_id,$match_id,$team_id)
	{
		$request_array = SoccerPlayerMatchwiseStats::where('user_id',$user_id)->where('match_id',$match_id)->where('team_id',$team_id)->first();
		if(count($request_array)>0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	//function to view the score cards
	public function createScorecardView($match_id)
	{
		//get scheduled matches data data
		$match_data=array();
		$match_details = MatchSchedule::where('id',$match_id)->get();
		if(count($match_details)>0)
			$match_data = $match_details->toArray();
		if(!empty($match_data))
		{
			$sport_id = $match_data[0]['sports_id'];//get sport id
			$sportsDetails = Sport::where('id',$sport_id)->get()->toArray();//get sports details

			$tournamentDetails = [];
			if (!empty($match_data[0]['tournament_id']))
			{
				$tournamentDetails = Tournaments::where('id', '=', $match_data[0]['tournament_id'])->first();
			}

			if(!empty($sportsDetails))
			{
				$sport_name = $sportsDetails[0]['sports_name'];
				if(strtolower($sport_name)==strtolower('Tennis'))//if match is related to tennis
				{
					$tt = new ScoreCard\TennisScoreCardController;
					return $tt->tennisScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
					//return  $this->tennisOrTableTennisScoreCard($match_data,$match='Tennis',$sportsDetails,$tournamentDetails,$is_from_view=1);
				}else if(strtolower($sport_name)==strtolower('Table Tennis'))//if match is related to table tennis
				{
					//return $this->tennisOrTableTennisScoreCard($match_data,$match='Table Tennis',$sportsDetails,$tournamentDetails,$is_from_view=1);

					$tt = new ScoreCard\TabletennisScoreCardController;
					return $tt->tabletennisScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}else if(strtolower($sport_name)==strtolower('Cricket'))
				{
                    $tt = new ScoreCard\CricketScoreCardController;
					return $tt->cricketScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('soccer'))
				{
                    $tt = new ScoreCard\SoccerScoreCardController;
					return $tt->soccerScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('hockey'))
				{
					$hockey = new ScoreCard\HockeyScorecardController;
					return $hockey->soccerScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('badminton'))
				{
					$badminton = new ScoreCard\BadmintonScoreCardController;
					return $badminton->badmintonScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('squash'))
				{
					$squash = new ScoreCard\SquashScoreCardController;
					return $squash->squashScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('volleyball'))
				{
					$squash = new ScoreCard\VolleyballScoreCardController;
					return $squash->volleyballScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('throw ball'))
				{
					$squash = new ScoreCard\ThrowballScoreCardController;
					return $squash->throwballScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('kabaddi'))
				{
					$squash = new ScoreCard\KabaddiScoreCardController;
					return $squash->kabaddiScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('basketball'))
				{
					$squash = new ScoreCard\BasketballScoreCardController;
					return $squash->basketballScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}

				else if(strtolower($sport_name)==strtolower('Ultimate Frisbee'))
				{
						$hockey= new ScoreCard\UltimateFrisbeeScorecardController;
					return $hockey->ultimateFrisbeeScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('Water Polo'))
				{
						$hockey= new ScoreCard\WaterPoloScorecardController;
				  return $hockey->waterpoloScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}

				else if(strtolower($sport_name)==strtolower('archery'))
				{
					$archery = new ScoreCard\ArcheryController;
					return $archery->archeryScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
                else if(strtolower($sport_name)==strtolower('smite'))
                {
                    $smite = new Esports\SmiteController;
                    return $smite->smiteScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
                }
				
			}
		}
	}

	public function createScorecardpublicView($match_id)
	{
		//get scheduled matches data data
		$match_data=array();
		$match_details = MatchSchedule::where('id',$match_id)->get();
		if(count($match_details)>0)
			$match_data = $match_details->toArray();
		if(!empty($match_data))
		{
			$sport_id = $match_data[0]['sports_id'];//get sport id
			$sportsDetails = Sport::where('id',$sport_id)->get()->toArray();//get sports details

			$tournamentDetails = [];
			if (!empty($match_data[0]['tournament_id']))
			{
				$tournamentDetails = Tournaments::where('id', '=', $match_data[0]['tournament_id'])->first();
			}

			if(!empty($sportsDetails))
			{
				$sport_name = $sportsDetails[0]['sports_name'];
				if(strtolower($sport_name)==strtolower('Tennis'))//if match is related to tennis
				{
					//return  $this->tennisOrTableTennisScoreCard($match_data,$match='Tennis',$sportsDetails,$tournamentDetails,$is_from_view=1);
					$tt = new ScoreCard\TennisScoreCardController;
					return $tt->tennisScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}else if(strtolower($sport_name)==strtolower('Table Tennis'))//if match is related to table tennis
				{
					//return $this->tennisOrTableTennisScoreCard($match_data,$match='Table Tennis',$sportsDetails,$tournamentDetails,$is_from_view=1);

					$tt = new ScoreCard\TabletennisScoreCardController;
					return $tt->tabletennisScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}else if(strtolower($sport_name)==strtolower('Cricket'))
				{
                    $tt = new ScoreCard\CricketScoreCardController;
                    return $tt->cricketScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('soccer'))
				{
                    $tt = new ScoreCard\SoccerScoreCardController;
					return $tt->soccerScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}

				else if(strtolower($sport_name)==strtolower('hockey'))
				{
					$hockey = new ScoreCard\HockeyScorecardController;
					return $hockey->soccerScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('badminton'))
				{
					$badminton = new ScoreCard\BadmintonScoreCardController;
					return $badminton->badmintonScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('squash'))
				{
					$squash = new ScoreCard\SquashScoreCardController;
					return $squash->squashScoreCard($match_data,[],$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('volleyball'))
				{
					$squash = new ScoreCard\VolleyballScoreCardController;
					return $squash->volleyballScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('throw ball'))
				{
					$squash = new ScoreCard\ThrowballScoreCardController;
					return $squash->throwballScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('kabaddi'))
				{
					$squash = new ScoreCard\KabaddiScoreCardController;
					return $squash->kabaddiScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('basketball'))
				{
					$squash = new ScoreCard\BasketballScoreCardController;
					return $squash->basketballScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}

				else if(strtolower($sport_name)==strtolower('Ultimate Frisbee'))
				{
						$hockey= new ScoreCard\UltimateFrisbeeScorecardController;
					return $hockey->ultimateFrisbeeScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('Water Polo'))
				{
						$hockey= new ScoreCard\WaterPoloScorecardController;
				  return $hockey->waterpoloScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}

				else if(strtolower($sport_name)==strtolower('archery'))
				{
					$archery = new ScoreCard\ArcheryController;
					return $archery->archeryScoreCard($match_data,$sportsDetails,$tournamentDetails,$is_from_view=1);
				}
			}
		}
	}
	//function to update score card status
	public function scoreCardStatus()
	{
		$status = Request::get('scorecard_status');//status
		$match_id = Request::get('match_id');
		$rej_note = !empty(Request::get('rej_note'))?Request::get('rej_note'):'';
		$sport_name = !empty(Request::get('sport_name'))?Request::get('sport_name'):'';
		$loginUserId = Auth::user()->id;

		$loginUserName = Auth::user()->name;

		$matchDetails=MatchSchedule::find($match_id);
		$sportId=$matchDetails->sports_id;
		$sportDetails=Sport::find($sportId);
		$sportName=$sportDetails->name;

		//get previous scorecard status data
		$scorecardDetails = MatchSchedule::where('id',$match_id)->pluck('score_added_by');
		$decode_scorecard_data = json_decode($scorecardDetails,true);

		$modified_users = !empty($decode_scorecard_data['modified_users'])?$decode_scorecard_data['modified_users']:'';

		$modified_users = $modified_users.','.$loginUserId;//scorecard changed users

		$added_by = !empty($decode_scorecard_data['added_by'])?$decode_scorecard_data['added_by']:$loginUserId;

		$rejected_note = !empty($decode_scorecard_data['rejected_note'])?$decode_scorecard_data['rejected_note']:'';

		if($rej_note!='' && $status == 'rejected')
			$rejected_note = $rejected_note.'@'.$rej_note;

		//score card approval process
		$score_status = array('added_by'=>$added_by,'active_user'=>$loginUserId,'modified_users'=>$modified_users,'rejected_note'=>$rejected_note);

		$json_score_status = json_encode($score_status);

		//update winner id
		MatchSchedule::where('id',$match_id)->update(['scoring_status'=>$status,'score_added_by'=>$json_score_status]);

		//notifications

		//get teams
		$team_a_id = MatchSchedule::where('id',$match_id)->pluck('a_id');
		$team_b_id = MatchSchedule::where('id',$match_id)->pluck('b_id');


		//get team a manager,owner,captain
		$team_a_owner_id = AllRequests::getempidonroles($team_a_id,'owner');
		$team_a_manager_id = AllRequests::getempidonroles($team_a_id,'manager');
		$team_a_captain_id = AllRequests::getempidonroles($team_a_id,'captain');


		//get team b manager,owner,captain
		$team_b_owner_id = AllRequests::getempidonroles($team_b_id,'owner');
		$team_b_manager_id = AllRequests::getempidonroles($team_b_id,'manager');
		$team_b_captain_id = AllRequests::getempidonroles($team_b_id,'captain');

		$match_start_date = MatchSchedule::where('id',$match_id)->pluck('match_start_date');
		$sports_id = MatchSchedule::where('id',$match_id)->pluck('sports_id');
		$match_data=MatchSchedule::where('id', $match_id)->first();
		$sports_name = Sport::where('id',$sports_id)->pluck('sports_name');

		$scorecardDetails = htmlentities("<a href='".('REQURL|'.'/match/scorecard/edit'.'/'.$match_id)."'> scorecard </a>");
		$loginUserNameData = htmlentities("<a href='".('REQURL|'.'/editsportprofile'.'/'.$loginUserId)."'>$loginUserName</a>");
		//notification code
		$message='';
		if($status=='approval_pending')
		{
			//$message=  trans('message.scorecard.forapprovenotification') ;

			$message = $loginUserNameData.' has sent you a '.$scorecardDetails.' Approval request. <br/> Sport:'.$sports_name.' , Sheduled Date:'.$match_start_date;

		}elseif($status=='rejected')
		{
			//$message=  trans('message.scorecard.rejectnotification') ;
			$message = 'Your '.$scorecardDetails.' has been rejected by '.$loginUserNameData.'. <br/>Sport:'.$sports_name.' , Sheduled Date:'.$match_start_date;
		}

		//if status is approved update match status as completed
		if($status == 'approved')
		{
			MatchSchedule::where('id',$match_id)->update(['match_status'=>'completed']);

			//$message=  trans('message.scorecard.approvenotification') ;
			$message = 'Your '.$scorecardDetails.' has been approved by '.$loginUserNameData.'. <br/>Sport:'.$sports_name.' , Sheduled Date:'.$match_start_date;

			
			//if no result, discard all data;

			// if($match_data->has_result==0){
			// 	$match_data->match_details=null;
			// 	$match_data->save();

			// 	if($sport_name=='Badminton'){
			// 		$players_stats=BadmintonPlayerMatchScore::whereMatchId($match_id)->get();
			// 		$this->discardMatchRecords($players_stats);
			// 	}
			// 	if($sport_name=='Squash'){
			// 		$players_stats=SquashPlayerMatchScore::whereMatchId($match_id)->get();
			// 		$this->discardMatchRecords($players_stats);
			// 	}
			// 	if($sport_name=='Hockey'){
			// 		$players_stats=	HockeyPlayerMatchwiseStat::whereMatchId($match_id)->get();
			// 		$this->discardMatchRecords($player_stats);
			// 	}
			// 	if($sport_name=='Soccer'){
			// 		$players_stats=	SoccerPlayerMatchwiseStat::whereMatchId($match_id)->get();
			// 		$this->discardMatchRecords($players_stats);
			// 	}
			// }

			// call function to insert player wise match details in statistics table
			if($sport_name!='')
				$this->insertPlayerStatistics($sport_name,$match_id);

			//send notification to players
			Helper::sendEmailPlayers($matchDetails, $sportName);	
		}
		//notification code
		$url= '';//url('match/scorecard/edit/'.$match_id) ;


		$schedule_type = MatchSchedule::where('id',$match_id)->pluck('schedule_type');

		if($schedule_type=='team') //IF schedule type is team
		{
			if($team_a_owner_id==$loginUserId || $team_a_manager_id==$loginUserId || $team_a_captain_id==$loginUserId)
			{
				if(!empty($team_b_owner_id)) //condition added if two team owneres are same
				{
					//if($loginUserId!=$team_b_owner_id)
					AllRequests::sendnotifications($team_b_owner_id,$message,$url);	//notification for owner
				}
				if(!empty($team_b_manager_id))
				{
					//if($loginUserId!=$team_b_manager_id)
					AllRequests::sendnotifications($team_b_manager_id,$message,$url);	//notification for manager
				}
				if(!empty($team_b_captain_id))
				{
					//if($loginUserId!=$team_b_captain_id)
					AllRequests::sendnotifications($team_b_captain_id,$message,$url);	//notification for captain
				}
			}else
			{
				if(!empty($team_a_owner_id)) //condition added if two team owneres are same
				{
					//if($loginUserId!=$team_a_owner_id)
					AllRequests::sendnotifications($team_a_owner_id,$message,$url);	//notification for owner
				}
				if(!empty($team_a_manager_id))
				{
					//if($loginUserId!=$team_a_manager_id)
					AllRequests::sendnotifications($team_a_manager_id,$message,$url);	//notification for manager
				}
				if(!empty($team_a_captain_id))
				{
					//if($loginUserId!=$team_a_captain_id)
					AllRequests::sendnotifications($team_a_captain_id,$message,$url); //notification for captain
				}
			}
		}else //if schedule type is player send notification to other user
		{
			if($team_a_id==$loginUserId)
				$user_id = $team_b_id;
			else
				$user_id = $team_a_id;
			AllRequests::sendnotifications($user_id,$message,$url);	//notification for owner
		}

		//return Response::json($results);
		return Response()->json( array('status' => 'success','msg' => trans('message.scorecard.scorecardstatus')) );
	}

	//function to call sport statistics
	public function insertPlayerStatistics($sport_name,$match_id)
	{
		$match_data = MatchSchedule::where('id',$match_id)->get(['winner_id','match_type','match_details','tournament_id','tournament_group_id','a_id','b_id','is_tied', 'match_result']);
		$match_type = !empty($match_data[0]['match_type'])?$match_data[0]['match_type']:'';
		$match_details = !empty($match_data[0]['match_details'])?$match_data[0]['match_details']:'';
		$winner_id = !empty($match_data[0]['winner_id'])?$match_data[0]['winner_id']:'';
		$decoded_match_details = array();
		if($match_details!='')
			$decoded_match_details = json_decode($match_details,true);
		//tennis or table tennis statistics
		if($sport_name=='Tennis' || $sport_name=='Table Tennis')
		{
			if(count($decoded_match_details)>0)
			{
				foreach($decoded_match_details as $key => $players)
				{
					$is_win='no';
					if($winner_id==$key)
					{
						$is_win = 'yes';
					}
					if($sport_name=='Tennis'){
						//$this->tennisStatistics($players,$match_type,$is_win);
					}
					else if($sport_name=='Table Tennis'){
						//$this->tableTennisStatistics($players,$match_type,$is_win);
					}
				}
			}

		}else if($sport_name=='Soccer')//soccer statistics Soccer
		{
			$soccer_details = SoccerPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
			if(!empty($soccer_details) && count($soccer_details)>0)
			{
				foreach($soccer_details as $user_id)
				{
					SoccerStatistic::updateUserStatistic($user_id['user_id']);
				}

			}

		}

		else if($sport_name=='Hockey')//soccer statistics Soccer
		{
			$soccer_details = HockeyPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
			if(!empty($soccer_details) && count($soccer_details)>0)
			{
				foreach($soccer_details as $user_id)
				{
                    HockeyStatistic::updateUserStatistic($user_id['user_id']);
				}

			}

		}

		else if($sport_name=='BasketBall')//basketball statistics 
		{
			$basketball_details = BasketballPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
			if(!empty($basketball_details) && count($basketball_details)>0)
			{
				foreach($basketball_details as $user_id)
				{
					BasketballStatistic::updateUserStatistic($user_id['user_id']);
				}

			}

		}

		// else if($sport_name=='Water Polo')//basketball statistics 
		// {
		// 	$basketball_details = BasketballPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
		// 	if(!empty($basketball_details) && count($basketball_details)>0)
		// 	{
		// 		foreach($basketball_details as $user_id)
		// 		{
		// 			$this->waterpoloStatistics($user_id['user_id']);
		// 		}

		// 	}

		// }

		// else if($sport_name=='Kabaddi')//kabaddi statistics 
		// {
		// 	$basketball_details = BasketballPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
		// 	if(!empty($basketball_details) && count($basketball_details)>0)
		// 	{
		// 		foreach($basketball_details as $user_id)
		// 		{
		// 			$this->kabaddiStatistics($user_id['user_id']);
		// 		}

		// 	}

		// }

		// else if($sport_name=='Volleyball')//volleyball statistics 
		// {
		// 	$basketball_details = BasketballPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
		// 	if(!empty($basketball_details) && count($basketball_details)>0)
		// 	{
		// 		foreach($basketball_details as $user_id)
		// 		{
		// 			$this->volleyballStatistics($user_id['user_id']);
		// 		}

		// 	}

		// }

		// else if($sport_name=='Ultimate Frisbee')//volleyball statistics 
		// {
		// 	$basketball_details = BasketballPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
		// 	if(!empty($basketball_details) && count($basketball_details)>0)
		// 	{
		// 		foreach($basketball_details as $user_id)
		// 		{
		// 			$this->volleyballStatistics($user_id['user_id']);
		// 		}

		// 	}

		// }


		else if($sport_name=='Cricket')//cricket statistics
		{
			$cricket_details = CricketPlayerMatchwiseStats::where('match_id',$match_id)->where('match_type',$match_type)->where('innings','first')->get(['user_id']);
			if(!empty($cricket_details) && count($cricket_details)>0)
			{
				foreach($cricket_details as $players)
				{
					CricketStatistic::cricketBatsmenStatistic($players['user_id'],$match_type,$inning='first');//batsmen statistics
                    CricketStatistic::cricketBowlerStatistic($players['user_id'],$match_type,$inning='first');//bowler statistics
				}

			}

			if($match_type=='test')//for test match
			{
				$cricket_second_ing_details = CricketPlayerMatchwiseStats::where('match_id',$match_id)->where('match_type',$match_type)->where('innings','second')->get(['user_id']);
				if(!empty($cricket_second_ing_details) && count($cricket_second_ing_details)>0)
				{
					foreach($cricket_second_ing_details as $users)
					{
                        CricketStatistic::cricketBatsmenStatistic($users['user_id'],$match_type,$inning='second');//batsmen statistics
                        CricketStatistic::cricketBowlerStatistic($users['user_id'],$match_type,$inning='second');//bowler statistics
					}

				}

			}

		}

		//if match is scheduled from tournament
		if($match_data[0]['tournament_id']!='' && $match_data[0]['tournament_group_id']!='')
		{
			$team_a_id = $match_data[0]['a_id'];
			$team_b_id = $match_data[0]['b_id'];

			$tournamentDetails = Tournaments::where('id',$match_data[0]['tournament_id'])->get(['points_win','points_loose', 'points_tie']);
			$tournament_won_poins = !empty($tournamentDetails[0]['points_win'])?$tournamentDetails[0]['points_win']:0;
			$tournament_lost_poins = !empty($tournamentDetails[0]['points_loose'])?$tournamentDetails[0]['points_loose']:0;
			$tournament_tie_poins = !empty($tournamentDetails[0]['points_tie'])?$tournamentDetails[0]['points_tie']:0;


			$team_a_groupdetails = TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_a_id)->get(['won','lost','points']);

			$team_b_groupdetails = TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_b_id)->get(['won','lost','points']);

			$team_a_won_count = !empty($team_a_groupdetails[0]['won'])?$team_a_groupdetails[0]['won']:0;
			$team_a_lost_count = !empty($team_a_groupdetails[0]['lost'])?$team_a_groupdetails[0]['lost']:0;
			$team_a_points = !empty($team_a_groupdetails[0]['points'])?$team_a_groupdetails[0]['points']:0;

			$team_b_won_count = !empty($team_b_groupdetails[0]['won'])?$team_b_groupdetails[0]['won']:0;
			$team_b_lost_count = !empty($team_b_groupdetails[0]['lost'])?$team_b_groupdetails[0]['lost']:0;
			$team_b_points = !empty($team_b_groupdetails[0]['points'])?$team_b_groupdetails[0]['points']:0;

			//if winner id exists
			if($winner_id!='')
			{
				//if team a wons
				if($team_a_id==$winner_id)
				{
					TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_a_id)->update(['won'=>$team_a_won_count+1,'points'=>$team_a_points+$tournament_won_poins]);
				}else
				{
					TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_a_id)->update(['lost'=>$team_a_lost_count+1,'points'=>$team_a_points+$tournament_lost_poins]);
				}

				//if team b wons
				if($team_b_id==$winner_id)
				{
					TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_b_id)->update(['won'=>$team_b_won_count+1,'points'=>$team_b_points+$tournament_won_poins]);
				}else
				{
					TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_b_id)->update(['lost'=>$team_b_lost_count+1,'points'=>$team_b_points+$tournament_lost_poins]);
				}

			}
			else if ($match_data[0]['is_tied'] > 0 || $match_data[0]['match_result'] == "washout")//if match is tied/washout
			{
				TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_a_id)->update(['points'=>$team_a_points+$tournament_tie_poins]);

				TournamentGroupTeams::where('tournament_id',$match_data[0]['tournament_id'])->where('tournament_group_id',$match_data[0]['tournament_group_id'])->where('team_id',$team_b_id)->update(['points'=>$team_b_points+$tournament_tie_poins]);

			}



			//update organization points;
	
		if(!is_null($match_data[0]['tournament_id'])){
				Helper::updateOrganizationTeamsPoints($match_data[0]['tournament_id']);
		} 

		}

		

	}

	function updateBracketDetails($matchScheduleDetails,$tournamentDetails,$winner_team_id) {
//            dd($matchScheduleDetails);
		$roundNumber = $matchScheduleDetails['tournament_round_number'];
		$matchNumber = $matchScheduleDetails['tournament_match_number'];
		$matchNumberToCheck = ceil($matchNumber / 2);
		$matchScheduleData = MatchSchedule::where('tournament_id',$matchScheduleDetails['tournament_id'])
			->where('tournament_round_number',$roundNumber+1)
			->where('tournament_match_number',$matchNumberToCheck)
			->first();
		if(count($matchScheduleData)) {
			if ($matchScheduleData['schedule_type'] == 'team') {
				$player_b_ids = TeamPlayers::select(DB::raw('GROUP_CONCAT(DISTINCT user_id) AS player_a_ids'))->where('team_id', $winner_team_id)->pluck('player_a_ids');
			}else {
				$player_b_ids = $winner_team_id;
			}


			 if(!empty($matchScheduleData->a_id)){
                    MatchSchedule::where('id',$matchScheduleData['id'])->update(['b_id'=>$winner_team_id,'player_b_ids'=>!empty($player_b_ids)?(','.trim($player_b_ids).','):NULL]);
                   }
              else{
                      MatchSchedule::where('id',$matchScheduleData['id'])->update(['a_id'=>$winner_team_id,'player_a_ids'=>!empty($player_b_ids)?(','.trim($player_b_ids).','):NULL]);
                   }			

		}else{
			if ($matchScheduleData['schedule_type'] == 'team') {
				$player_a_ids = TeamPlayers::select(DB::raw('GROUP_CONCAT(DISTINCT user_id) AS player_a_ids'))->where('team_id', $winner_team_id)->pluck('player_a_ids');
			}else {
				$player_a_ids = $winner_team_id;
			}
			$scheduleArray = [
				'tournament_id' => $matchScheduleDetails['tournament_id'],
				'tournament_round_number' => $roundNumber+1,
				'tournament_match_number' => $matchNumberToCheck,
				'sports_id' => $matchScheduleDetails['sports_id'],
				'facility_id' => $matchScheduleDetails['facility_id'],
				'facility_name' => $matchScheduleDetails['facility_name'],
				'created_by' => $matchScheduleDetails['created_by'],
				'match_category' => $matchScheduleDetails['match_category'],
				'schedule_type' => $matchScheduleDetails['schedule_type'],
				'match_type' => $matchScheduleDetails['match_type'],
				'match_location' => $matchScheduleDetails['match_location'],
				'city_id' => $matchScheduleDetails['city_id'],
				'city' => $matchScheduleDetails['city'],
				'state_id' => $matchScheduleDetails['state_id'],
				'state' => $matchScheduleDetails['state'],
				'country_id' => $matchScheduleDetails['country_id'],
				'country' => $matchScheduleDetails['country'],
				'zip' => $matchScheduleDetails['zip'],
				'match_status' => 'scheduled',
				'a_id' => $winner_team_id,
				'game_type' => $matchScheduleDetails['game_type'],
				'number_of_rubber' => $matchScheduleDetails['number_of_rubber'],
				'player_a_ids' => !empty($player_a_ids)?(','.trim($player_a_ids).','):NULL,
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now()
			];

			if(!$matchScheduleDetails['is_third_position']){
				$matchSchedule = MatchSchedule::create($scheduleArray);
			}

			// Update the winner Id of the for the winner team.
			$maxRoundNumber = MatchSchedule::
			where('tournament_id', $matchScheduleDetails['tournament_id'])->whereNull('tournament_group_id')
				->orderBy('tournament_round_number')
				->max('tournament_round_number');
			$tournamentDetails = Tournaments::where('id',$matchScheduleDetails['tournament_id'])->first(['final_stage_teams']);
			if(count($tournamentDetails)) {
				$lastRoundWinner = intval(ceil(log($tournamentDetails['final_stage_teams'], 2)));
			}
			if(count($maxRoundNumber) && !empty($lastRoundWinner)) {
				if($maxRoundNumber==$lastRoundWinner+1){
					if(!empty($matchSchedule) && $matchSchedule['id']>0) {
						MatchSchedule::where('id',$matchSchedule['id'])->update([
							'match_status'=>'completed',
							'winner_id'=>$winner_team_id
						]);

					}
				}
			}
		}


	}
	public function scorecardGallery($id)
	{
		return view('scorecards.gallery')->with(array('action_id'=>$id));
	}
	public function checkScoreEnterd($match_id)
	{
		$isvalid = 1;
		$loginUserId = Auth::user()->id;
		$match_details = MatchSchedule::where('id',$match_id)->get(['score_added_by']);
		$score_added_by = !empty($match_details[0]['score_added_by'])?$match_details[0]['score_added_by']:'';
		$decode_scorecard_data = array();
		if($score_added_by!='')
		{
			$decode_scorecard_data = json_decode($score_added_by,true);
			$added_by = $decode_scorecard_data['added_by'];
			if($added_by!=$loginUserId)
			{
				$isvalid = 0;
			}

		}
		return $isvalid;
	}
	public function scoreAddedByUserName($match_id)
	{
		$user_name='';
		$added_by=0;
		$match_details = MatchSchedule::where('id',$match_id)->get(['score_added_by']);
		$score_added_by = !empty($match_details[0]['score_added_by'])?$match_details[0]['score_added_by']:'';
		if($score_added_by!='')
		{
			$decode_scorecard_data = json_decode($score_added_by,true);
			$added_by = $decode_scorecard_data['added_by'];
			$user_name = User::where('id',$added_by)->pluck('name');
		}
		if($user_name!='' && $added_by>0)
		{
			return "<a href='".('/editsportprofile'.'/'.$added_by)."'> ".$user_name." </a>";
		}
		return $user_name;
	}


	//new controllers for soccer

	public function confirmSquad(){
		$request=Request::all();
		$match_id 		=$request['match_id'];

		$tournament_id 	=isset($request['tournament_id'])?$request['tournament_id']:null;
		$team_a_id 		=$request['team_a_id'];
		$team_b_id 		=$request['team_b_id'];

		$match_model=MatchSchedule::find($match_id);
		$match_model->hasSetupSquad=1;
		$match_model->save();

		$team_a_name=$request['team_a_name'];
		$team_b_name=$request['team_b_name'];
		$team_a_playing_players=isset($request['team_a']['playing'])?$request['team_a']['playing']:[];
		$team_b_playing_players=isset($request['team_b']['playing'])?$request['team_b']['playing']:[];

		$team_a_substitute_players=isset($request['team_a']['substitute'])?$request['team_a']['substitute']:[];
		$team_b_substitute_players=isset($request['team_b']['substitute'])?$request['team_b']['substitute']:[];

		foreach($team_a_playing_players as $p){
			$player_name=User::find($p)->name;
            SoccerPlayerMatchwiseStats::insertSoccerScore($p, $tournament_id, $match_id, $team_a_id,$player_name, $team_a_name,0,0,0,'P');
		}
		foreach($team_a_substitute_players as $p){
			$player_name=User::find($p)->name;
            SoccerPlayerMatchwiseStats::insertSoccerScore($p, $tournament_id, $match_id, $team_a_id,$player_name, $team_a_name,0,0,0,'S');
				
		}
		foreach($team_b_playing_players as $p){
			$player_name=User::find($p)->name;
            SoccerPlayerMatchwiseStats::insertSoccerScore($p, $tournament_id, $match_id, $team_b_id,$player_name, $team_b_name,0,0,0,'P');
		}
		foreach($team_b_substitute_players as $p){			
			$player_name=User::find($p)->name;
            SoccerPlayerMatchwiseStats::insertSoccerScore($p, $tournament_id, $match_id, $team_b_id,$player_name, $team_b_name,0,0,0,'S');
				
		}
		

		$match_model=MatchSchedule::find($match_id);
		$match_details=[
			"team_a"=>[
				"id"=>$team_a_id,
				"name"=>$team_a_name
					],
            "team_b"=>[
            	"id"=>$team_b_id,
            	"name"=>$team_b_name
            		],
			"{$team_a_id}"	=>	[
				"id"=>$team_a_id,
				"goals"=>0,
				"red_card_count"=>0,
				"yellow_card_count"=>0,
				"ball_percentage"=>0],
			"{$team_b_id}"=>[
				"id"=>$team_b_id,
				"goals"=>0,
				"red_card_count"=>0,
				"yellow_card_count"=>0,
				"ball_percentage"=>0],
			"first_half"=>[
				"goals"=>0,
				"team_{$team_a_id}_goals"=>0,
				"team_{$team_b_id}_goals"=>0,
				"team_{$team_a_id}_yellow_card_count"=>0,
				"team_{$team_b_id}_yellow_card_count"=>0,
				"team_{$team_a_id}_red_card_count"=>0,
				"team_{$team_b_id}_red_card_count"=>0,
				"red_card_count"=>0,
				"yellow_card_count"=>0,
				"goals_details"=>[],
				"red_card_details"=>[],
				"yellow_card_details"=>[]
			],
			"second_half"=>[
				"goals"=>0,
				"team_{$team_a_id}_goals"=>0,
				"team_{$team_b_id}_goals"=>0,
				"team_{$team_a_id}_yellow_card_count"=>0,
				"team_{$team_b_id}_yellow_card_count"=>0,
				"team_{$team_a_id}_red_card_count"=>0,
				"team_{$team_b_id}_red_card_count"=>0,
				"red_card_count"=>0,
				"yellow_card_count"=>0,
				"goals_details"=>[],
				"red_card_details"=>[],
				"yellow_card_details"=>[]
			],
			"penalties"=>[
				'score'=>'',
				'team_a'=>[
					'players'=>[],
					'goals'=>0,
					'players_ids'=>[]
				],
				'team_b'=>[
					'players'=>[],
					'goals'=>0,
					'players_ids'=>[]
				]
			]
		];

		$match_model->match_details=json_encode($match_details);
		$match_model->save();
		Helper::start_match_email($match_model);
	}




	/**
	 * Select penalties players
	 *
	 * @param  Request players
	 * @return Response
	 */

	public function choosePenaltyPlayers(){
		$request=Request::all();
		$index_a=$request['p_index_a'];
		$index_b=$request['p_index_b'];
		$team_a_id=$request['team_a_id'];
		$team_b_id=$request['team_b_id'];
		$match_id=$request['match_id'];

		$match_model=matchSchedule::find($match_id);
		$match_details=json_decode($match_model['match_details'],true);

if(!isset($match_details['penalties']['team_a']['players_ids']))$match_details['penalties']['team_a']['players_ids']=[];
if(!isset($match_details['penalties']['team_b']['players_ids']))$match_details['penalties']['team_b']['players_ids']=[];

		$penalties=$match_details['penalties'];			

		$response_a="";
		$response_b="";
		for($i=0; $i<$index_a; $i++){

		  if(isset($request['penalty_player_a_'.$i]) && $request['penalty_player_a_'.$i]=='on' ){

			 if(!in_array($request['penalty_player_user_id_a_'.$i], $penalties['team_a']['players_ids'])){
				$penalties['team_a']['players_ids'][$i]=$request['penalty_player_user_id_a_'.$i];
				
				$player_id=$request['penalty_player_id_a_'.$i];
				$matchwise_model=SoccerPlayerMatchwiseStats::find($player_id);
				$matchwise_model->penalty=1;
				$matchwise_model->save();
				$player=[
					'name'=>$request['penalty_player_name_a_'.$i],
					'stat_id'=>$request['penalty_player_id_a_'.$i],
					'goal'=>'',
					'user_id'=>$request['penalty_player_user_id_a_'.$i],
				];
				$penalties['team_a']['players'][$i]=$player;

				$response_a.="
	  					<tr>
	  					<td colspan=2>{$player['name']}</td><td> 
	  					0 <button class='btn-red-card btn-card btn-circle btn-penalty btn_team_a_$i' value='0' name='penalty_goal_a_$i' index='$i' team_id='$team_a_id' team_type='team_a' onclick='return scorePenalty(this)' > </button> 
	  					1 <button class='btn-green-card btn-card btn-circle btn-penalty btn_team_a_$i' value='1' name='penalty_goal_a_$i' index='$i' team_id='$team_a_id' team_type='team_a' onclick='return scorePenalty(this)' >  
	  					<input type='hidden' name='penalty_goal_player_a_$i' value='$player_id' > </button>
	  					<tr>
	  				";
				}
			}
		}

		for($i=0; $i<$index_b; $i++){
			if(isset($request['penalty_player_b_'.$i]) && $request['penalty_player_b_'.$i]=='on'){
			 if(!in_array($request['penalty_player_user_id_b_'.$i], $penalties['team_b']['players_ids'])){

				$penalties['team_b']['players_ids'][$i]= $request['penalty_player_user_id_b_'.$i];
				
				$player_id=$request['penalty_player_id_b_'.$i];
				$matchwise_model=SoccerPlayerMatchwiseStats::find($player_id);
				$matchwise_model->penalty=1;
				$matchwise_model->save();
				$player=[
					'name'=>$request['penalty_player_name_b_'.$i],
					'stat_id'=>$request['penalty_player_id_b_'.$i],
					'goal'=>'',
					'user_id'=>$request['penalty_player_user_id_b_'.$i],
				];
				$penalties['team_b']['players'][$i]= $player;

				$response_b.="
	  					<tr>
	  					<td colspan=2>{$player['name']}</td><td> 
	  					0 <button class='btn-red-card btn-card btn-circle btn-penalty btn_team_b_$i'  value='0' name='penalty_goal_b_$i' index='$i' team_type='team_b'  team_id='$team_b_id' onclick='return scorePenalty(this)'> </button>
	  					1 <button class='btn-green-card btn-card btn-circle btn-penalty btn_team_b_$i'  value='1'  name='penalty_goal_b_$i' index='$i' team_id='$team_b_id' team_type='team_b'  onclick='return scorePenalty(this)'> </button> 
	  					<input type='hidden' name='penalty_goal_player_b_$i' value='$player_id'>
	  					<tr>
	  				";
	  			}
			}
		}

		$match_details['penalties']=$penalties;
		

		$match_model['match_details']=json_encode($match_details);
		$match_model->save();
		$response_a.="<input type='hidden' value='$index_a' name='penalty_goal_index_a'>";
		$response_b.="<input type='hidden' value='$index_b' name='penalty_goal_index_b'><input type='hidden' name='set_penalty'>";


		return [
			"message"=>"Players have been Chosen Succesffuly!",
			"response_a"=>$response_a,
			"response_b"=>$response_b
		];

	}

	public function scorePenalty(){
			$request=Request::all();
			$match_id=$request['match_id'];
			$team_type=$request['team_type'];
			$index=$request['index'];
			$value=$request['value'];

			$match_model=MatchSchedule::find($match_id);
			$match_details=json_decode($match_model->match_details, true);

			$match_details['penalties'][$team_type]['players'][$index]['goal']=$value;

			$team_a_penalty_goals=0;
			$team_b_penalty_goals=0;

			foreach ($match_details['penalties'][$team_type]['players'] as $key => $value) {
					${$team_type.'_penalty_goals'}+=$value['goal'];					
			}

			$match_details['penalties'][$team_type]['goals']=${$team_type.'_penalty_goals'};
			$match_details=json_encode($match_details);
			$match_model->match_details=$match_details;
			$match_model->save();
			return $match_details;
	}

//discard match details
	public function discardMatchRecords($players_stats){
			foreach ($players_stats as $ps) {
				//$ps->delete();
			}
	}


//get the active rubber
	public function getActiveRubber($match_id){
	$match_model=MatchSchedule::find($match_id);

		if(Session::has('rubberInfo')){
			return Session::get('rubberInfo');
		}
			
	$active_rubber=MatchScheduleRubber::whereMatchId($match_id)->orderBy('id', 'asc')->where('match_status', '=', 'scheduled')->first();
		return $active_rubber;
	}

//set active rubber
	public function setActiveRubber($rubber_id){
		$active_rubber=MatchScheduleRubber::find($rubber_id);		
		Session(['rubberInfo'=>$active_rubber]);
	}

//deselect rubber
	public function destroyRubberFromSession(){
		Session::remove('rubberInfo');
	}

	public function updatehalftime($match_id, $half_time){
		$match_model = MatchSchedule::find($match_id);
		$match_model->selected_half_or_quarter = explode('_', $half_time)[1];
		$match_model->save();		
	}

	public function allow_match_edit_by_admin(){
		$request=Request::all();
		$match_id=$request['match_id'];
		$match_data=matchSchedule::whereId($match_id)->get();

		if(Auth::check() && Helper::isValidUserForScoreEnter($match_data)){

			Session(['is_allowed_to_edit_match'=>$match_data]);
				return [
					'status'=>'ok'
				];
		}
		else {
			return [
					'status'=>'error'
				];
		}
	}

	public function deny_match_edit_by_admin(){
			Session::remove('is_allowed_to_edit_match');
	}



}
?>
