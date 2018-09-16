<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\MatchSchedule;
use App\Model\UserStatistic;
use App\Model\State;
use App\Model\City;
use App\Model\Team;
use App\Model\TeamPlayers;
use App\Model\Sport;
use App\Model\Facilityprofile;
use App\Model\Country;
use App\Model\Photo;
use App\Model\Tournaments;
use App\Model\TennisPlayerMatchScore;
use App\Model\TtPlayerMatchScore;
use App\Model\CricketStatistic;
use App\Model\TennisStatistic;
use App\Model\TtStatistic;
use App\Model\CricketPlayerMatchwiseStats;
use App\Model\SoccerPlayerMatchwiseStats;
use App\Model\SoccerStatistic;
use App\User;
use DB;
use Request;
use Carbon\Carbon;
use Response;
use Auth;
use App\Helpers\Helper;
use DateTime;
class ScoreCardController extends Controller {
	 /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display all the sports configured for the user.
     * User can follow sports. If already followed then the user will be redirected to edit function
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the sports profile.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
	public function scheduledMatches()
	{
		 $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
		        $selectedSport = '';
        $request = Request::all();
        // $sports = Sport::orderBy('id')->lists('sports_name', 'id')->all();
		$sports = Helper::getDevelopedSport(1,1);
        if (count($request)) {
            $selectedSport = $request['sportsId'];
        }
		return view('admin.schedules.showschedules',['selectedSport' => $selectedSport,'currentMonth' => $currentMonth, 'currentYear' => $currentYear,'sportArray' => ['' => 'All'] + $sports]);
	}
	public function getListViewEvents() {
        $month = Request::get('month');
        $year = Request::get('year');
        $sportsId = Request::get('sportsId');
        $limit = config('constants.LIMIT');
        $offset = 0;
		if($sportsId=='') // if no sport selected
		{
			 //$sportsIdsArray = Sport::orderBy('id')->lists('id')->all();
			$sportsIdsArray = Sport::where('is_schedule_available',1)->where('is_scorecard_available',1)->lists('id')->all();
			//$sportsIdsArray = Helper::getDevelopedSport(1,1);
		}	
		else  // if sport selected
			$sportsIdsArray = explode(',',$sportsId);

        //Converting the month integer to month name
        $monthName = Carbon::createFromFormat('m', $month)->format('F');
        //Getting the first and last day of the month
        $firstDay = new Carbon('first day of ' . $monthName . ' ' . $year . '');
        $lastDay = new Carbon('last day of ' . $monthName . ' ' . $year . '');
		
		$now = Carbon::now();
		$cur_year = $now->year;
		$cur_month = $now->month;
		//if curtrent month schedules searching
		if($month==$cur_month && $cur_year==$year)
		{
			$lastDay = Carbon::now();
		}
        // Converting the date to db format
        $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $firstDay)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastDay)->format('Y-m-d');
		
		$toDaysDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('Y-m-d');
		
		
		$teamIds = '';
        $playerIds = '';
        $teamLogoArray = [];
        $playerLogoArray = [];
        $teamNameArray = [];
        $playerNameArray = [];

        $matchScheduleData = MatchSchedule::with(array('sport' => function($q3) {
                $q3->select('id','sports_name');
            },))
				->whereIn('sports_id', $sportsIdsArray)
                ->whereBetween('match_start_date', [$fromDate, $toDate])
				//->where('match_start_date','!=',$toDaysDate)
				->where('match_invite_status','=','accepted')
                ->orderby('match_start_date', 'desc')
				->orderby('match_start_time', 'desc')
                ->limit($limit)->offset($offset)
                ->get(['id', 'match_start_date', 'winner_id', 'a_id', 'b_id', 'match_invite_status','match_status','schedule_type','score_added_by','match_type','sports_id','match_start_time']);

        $matchScheduleDataTotalCount = MatchSchedule::whereIn('sports_id', $sportsIdsArray)->whereBetween('match_start_date', [$fromDate, $toDate])->where('match_start_date','!=',$toDaysDate)->where('match_invite_status','=','accepted')->count();
		
		if (count($matchScheduleData)) {
            $matchScheduleData = $matchScheduleData->toArray();
            foreach ($matchScheduleData as $key => $schedule) {
                $matchScheduleData[$key]['a_logo'] = '';
                $matchScheduleData[$key]['b_logo'] = '';
                $matchScheduleData[$key]['a_name'] = '';
                $matchScheduleData[$key]['b_name'] = '';
                if ($schedule['schedule_type'] == 'team') {
                    $teamIds.=$schedule['a_id'] . ',' . $schedule['b_id'] . ',';
                } else {
                    $playerIds.=$schedule['a_id'] . ',' . $schedule['b_id'] . ',';
                }
            }
        }
		 if (!empty($teamIds)) {
            $teamIdArray = explode(',', rtrim($teamIds, ','));
            $teamLogos = Photo::whereIn('imageable_id', $teamIdArray)
                    ->where('imageable_type', config('constants.PHOTO.TEAM_PHOTO'))
                    ->where('is_album_cover', 1)
                    ->get(['url', 'imageable_id']);
            $teamNames = Team::whereIn('id', $teamIdArray)->get(['id', 'team_owner_id', 'sports_id', 'name']);

            if (count($teamLogos)) {
                foreach ($teamLogos->toArray() as $teamkey => $teamLogo) {
                    $teamLogoArray[$teamLogo['imageable_id']] = $teamLogo['url'];
                }
            }

            if (count($teamNames)) {
                foreach ($teamNames as $teamName) {
                    $teamNameArray[$teamName['id']] = $teamName['name'];
                }
            }
        }

        if (!empty($playerIds)) {
            $playerIdArray = explode(',', rtrim($playerIds, ','));
            $playerLogos = Photo::whereIn('user_id', $playerIdArray)
                    ->where('imageable_type', config('constants.PHOTO.USER_PHOTO'))
                    ->where('is_album_cover', 1)
                    ->get(['url', 'imageable_id', 'user_id']);

            $playerNames = User::whereIn('id', $playerIdArray)->get(['id', 'name']);

            if (count($playerLogos)) {
                foreach ($playerLogos->toArray() as $playerLogo) {
                    $playerLogoArray[$playerLogo['user_id']] = $playerLogo['url'];
                }
            }

            if (count($playerNames)) {
                foreach ($playerNames as $playerName) {
                    $playerNameArray[$playerName['id']] = $playerName['name'];
                }
            }
        }

		 if (!empty($matchScheduleData)) {
            foreach ($matchScheduleData as $key => $schedule) {
                if ($schedule['schedule_type'] == 'team') {
                    if (!empty($teamLogoArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $teamLogoArray)) {
                            $matchScheduleData[$key]['a_logo'] = $teamLogoArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $teamLogoArray)) {
                            $matchScheduleData[$key]['b_logo'] = $teamLogoArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                    if (!empty($teamNameArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $teamNameArray)) {
                            $matchScheduleData[$key]['a_name'] = $teamNameArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $teamNameArray)) {
                            $matchScheduleData[$key]['b_name'] = $teamNameArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                } else {
                    if (!empty($playerLogoArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $playerLogoArray)) {
                            $matchScheduleData[$key]['a_logo'] = $playerLogoArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $playerLogoArray)) {
                            $matchScheduleData[$key]['b_logo'] = $playerLogoArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                    if (!empty($playerNameArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $playerNameArray)) {
                            $matchScheduleData[$key]['a_name'] = $playerNameArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $playerNameArray)) {
                            $matchScheduleData[$key]['b_name'] = $playerNameArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                }
				
				 $matchStartDate = Carbon::createFromFormat('Y-m-d', $schedule['match_start_date']);

                if (!empty($schedule['winner_id']) && $schedule['match_status']=='completed') {
                    $matchScheduleData[$key]['winner_text'] = trans('message.schedule.viewscore');
                } else if (Carbon::now()->gte($matchStartDate)) {
                        //$matchScheduleData[$key]['winner_text'] = trans('message.schedule.addscore');
						//$matchScheduleData[$key]['winner_text'] = Helper::getCurrentScoringStatus($schedule);
					$score_status_array = json_decode($schedule['score_added_by'],true);
					if(empty($score_status_array['added_by'])) {
						$matchScheduleData[$key]['winner_text'] = trans('message.schedule.addscore');
					}else if(!empty($score_status_array['added_by']) && empty($schedule['scoring_status'])) {
						if(!empty($score_status_array['added_by']) && $score_status_array['added_by']==Auth::user()->id)
							$matchScheduleData[$key]['winner_text'] = trans('message.schedule.editscore');
						else
							$matchScheduleData[$key]['winner_text'] = trans('message.schedule.viewscore');
					}else
					{
						$matchScheduleData[$key]['winner_text'] = trans('message.schedule.viewscore');
					}	
					
                }
                //$matchScheduleData[$key]['match_start_date'] = $matchStartDate->toFormattedDateString();
				$matchScheduleData[$key]['match_start_date'] = Helper::getFormattedTimeStamp($schedule);
            }
        }

        return view('admin.schedules.listview', ['matchScheduleData' => $matchScheduleData,
            'matchScheduleDataTotalCount' => $matchScheduleDataTotalCount,
            'sportsId' => $sportsId,
            'limit' => $limit, 'offset' => $limit + $offset]);
    }
	 public function viewMoreList() {
        $month = Request::get('month');
        $year = Request::get('year');
        $sportsId = Request::get('sportsId');
        $limit = Request::get('limit');
        $offset = Request::get('offset');
		if($sportsId=='' || $sportsId=='null') // if no sport selected
		{
			// $sportsIdsArray = Sport::orderBy('id')->lists('id')->all();
			//$sportsIdsArray = Helper::getDevelopedSport(1,1);
			$sportsIdsArray = Sport::where('is_schedule_available',1)->where('is_scorecard_available',1)->lists('id')->all();
		}
		else  // if sport selected
			$sportsIdsArray = explode(',',$sportsId);

        $monthName = Carbon::createFromFormat('m', $month)->format('F');
        //Getting the first and last day of the month
        $firstDay = new Carbon('first day of ' . $monthName . ' ' . $year . '');
        $lastDay = new Carbon('last day of ' . $monthName . ' ' . $year . '');
		
		$now = Carbon::now();
		$cur_year = $now->year;
		$cur_month = $now->month;
		//if curtrent month schedules searching
		if($month==$cur_month && $cur_year==$year)
		{
			$lastDay = Carbon::now();
		}
		
		$teamIds = '';
        $playerIds = '';
        $teamLogoArray = [];
        $playerLogoArray = [];
        $teamNameArray = [];
        $playerNameArray = [];
		
        // Converting the date to db format
        $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $firstDay)->format('Y-m-d');
        $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $lastDay)->format('Y-m-d');
		$toDaysDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now())->format('Y-m-d');
        $matchScheduleData = MatchSchedule::with(array('sport' => function($q3) {
                $q3->select('id','sports_name');
            },))->whereIn('sports_id', $sportsIdsArray)
                ->whereBetween('match_start_date', [$fromDate, $toDate])
				//->where('match_start_date','!=',$toDaysDate)
				->where('match_invite_status','=','accepted')
				->orderby('match_start_date', 'desc')
				->orderby('match_start_time', 'desc')
                ->limit($limit)->offset($offset)
                ->get(['id', 'match_start_date', 'winner_id', 'a_id', 'b_id','match_status','schedule_type','score_added_by','match_type','sports_id','match_start_time']);
				
				if (count($matchScheduleData)) {
            $matchScheduleData = $matchScheduleData->toArray();
            foreach ($matchScheduleData as $key => $schedule) {
                $matchScheduleData[$key]['a_logo'] = '';
                $matchScheduleData[$key]['b_logo'] = '';
                $matchScheduleData[$key]['a_name'] = '';
                $matchScheduleData[$key]['b_name'] = '';
                if ($schedule['schedule_type'] == 'team') {
                    $teamIds.=$schedule['a_id'] . ',' . $schedule['b_id'] . ',';
                } else {
                    $playerIds.=$schedule['a_id'] . ',' . $schedule['b_id'] . ',';
                }
            }
        }
		 if (!empty($teamIds)) {
            $teamIdArray = explode(',', rtrim($teamIds, ','));
            $teamLogos = Photo::whereIn('imageable_id', $teamIdArray)
                    ->where('imageable_type', config('constants.PHOTO.TEAM_PHOTO'))
                    ->where('is_album_cover', 1)
                    ->get(['url', 'imageable_id']);
            $teamNames = Team::whereIn('id', $teamIdArray)->get(['id', 'team_owner_id', 'sports_id', 'name']);

            if (count($teamLogos)) {
                foreach ($teamLogos->toArray() as $teamkey => $teamLogo) {
                    $teamLogoArray[$teamLogo['imageable_id']] = $teamLogo['url'];
                }
            }

            if (count($teamNames)) {
                foreach ($teamNames as $teamName) {
                    $teamNameArray[$teamName['id']] = $teamName['name'];
                }
            }
        }

        if (!empty($playerIds)) {
            $playerIdArray = explode(',', rtrim($playerIds, ','));
            $playerLogos = Photo::whereIn('user_id', $playerIdArray)
                    ->where('imageable_type', config('constants.PHOTO.USER_PHOTO'))
                    ->where('is_album_cover', 1)
                    ->get(['url', 'imageable_id', 'user_id']);

            $playerNames = User::whereIn('id', $playerIdArray)->get(['id', 'name']);

            if (count($playerLogos)) {
                foreach ($playerLogos->toArray() as $playerLogo) {
                    $playerLogoArray[$playerLogo['user_id']] = $playerLogo['url'];
                }
            }

            if (count($playerNames)) {
                foreach ($playerNames as $playerName) {
                    $playerNameArray[$playerName['id']] = $playerName['name'];
                }
            }
        }

		 if (!empty($matchScheduleData)) {
            foreach ($matchScheduleData as $key => $schedule) {
                if ($schedule['schedule_type'] == 'team') {
                    if (!empty($teamLogoArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $teamLogoArray)) {
                            $matchScheduleData[$key]['a_logo'] = $teamLogoArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $teamLogoArray)) {
                            $matchScheduleData[$key]['b_logo'] = $teamLogoArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                    if (!empty($teamNameArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $teamNameArray)) {
                            $matchScheduleData[$key]['a_name'] = $teamNameArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $teamNameArray)) {
                            $matchScheduleData[$key]['b_name'] = $teamNameArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                } else {
                    if (!empty($playerLogoArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $playerLogoArray)) {
                            $matchScheduleData[$key]['a_logo'] = $playerLogoArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $playerLogoArray)) {
                            $matchScheduleData[$key]['b_logo'] = $playerLogoArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                    if (!empty($playerNameArray)) {
                        if (array_key_exists($matchScheduleData[$key]['a_id'], $playerNameArray)) {
                            $matchScheduleData[$key]['a_name'] = $playerNameArray[$matchScheduleData[$key]['a_id']];
                        }
                        if (array_key_exists($matchScheduleData[$key]['b_id'], $playerNameArray)) {
                            $matchScheduleData[$key]['b_name'] = $playerNameArray[$matchScheduleData[$key]['b_id']];
                        }
                    }
                }
				
				 $matchStartDate = Carbon::createFromFormat('Y-m-d', $schedule['match_start_date']);

                if (!empty($schedule['winner_id']) && $schedule['match_status']=='completed') {
                    $matchScheduleData[$key]['winner_text'] = trans('message.schedule.viewscore');
                } else if (Carbon::now()->gte($matchStartDate)) {
                       // $matchScheduleData[$key]['winner_text'] = trans('message.schedule.addscore');
						//$matchScheduleData[$key]['winner_text'] = Helper::getCurrentScoringStatus($schedule);
					$score_status_array = json_decode($schedule['score_added_by'],true);
					if(empty($score_status_array['added_by'])) {
						$matchScheduleData[$key]['winner_text'] = trans('message.schedule.addscore');
					}else if(!empty($score_status_array['added_by']) && empty($schedule['scoring_status'])) {
						if(!empty($score_status_array['added_by']) && $score_status_array['added_by']==Auth::user()->id)
							$matchScheduleData[$key]['winner_text'] = trans('message.schedule.editscore');
						else
							$matchScheduleData[$key]['winner_text'] = trans('message.schedule.viewscore');
					}
                }
               // $matchScheduleData[$key]['match_start_date'] = $matchStartDate->toFormattedDateString();
				$matchScheduleData[$key]['match_start_date'] = Helper::getFormattedTimeStamp($schedule);
            }
        }

       

        return view('admin.schedules.listmoreview', ['matchScheduleData' => $matchScheduleData,
            'sportsId' => $sportsId,
            'limit' => $limit, 'offset' => $limit + $offset]);
    }
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
			 $sport_id = $match_data[0]['sports_id'];//get sport id
			$sportsDetails = Sport::where('id',$sport_id)->get()->toArray();//get sports details
			
			if(!empty($sportsDetails))
			{
				 $sport_name = $sportsDetails[0]['sports_name'];
				if(strtolower($sport_name)==strtolower('Tennis'))//if match is related to tennis
				{
					return  $this->tennisOrTableTennisScoreCard($match_data,$match='Tennis');
				}else if(strtolower($sport_name)==strtolower('Table Tennis'))//if match is related to table tennis
				{
					return $this->tennisOrTableTennisScoreCard($match_data,$match='Table Tennis');
				}else if(strtolower($sport_name)==strtolower('Cricket'))
				{
					return $this->cricketScoreCard($match_data);
				}
				else if(strtolower($sport_name)==strtolower('soccer'))
				{
					return $this->soccerScoreCard($match_data);
				}
			}
		}
	}

	//function to display tennis score card form
	public function tennisOrTableTennisScoreCard($match_data,$match,$is_from_view=0)
	{
		$score_a_array=array();
		$score_b_array=array();
		$loginUserId = Auth::user()->id;
		//if($match_data[0]['match_status']=='scheduled')//match should be already scheduled
		//{
			$player_a_ids = $match_data[0]['player_a_ids'];
			$player_b_ids = $match_data[0]['player_b_ids'];
			
			$a_players = array();
			
			$team_a_playerids = explode(',',$player_a_ids);
			$a_team_players = User::select('id','name')->whereIn('id',$team_a_playerids)->get();
			
			if (count($a_team_players)>0)
				$a_players = $a_team_players->toArray();
			
			$b_players = array();
			
			$team_b_playerids = explode(',',$player_b_ids);
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
			}
			$decoded_match_details = array();
			if($match_data[0]['match_details']!='')
			{
				$decoded_match_details = json_decode($match_data[0]['match_details'],true);
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


			//ONLY FOR VIEW SCORE CARD
			if($is_from_view==1 || (!empty($score_status_array['added_by']) && $score_status_array['added_by']!=$loginUserId) || $match_data[0]['match_status']=='completed' || $match_data[0]['scoring_status']=='approval_pending' || $match_data[0]['scoring_status']=='approved') 
			{
				if($match=='Tennis')
				{
					return view('scorecards.tennisscorecardview',array('user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
				}else
				{
					
					return view('scorecards.tabletennisscorecardview',array('user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
				}
			}
			else //to view and edit tennis/table tennis score card
			{
				if($match=='Tennis')
				{
					return view('scorecards.tennisscorecard',array('user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
				}else
				{
					
					return view('scorecards.tabletennisscorecard',array('user_a_name'=>$user_a_name,'user_b_name'=>$user_b_name,'user_a_logo'=>$user_a_logo,'user_b_logo'=>$user_b_logo,'match_data'=>$match_data,'upload_folder'=>$upload_folder,'is_singles'=>$is_singles,'score_a_array'=>$score_a_array,'score_b_array'=>$score_b_array,'b_players'=>$b_players,'a_players'=>$a_players,'team_a_player_images'=>$team_a_player_images,'team_b_player_images'=>$team_b_player_images,'decoded_match_details'=>$decoded_match_details,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
				}
			}
			
		//}
	}
	//function to insert tennis score card
	public function insertTennisScoreCard()
	{
		$loginUserId = Auth::user()->id;
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
		
		
		//insert match a details
		if(count($team_a_records)>0)//if team a record is already exist
		{
			$this->updateTennisScore($user_id_a,$match_id,$set1_a,$set2_a,$set3_a,$set4_a,$set5_a,$set1_tie_breaker_a,$set2_tie_breaker_a,$set3_tie_breaker_a,$set4_tie_breaker_a,$set5_tie_breaker_a,$is_singles,$aces_a,$double_faults_a,$team_a_players,$schedule_type,$match_type);

		}else
		{
			$this->insertTennisScore($user_id_a,$tournament_id,$match_id,$player_name_a,$set1_a,$set2_a,$set3_a,$set4_a,$set5_a,$set1_tie_breaker_a,$set2_tie_breaker_a,$set3_tie_breaker_a,$set4_tie_breaker_a,$set5_tie_breaker_a,$is_singles,$aces_a,$double_faults_a,$team_a_players,$schedule_type,$match_type);

		}
		
		
		//insert match b details
		if(count($team_b_records)>0)//if team b record is already exist
		{
			$this->updateTennisScore($user_id_b,$match_id,$set1_b,$set2_b,$set3_b,$set4_b,$set5_b,$set1_tie_breaker_b,$set2_tie_breaker_b,$set3_tie_breaker_b,$set4_tie_breaker_b,$set5_tie_breaker_b,$is_singles,$aces_b,$double_faults_b,$team_b_players,$schedule_type,$match_type);
		
		}else
		{
			$this->insertTennisScore($user_id_b,$tournament_id,$match_id,$player_name_b,$set1_b,$set2_b,$set3_b,$set4_b,$set5_b,$set1_tie_breaker_b,$set2_tie_breaker_b,$set3_tie_breaker_b,$set4_tie_breaker_b,$set5_tie_breaker_b,$is_singles,$aces_b,$double_faults_b,$team_b_players,$schedule_type,$match_type);

		}
		
		
		//match details clmn
		$team_a_details[$user_id_a] = $team_a_players;
		$team_b_details[$user_id_b] = $team_b_players;
		
		$match_details = $team_a_details+$team_b_details;
		$json_match_details_array = json_encode($match_details);
		
		//get previous scorecard status data
		$scorecardDetails = MatchSchedule::where('id',$match_id)->pluck('score_added_by');
		$decode_scorecard_data = json_decode($scorecardDetails,true);
		
		$modified_users = !empty($decode_scorecard_data['modified_users'])?$decode_scorecard_data['modified_users']:'';
		
		$modified_users = $modified_users.','.$loginUserId;//scorecard changed users
		
		$added_by = !empty($decode_scorecard_data['added_by'])?$decode_scorecard_data['added_by']:$loginUserId;
		
		//score card approval process
		$score_status = array('added_by'=>$added_by,'active_user'=>$loginUserId,'modified_users'=>$modified_users,'rejected_note'=>'');
		
		$json_score_status = json_encode($score_status);
		
		//update winner id
                $matchScheduleDetails = MatchSchedule::where('id',$match_id)->first();
                if(count($matchScheduleDetails)) {
                    $looser_team_id = NULL;
                        if(isset($winner_team_id)) {
                            if($winner_team_id==$matchScheduleDetails['a_id']) {
                                $looser_team_id=$matchScheduleDetails['b_id'];
                            }else{
                                $looser_team_id=$matchScheduleDetails['a_id'];
                            }
                        }
                    
                    if(!empty($matchScheduleDetails['tournament_id'])) {
                            $tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
                            if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {
                                MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'match_status'=>'completed',
                                                    'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                                    'score_added_by'=>$json_score_status]);
//                                Helper::printQueries();
                                
                                if(!empty($matchScheduleDetails['tournament_round_number'])) {
                                        $this->updateBracketDetails($matchScheduleDetails,$tournamentDetails);
                                }
                                $sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
                                $this->insertPlayerStatistics($sportName,$match_id);
                            }

                    }else {
                        MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'winner_id'=>$winner_team_id ,
                                                            'looser_id'=>$looser_team_id,'score_added_by'=>$json_score_status]);
                    } 
                }
		//MatchSchedule::where('id',$match_id)->update(['winner_id'=>$winner_team_id,'match_details'=>$json_match_details_array,'score_added_by'=>$json_score_status]);
		//if($winner_team_id>0)
			//return redirect()->route('match/scorecard/view', [$match_id])->with('status', trans('message.scorecard.scorecardmsg'));
		
		return redirect()->back()->with('status', trans('message.scorecard.scorecardmsg'));
	}
	
	//function to insert tennis score card
	public function insertTennisScore($user_id,$tournament_id,$match_id,$player_name,$set1,$set2,$set3,$set4,$set5,$set1_tie_breaker,$set2_tie_breaker,$set3_tie_breaker,$set4_tie_breaker,$set5_tie_breaker,$is_singles,$aces,$double_faults,$team_players,$schedule_type,$match_type)
	{
		$model = new TennisPlayerMatchScore();
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
		$model->save();
	}
	//function to update tennis score
	public function updateTennisScore($user_id,$match_id,$set1,$set2,$set3,$set4,$set5,$set1_tie_breaker,$set2_tie_breaker,$set3_tie_breaker,$set4_tie_breaker,$set5_tie_breaker,$is_singles,$aces,$double_faults,$team_players,$schedule_type,$match_type)
	{
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
	//function to insert tennis statitistics
	public function tennisStatistics($player_ids_a_array,$match_type,$is_win='')
	{
		//$player_ids_a_array = explode(',',$player_ids);
		foreach($player_ids_a_array as $user_id)
		{
			//check already user id exists or not
			$tennis_statistics_array = array();
			$tennisStatistics = TennisStatistic::select()->where('user_id',$user_id)->where('match_type',$match_type)->get();
			if(count($tennisStatistics)>0)
			{
				$player_match_details = TennisPlayerMatchScore::selectRaw('sum(aces) as aces_count')->selectRaw('sum(double_faults) as double_faults_count')->where('user_id_a',$user_id)->groupBy('user_id_a')->get();
				
				$tennis_statistics_array = $tennisStatistics->toArray();
				$matches = $tennis_statistics_array[0]['matches'];
				$won = $tennis_statistics_array[0]['won'];
				$lost = $tennis_statistics_array[0]['lost'];
				$aces_count = '';
				$double_faults_count = '';
				
				if($match_type=='singles')
				{
					$aces_count = (!empty($player_match_details[0]['aces_count']))?$player_match_details[0]['aces_count']:'';
					$double_faults_count = (!empty($player_match_details[0]['double_faults_count']))?$player_match_details[0]['double_faults_count']:'';
				}
				
				TennisStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['matches'=>$matches+1,'aces'=>$aces_count,'double_faults'=>$double_faults_count]);
				
				if($is_win=='yes') //win count
				{
					$won_percentage = ($won+1/$matches)*100;
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
					$won_percentage = 100;
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
				$tennisStatisticsModel->save();
			}
		}
		
	}
	
	//function to save table tennis score card
	public function insertTableTennisScoreCard()
	{
		$loginUserId = Auth::user()->id;
		$request = Request::all();
		$tournament_id = !empty(Request::get('tournament_id'))?Request::get('tournament_id'):NULL;
		$match_id = !empty(Request::get('match_id'))?Request::get('match_id'):NULL;
		$match_type = !empty(Request::get('match_type'))?Request::get('match_type'):NULL;
		$player_ids_a = !empty(Request::get('player_ids_a'))?Request::get('player_ids_a'):NULL;
		$player_ids_b= !empty(Request::get('player_ids_b'))?Request::get('player_ids_b'):NULL;
		$is_singles = !empty(Request::get('is_singles'))?Request::get('is_singles'):NULL;
		$is_winner_inserted = !empty(Request::get('is_winner_inserted'))?Request::get('is_winner_inserted'):NULL;
		$winner_team_id = !empty(Request::get('winner_team_id'))?Request::get('winner_team_id'):$is_winner_inserted;//winner_id
		
		$team_a_players = !empty(Request::get('a_player_ids'))?Request::get('a_player_ids'):array();//player id if match type is singles
		$team_b_players = !empty(Request::get('b_player_ids'))?Request::get('b_player_ids'):array();//player id if match type is singles
		
		$schedule_type = !empty(Request::get('schedule_type'))?Request::get('schedule_type'):NULL;
		
		//match a Details		
		$user_id_a = !empty(Request::get('user_id_a'))?Request::get('user_id_a'):NULL;
		$player_name_a = !empty(Request::get('player_name_a'))?Request::get('player_name_a'):NULL;		
		$set1_a = !empty(Request::get('set_1_a'))?Request::get('set_1_a'):NULL;
		$set2_a = !empty(Request::get('set_2_a'))?Request::get('set_2_a'):NULL;
		$set3_a = !empty(Request::get('set_3_a'))?Request::get('set_3_a'):NULL;
		$set4_a = !empty(Request::get('set_4_a'))?Request::get('set_4_a'):NULL;
		$set5_a = !empty(Request::get('set_5_a'))?Request::get('set_5_a'):NULL;		
		
		
		//match a Details
		$user_id_b = !empty(Request::get('user_id_b'))?Request::get('user_id_b'):NULL;
		$player_name_b = !empty(Request::get('player_name_b'))?Request::get('player_name_b'):NULL;
		$set1_b = !empty(Request::get('set_1_b'))?Request::get('set_1_b'):NULL;
		$set2_b = !empty(Request::get('set_2_b'))?Request::get('set_2_b'):NULL;
		$set3_b = !empty(Request::get('set_3_b'))?Request::get('set_3_b'):NULL;
		$set4_b = !empty(Request::get('set_4_b'))?Request::get('set_4_b'):NULL;
		$set5_b = !empty(Request::get('set_5_b'))?Request::get('set_5_b'):NULL;
		
		if($is_singles=='yes')
		{
			$team_a_records = TtPlayerMatchScore::select()->where('match_id',$match_id)->where('user_id_a',$user_id_a)->get();
			$team_b_records = TtPlayerMatchScore::select()->where('match_id',$match_id)->where('user_id_a',$user_id_b)->get();
			$users_a = $user_id_a; //if singles
			$users_b = $user_id_b;
		}else
		{
			$team_a_records = TtPlayerMatchScore::select()->where('match_id',$match_id)->where('team_id',$user_id_a)->get();
			$team_b_records = TtPlayerMatchScore::select()->where('match_id',$match_id)->where('team_id',$user_id_b)->get();
			$users_a = $player_ids_a;
			$users_b = $player_ids_b;
		}
		
		
		//insert match a details
		if(count($team_a_records)>0)//if team a record is already exist
		{
			$this->updateTableTennisScore($user_id_a,$match_id,$set1_a,$set2_a,$set3_a,$set4_a,$set5_a,$is_singles,$team_a_players,$schedule_type,$match_type);

		}else
		{
			$this->insertTableTennisScore($user_id_a,$tournament_id,$match_id,$player_name_a,$set1_a,$set2_a,$set3_a,$set4_a,$set5_a,$is_singles,$team_a_players,$schedule_type,$match_type);

		}

		
		//insert match b details
		if(count($team_b_records)>0)//if team b record is already exist
		{
			$this->updateTableTennisScore($user_id_b,$match_id,$set1_b,$set2_b,$set3_b,$set4_b,$set5_b,$is_singles,$team_b_players,$schedule_type,$match_type);

		}else
		{
			$this->insertTableTennisScore($user_id_b,$tournament_id,$match_id,$player_name_b,$set1_b,$set2_b,$set3_b,$set4_b,$set5_b,$is_singles,$team_b_players,$schedule_type,$match_type);
			
		}
		
		//match details clmn
		$team_a_details[$user_id_a] = $team_a_players;
		$team_b_details[$user_id_b] = $team_b_players;
		
		$match_details = $team_a_details+$team_b_details;
		$json_match_details_array = json_encode($match_details);
		
		//get previous scorecard status data
		$scorecardDetails = MatchSchedule::where('id',$match_id)->pluck('score_added_by');
		$decode_scorecard_data = json_decode($scorecardDetails,true);
		
		$modified_users = !empty($decode_scorecard_data['modified_users'])?$decode_scorecard_data['modified_users']:'';
		
		$modified_users = $modified_users.','.$loginUserId;//scorecard changed users
		
		$added_by = !empty($decode_scorecard_data['added_by'])?$decode_scorecard_data['added_by']:$loginUserId;
		
		//score card approval process
		$score_status = array('added_by'=>$added_by,'active_user'=>$loginUserId,'modified_users'=>$modified_users,'rejected_note'=>'');
		
		$json_score_status = json_encode($score_status);
		
		//update winner id
                $matchScheduleDetails = MatchSchedule::where('id',$match_id)->first();
                if(count($matchScheduleDetails)) {
                    $looser_team_id = NULL;
                        if(isset($winner_team_id)) {
                            if($winner_team_id==$matchScheduleDetails['a_id']) {
                                $looser_team_id=$matchScheduleDetails['b_id'];
                            }else{
                                $looser_team_id=$matchScheduleDetails['a_id'];
                            }
                        }
                    
                    if(!empty($matchScheduleDetails['tournament_id'])) {
                            $tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
                            if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {
                                MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'match_status'=>'completed',
                                                    'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                                    'score_added_by'=>$json_score_status]);
//                                Helper::printQueries();
                                
                                if(!empty($matchScheduleDetails['tournament_round_number'])) {
                                        $this->updateBracketDetails($matchScheduleDetails,$tournamentDetails);
                                }
                                $sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
                                $this->insertPlayerStatistics($sportName,$match_id);
                            }

                    }else {
                        MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'winner_id'=>$winner_team_id ,
                                                            'looser_id'=>$looser_team_id,'score_added_by'=>$json_score_status]);
                    } 
                }
		//MatchSchedule::where('id',$match_id)->update(['winner_id'=>$winner_team_id,'match_details'=>$json_match_details_array,'score_added_by'=>$json_score_status ]);
		//if($winner_team_id>0)
			//return redirect()->route('match/scorecard/view', [$match_id])->with('status', trans('message.scorecard.scorecardmsg'));
		
		return redirect()->back()->with('status', trans('message.scorecard.scorecardmsg'));
	}
	//function to save table tennis score
	public function insertTableTennisScore($user_id,$tournament_id,$match_id,$player_name,$set1,$set2,$set3,$set4,$set5,$is_singles,$team_players,$schedule_type,$match_type)
	{
		//insert match a details
		$model = new TtPlayerMatchScore();
		if($is_singles=='yes')
		{
			$model->user_id_a = $user_id;
		}else
		{
			if($schedule_type=='team' && $match_type=='singles')
			{
				$model->user_id_a = (!empty($team_players[0]))?$team_players[0]:'';
			}
			$model->team_id = $user_id;
		}
		
		$model->tournament_id = $tournament_id;
		$model->match_id = $match_id;
		$model->player_name_a = $player_name;
		$model->set1 = $set1;
		$model->set2 = $set2;
		$model->set3 = $set3;
		$model->set4 = $set4;
		$model->set5 = $set5;
		$model->save();
	}
	//function to update table tennis
	public function updateTableTennisScore($user_id,$match_id,$set1,$set2,$set3,$set4,$set5,$is_singles,$team_players,$schedule_type,$match_type)
	{
		if($is_singles=='yes')
		{
			TtPlayerMatchScore::where('match_id',$match_id)->where('user_id_a',$user_id)->update(['set1'=>$set1,'set2'=>$set2,'set3'=>$set3,'set4'=>$set4,'set5'=>$set5]);
		}else
		{
			$user_id_a='';
			if($schedule_type=='team' && $match_type=='singles')
			{
				$user_id_a = (!empty($team_players[0]))?$team_players[0]:'';
			}
			TtPlayerMatchScore::where('match_id',$match_id)->where('team_id',$user_id)->update(['set1'=>$set1,'set2'=>$set2,'set3'=>$set3,'set4'=>$set4,'set5'=>$set5,'user_id_a'=>$user_id_a]);
		}
	}
	
	//function to insert tennis statitistics
	public function tableTennisStatistics($player_ids_array,$match_type,$is_win='')
	{
		//$player_ids_array = explode(',',$player_ids);
		foreach($player_ids_array as $user_id)
		{
			//check already user id exists or not
			$tennis_statistics_array = array();
			$tennisStatistics = TtStatistic::select()->where('user_id',$user_id)->where('match_type',$match_type)->get();
			if(count($tennisStatistics)>0)
			{
				$tennis_statistics_array = $tennisStatistics->toArray();
				$matches = $tennis_statistics_array[0]['matches'];
				$won = $tennis_statistics_array[0]['won'];
				$lost = $tennis_statistics_array[0]['lost'];
					TtStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['matches'=>$matches+1]);
				if($is_win=='yes') //win count
				{
					$won_percentage = ($won+1/$matches)*100;
					TtStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['won'=>$won+1,'won_percentage'=>$won_percentage]);
					
				}else if($is_win=='no')//loss count
				{
					TtStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['lost'=>$lost+1]);
				}
			}else
			{
				$won='';
				$won_percentage='';
				$lost='';
				if($is_win=='yes') //win count
				{
					$won = 1;
					$won_percentage = 100;
				}else if($is_win=='no') //lost count
				{
					$lost=1;
				}
				$tennisStatisticsModel = new TtStatistic();
				$tennisStatisticsModel->user_id = $user_id;
				$tennisStatisticsModel->match_type = $match_type;
				$tennisStatisticsModel->matches = 1;
				$tennisStatisticsModel->won_percentage = $won_percentage;
				$tennisStatisticsModel->won = $won;
				$tennisStatisticsModel->lost = $lost;
				$tennisStatisticsModel->save();
			}
		}
		
	}
	//function to save cricket details
	public function cricketScoreCard($match_data,$is_from_view=0)
	{
		$loginUserId = Auth::user()->id;
		$team_a_players = array();
		$team_b_players = array();
		$team_a_id = $match_data[0]['a_id'];
		$team_b_id = $match_data[0]['b_id'];
		$team_a_playerids = explode(',',$match_data[0]['player_a_ids']);
		$team_b_playerids = explode(',',$match_data[0]['player_b_ids']);
		
		//get player names
		$a_team_players = User::select()->whereIn('id',$team_a_playerids)->get();
		$b_team_players = User::select()->whereIn('id',$team_b_playerids)->get();
		
		//get team names
		$team_a_name = Team::where('id',$team_a_id)->pluck('name');
		$team_b_name = Team::where('id',$team_b_id)->pluck('name');
		
		if(!empty($a_team_players))
			$team_a_players = $a_team_players->toArray();
		if(!empty($b_team_players))
			$team_b_players = $b_team_players->toArray();
		$team_a = array();
		$team_b = array();
	
		//get team a players
		foreach($team_a_players as $team_a_player)
		{		
			$team_a[$team_a_player['id']] = $team_a_player['name'];
		}
		
		//get team b players
		foreach($team_b_players as $team_b_player)
		{		
			$team_b[$team_b_player['id']] = $team_b_player['name'];
		}
		
		//out_as enum 
		$enum = config('constants.ENUM.SCORE_CARD.OUT_AS'); 
		
		
		//get team a details first innings
		$team_a_fst_ing_array = array();
		$team_a_fst_innings = CricketPlayerMatchwiseStats::select()->where('match_id',$match_data[0]['id'])->where('team_id',$team_a_id)->where('innings','first')->get();
		if(count($team_a_fst_innings)>0)
		{
			$team_a_fst_ing_array = $team_a_fst_innings->toArray();
		}
		
		//get team a details first innings
		$team_b_fst_ing_array = array();
		$team_b_fst_innings = CricketPlayerMatchwiseStats::select()->where('match_id',$match_data[0]['id'])->where('team_id',$team_b_id)->where('innings','first')->get();
		if(count($team_b_fst_innings)>0)
		{
			$team_b_fst_ing_array = $team_b_fst_innings->toArray();
		}
		
		//if test match second innings
		$team_a_secnd_ing_array = array();
		$team_b_secnd_ing_array = array();
		if($match_data[0]['match_type']=='test')
		{
			//get team a details second innings
			$team_a_second_innings = CricketPlayerMatchwiseStats::select()->where('match_id',$match_data[0]['id'])->where('team_id',$team_a_id)->where('innings','second')->get();
			if(count($team_a_second_innings)>0)
			{
				$team_a_secnd_ing_array = $team_a_second_innings->toArray();
			}
			
			//get team b details second innings
			$team_b_fst_innings = CricketPlayerMatchwiseStats::select()->where('match_id',$match_data[0]['id'])->where('team_id',$team_b_id)->where('innings','second')->get();
			if(count($team_b_fst_innings)>0)
			{
				$team_b_secnd_ing_array = $team_b_fst_innings->toArray();
			}
		}
		
		//get match details fall of wickets
		$team_wise_match_details = array();
		$match_details = $match_data[0]['match_details'];
		if($match_details!='' && $match_details!=NULL)
		{
			$json_decode_array = json_decode($match_details,true);
			foreach($json_decode_array as $key => $array)
			{
				$team_wise_match_details[$key] = $array;
			}
		}

		$b_keyCount_fst_ing=0; // get fall of wickets for team a first inning 
		$a_keyCount_fst_ing=0; // get fall of wickets for team b first inning
		
		$b_keycount_scnd_ing = 0;
		$a_keycount_scnd_ing = 0;
		if(count($team_wise_match_details)>0)
		{
			//get b array key count
			$b_keyCount_fst_ing = count(
					array_filter(
						array_keys($team_wise_match_details[$match_data[0]['b_id']]['first']),
						'is_numeric'
					)
				);
				
			//get a array key count
			$a_keyCount_fst_ing = count(
					array_filter(
						array_keys($team_wise_match_details[$match_data[0]['a_id']]['first']),
						'is_numeric'
					)
				);
				if($match_data[0]['match_type']=='test') //FOR TEST MATCH second ing
				{
					//get b array key count
				 	$b_keycount_scnd_ing = count(
							array_filter(
								array_keys($team_wise_match_details[$match_data[0]['b_id']]['second']),
								'is_numeric'
							)
						);
						
					//get a array key count
					$a_keycount_scnd_ing = count(
							array_filter(
								array_keys($team_wise_match_details[$match_data[0]['a_id']]['second']),
								'is_numeric'
							)
						);
				}
		}

		$team_a_count = count($team_a);
		$team_b_count = count($team_b);
		
		$team_a_fst_ing_score='';
		$team_a_fst_ing_wkt='';
		$team_a_fst_ing_overs='';
		$team_a_scnd_ing_score='';
		$team_a_scnd_ing_wkt='';
		$team_a_scnd_ing_overs='';
		//team_a_total_score fst ing
		if(!empty($team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score']) && $team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score']!=null)
		{
			$team_a_fst_ing_score = $team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score']) && $team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score']!=null)
		{
			$team_a_fst_ing_wkt = $team_wise_match_details[$match_data[0]['a_id']]['fst_ing_wkt'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score']) && $team_wise_match_details[$match_data[0]['a_id']]['fst_ing_score']!=null)
		{
			$team_a_fst_ing_overs = $team_wise_match_details[$match_data[0]['a_id']]['fst_ing_overs'];
		}

		//team_a_total_score scnd ing
		if(!empty($team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_score']) && $team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_score']!=null)
		{
			$team_a_scnd_ing_score = $team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_score'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_wkt']) && $team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_wkt']!=null)
		{
			$team_a_scnd_ing_wkt = $team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_wkt'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_overs']) && $team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_overs']!=null)
		{
			$team_a_scnd_ing_overs = $team_wise_match_details[$match_data[0]['a_id']]['scnd_ing_overs'];
		}
		
		$team_b_fst_ing_score='';
		$team_b_fst_ing_wkt='';
		$team_b_fst_ing_overs='';
		$team_b_scnd_ing_score='';
		$team_b_scnd_ing_wkt='';
		$team_b_scnd_ing_overs='';
		//team_b_total_score
		if(!empty($team_wise_match_details[$match_data[0]['b_id']]['fst_ing_score']) && $team_wise_match_details[$match_data[0]['b_id']]['fst_ing_score']!=null)
		{
			$team_b_fst_ing_score = $team_wise_match_details[$match_data[0]['b_id']]['fst_ing_score'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['b_id']]['fst_ing_wkt']) && $team_wise_match_details[$match_data[0]['b_id']]['fst_ing_wkt']!=null)
		{
			$team_b_fst_ing_wkt = $team_wise_match_details[$match_data[0]['b_id']]['fst_ing_wkt'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['b_id']]['fst_ing_overs']) && $team_wise_match_details[$match_data[0]['b_id']]['fst_ing_overs']!=null)
		{
			$team_b_fst_ing_overs = $team_wise_match_details[$match_data[0]['b_id']]['fst_ing_overs'];
		}
		
		//team_b_total_score scnd ing
		if(!empty($team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_score']) && $team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_score']!=null)
		{
			$team_b_scnd_ing_score = $team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_score'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_wkt']) && $team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_wkt']!=null)
		{
			$team_b_scnd_ing_wkt = $team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_wkt'];
		}
		if(!empty($team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_overs']) && $team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_overs']!=null)
		{
			$team_b_scnd_ing_overs = $team_wise_match_details[$match_data[0]['b_id']]['scnd_ing_overs'];
		}
		
		//get team logos
		$team_a_logo = Photo::select()->where('imageable_id', $team_a_id)->where('imageable_type', config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first(); //get team a logo
		
		$team_b_logo = Photo::select()->where('imageable_id', $team_b_id)->where('imageable_type', config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first(); //get team b logo
		
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
		
		if($is_from_view==1 || (!empty($score_status_array['added_by']) && $score_status_array['added_by']!=$loginUserId) || $match_data[0]['match_status']=='completed' || $match_data[0]['scoring_status']=='approval_pending' || $match_data[0]['scoring_status']=='approved') //only to view cricket score
		{
			$player_name_array = array();
			$users = User::select('id', 'name')->get()->toArray(); //get player names
            foreach ($users as $user) {
                $player_name_array[$user['id']] = $user['name']; //get team names
            }
			
			$enum_shortcuts = array('bowled' => 'b', 'caught' => 'c', 'handled_ball' => 'htb', 'hit_ball_twice' => 'htbt', 'hit_wicket' => 'hw', 'lbw' => 'lbw', 'obstructing_the_field' => 'otf' ,'retired' => 'r', 'run_out' => 'ro', 'stumped' => 's', 'timed_out'=>'to');
		
			return view('scorecards.cricketscorecardview',array('team_a'=>[''=>'Select Player']+$team_a,'team_b'=>[''=>'Select Player']+$team_b,'match_data'=>$match_data,'team_a_name'=>$team_a_name,'team_b_name'=>$team_b_name,'enum'=> ['' => 'Select Out As'] + $enum,'team_a_fst_ing_array'=>$team_a_fst_ing_array,'team_b_fst_ing_array'=>$team_b_fst_ing_array,'team_a_secnd_ing_array'=>$team_a_secnd_ing_array,'team_b_secnd_ing_array'=>$team_b_secnd_ing_array,'team_wise_match_details'=>$team_wise_match_details,'team_a_count'=>$team_a_count,'team_b_count'=>$team_b_count,'team_a_logo'=>$team_a_logo,'team_b_logo'=>$team_b_logo,'team_a_fst_ing_score'=>$team_a_fst_ing_score,'team_a_fst_ing_wkt'=>$team_a_fst_ing_wkt,'team_a_fst_ing_overs'=>$team_a_fst_ing_overs,'team_a_scnd_ing_score'=>$team_a_scnd_ing_score,'team_a_scnd_ing_wkt'=>$team_a_scnd_ing_wkt,'team_a_scnd_ing_overs'=>$team_a_scnd_ing_overs,'team_b_fst_ing_score'=>$team_b_fst_ing_score,'team_b_fst_ing_wkt'=>$team_b_fst_ing_wkt,'team_b_fst_ing_overs'=>$team_b_fst_ing_overs,'team_b_scnd_ing_score'=>$team_b_scnd_ing_score,'team_b_scnd_ing_wkt'=>$team_b_scnd_ing_wkt,'team_b_scnd_ing_overs'=>$team_b_scnd_ing_overs,'player_name_array'=>$player_name_array,'a_keyCount'=>$a_keyCount_fst_ing,'b_keyCount'=>$b_keyCount_fst_ing,'a_keycount_scnd_ing'=>$a_keycount_scnd_ing,'b_keycount_scnd_ing'=>$b_keycount_scnd_ing,'enum_shortcuts'=>$enum_shortcuts,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
		}
		else //to view and edit cricket score card
		{
			return view('scorecards.cricketscorecard',array('team_a'=>[''=>'Select Player']+$team_a,'team_b'=>[''=>'Select Player']+$team_b,'match_data'=>$match_data,'team_a_name'=>$team_a_name,'team_b_name'=>$team_b_name,'enum'=> ['' => 'Select Out As'] + $enum,'team_a_fst_ing_array'=>$team_a_fst_ing_array,'team_b_fst_ing_array'=>$team_b_fst_ing_array,'team_a_secnd_ing_array'=>$team_a_secnd_ing_array,'team_b_secnd_ing_array'=>$team_b_secnd_ing_array,'team_wise_match_details'=>$team_wise_match_details,'team_a_count'=>$team_a_count,'team_b_count'=>$team_b_count,'team_a_logo'=>$team_a_logo,'team_b_logo'=>$team_b_logo,'team_a_fst_ing_score'=>$team_a_fst_ing_score,'team_a_fst_ing_wkt'=>$team_a_fst_ing_wkt,'team_a_fst_ing_overs'=>$team_a_fst_ing_overs,'team_a_scnd_ing_score'=>$team_a_scnd_ing_score,'team_a_scnd_ing_wkt'=>$team_a_scnd_ing_wkt,'team_a_scnd_ing_overs'=>$team_a_scnd_ing_overs,'team_b_fst_ing_score'=>$team_b_fst_ing_score,'team_b_fst_ing_wkt'=>$team_b_fst_ing_wkt,'team_b_fst_ing_overs'=>$team_b_fst_ing_overs,'team_b_scnd_ing_score'=>$team_b_scnd_ing_score,'team_b_scnd_ing_wkt'=>$team_b_scnd_ing_wkt,'team_b_scnd_ing_overs'=>$team_b_scnd_ing_overs,'a_keyCount'=>$a_keyCount_fst_ing,'b_keyCount'=>$b_keyCount_fst_ing,'a_keycount_scnd_ing'=>$a_keycount_scnd_ing,'b_keycount_scnd_ing'=>$b_keycount_scnd_ing,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
		}
		
	}
	public function insertCricketScoreCard()
	{
		$loginUserId = Auth::user()->id;
		$request = Request::all();
		//team a details
		$team_a_player_count = Request::get('a_player_count');
		$team_b_player_count = Request::get('b_player_count');
		$a_bowler_count = Request::get('a_bowler_count');
		$b_bowler_count = Request::get('b_bowler_count');
		$team_a_name = Request::get('team_a_name');
		$team_b_name = Request::get('team_b_name');
		$winner_team_id = !empty(Request::get('winner_team_id'))?Request::get('winner_team_id'):NULL;//winner team id
		$match_result = !empty(Request::get('hid_match_result'))?Request::get('hid_match_result'):NULL;//winner team id
		
		$team_a_id = !empty(Request::get('team_a_id'))?Request::get('team_a_id'):NULL;
		$team_b_id = !empty(Request::get('team_b_id'))?Request::get('team_b_id'):NULL;
		$tournament_id = !empty(Request::get('tournament_id'))?Request::get('tournament_id'):NULL;
		$match_type = !empty(Request::get('match_type'))?Request::get('match_type'):NULL;
		$inning = !empty(Request::get('inning'))?Request::get('inning'):'first';
		$match_id = Request::get('match_id');
		
		
		
		//delete all records before insert or update score card
		$match_score = CricketPlayerMatchwiseStats::select()->where('match_id',$match_id)->where('innings',$inning)->get();
		if(count($match_score)>0)
		{
			CricketPlayerMatchwiseStats::where('match_id',$match_id)->where('innings',$inning)->update(['deleted_at'=>Carbon::now()]);
		}
		for($i=1;$i<=$team_a_player_count;$i++)//insert team a batsman score
		{
			$user_id_a = !empty(Request::get('a_player_'.$i))?Request::get('a_player_'.$i):0;
			
			$totalruns_a = (is_numeric(Request::get('a_runs_'.$i)))?Request::get('a_runs_'.$i):0;
			$balls_played_a = (is_numeric(Request::get('a_balls_'.$i)))?Request::get('a_balls_'.$i):0;
			$fours_a = (is_numeric(Request::get('a_fours_'.$i)))?Request::get('a_fours_'.$i):0;
			$sixes_a = (is_numeric(Request::get('a_sixes_'.$i)))?Request::get('a_sixes_'.$i):0;
			$out_as_a = Request::get('a_outas_'.$i);
			$strikerate_a = Request::get('a_strik_rate_'.$i);
			$bowled_id_a = Request::get('a_bowled_'.$i);
			$fielder_id_a = Request::get('a_fielder_'.$i);
			if($user_id_a>0)
			{
				$player_name = User::where('id',$user_id_a)->pluck('name');
				//check already player exists r not
				$is_player_exist = CricketPlayerMatchwiseStats::select()->where('match_id',$match_id)->where('team_id',$team_a_id)->where('user_id',$user_id_a)->where('innings',$inning)->get()->first();
				
				//bat status 
				$a_bat_status = 'notout';
				if($out_as_a!='')
				{
					$a_bat_status = 'out';
				}else if(!($totalruns_a>0 || $balls_played_a>0 || $fours_a>0 || $sixes_a>0))
				{
					$a_bat_status = 'dnb';
				}
				
				if(count($is_player_exist)>0)// if player already exist
				{
					$update_id = $is_player_exist['id'];
					CricketPlayerMatchwiseStats::where('id',$update_id)->update(['balls_played'=>$balls_played_a,'totalruns'=>$totalruns_a,'fours'=>$fours_a,'sixes'=>$sixes_a,'out_as'=>$out_as_a,'strikerate'=>$strikerate_a,'fielder_id'=>$fielder_id_a,'bowled_id'=>$bowled_id_a,'bat_status'=>$a_bat_status]);
					
				}else
				{
					$this->insertBatsmenScore($user_id_a,$tournament_id,$match_id,$team_a_id,$match_type,$balls_played_a,$totalruns_a,$fours_a,$sixes_a,$out_as_a,$strikerate_a,$team_a_name,$player_name,$inning,$fielder_id_a,$bowled_id_a,$a_bat_status);
				}
				
				
			}
		}
		//Team a bowler Detail
		for($j=1;$j<=$a_bowler_count;$j++)
		{
			$bowler_id_a = !empty(Request::get('a_bowler_'.$j))?Request::get('a_bowler_'.$j):0;
			$bowler_name = User::where('id',$bowler_id_a)->pluck('name');
			$a_overs_bowled = Request::get('a_bowler_overs_'.$j);
			$a_wickets = (is_numeric(Request::get('a_bowler_wkts_'.$j)))?Request::get('a_bowler_wkts_'.$j):0;
			$a_runs_conceded = (is_numeric(Request::get('a_bowler_runs_'.$j)))?Request::get('a_bowler_runs_'.$j):0;
			$a_ecomony = Request::get('a_ecomony_'.$j);
			$a_wide = !empty(Request::get('a_bowler_wide_'.$j))?Request::get('a_bowler_wide_'.$j):0;
			$a_noball = !empty(Request::get('a_bowler_noball_'.$j))?Request::get('a_bowler_noball_'.$j):0;
			
			
			if($bowler_id_a>0 && ($a_overs_bowled>0 || $a_wickets>0 || $a_runs_conceded>0))
			{
				//check already bowler exists r not
				$is_bowler_exist = CricketPlayerMatchwiseStats::select()->where('match_id',$match_id)->where('team_id',$team_a_id)->where('user_id',$bowler_id_a)->where('innings',$inning)->get()->first();
				
				if(count($is_bowler_exist)>0) // if player already exist
				{
					$bowler_id = $is_bowler_exist['id'];
					CricketPlayerMatchwiseStats::where('id',$bowler_id)->update(['overs_bowled'=>$a_overs_bowled,'wickets'=>$a_wickets,'runs_conceded'=>$a_runs_conceded,'ecomony'=>$a_ecomony,'wides_bowl'=>$a_wide,'noballs_bowl'=>$a_noball]);
					
				}else
				{
					$this->insertBowlerScore($bowler_id_a,$tournament_id,$match_id,$team_a_id,$match_type,$a_overs_bowled,$a_wickets,$a_runs_conceded,$a_ecomony,$team_a_name,$bowler_name,$inning,$a_wide,$a_noball);
					
				}
				
			}
			
		}
		//Team b innings
		for($k=1;$k<=$team_b_player_count;$k++)//insert team a batsman score
		{
			$user_id_b = !empty(Request::get('b_player_'.$k))?Request::get('b_player_'.$k):0;
			$player_b_name = User::where('id',$user_id_b)->pluck('name');
			$totalruns_b = (is_numeric(Request::get('b_runs_'.$k)))?Request::get('b_runs_'.$k):0;
			$balls_played_b = (is_numeric(Request::get('b_balls_'.$k)))?Request::get('b_balls_'.$k):0;
			$fours_b = (is_numeric(Request::get('b_fours_'.$k)))?Request::get('b_fours_'.$k):0;
			$sixes_b = (is_numeric(Request::get('b_sixes_'.$k)))?Request::get('b_sixes_'.$k):0;
			$out_as_b = Request::get('b_outas_'.$k);
			$strikerate_b = Request::get('b_strik_rate_'.$k);
			$bowled_id_b = Request::get('b_bowled_'.$k);
			$fielder_id_b = Request::get('b_fielder_'.$k);
			if($user_id_b>0)
			{
				//check already player exists r not
				$is_b_player_exist = CricketPlayerMatchwiseStats::select()->where('match_id',$match_id)->where('team_id',$team_b_id)->where('user_id',$user_id_b)->where('innings',$inning)->get()->first();
				
				
				//bat status 
				$b_bat_status = 'notout';
				if($out_as_b!='')
				{
					$b_bat_status = 'out';
				}else if(!($totalruns_b>0 || $balls_played_b>0 || $fours_b>0 || $sixes_b>0))
				{
					$b_bat_status = 'dnb';
				}
				
				if(count($is_b_player_exist)>0)
				{
					$update_id = $is_b_player_exist['id'];
					CricketPlayerMatchwiseStats::where('id',$update_id)->update(['balls_played'=>$balls_played_b,'totalruns'=>$totalruns_b,'fours'=>$fours_b,'sixes'=>$sixes_b,'out_as'=>$out_as_b,'strikerate'=>$strikerate_b,'fielder_id'=>$fielder_id_b,'bowled_id'=>$bowled_id_b,'bat_status'=>$b_bat_status]);
				}else
				{
					$this->insertBatsmenScore($user_id_b,$tournament_id,$match_id,$team_b_id,$match_type,$balls_played_b,$totalruns_b,$fours_b,$sixes_b,$out_as_b,$strikerate_b,$team_b_name,$player_b_name,$inning,$fielder_id_b,$bowled_id_b,$b_bat_status);
				}
				
				
				
			}
		}
		//Team b bowler Detail
		for($l=1;$l<=$b_bowler_count;$l++)
		{
			$bowler_id_b = !empty(Request::get('b_bowler_'.$l))?Request::get('b_bowler_'.$l):0;
			$bowler_b_name = User::where('id',$bowler_id_b)->pluck('name');
			$b_overs_bowled = Request::get('b_bowler_overs_'.$l);
			$b_wickets = (is_numeric(Request::get('b_bowler_wkts_'.$l)))?Request::get('b_bowler_wkts_'.$l):0;
			$b_runs_conceded = (is_numeric(Request::get('b_bowler_runs_'.$l)))?Request::get('b_bowler_runs_'.$l):0;
			$b_ecomony = Request::get('b_ecomony_'.$l);
			$b_wide = !empty(Request::get('b_bowler_wide_'.$l))?Request::get('b_bowler_wide_'.$l):0;
			$b_noball = !empty(Request::get('b_bowler_noball_'.$l))?Request::get('b_bowler_noball_'.$l):0;
			if($bowler_id_b>0 && ($b_overs_bowled>0 || $b_wickets>0 || $b_runs_conceded>0))
			{
				//check already bowler exists r not
				$is_bowler_b_exist = CricketPlayerMatchwiseStats::select()->where('match_id',$match_id)->where('team_id',$team_b_id)->where('user_id',$bowler_id_b)->where('innings',$inning)->get()->first();
				
				if(count($is_bowler_b_exist)>0)
				{
					$bowler_id = $is_bowler_b_exist['id'];
					CricketPlayerMatchwiseStats::where('id',$bowler_id)->update(['overs_bowled'=>$b_overs_bowled,'wickets'=>$b_wickets,'runs_conceded'=>$b_runs_conceded,'ecomony'=>$b_ecomony,'wides_bowl'=>$b_wide,'noballs_bowl'=>$b_noball]);
					
				}else
				{
					$this->insertBowlerScore($bowler_id_b,$tournament_id,$match_id,$team_b_id,$match_type,$b_overs_bowled,$b_wickets,$b_runs_conceded,$b_ecomony,$team_b_name,$bowler_b_name,$inning,$b_wide,$b_noball);
				}
				
				
			}
			
		}
		//Team b bowling
		
		//Fall of Wikets for Team a
		$team_a_fallofwkt_count = Request::get('a_fall_of_count');
		$team_a_array = array();
		for($m=1;$m<=$team_a_fallofwkt_count;$m++)
		{
			$wkt_a_at = (is_numeric(Request::get('a_wicket_'.$m)))?Request::get('a_wicket_'.$m):0;
			$player_a_id = Request::get('a_wkt_player_'.$m);
			$at_runs_a = (is_numeric(Request::get('a_at_runs_'.$m)))?Request::get('a_at_runs_'.$m):0;
			$at_over_a = Request::get('a_at_over_'.$m);
			
			if($player_a_id>0)
			{
				$team_a_array[] = array('wicket'=>$wkt_a_at,'batsman'=>$player_a_id,'score'=>$at_runs_a,'over'=>$at_over_a);
			}
			
		}
		//team a extras
		$team_a_wide = !empty(Request::get('team_a_wide'))?Request::get('team_a_wide'):0;
		$team_a_noball = !empty(Request::get('team_a_noball'))?Request::get('team_a_noball'):0;
		$team_a_legbye = !empty(Request::get('team_a_legbye'))?Request::get('team_a_legbye'):0;
		$team_a_bye = !empty(Request::get('team_a_bye'))?Request::get('team_a_bye'):0;
		$team_a_others = !empty(Request::get('team_a_others'))?Request::get('team_a_others'):0;
		$team_a_extras_array = array('wide'=>$team_a_wide,'noball'=>$team_a_noball,'legbye'=>$team_a_legbye,'bye'=>$team_a_bye,'others'=>$team_a_others);

		//team a scores
		$team_a_fst_ing_score = !empty(Request::get('fst_a_score'))?Request::get('fst_a_score'):NULL;
		$team_a_fst_ing_wkt = !empty(Request::get('fst_a_wkt'))?Request::get('fst_a_wkt'):NULL;
		$team_a_fst_ing_overs = !empty(Request::get('fst_a_overs'))?Request::get('fst_a_overs'):NULL;
		$team_a_scnd_ing_score = !empty(Request::get('scnd_a_score'))?Request::get('scnd_a_score'):NULL;
		$team_a_scnd_ing_wkt = !empty(Request::get('scnd_a_wkt'))?Request::get('scnd_a_wkt'):NULL;
		$team_a_scnd_ing_overs = !empty(Request::get('scnd_a_overs'))?Request::get('scnd_a_overs'):NULL;
		
		
		$team_a_score = array('fst_ing_score'=>$team_a_fst_ing_score,'scnd_ing_score'=>$team_a_scnd_ing_score,'fst_ing_wkt'=>$team_a_fst_ing_wkt,'scnd_ing_wkt'=>$team_a_scnd_ing_wkt,'fst_ing_overs'=>$team_a_fst_ing_overs,'scnd_ing_overs'=>$team_a_scnd_ing_overs);
		
		
		//team b scores
		$team_b_fst_ing_score = !empty(Request::get('fst_b_score'))?Request::get('fst_b_score'):NULL;
		$team_b_fst_ing_wkt = !empty(Request::get('fst_b_wkt'))?Request::get('fst_b_wkt'):NULL;
		$team_b_fst_ing_overs = !empty(Request::get('fst_b_overs'))?Request::get('fst_b_overs'):NULL;
		$team_b_scnd_ing_score = !empty(Request::get('scnd_b_score'))?Request::get('scnd_b_score'):NULL;
		$team_b_scnd_ing_wkt = !empty(Request::get('scnd_b_wkt'))?Request::get('scnd_b_wkt'):NULL;
		$team_b_scnd_ing_overs = !empty(Request::get('scnd_b_overs'))?Request::get('scnd_b_overs'):NULL;
		
		
		//team b extras
		$team_b_wide = !empty(Request::get('team_b_wide'))?Request::get('team_b_wide'):0;
		$team_b_noball = !empty(Request::get('team_b_noball'))?Request::get('team_b_noball'):0;
		$team_b_legbye = !empty(Request::get('team_b_legbye'))?Request::get('team_b_legbye'):0;
		$team_b_bye = !empty(Request::get('team_b_bye'))?Request::get('team_b_bye'):0;
		$team_b_others = !empty(Request::get('team_b_others'))?Request::get('team_b_others'):0;
		$team_b_extras_array = array('wide'=>$team_b_wide,'noball'=>$team_b_noball,'legbye'=>$team_b_legbye,'bye'=>$team_b_bye,'others'=>$team_b_others);
		
		$fallOfCount_a[$team_a_id][$inning] = $team_a_array+$team_a_extras_array;//indvidual team fall of count

		$team_a_two_ings_score[$team_a_id] = $team_a_score; //team a toral score with overs wikets 
		
		$team_a_match_details = array_replace_recursive($fallOfCount_a,$team_a_two_ings_score) ;// merge fall of wkts, match score details
				
		$decode_json=array();
		//get exists match details
		$get_match_details = MatchSchedule::where('id',$match_id)->pluck('match_details');
		if($get_match_details!='')
		$decode_json = json_decode($get_match_details,true);
		
		
		//Fall of Wikets for Team b
		$team_b_fallofwkt_count = Request::get('b_fall_of_count');
		$team_b_array = array();
		for($n=1;$n<=$team_b_fallofwkt_count;$n++)
		{
			$wkt_b_at = (is_numeric(Request::get('b_wicket_'.$n)))?Request::get('b_wicket_'.$n):0;
			$player_b_id = Request::get('b_wkt_player_'.$n);
			$at_runs_b = (is_numeric(Request::get('b_at_runs_'.$n)))?Request::get('b_at_runs_'.$n):0;
			$at_over_b = Request::get('b_at_over_'.$n);
			if($player_b_id>0)
			{
				$team_b_array[] = array('wicket'=>$wkt_b_at,'batsman'=>$player_b_id,'score'=>$at_runs_b,'over'=>$at_over_b);
			}
		}
		
		$team_b_score = array('fst_ing_score'=>$team_b_fst_ing_score,'scnd_ing_score'=>$team_b_scnd_ing_score,'fst_ing_wkt'=>$team_b_fst_ing_wkt,'scnd_ing_wkt'=>$team_b_scnd_ing_wkt,'fst_ing_overs'=>$team_b_fst_ing_overs,'scnd_ing_overs'=>$team_b_scnd_ing_overs);
		
		$fallOfCount_b[$team_b_id][$inning] = $team_b_array+$team_b_extras_array;//indvidual team fall of count
		
		$team_b_two_ings_score[$team_b_id] = $team_b_score; //team a toral score with overs wikets 
		
		$team_b_match_details = array_replace_recursive($fallOfCount_b,$team_b_two_ings_score); // merge fall of wkts, match score details
		
		$match_details_array = $team_a_match_details+$team_b_match_details;
		
		$final_match_details = array_replace_recursive($decode_json,$match_details_array);

		$json_match_details_array = json_encode($final_match_details);
		
		$is_tie=0;
		if($match_result=='tie')
				$is_tie=1;
			
		//get previous scorecard status data
		$scorecardDetails = MatchSchedule::where('id',$match_id)->pluck('score_added_by');
		$decode_scorecard_data = json_decode($scorecardDetails,true);
		
		$modified_users = !empty($decode_scorecard_data['modified_users'])?$decode_scorecard_data['modified_users']:'';
		
		$modified_users = $modified_users.','.$loginUserId;//scorecard changed users
		
		$added_by = !empty($decode_scorecard_data['added_by'])?$decode_scorecard_data['added_by']:$loginUserId;
		
		//score card approval process
		$score_status = array('added_by'=>$added_by,'active_user'=>$loginUserId,'modified_users'=>$modified_users,'rejected_note'=>'');
		
		$json_score_status = json_encode($score_status);	
                
                //update match details col  && winner id in match schedule table
                $matchScheduleDetails = MatchSchedule::where('id',$match_id)->first();
                if(count($matchScheduleDetails)) {
                    $looser_team_id = NULL;
                    if($is_tie==0) {
                        
                        if(isset($winner_team_id)) {
                            if($winner_team_id==$matchScheduleDetails['a_id']) {
                                $looser_team_id=$matchScheduleDetails['b_id'];
                            }else{
                                $looser_team_id=$matchScheduleDetails['a_id'];
                            }
                        }
                        
                    }
                    
                    if(!empty($matchScheduleDetails['tournament_id'])) {
//                        dd($winner_team_id.'<>'.$looser_team_id);
                            $tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
                            if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {
                                MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'match_status'=>'completed',
                                                    'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                                    'is_tied'=>$is_tie,'score_added_by'=>$json_score_status]);
//                                Helper::printQueries();
                                
                                if(!empty($matchScheduleDetails['tournament_round_number'])) {
                                        $this->updateBracketDetails($matchScheduleDetails,$tournamentDetails);
                                }
                                $sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
                                $this->insertPlayerStatistics($sportName,$match_id);
                            }

                    }else {
                        MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_details_array,'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,'is_tied'=>$is_tie,'score_added_by'=>$json_score_status]);
                    } 
                }
		
		//if($match_result!='')
			//return redirect()->route('match/scorecard/view', [$match_id])->with('status', trans('message.scorecard.scorecardmsg'));
		
		//return redirect()->back()->with('status', trans('message.scorecard.scorecardmsg'));
		return Response()->json( array('success' => trans('message.scorecard.scorecardmsg')) );
	}
	//function to insert batsmen score
	public function insertBatsmenScore($user_id,$tournament_id,$match_id,$team_id,$match_type,$balls_played,$totalruns,$fours,$sixes,$out_as,$strikerate,$team_name,$player_name,$innings,$fielder_id,$bowled_id,$bat_status)
	{
		$model = new CricketPlayerMatchwiseStats();
		$model->user_id = $user_id;
		$model->tournament_id = $tournament_id;
		$model->match_id = $match_id;
		$model->team_id = $team_id;
		$model->match_type = $match_type;
		$model->balls_played = $balls_played;
		$model->totalruns = $totalruns;
		$model->fours = $fours;
		$model->sixes = $sixes;
		$model->out_as = $out_as;
		$model->strikerate = $strikerate;
		$model->team_name = $team_name;
		$model->player_name = $player_name;
		$model->innings = $innings;
		$model->fielder_id = $fielder_id;
		$model->bowled_id = $bowled_id;
		$model->bat_status = $bat_status;
		$model->save();
	}
	
	//insert bowler score
	public function insertBowlerScore($bowler_id,$tournament_id,$match_id,$team_id,$match_type,$overs_bowled,$wickets,$runs_conceded,$ecomony,$team_name,$bowler_name,$inning,$wide,$noball)
	{
		$bowler_model = new CricketPlayerMatchwiseStats();
		$bowler_model->user_id = $bowler_id;
		$bowler_model->tournament_id = $tournament_id;
		$bowler_model->match_id = $match_id;
		$bowler_model->team_id = $team_id;
		$bowler_model->match_type = $match_type;
		$bowler_model->overs_bowled = $overs_bowled;
		$bowler_model->wickets = $wickets;
		$bowler_model->runs_conceded = $runs_conceded;
		$bowler_model->ecomony = $ecomony;
		$bowler_model->team_name = $team_name;
		$bowler_model->player_name = $bowler_name;
		$bowler_model->innings = $inning;
		$bowler_model->wides_bowl = $wide;
		$bowler_model->noballs_bowl = $noball;
		$bowler_model->save();
	}
	
	//function to insert or update batsmen statistics
	public function cricketBatsmenStatistic($user_id,$match_type,$inning)
	{
		//check already record is exists or not
		$cricket_statistics_array = array();
		$cricket_statistics = CricketStatistic::select()->where('user_id',$user_id)->where('match_type',$match_type)->where('innings',$inning)->get();
		
		$batsman_detais = CricketPlayerMatchwiseStats::selectRaw('count(DISTINCT(match_id)) as match_count')->selectRaw('count(innings) as inningscount')->selectRaw('sum(totalruns) as totalruns')->selectRaw('sum(balls_played) as balls_played')->selectRaw('sum(fifties) as fifties')->selectRaw('sum(hundreds) as hundreds')->selectRaw('sum(fours) as fours')->selectRaw('sum(sixes) as sixes')->where('user_id',$user_id)->where('match_type',$match_type)->where('innings',$inning)->groupBy('user_id')->get();
		
		$innings_bat = (!empty($batsman_detais[0]['inningscount']))?$batsman_detais[0]['inningscount']:0;
		$totalruns = (!empty($batsman_detais[0]['totalruns']))?$batsman_detais[0]['totalruns']:0;
		$totalballs = (!empty($batsman_detais[0]['balls_played']))?$batsman_detais[0]['balls_played']:0;
		$fours = (!empty($batsman_detais[0]['fours']))?$batsman_detais[0]['fours']:0;
		$sixes = (!empty($batsman_detais[0]['sixes']))?$batsman_detais[0]['sixes']:0;
		$match_count = (!empty($batsman_detais[0]['match_count']))?$batsman_detais[0]['match_count']:0;
		
		if(count($cricket_statistics)>0)
		{
			$average_bat='';
			if($totalruns>0 && $innings_bat>0)
			{
				$average_bat = $totalruns/$innings_bat; //total runs / innings bat
			}
			
			$strikerate='';
			if($totalballs>0)
			{
				$strikerate = ($totalruns/$totalballs)*100;//strikerate calculation [total runs/total ball*100]
			}
			CricketStatistic::where('user_id',$user_id)->where('match_type',$match_type)->update(['matches'=>$match_count,'innings_bat'=>$innings_bat,'totalruns'=>$totalruns,'totalballs'=>$totalballs,'fours'=>$fours,'sixes'=>$sixes,'strikerate'=>$strikerate,'average_bat'=>$average_bat]);
		}
		else
		{
			$matchcount = (!empty($batsman_detais[0]['match_count']))?$batsman_detais[0]['match_count']:0;
			$innings_bat = (!empty($batsman_detais[0]['inningscount']))?$batsman_detais[0]['inningscount']:0;
			$objStatistics = new CricketStatistic();
			$objStatistics->user_id = $user_id;
			$objStatistics->match_type = $match_type;
			$objStatistics->matches = $matchcount;
			$objStatistics->innings_bat = $innings_bat;
			$objStatistics->totalruns = $totalruns;
			$objStatistics->totalballs = $totalballs;
			$objStatistics->fours = $fours;
			$objStatistics->sixes = $sixes;
			$objStatistics->innings = $inning;
			$strikerate='';
			if($totalballs>0)
			{
				$strikerate = ($totalruns/$totalballs)*100;//strikerate calculation [total runs/total ball*100]
			}
			$average_bat = $totalruns; //total runs / innings bat
			$objStatistics->strikerate = $strikerate;
			$objStatistics->save();
		}
	}	
	//cricket bowler statistics
	public function cricketBowlerStatistic($bowler_id,$match_type,$inning)
	{
		//check already record is exists or not
		$cricket_statistics_array = array();
		$bowler_cricket_statistics = CricketStatistic::select()->where('user_id',$bowler_id)->where('match_type',$match_type)->where('innings',$inning)->get();
		
		$bowler_detais = CricketPlayerMatchwiseStats::selectRaw('count(DISTINCT(match_id)) as match_count')->selectRaw('count(innings) as inningscount')->selectRaw('sum(wickets) as wickets')->selectRaw('sum(runs_conceded) as runs_conceded')->selectRaw('sum(overs_bowled) as overs_bowled')->where('user_id',$bowler_id)->where('match_type',$match_type)->where('innings',$inning)->groupBy('user_id')->get();
		
		$innings_bowl = (!empty($bowler_detais[0]['inningscount']))?$bowler_detais[0]['inningscount']:0;
		$wickets = (!empty($bowler_detais[0]['wickets']))?$bowler_detais[0]['wickets']:0;
		$runs_conceded = (!empty($bowler_detais[0]['runs_conceded']))?$bowler_detais[0]['runs_conceded']:0;
		$overs_bowled = (!empty($bowler_detais[0]['overs_bowled']))?$bowler_detais[0]['overs_bowled']:0;
		$match_count = (!empty($bowler_detais[0]['match_count']))?$bowler_detais[0]['match_count']:0;
		if(count($bowler_cricket_statistics)>0)
		{
			
			$ecomony  = '';
			if($overs_bowled>0)
			{
				$ecomony = $runs_conceded/$overs_bowled;
			}
			$average_bowl ='';
			if($wickets>0)
			{
				$average_bowl = $runs_conceded/$wickets;
			}
			CricketStatistic::where('user_id',$bowler_id)->where('match_type',$match_type)->update(['matches'=>$match_count,'innings_bowl'=>$innings_bowl,'wickets'=>$wickets,'runs_conceded'=>$runs_conceded,'overs_bowled'=>$overs_bowled,'ecomony'=>$ecomony,'average_bowl'=>$average_bowl]);
		}
		else
		{
			$matchcount = (!empty($bowler_detais[0]['match_count']))?$bowler_detais[0]['match_count']:0;;
			$innings_bowl = (!empty($bowler_detais[0]['inningscount']))?$bowler_detais[0]['inningscount']:0;;
			
			$objBowlerStatistics = new CricketStatistic();
			$objBowlerStatistics->user_id = $bowler_id;
			$objBowlerStatistics->match_type = $match_type;
			$objBowlerStatistics->matches = $matchcount;
			$objBowlerStatistics->innings_bowl = $innings_bowl;
			$objBowlerStatistics->wickets = $wickets;
			$objBowlerStatistics->runs_conceded = $runs_conceded;
			$objBowlerStatistics->overs_bowled = $overs_bowled;
			$objBowlerStatistics->innings = $inning;
			$ecomony='';
			if($overs_bowled>0)
			{
				$ecomony = $runs_conceded/$overs_bowled;//economy calculation [total runs/total overs]
			}
			$average_bowl ='';
			if($wickets>0)
			{
				$average_bowl = $runs_conceded/$wickets;//[total runs/total wickets]
			}
			$objBowlerStatistics->ecomony = $ecomony;
			$objBowlerStatistics->save();
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
					$get_a_player_ids = $get_a_player_ids.','.$player_id;
					MatchSchedule::where('id',$match_id)->where('a_id',$team_id)->update(['player_a_ids'=>$get_a_player_ids]);
				}else
				{
					$get_b_player_ids = MatchSchedule::where('id',$match_id)->where('b_id',$team_id)->pluck('player_b_ids');//get team a players
					$get_b_player_ids = $get_b_player_ids.','.$player_id;
					MatchSchedule::where('id',$match_id)->where('b_id',$team_id)->update(['player_b_ids'=>$get_b_player_ids]);
				}
				
			}
			return Response()->json( array('success' => trans('message.sports.teamplayer')) );
		}else
		{
			return Response()->json( array('failure' => trans('message.sports.teamvalidation')) );
		}
	}
	// function to insert soccer score card
	public function soccerScoreCard($match_data,$is_from_view=0)
	{
		$loginUserId = Auth::user()->id;
		$team_a_players = array();
		$team_b_players = array();
		$team_a_id = $match_data[0]['a_id'];
		$team_b_id = $match_data[0]['b_id'];
		$team_a_playerids = explode(',',$match_data[0]['player_a_ids']);
		$team_b_playerids = explode(',',$match_data[0]['player_b_ids']);
		
		//get soccer scores for team a
		$team_a_soccer_scores = SoccerPlayerMatchwiseStats::select()->where('match_id',$match_data[0]['id'])->where('team_id',$team_a_id)->get();

		$team_a_soccer_scores_array = array();
		if(count($team_a_soccer_scores)>0)
		{
			$team_a_soccer_scores_array = $team_a_soccer_scores->toArray();
		}
		
		//get soccer scores for team b
		$team_b_soccer_scores = SoccerPlayerMatchwiseStats::select()->where('match_id',$match_data[0]['id'])->where('team_id',$team_b_id)->get();
		$team_b_soccer_scores_array = array();
		if(count($team_b_soccer_scores)>0)
		{
			$team_b_soccer_scores_array = $team_b_soccer_scores->toArray();
		}
		
		//get player names
		$a_team_players = User::select()->whereIn('id',$team_a_playerids)->get();
		$b_team_players = User::select()->whereIn('id',$team_b_playerids)->get();
		
		//get team names
		$team_a_name = Team::where('id',$team_a_id)->pluck('name');
		$team_b_name = Team::where('id',$team_b_id)->pluck('name');
		
		if(!empty($a_team_players))
			$team_a_players = $a_team_players->toArray();
		if(!empty($b_team_players))
			$team_b_players = $b_team_players->toArray();
		$team_a = array();
		$team_b = array();
	
		//get team a players
		foreach($team_a_players as $team_a_player)
		{		
			$team_a[$team_a_player['id']] = $team_a_player['name'];
		}
		
		//get team b players
		foreach($team_b_players as $team_b_player)
		{		
			$team_b[$team_b_player['id']] = $team_b_player['name'];
		}
		
		$team_a_logo = Photo::select()->where('imageable_id', $match_data[0]['a_id'])->where('imageable_type',config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
		$team_b_logo = Photo::select()->where('imageable_id', $match_data[0]['b_id'])->where('imageable_type',config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first();//get user logo
		
		$team_a_count = count($team_a);
		$team_b_count = count($team_b);
		
		
		
		//get match details fall of wickets
		$team_wise_score_details = array();
		$match_details = $match_data[0]['match_details'];
		if($match_details!='' && $match_details!=NULL)
		{
			$json_decode_array = json_decode($match_details,true);
			foreach($json_decode_array as $key => $array)
			{
				$team_wise_score_details[$key] = $array;
			}
		}
		$team_a_goals=0;
		$team_b_goals=0;
		//team a goals
		if(!empty($team_wise_score_details[$match_data[0]['a_id']]['goals']) && $team_wise_score_details[$match_data[0]['a_id']]['goals']!=null)
		{
			$team_a_goals = $team_wise_score_details[$match_data[0]['a_id']]['goals'];
		}
		//team b goals
		if(!empty($team_wise_score_details[$match_data[0]['b_id']]['goals']) && $team_wise_score_details[$match_data[0]['b_id']]['goals']!=null)
		{
			$team_b_goals = $team_wise_score_details[$match_data[0]['b_id']]['goals'];
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
		
		
		
		if($is_from_view==1 || (!empty($score_status_array['added_by']) && $score_status_array['added_by']!=$loginUserId) || $match_data[0]['match_status']=='completed' || $match_data[0]['scoring_status']=='approval_pending' || $match_data[0]['scoring_status']=='approved')//soccer score view only
		{
			$player_name_array = array();
			$users = User::select('id', 'name')->get()->toArray(); //get player names
            foreach ($users as $user) {
                $player_name_array[$user['id']] = $user['name']; //get team names
            }
			return view('scorecards.soccerscorecardview',array('team_a'=>[''=>'Select Player']+$team_a,'team_b'=>[''=>'Select Player']+$team_b,'match_data'=>$match_data,'team_a_name'=>$team_a_name,'team_b_name'=>$team_b_name,'team_a_soccer_scores_array'=>$team_a_soccer_scores_array,'team_b_soccer_scores_array'=>$team_b_soccer_scores_array,'team_a_count'=>$team_a_count,'team_b_count'=>$team_b_count,'team_a_logo'=>$team_a_logo,'team_b_logo'=>$team_b_logo,'team_a_goals'=>$team_a_goals,'team_b_goals'=>$team_b_goals,'player_name_array'=> $player_name_array,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
		}else //soccer score view and edit
		{
			return view('scorecards.soccerscorecard',array('team_a'=>[''=>'Select Player']+$team_a,'team_b'=>[''=>'Select Player']+$team_b,'match_data'=>$match_data,'team_a_name'=>$team_a_name,'team_b_name'=>$team_b_name,'team_a_soccer_scores_array'=>$team_a_soccer_scores_array,'team_b_soccer_scores_array'=>$team_b_soccer_scores_array,'team_a_count'=>$team_a_count,'team_b_count'=>$team_b_count,'team_a_logo'=>$team_a_logo,'team_b_logo'=>$team_b_logo,'team_a_goals'=>$team_a_goals,'team_b_goals'=>$team_b_goals,'score_status_array'=>$score_status_array,'loginUserId'=>$loginUserId,'rej_note_str'=>$rej_note_str));
		}
		
	}
	//function to save soccer score card
	public function insertSoccerScoreCard()
	{
		$request = Request::all();

		$team_a_count = Request::get('team_a_count');
		$team_b_count = Request::get('team_b_count');
		$tournament_id = !empty(Request::get('tournament_id'))?Request::get('tournament_id'):NULL;
		$match_id = !empty(Request::get('match_id'))?Request::get('match_id'):NULL;
		$team_a_id = !empty(Request::get('team_a_id'))?Request::get('team_a_id'):NULL;
		$team_b_id = !empty(Request::get('team_b_id'))?Request::get('team_b_id'):NULL;
		$team_a_name = !empty(Request::get('team_a_name'))?Request::get('team_a_name'):NULL;
		$team_b_name = !empty(Request::get('team_b_name'))?Request::get('team_b_name'):NULL;
		$winner_team_id = !empty(Request::get('winner_team_id'))?Request::get('winner_team_id'):NULL;//winner_id
		
		$match_result = !empty(Request::get('match_result'))?Request::get('match_result'):NULL; // match result win or tie
		$team_a_goal_count = 0;
		
		//delete team players
		$delete_ids = !empty(Request::get('delted_ids'))?Request::get('delted_ids'):NULL;
		$deleted_id_array=array();
		if($delete_ids!='')
		{
			$deletedIds = trim($delete_ids,',');
			$deleted_id_array = explode(',',$deletedIds);
		}

		if(count($deleted_id_array)>0) //delete selected players
		{
			foreach($deleted_id_array as $primary_id)
			{
				SoccerPlayerMatchwiseStats::find($primary_id)->delete();//delete player id
			}
			
		}
		
		for($i=1;$i<=$team_a_count;$i++)//insert team a player goals
		{
			$user_id_a = !empty(Request::get('a_player_'.$i))?Request::get('a_player_'.$i):0;
			
			if($user_id_a>0)
			{
				$a_player_name = User::where('id',$user_id_a)->pluck('name');
				$a_yellow_card = !empty(Request::get('a_yellow_card_'.$i))?Request::get('a_yellow_card_'.$i):NULL;
				$a_red_card = !empty(Request::get('a_red_card_'.$i))?Request::get('a_red_card_'.$i):NULL;
				$a_goal = !empty(Request::get('a_goal_'.$i))?Request::get('a_goal_'.$i):NULL;
				
				$hid_player_id = !empty(Request::get('hid_a_player_'.$i))?Request::get('hid_a_player_'.$i):0;
				$a_primary_id = !empty(Request::get('hid_a_primary_id_'.$i))?Request::get('hid_a_primary_id_'.$i):0;
				if($hid_player_id>0 && $hid_player_id!=$user_id_a && $a_primary_id>0) // if prev player and current player is not same delete old player
				{
					SoccerPlayerMatchwiseStats::find($a_primary_id)->delete();//delete player id
				}
				
				//check already score is entered or not
				$a_is_score_exist = $this->isScoreEntered($user_id_a,$match_id,$team_a_id);
				
				if(!$a_is_score_exist)
				{
					//save soccer score card details
					$this->insertSoccerScore($user_id_a,$tournament_id,$match_id,$team_a_id,$a_player_name,$team_a_name,$a_yellow_card,$a_red_card,$a_goal);
					
				}else
				{
					//update scores if already exist
					$this->updateSoccerScore($user_id_a,$match_id,$team_a_id,$a_player_name,$a_yellow_card,$a_red_card,$a_goal);
				}
				
				
				$team_a_goal_count = $team_a_goal_count+$a_goal;//to calculate team goal count by adding individual player goals
			}
		}
		$team_b_goal_count =0;
		for($i=1;$i<=$team_b_count;$i++)//insert team b player goals
		{
			$user_id_b = Request::get('b_player_'.$i);
			
			if($user_id_b>0)
			{
				$b_player_name = User::where('id',$user_id_b)->pluck('name');
				$b_yellow_card = !empty(Request::get('b_yellow_card_'.$i))?Request::get('b_yellow_card_'.$i):NULL;
				$b_red_card = !empty(Request::get('b_red_card_'.$i))?Request::get('b_red_card_'.$i):NULL;
				$b_goal = !empty(Request::get('b_goal_'.$i))?Request::get('b_goal_'.$i):NULL;
				
				$hid_b_player_id = !empty(Request::get('hid_b_player_'.$i))?Request::get('hid_b_player_'.$i):0;
				$b_primary_id = !empty(Request::get('hid_b_primary_id_'.$i))?Request::get('hid_b_primary_id_'.$i):0;
				if($hid_b_player_id>0 && $hid_b_player_id!=$user_id_b && $b_primary_id>0) // if prev player and current player is not same delete old player
				{
					SoccerPlayerMatchwiseStats::find($b_primary_id)->delete();//delete player id
				}
				
				//check already score is entered or not
				$b_is_score_exist = $this->isScoreEntered($user_id_b,$match_id,$team_b_id);
				
				if(!$b_is_score_exist)
				{
					//save soccer score card details
					$this->insertSoccerScore($user_id_b,$tournament_id,$match_id,$team_b_id,$b_player_name,$team_b_name,$b_yellow_card,$b_red_card,$b_goal);
				}
				else
				{
					//update scores if already exist
					$this->updateSoccerScore($user_id_b,$match_id,$team_b_id,$b_player_name,$b_yellow_card,$b_red_card,$b_goal);
				}
				
				$team_b_goal_count = $team_b_goal_count+$b_goal;//to calculate team goal count by adding individual player goals
			}
		}
		
		//insert team goals in json format
		$team_a_score[$team_a_id] = array('goals'=>$team_a_goal_count); //team a goals
		$team_b_score[$team_b_id] = array('goals'=>$team_b_goal_count);//team b goals
		
		$two_teams_scores = array_replace_recursive($team_a_score,$team_b_score);// merge two teams goals
		
		
		$json_match_score_array = json_encode($two_teams_scores); //convert json format
		
		
		//get previous scorecard status data
		$loginUserId = Auth::user()->id;
		$scorecardDetails = MatchSchedule::where('id',$match_id)->pluck('score_added_by');
		$decode_scorecard_data = json_decode($scorecardDetails,true);
		
		$modified_users = !empty($decode_scorecard_data['modified_users'])?$decode_scorecard_data['modified_users']:'';
		
		$modified_users = $modified_users.','.$loginUserId;//scorecard changed users
		
		$added_by = !empty($decode_scorecard_data['added_by'])?$decode_scorecard_data['added_by']:$loginUserId;
		
		//score card approval process
		$score_status = array('added_by'=>$added_by,'active_user'=>$loginUserId,'modified_users'=>$modified_users,'rejected_note'=>'');
		
		$json_score_status = json_encode($score_status);
		
		$is_tied = 0;
		if($match_result=='tie')
			$is_tied = 1;
		
		//update winner id in match schedule table
                $matchScheduleDetails = MatchSchedule::where('id',$match_id)->first();
                if(count($matchScheduleDetails)) {
                    $looser_team_id = NULL;
                    if($is_tied==0) {
                        
                        if(isset($winner_team_id)) {
                            if($winner_team_id==$matchScheduleDetails['a_id']) {
                                $looser_team_id=$matchScheduleDetails['b_id'];
                            }else{
                                $looser_team_id=$matchScheduleDetails['a_id'];
                            }
                        }
                        
                    }
                    
                    if(!empty($matchScheduleDetails['tournament_id'])) {
//                        dd($winner_team_id.'<>'.$looser_team_id);
                            $tournamentDetails = Tournaments::where('id', '=', $matchScheduleDetails['tournament_id'])->first();
                            if(Helper::isTournamentOwner($tournamentDetails['manager_id'],$tournamentDetails['tournament_parent_id'])) {
                                MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_score_array,'match_status'=>'completed',
                                                    'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id,
                                                    'is_tied'=>$is_tied,'score_added_by'=>$json_score_status]);
//                                Helper::printQueries();
                                
                                if(!empty($matchScheduleDetails['tournament_round_number'])) {
                                        $this->updateBracketDetails($matchScheduleDetails,$tournamentDetails);
                                }
                                $sportName = Sport::where('id',$matchScheduleDetails['sports_id'])->pluck('sports_name');
                                $this->insertPlayerStatistics($sportName,$match_id);
                            }

                    }else {
                        MatchSchedule::where('id',$match_id)->update(['match_details'=>$json_match_score_array,'winner_id'=>$winner_team_id ,'looser_id'=>$looser_team_id, 
                                                                    'is_tied'=>$is_tied,'score_added_by'=>$json_score_status]);
                    } 
                }
		//MatchSchedule::where('id',$match_id)->update(['winner_id'=>$winner_team_id,'match_details'=>$json_match_score_array,'is_tied'=>$is_tied,'score_added_by'=>$json_score_status]);
		
		//if($match_result!='')
			//return redirect()->route('match/scorecard/view', [$match_id])->with('status', trans('message.scorecard.scorecardmsg'));
		return redirect()->back()->with('status',trans('message.scorecard.scorecardmsg') );
	}
	public function insertSoccerScore($user_id,$tournament_id,$match_id,$team_id,$player_name,$team_name,$yellow_card_count,$red_card_count,$goal_count)
	{
		$soccer_model = new SoccerPlayerMatchwiseStats();
		$soccer_model->user_id = $user_id;
		$soccer_model->tournament_id = $tournament_id;
		$soccer_model->match_id = $match_id;
		$soccer_model->team_id = $team_id;
		$soccer_model->player_name = $player_name;
		$soccer_model->team_name = $team_name;
		$soccer_model->yellow_cards = $yellow_card_count;
		$soccer_model->red_cards = $red_card_count;
		$soccer_model->goals_scored = $goal_count;
		$soccer_model->save();
	}
	//function to update player scores if already exist
	public function updateSoccerScore($user_id,$match_id,$team_id,$player_name,$yellow_card_count,$red_card_count,$goal_count)
	{
		SoccerPlayerMatchwiseStats::where('user_id',$user_id)->where('match_id',$match_id)->where('team_id',$team_id)->update(['user_id'=>$user_id,'player_name'=>$player_name,'yellow_cards'=>$yellow_card_count,'red_cards'=>$red_card_count,'goals_scored'=>$goal_count]);
		//SoccerStatistic::where('user_id',$user_id)->update(['yellow_cards'=>$yellow_card_count,'red_cards'=>$red_card_count,'goals_scored'=>$goal_count]);
	}
	//soccer statistics function player wise
	public function soccerStatistics($user_id)
	{
		//check already player has record or not
		$user_soccer_details = SoccerStatistic::select()->where('user_id',$user_id)->get();
		
		$soccer_details = SoccerPlayerMatchwiseStats::selectRaw('count(match_id) as match_count')->selectRaw('sum(yellow_cards) as yellow_cards')->selectRaw('sum(red_cards) as red_cards')->selectRaw('sum(goals_scored) as goals_scored')->where('user_id',$user_id)->groupBy('user_id')->get();
		$yellow_card_cnt = (!empty($soccer_details[0]['yellow_cards']))?$soccer_details[0]['yellow_cards']:0;
		$red_card_cnt = (!empty($soccer_details[0]['red_cards']))?$soccer_details[0]['red_cards']:0;
		$goals_cnt = (!empty($soccer_details[0]['goals_scored']))?$soccer_details[0]['goals_scored']:0;
		if(count($user_soccer_details)>0)
		{
			$match_count = (!empty($soccer_details[0]['match_count']))?$soccer_details[0]['match_count']:0;
			SoccerStatistic::where('user_id',$user_id)->update(['matches'=>$match_count,'yellow_cards'=>$yellow_card_cnt,'red_cards'=>$red_card_cnt,'goals_scored'=>$goals_cnt]);
		}else
		{
			$soccer_statistics = new SoccerStatistic();
			$soccer_statistics->user_id = $user_id;
			$soccer_statistics->matches = 1;
			$soccer_statistics->yellow_cards = $yellow_card_cnt;
			$soccer_statistics->red_cards = $red_card_cnt;
			$soccer_statistics->goals_scored = $goals_cnt;
			$soccer_statistics->save(); 
		}
	}
	//check is score enter for match
	public function isScoreEntered($user_id,$match_id,$team_id)
	{
		$data_array = SoccerPlayerMatchwiseStats::where('user_id',$user_id)->where('match_id',$match_id)->where('team_id',$team_id)->first();
		if(count($data_array)>0)
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
			if(!empty($sportsDetails))
			{
				$sport_name = $sportsDetails[0]['sports_name'];
				if(strtolower($sport_name)==strtolower('Tennis'))//if match is related to tennis
				{
					return  $this->tennisOrTableTennisScoreCard($match_data,$match='Tennis',$is_from_view=1);
				}else if(strtolower($sport_name)==strtolower('Table Tennis'))//if match is related to table tennis
				{
					return $this->tennisOrTableTennisScoreCard($match_data,$match='Table Tennis',$is_from_view=1);
				}else if(strtolower($sport_name)==strtolower('Cricket'))
				{
					return $this->cricketScoreCard($match_data,$is_from_view=1);
				}
				else if(strtolower($sport_name)==strtolower('soccer'))
				{
					return $this->soccerScoreCard($match_data,$is_from_view=1);
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
		
		//if status is approved update match status as completed
		if($status == 'approved')
		{
			MatchSchedule::where('id',$match_id)->update(['match_status'=>'completed']);
			// call function to insert player wise match details in statistics table
			if($sport_name!='')
				$this->insertPlayerStatistics($sport_name,$match_id);
		}
			
		
		//return Response::json($results);
		return Response()->json( array('status' => 'success','msg' => trans('message.scorecard.scorecardstatus')) );
	}
	
	//function to call sport statistics
	public function insertPlayerStatistics($sport_name,$match_id)
	{
		$match_data = MatchSchedule::where('id',$match_id)->get(['winner_id','match_type','match_details']);
		$match_type = !empty($match_data[0]['match_type'])?$match_data[0]['match_type']:'';
		$match_details = !empty($match_data[0]['match_details'])?$match_data[0]['match_details']:'';
		$winner_id = !empty($match_data[0]['winner_id'])?$match_data[0]['winner_id']:'';
		$decoded_match_details = array();
		if($match_details!='')
			$decoded_match_details = json_decode($match_details,true);
		//tennis or table tennis statistics
		if($sport_name=='tennis' || $sport_name=='tabletennis')
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
					if($sport_name=='tennis')
						$this->tennisStatistics($players,$match_type,$is_win);
					else if($sport_name=='tabletennis')
						$this->tableTennisStatistics($players,$match_type,$is_win);
				}
			}
			
		}else if($sport_name=='soccer')//soccer statistics
		{
			$soccer_details = SoccerPlayerMatchwiseStats::where('match_id',$match_id)->get(['user_id']);
			if(!empty($soccer_details) && count($soccer_details)>0)
			{
				foreach($soccer_details as $user_id)
				{
					$this->soccerStatistics($user_id['user_id']);
				}
					
			}
			
		}else if($sport_name=='cricket')//cricket statistics
		{
			$cricket_details = CricketPlayerMatchwiseStats::where('match_id',$match_id)->where('match_type',$match_type)->where('innings','first')->get(['user_id']);
			if(!empty($cricket_details) && count($cricket_details)>0)
			{
				foreach($cricket_details as $players)
				{
					$this->cricketBatsmenStatistic($players['user_id'],$match_type,$inning='first');//batsmen statistics
					$this->cricketBowlerStatistic($players['user_id'],$match_type,$inning='first');//bowler statistics
				}
				
			}
			
			if($match_type=='test')//for test match
			{
				$cricket_second_ing_details = CricketPlayerMatchwiseStats::where('match_id',$match_id)->where('match_type',$match_type)->where('innings','second')->get(['user_id']);
				if(!empty($cricket_second_ing_details) && count($cricket_second_ing_details)>0)
				{
					foreach($cricket_second_ing_details as $users)
					{
						$this->cricketBatsmenStatistic($users['user_id'],$match_type,$inning='second');//batsmen statistics
						$this->cricketBowlerStatistic($users['user_id'],$match_type,$inning='second');//bowler statistics
					}
					
				}
				
			}
				
		}
			
	}
        
        function updateBracketDetails($matchScheduleDetails,$tournamentDetails) {
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
                    $player_b_ids = TeamPlayers::select(DB::raw('GROUP_CONCAT(DISTINCT user_id) AS player_a_ids'))->where('team_id', $matchScheduleDetails['winner_id'])->pluck('player_a_ids');
                }else {
                    $player_b_ids = $matchScheduleDetails['winner_id'];
                }
                $matchScheduleData->b_id=$matchScheduleDetails['winner_id'];
                $matchScheduleData->player_b_ids=!empty($player_b_ids)?(','.trim($player_b_ids).','):NULL;
                MatchSchedule::where('id',$matchScheduleData['id'])->update(['b_id'=>$matchScheduleDetails['winner_id'],'player_b_ids'=>!empty($player_b_ids)?(','.trim($player_b_ids).','):NULL]);
                
            }else{
                if ($matchScheduleData['schedule_type'] == 'team') {
                    $player_a_ids = TeamPlayers::select(DB::raw('GROUP_CONCAT(DISTINCT user_id) AS player_a_ids'))->where('team_id', $matchScheduleDetails['winner_id'])->pluck('player_a_ids');
                }else {
                    $player_a_ids = $matchScheduleDetails['winner_id'];
                }
                $scheduleArray[] = [
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
                    'match_status' => 'scheduled',
                    'a_id' => $matchScheduleDetails['winner_id'],
                    'player_a_ids' => !empty($player_a_ids)?(','.trim($player_a_ids).','):NULL,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            
                MatchSchedule::insert($scheduleArray);
            }
            
            
        }
}
?>
