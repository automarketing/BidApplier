<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PDF;
use App\Helpers\Helper;
use App\Http\Controllers\User\InvitePlayerController;
use App\Http\Controllers\User\TournamentsController;
use App\Model\City;
use App\Model\Country;
use App\Model\Facilityprofile;
use App\Model\Followers;
use App\Model\MatchSchedule;
use App\Model\MatchScheduleRubber;
use App\Model\Photo;
use App\Model\Requestsmodel;
use App\Model\Sport;
use App\Model\State;
use App\Model\Team;
use App\Model\TournamentFinalTeams;
use App\Model\TournamentGroups;
use App\Model\TournamentGroupTeams;
use App\Model\TournamentParent;
use App\Model\Tournaments;
use App\Model\UserStatistic;
use App\Model\TournamentMatchPreference as Settings;
use App\Model\Organization;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;
use Response;
use Session;
use View;
//use Dompdf \ Dompdf as PDF;
//use Dompdf\Options;


class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function print_schedules(Request $request)
    {
        $tournament_id = $request->tournament_id;
        $group_id = $request->group_id;
        $tournament = Tournaments::where('id',$tournament_id)->with('groups')->first();
        $schedules = MatchSchedule::whereTournamentId($tournament_id);
        if ($group_id) {
            $schedules->where('tournament_group_id',$group_id);
            $tournament_groups = $tournament->groups()->whereId($group_id)->pluck('name','id');
        } else {
            $tournament_groups = $tournament->groups->pluck('name','id');
        }
        $schedules = $schedules->get();

        $team_logo = array();
        $user_name = array();
        $user_profile = array();
        $team_name_array = array();

        if (count($schedules)) {
            $match = $schedules[0];
            $teams = Team::select('id', 'name')->where('sports_id', $match->sports_id)->get()->toArray(); //get teams
            foreach ($teams as $team) {
                $team_name_array[$team['id']] = $team['name']; //get team names
                $team_logo[$team['id']] = Photo::select()->where('imageable_id', $team['id'])->where('imageable_type',
                    config('constants.PHOTO.TEAM_PHOTO'))->orderBy('id', 'desc')->first(); //get team logo
            }

            $users = User::select('id', 'name')->get()->toArray(); //if scheduled type is player
            foreach ($users as $user) {
                $user_name[$user['id']] = $user['name']; //get team names
                $user_profile[$user['id']] = Photo::select()->where('imageable_id',
                    $user['id'])->where('imageable_type', config('constants.PHOTO.USER_PHOTO'))->orderBy('id',
                    'desc')->first(); //get team logo
            }
/***
        }
        

         $view=view('pdf.schedules', compact('schedules', 'tournament', 'team_logo', 'user_name', 'team_name_array', 'user_profile'));
        
        //return $view;

     

         $pdf = new PDF;         
         $pdf ->load_html($view->render());
         $pdf->setPaper('a3', 'landscape');

         $pdf->render();
             
         return $pdf->stream('download.pdf');

        //return view('pdf.schedules', compact('schedules', 'tournament', 'team_logo', 'user_name', 'team_name_array', 'user_profile'));
       
======= **/

        }
        $tournamentParent = null;
        if ($tournament) {
            $tournamentParent = TournamentParent::where('id', $tournament->tournament_parent_id)->first();
        }
        $logo = object_get($tournament, 'logo', '');
        if (!$logo ){
            $logo = object_get($tournamentParent,'logo','');
        }

       // $pdf = PDF::loadView('pdf.schedules',
        //     compact('schedules', 'tournament', 'team_logo', 'user_name', 'team_name_array', 'user_profile', 'logo','group_id','tournament_groups'));


        // return $pdf->stream('match_schedule_tournament_' . $tournament_id . '_' . time() . '.pdf');
        return view('pdf.schedules',
            compact('schedules', 'tournament', 'team_logo', 'user_name', 'team_name_array', 'user_profile', 'logo','group_id','tournament_groups'));
    }


    public function player_standing(request $request){
        $tournament_id = $request->tournament_id;

        $tournament = Tournaments::find($tournament_id);
        /** @var Tournaments $tournament */
        $sport_id=$tournament->sports_id;
        $sport_name=strtolower(Sport::find($sport_id)->sports_name);
          $logo = object_get($tournament, 'logo', '');
        $player_standing = $tournament->playerStanding();
        $to_print = true;
        $pdf = PDF::loadView('pdf.player_standing', compact('player_standing', 'tournament_id','tournament','sports_id','sports_name','logo','sport_name','to_print'));

        return $pdf->stream('player_standing_'.$tournament_id.'_'.time().'.pdf');
    }

    public function overall_standing(request $request){
        $orgInfoObj = Organization::find($request->organization_id);
        $parent_tournament = tournamentParent::find($request->parent_tournament_id);



              $pdf = PDF::loadView('pdf.overall_standing', compact('lis','orgInfoObj','parent_tournament'));
              return $pdf->stream('overall_standing_'.$parent_tournament->id.'_'.time().'.pdf');
    }

    public function event_points(request $request){
              $orgInfoObj = Organization::find($request->organization_id);
              $lis = Tournaments::find($request->tournament_id);

              $pdf = PDF::loadView('pdf.event_points', compact('lis','orgInfoObj'));
              return $pdf->stream('event_points_'.$lis->id.'_'.time().'.pdf');
    }
}
