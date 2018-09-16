<?php

namespace App\Http\Controllers\User;

use App\User;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\organization;
use App\Model\Country;
use App\Model\State;
use App\Model\City;
use App\Model\Team;
use App\Helpers\Helper;
use App\Model\TournamentParent;
use App\Model\Tournaments;
use Auth;
use App\Model\Photo;
use App\Model\Sport;
use App\Http\Controllers\User\SearchController;
use DB;
use App\Model\TournamentGroupTeams;
use App\Model\OrganizationGroupTeamPoint;
use App\Model\OrganizationStaff;

use Illuminate\Http\Request as ObjRequest;
use App\Model\BasicSettings;
use App\Model\Marketplace;
use App\Model\Album;
use App\Model\PaymentSetting;
use File;
use Session;
use App\Model\poll;
use App\Model\poll_options as poll_option;
use App\Model\poll_voters as poll_vote;
use App\Model\poll_setting;
use App\Model\VendorBankAccounts;
use App\Model\news; 
use App\Model\coaching; 

//use Helper;

class OrganizationController extends Controller
{


    public function __construct(ObjRequest $request){
          $id = $request->route()->parameter('id');

               
          $this->is_owner = false;
          $this->new_template = false;
          $this->view = 'organization';

          $allow_newtemplate_setting  = BasicSettings::where('name', 'organization_new_template')->first();


          if($allow_newtemplate_setting && $allow_newtemplate_setting->description=='1'){
             $this->new_template=true;
          }

        //if($id && (Auth::user()->type==1 && count(Auth::user()->organizations))){

            // if(Auth::user()->organizations[0]->id == $id && $this->new_template){

            if( $this->new_template){
                 if(Auth::user()->organizations->count() && Auth::user()->organizations[0]->id==$id)
                    $this->is_owner = true;

                 $this->view = 'organization_2';
                 $organization = Organization::find($id);
                 $this->organization = $organization;

                 view()->share('organisation', $organization);

            }
            
        //}    
            view()->share('is_owner', $this->is_owner); 

    }

    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //

          if($this->new_template){     
          $this->organization = Organization::find($id);  
          $tournaments = $this->organization->tournaments; 
          $teams = $this->organization->teamplayers;
          $parent_tournaments = $this->organization->parent_tournaments;
          
          Session::put('organization_id', $id);
          $organisation = $this->organization;

           foreach ($parent_tournaments as $parent_tournament) {
                foreach ($parent_tournament->tournaments as $teamdet) {
                    $currentTimestamp = time();
                    $startDateTimestamp = strtotime($teamdet->start_date);
                    $endDateTimestamp = strtotime($teamdet->end_date);
                    if ($endDateTimestamp <= $currentTimestamp) {
                        $teamdet->status = "Completed";
                        $teamdet->statusColor = "black";
                        $tournament_winner_details = SearchController::getTournamentWinner($teamdet, ["name"]);
                        if (!empty($tournament_winner_details)) {
                            $teamdet->winnerName = $tournament_winner_details["name"];
                        }
                    } else {
                        if ($startDateTimestamp > $currentTimestamp) {
                            $teamdet->status = "Not started";
                            $teamdet->statusColor = "green";
                        } else {
                            if ($currentTimestamp >= $startDateTimestamp) {
                                $teamdet->status = "In progress";
                                $teamdet->statusColor = "black";
                            }
                        }
                    }
                }

                $sports = Sport::get();
                foreach ($sports as $sport) {
                    $sports_array[$sport->id] = $sport->sports_name;
                }
            }

                  
           

        $marketplace = marketplace::where('organization_id', $this->organization->id)->get();
        $imageable_type_name = config('constants.PHOTO.GALLERY_ORGANIZATION');
        $photos = Photo::where('imageable_type',$imageable_type_name)->where('imageable_id',$this->organization->id)->get();
        $polls = poll::where('organization_id', $id)->get();
        $news = news::where('organization_id', $id)->orderBy('id','desc')->take(5)->get();
        $coaching_sessions = coaching::where('organization_id', $id)->get();
 
         return view('organization_2.index', compact('tournaments','teams','parent_tournaments','marketplace','items','photos','schedules','reports','organisation','polls','news','coaching_sessions'));
        }

        else return redirect()->to('/organization/'.$id.'/info');
      

    }

    public function new_tournament(){

        return view('organization_2.tournament.new_tournament');
    }

    public function getorgDetails($id)
    {
        $user_id = (isset(Auth::user()->id) ? Auth::user()->id : 0);
        $teams = Team::select('id', 'name')->where('organization_id', $id)->get()->toArray();
        $photo = Photo::select('url')->where('imageable_id', '=', $id)->where('imageable_type', '=',
            config('constants.PHOTO.TEAM_PHOTO'))->where('user_id',
            (isset(Auth::user()->id) ? Auth::user()->id : 0))->get()->toArray();
        $orgInfoObj = Organization::find($id);

        if($this->is_owner){        
         return view('organization_2.info', compact('teams','photo','orgInfoObj','id','userId'));
        }

        return view('teams.teams')->with(array(
            'teams' => $teams,
            'photo' => $photo,
            'orgInfoObj' => $orgInfoObj,
            'id' => $id,
            'userId' => $user_id
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = config('constants.ENUM.ORGANIZATION.ORGANIZATION_TYPE');
        $countries = Country::orderBy('country_name')->lists('country_name', 'id')->all();
        $teams = Team::where('team_owner_id', Auth::user()->id)->orderBy('name')->lists('name', 'id')->all();
        $states = [];
        $cities = [];
        return view('organization.create', array(
            'countries' => ['' => 'Select Country'] + $countries,
            'states' => ['' => 'Select State'] + $states,
            'cities' => ['' => 'Select City'] + $cities,
            'type' => ['' => 'Select Organization Type'] + $type,
            'id' => '',
            'roletype' => 'user',
            'teams' => ['' => 'Select Team'] + $teams,
            'selectedTeams' => ''
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateOrganizatonRequest $request)
    {

        $request['user_id'] = Auth::user()->id;
        $request['country'] = !empty($request['country_id']) ? Country::where('id',
            $request['country_id'])->first()->country_name : 'null';
        $request['state'] = !empty($request['state_id']) ? State::where('id',
            $request['state_id'])->first()->state_name : 'null';
        $request['city'] = !empty($request['city_id']) ? City::where('id',
            $request['city_id'])->first()->city_name : 'null';
        $location = Helper::address($request['address'], $request['city'], $request['state'], $request['country']);
        $request['location'] = trim($location, ",");
        $organization = Organization::create($request->all());
        if (count($request->team)) {
            Team::where('team_owner_id', Auth::user()->id)->whereIn('id',
                $request->team)->update(['organization_id' => $organization->id]);
        }
        $id = $organization->id; //Inserted record ID
        $user_id = Auth::user()->id;
        //Upload Photos
        $albumID = 1; //Default album if no album is not selected.
        $coverPic = 1;
        if (isset($input['album_id']) && $input['album_id']) {
            $albumID = $input['album_id'];
        }
        if (isset($input['cover_pic']) && $input['cover_pic']) {
            $coverPic = $input['cover_pic'];
        }
        Helper::uploadPhotos($request['filelist_photos'], config('constants.PHOTO_PATH.ORGANIZATION'), $id, $albumID,
            $coverPic, config('constants.PHOTO.ORGANIZATION_LOGO'), $user_id);
        Helper::uploadPhotos($request['filelist_gallery'], config('constants.PHOTO_PATH.ORGANIZATION_PROFILE'), $id,
            $albumID, $coverPic, config('constants.PHOTO.ORGANIZATION_PROFILE'), $user_id);
        $logo = Photo::select('url')->where('imageable_type',
            config('constants.PHOTO.ORGANIZATION_LOGO'))->where('imageable_id', $id)->where('user_id',
            Auth::user()->id)->where('is_album_cover', 1)->get()->toArray();
        if (!empty($logo)) {
            foreach ($logo as $l) {
                Organization::where('id', $id)->update(['logo' => $l['url']]);
                //echo $l['url'];exit;
            }

        }
        //End Upload Photos        
        // redirect('/');
        return redirect()->back()->with('status', trans('message.organization.create'));
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
        if($this->is_owner){        
         return view('organization_2.index', compact('teams','photo','orgInfoObj','id','userId'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request['user_id'] = Auth::user()->id;
        $organization = Organization::findOrFail($id);
        $type = config('constants.ENUM.ORGANIZATION.ORGANIZATION_TYPE');
        $countries = Country::orderBy('country_name')->lists('country_name', 'id')->all();
        $states = State::where('country_id', $organization->country_id)->orderBy('state_name')->lists('state_name',
            'id')->all();
        $cities = City::where('state_id', $organization->state_id)->orderBy('city_name')->lists('city_name',
            'id')->all();
        $teams = Team::where('team_owner_id', Auth::user()->id)->orderBy('name')->lists('name', 'id')->all();
        $selectedTeams = Team::where('team_owner_id', Auth::user()->id)->where('organization_id', $id)->get(['id']);
        $selectedTeamsIds = '';
        if (count($selectedTeams)) {
            $selectedTeamsIds = array_divide(array_flatten($selectedTeams->toArray()));
        }
        if ($selectedTeamsIds == '') {
            $selectedTeams = '';
        } else {
            $selectedTeams = $selectedTeamsIds[1];
        }

        return view('organization.edit', compact('organization'))->with(array(
            'id' => $id,
            'countries' => ['' => 'Select Country'] + $countries,
            'states' => ['' => 'Select State'] + $states,
            'cities' => ['' => 'Select City'] + $cities,
            'type' => ['' => 'Select Organization Type'] + $type,
            'roletype' => 'user',
            'organization' => $organization,
            'teams' => ['' => 'Select Teams'] + $teams,
            'selectedTeams' => $selectedTeams
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateOrganizatonRequest $request, $id)
    {
        $request['city'] = !empty($request['city_id']) ? City::where('id',
            $request['city_id'])->first()->city_name : 'null';
        $request['state'] = !empty($request['state_id']) ? State::where('id',
            $request['state_id'])->first()->state_name : 'null';
        $request['country'] = !empty($request['country_id']) ? Country::where('id',
            $request['country_id'])->first()->country_name : 'null';
        $location = Helper::address($request['address'], $request['city'], $request['state'], $request['country']);
        $request['location'] = trim($location, ",");
        Organization::whereId($id)->update($request->except([
            '_method',
            '_token',
            'files',
            'filelist_photos',
            'team',
            'filelist_gallery',
            'jfiler-items-exclude-files-0'
        ]));
        if (count($request->team)) {
            Team::where('team_owner_id', Auth::user()->id)->where('organization_id',
                $id)->update(['organization_id' => null]);
            Team::where('team_owner_id', Auth::user()->id)->whereIn('id',
                $request->team)->update(['organization_id' => $id]);
        }
        if (!empty($request['filelist_photos'])) {
            Photo::where([
                'imageable_id' => $id,
                'imageable_type' => config('constants.PHOTO.ORGANIZATION_LOGO')
            ])->update(['is_album_cover' => 0]);
            //Upload Photos
            $albumID = 1; //Default album if no album is not selected.
            $coverPic = 1;
            $user_id = Auth::user()->id;
            if (isset($input['album_id']) && $input['album_id']) {
                $albumID = $input['album_id'];
            }
            if (isset($input['cover_pic']) && $input['cover_pic']) {
                $coverPic = $input['cover_pic'];
            }
            Helper::uploadPhotos($request['filelist_photos'], config('constants.PHOTO_PATH.ORGANIZATION'), $id,
                $albumID, $coverPic, config('constants.PHOTO.ORGANIZATION_LOGO'), $user_id);

            //End Upload Photos
        }
        if (!empty($request['filelist_gallery'])) {
            //  Photo::where(['user_id' => Auth::user()->id, 'imageable_type' => config('constants.PHOTO.ORGANIZATION_PROFILE')])->update(['is_album_cover' => 0]);
            //Upload Photos
            $albumID = 1; //Default album if no album is not selected.
            $coverPic = 1;
            $user_id = Auth::user()->id;
            if (isset($input['album_id']) && $input['album_id']) {
                $albumID = $input['album_id'];
            }
            if (isset($input['cover_pic']) && $input['cover_pic']) {
                $coverPic = $input['cover_pic'];
            }
            Helper::uploadPhotos($request['filelist_gallery'], config('constants.PHOTO_PATH.ORGANIZATION_PROFILE'), $id,
                $albumID, $coverPic, config('constants.PHOTO.ORGANIZATION_PROFILE'), $user_id);
            //End Upload Photos
        }
        $logo = Photo::select('url')->where('is_album_cover', 1)->where('imageable_type',
            config('constants.PHOTO.ORGANIZATION_LOGO'))->where('imageable_id', $id)->where('user_id',
            Auth::user()->id)->get()->toArray();
        if (!empty($logo)) {
            foreach ($logo as $l) {
                Organization::where('id', $id)->update(['logo' => $l['url']]);
            }

        }
        return redirect()->back()->with('status', trans('message.organization.update'))->with('div_sel_org', 'active');
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

    public function deleteorganization($org_id, $flag)
    {
        $request = Request::all();
        $delete_id = $org_id;
        if (is_numeric($delete_id) && $delete_id > 0) {
            if ($flag == 'd') {
                if (Organization::where('id', $delete_id)->update(['isactive' => 0])) {
                    return redirect()->back()->with('status', trans('message.organization.delete'))->with('div_sel_org',
                        'active');
                } else {
                    return redirect()->back()->with('error_msg',
                        trans('message.organization.deletefail'))->with('div_sel_org', 'active');
                }
            } elseif ($flag == 'a') {
                if (Organization::where('id', $delete_id)->update(['isactive' => 1])) {
                    return redirect()->back()->with('status',
                        trans('message.organization.activate'))->with('div_sel_org', 'active');
                } else {
                    return redirect()->back()->with('error_msg',
                        trans('message.organization.activatefail'))->with('div_sel_org', 'active');
                }
            } else {
                return redirect()->back()->with('error_msg',
                    trans('message.organization.updatefail'))->with('div_sel_org', 'active');
            }
        } else {
            return redirect()->back()->with('error_msg', trans('message.organization.updatefail'))->with('div_sel_org',
                'active');
        }
    }

    public function organizationTournaments($id)
    {
        $offset = !empty(Request::get('offset')) ? Request::get('offset') : 0;
        $limit = !empty(Request::get('limit')) ? Request::get('limit') : config('constants.LIMIT');
        $sports_array = $exist_array = $follow_array = [];

        if (\Auth::user())
            $user_id = Auth::user()->id;
        else
            $user_id = false;
        $query = DB::table('tournament_parent')
            ->join('tournaments', 'tournaments.tournament_parent_id', '=', 'tournament_parent.id')
            ->select('tournament_parent.logo',
                'tournaments.id',
                'tournaments.tournament_parent_id',
                'tournaments.tournament_parent_name',
                'tournaments.name',
                'tournaments.type',
                'tournaments.prize_money',
                'tournaments.location',
                'tournaments.start_date',
                'tournaments.end_date',
                'tournaments.sports_id',
                'tournaments.enrollment_fee',
                'tournaments.description',
                'tournaments.schedule_type')
            ->where('tournaments.isactive', 1)
            ->whereNull('tournaments.deleted_at')
            ->where('tournament_parent.organization_id', $id);

        $totalresult = $query->get();
        $total = count($totalresult);
        $tournaments = $query->limit($limit)->offset($offset)->orderBy('tournaments.updated_at', 'desc')->get();

        $orgInfoObj = Organization::find($id);

        $parent_tournaments = TournamentParent::whereOrganizationId($id)->get();

        if (!empty($parent_tournaments)) {
            foreach ($parent_tournaments as $parent_tournament) {
                foreach ($parent_tournament->tournaments as $teamdet) {
                    $currentTimestamp = time();
                    $startDateTimestamp = strtotime($teamdet->start_date);
                    $endDateTimestamp = strtotime($teamdet->end_date);
                    if ($endDateTimestamp <= $currentTimestamp) {
                        $teamdet->status = "Completed";
                        $teamdet->statusColor = "black";
                        $tournament_winner_details = SearchController::getTournamentWinner($teamdet, ["name"]);
                        if (!empty($tournament_winner_details)) {
                            $teamdet->winnerName = $tournament_winner_details["name"];
                        }
                    } else {
                        if ($startDateTimestamp > $currentTimestamp) {
                            $teamdet->status = "Not started";
                            $teamdet->statusColor = "green";
                        } else {
                            if ($currentTimestamp >= $startDateTimestamp) {
                                $teamdet->status = "In progress";
                                $teamdet->statusColor = "black";
                            }
                        }
                    }
                }

                $sports = Sport::get();
                foreach ($sports as $sport) {
                    $sports_array[$sport->id] = $sport->sports_name;
                }
            }
        }

        return view($this->view.'.tournaments')->with([
            'tournaments' => $tournaments,
            'id' => $id,
            'userId' => $user_id,
            'totalTournaments' => $total,
            'sports_array' => $sports_array,
            'exist_array' => $exist_array,
            'follow_array' => $follow_array,
            'parent_tournaments' => $parent_tournaments,
            'orgInfoObj' => $orgInfoObj
        ]);
    }

    public function testTournaments()
    {
        return Helper::updateOrganizationTeamsPoints();
    }

    public function addGroupSportPoints($tournament_parent_id, ObjRequest $request)
    {
        $sports_id = $request->sport_id;
        $max_index = $request->max_index;

        $parent_tournament = TournamentParent::find($tournament_parent_id);
        $orgInfoObj = Organization::find($parent_tournament->organization_id);

        $organization_id = $orgInfoObj->id;


        $check = OrganizationGroupTeamPoint::whereTournamentParentId($tournament_parent_id)->whereSportsId($sports_id)->whereOrganizationId($organization_id)->first();

        if (!is_null($check)) {

            return 'Sorry, this sports already exists';
        } else {

            for ($i = 0; $i <= $max_index; $i++) {
                $group_id = $request->{'group_' . $i};
                $points = $request->{'input_' . $i};

                $model = new OrganizationGroupTeamPoint;
                $model->points = $points;
                $model->organization_group_id = $group_id;
                $model->tournament_parent_id = $tournament_parent_id;
                $model->organization_id = $organization_id;
                $model->sports_id = $sports_id;
                $model->save();
            }
        }

        return view('organization.standing.overall_standing_display_sports',
            compact('orgInfoObj', 'parent_tournament'));
    }

    public function organizationList($user_id = null)
    {

        $user = $user_id ? User::whereId($user_id)->first() : null;
        if (!$user) {
            $user = \Auth::user();
            $user_id = $user->id;
        }

        $managedOrgs = Organization::with(['teamplayers', 'photos', 'user'])
            ->where('user_id', $user_id)
            ->orderBy('isactive', 'desc')
            ->get();

        $followingIds = $user ? $user->followers()->organizations()->lists('type_id') : [];
        $followingOrgs = Organization::with(['teamplayers', 'photos', 'user'])->whereIn('id', $followingIds)
            ->orderBy('isactive', 'desc')
            ->get();

        $joinedOrgs = Organization::with([
            'teamplayers',
            'photos',
            'user',
            'staff'
        ])
            ->whereHas('staff',function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })
            ->orderBy('isactive', 'desc')
            ->get();

        return view('organization.organizationList', [
            'managedOrgs' => $managedOrgs,
            'followingOrgs' => $followingOrgs,
            'joinedOrgs' => $joinedOrgs,
            'user' => $user,
            'user_id'=>$user_id 
        ]);
    }

    public function widgetCode($id){
        $request['user_id'] = Auth::user()->id;
        $organization = Organization::findOrFail($id);


        return view('organization.widget_code', compact('organization'))->with(array(
            'id' => $id,
            'orgInfoObj'=>$organization,
        ));
    }

    public function delete_actions(objrequest $request){
        switch ($request->type) {
            case 'staff':
                $staff = OrganizationStaff::find($request->id);
                $staff->delete();
                break;
            
            default:
                # code...
                break;
        }

        return 'ok';
    }

    public function gallery($id, objrequest $request){
          
            $orgInfoObj= Organization::find($id);
            $imageable_type_name = config('constants.PHOTO.GALLERY_ORGANIZATION');
            $album_array = Album::where('imageable_type',$imageable_type_name)->where('imageable_id',$id)->get();
            $photos = Photo::where('imageable_type',$imageable_type_name)->where('imageable_id',$id)->get();
            $album_select = Album::where('imageable_type',$imageable_type_name)->where('imageable_id',$id)->lists('title', 'id');
        return view('organization_2.gallery.gallery', compact('photos','album_array','album_select'));
    }

    
    //Save Organization Album
    public function album_save($id, ObjRequest $request){
        $album = new album;
        $album->imageable_type =  config('constants.PHOTO.GALLERY_ORGANIZATION');
        $album->imageable_id   =  $id;
        $album->title          = $request->title; 
        $album->description    = $request->description;
        $album->user_id        = Auth::user()->id;
        $album->save();

        $albums  =  album::where(['imageable_type'=>$album->imageable_type, 'imageable_id'=>$id])->get();
        $Response = ''; 
        foreach ($albums as $key => $value) {
            $Response.="<option value='$value->id'>$value->title</option>";
        }

        return $Response;
    }

    public function photo_save($id, ObjRequest $request){

        $photo = new photo;
        $photo->album_id = $request->album_id;
        $filename = $request->file('image')->getClientOriginalName();
        $ext = $request->file('image')->getClientOriginalExtension();
        $str = str_random(12).'.'.$ext;
        $photo->title = $filename;
        $photo->url = $str;
        $photo->imageable_type =  config('constants.PHOTO.GALLERY_ORGANIZATION');
        $photo->imageable_id   =  $id;
        $photo->user_id = Auth::user()->id;        

        $path = public_path().'/uploads/'.config('constants.PHOTO.GALLERY_ORGANIZATION');
        if(!is_dir($path)) mkdir($path);

        $photo->save();

        $request->file('image')->move($path, $str);

        return redirect()->back()->with('message', 'Successful!'); 


    }

    public function update_fields($id, objrequest $request){
        $org = organization::find($id); 
        $org->{$request->field} = $request->value;
        $org->save(); 

        return 'ok';
    }



/* 
    Polls Actions 
*/

    public function get_polls($id){
        $polls = poll::where('organization_id',$id)->get();
        return view('organization_2.polls.index', compact('polls'));
    }

    public function add_poll(objrequest $request, $id){

        $i = $request->i;
        $poll = new poll; 

        $poll->title = $request->question;
        $poll->user_id = Auth::user()->id;
        $poll->organization_id = $id;
        $poll->start_date = $request->start_date;
        $poll->end_date = $request->end_date;
        $poll->save();

        for($j=0; $j<=$i; $j++){
            if($request->{'option_'.$j}){
                $option = new poll_option;
                $option->poll_id = $poll->id;
                $option->title = $request->{'option_'.$j};
                $option->save();
            }
        }

        $organization  = Organization::find($id);

        if($organization->poll_settings){
            $organization->poll_settings->update(['poll_result' => $request->poll_results,
                                                  'block_votes' => $request->block_votes]);
        }
        else{
            poll_setting::create(['poll_result' => $request->poll_results,
                                  'block_votes' => $request->block_votes,
                                  'organization_id'=>$id]);
        }

        return redirect()->back()->with('message', 'Poll Added');
    }

    public function delete_poll($id, $poll_id){
        $poll = poll::find($id);
        $poll->options->delete();
        $poll->voters->delete();
        $poll->delete();
        return redirect()->back()->with('message', 'Poll Deleted!');
    }

    public function polls_show($id, $poll_id){
        $poll = poll::find($poll_id);
        return view('organization_2.polls.show', compact('poll'));
    }

    public function polls_edit($id,$poll_id){
        $poll = poll::find($poll_id);
        return view('organization_2.polls.edit', compact('poll'));
    }

     public function polls_toggle($id, $poll_id){
        $poll = poll::find($poll_id);

        if($poll->status==1)$poll->status=0; 
        else $poll->status=1; 

        $poll->save(); 

        return 'Status Changed';
    }

    public function polls_vote($id, $poll_id, objRequest $request){
        $poll_vote = new poll_vote; 

        $check = poll_vote::where(['user_id'=>Auth::user()->id,'poll_id'=>$request->poll_id])->first();

        if($check){
            $poll_vote = $check;
            $poll_vote->option_id = $request->option_id; 
            $poll_vote->user_id = Auth::check()?Auth::user()->id:0;
            $poll_vote->save();
        }
        else{
            $poll_vote->poll_id = $poll_id;
            $poll_vote->option_id = $request->option_id; 
            $poll_vote->user_id = Auth::check()?Auth::user()->id:0;
            $poll_vote->save();
        }
       


        return 'ok';
    }

    public function polls_update($id, $poll_id, objrequest $request){
        $poll = poll::find($poll_id);

         $i = $request->i;  


        $poll->title = $request->question;
        $poll->user_id = Auth::user()->id;
        $poll->organization_id = $id;
        $poll->start_date = $request->start_date;
        $poll->end_date = $request->end_date;
        $poll->save();

        for($j=0; $j<=$i; $j++){
            if($request->{'option_'.$j}){
               if($request->{'option_old_'.$j}) $option = poll_option::find($request->{'option_old_'.$j}); 
               else $option = new poll_option;

                $option->poll_id = $poll->id;
                $option->title = $request->{'option_'.$j};
                $option->save();
            }
        }

        $organization  = Organization::find($id);

        if($organization->poll_settings){
            $organization->poll_settings->update(['poll_result' => $request->poll_results,
                                                  'block_votes' => $request->block_votes]);
        }
        else{
            poll_setting::create(['poll_result' => $request->poll_results,
                                  'block_votes' => $request->block_votes,
                                  'organization_id'=>$id]);
        }

        return redirect()->back()->with('message', 'Poll Added');
    }

/* 
End of Poll actions 
*/




/* start settings
*/
    public function settings($id){
         $organization = organization::find($id);
         $teams = $organization->teamplayers;
         $bank_accounts = VendorBankAccounts::where('user_id',Auth::user()->id)->get();

        $type = config('constants.ENUM.ORGANIZATION.ORGANIZATION_TYPE');
        $countries = Country::orderBy('country_name')->lists('country_name', 'id')->all();
        $states = State::where('country_id', $organization->country_id)->orderBy('state_name')->lists('state_name',
            'id')->all();
        $cities = City::where('state_id', $organization->state_id)->orderBy('city_name')->lists('city_name',
            'id')->all();
        $teams = Team::where('team_owner_id', Auth::user()->id)->orderBy('name')->lists('name', 'id')->all();
        $selectedTeams = Team::where('team_owner_id', Auth::user()->id)->where('organization_id', $id)->get(['id']);
        $selectedTeamsIds = '';
        if (count($selectedTeams)) {
            $selectedTeamsIds = array_divide(array_flatten($selectedTeams->toArray()));
        }
        if ($selectedTeamsIds == '') {
            $selectedTeams = '';
        } else {
            $selectedTeams = $selectedTeamsIds[1];
        }

        $paymentsetting = $organization->payment_settings;


        return view('organization_2.settings.index', compact('bank_accounts','organization','id','teams','selectedTeams','cities','states','type','countries','paymentsetting'));
    }


    public function save_bank($id, objrequest $request){       

        if(!empty($request['account_holder_name']) && 
            !empty($request['account_number']) &&
            !empty($request['bank_name']) && 
            !empty($request['branch']) &&
            !empty($request['ifsc'])
         ){
            $vendor = new VendorBankAccounts();
            $vendor_bank_account_id = $vendor->saveBankDetails(
                $request['account_holder_name'],
                $request['account_number'],
                $request['bank_name'],
                $request['branch'],
                $request['ifsc'],
                Auth::user()->id
            );
            if($vendor_bank_account_id){
                $request['vendor_bank_account_id'] = $vendor_bank_account_id;
            
          }

        }

        else redirect()->back()->with('error', 'A field is missing sorry!');


         if(!empty($request['filelist_file_upload'])) {

           //  /*--files moving from temp directory to attachments directory--*/
             $image_moved=Helper::moveImage($request['filelist_file_upload'],$vendor_bank_account_id);
           /*--files moving from temp directory to attachments directory--*/
          
        }  

        return redirect()->back()->with('message', 'Bank Added!');

    }

    public function change_password($id, ObjRequest $request){
        $user = Auth::user(); 

        if(bcrypt($request->old_password) != $user->password || ($request->new_password!=$request->new_password_2)){
            return redirect()->back()->with('error', 'Wrong Password');
        }
        else{
            $user->password = bcrypt($request->new_password);
            $user->save();
        }

        return redirect()->back()->with('message','Password Updated!');
    }

    public function payment_settings($id, objrequest $request){
        $organization = Organization::find($id);

        if(!$paymentsetting = $organization->payment_settings) $paymentsetting = new paymentsetting;

        $paymentsetting->user_id = Auth::user()->id;
        $paymentsetting->organization_id = $id; 
        $paymentsetting->paypal_username = $request->paypal_username;
        $paymentsetting->paypal_password = $request->paypal_password;
        $paymentsetting->paypal_signature = $request->paypal_signature;
        $paymentsetting->paypal_sandbox = $request->paypal_sandbox;
        $paymentsetting->save(); 

        return redirect()->back()->with('message', 'Settings update');
    }

/* End of settings

===================================================================================================
*/




/* Start of news
====================================================================================================
*/


    public function news($id){
        $news = news::where('organization_id', $id)->orderBy('id', 'desc')->get();
        return view('organization_2.news.index', compact('news'));
    }

    public function news_create(){
        return view('organization_2.news.create');
    }

    public function news_add($id, objRequest $request){

        $user_id = Auth::user()->id;
        Helper::uploadPhotos($request['filelist_photos'], config('constants.PHOTO_PATH.ORGANIZATION_NEWS'), $id, 1,
            1, config('constants.PHOTO.ORGANIZATION_NEWS'), $user_id);
      
        $logo = Photo::select('url')->where('imageable_type',
            config('constants.PHOTO.ORGANIZATION_NEWS'))->where('imageable_id', $id)->where('user_id',
            Auth::user()->id)->where('is_album_cover', 1)->get()->toArray();
       

        $news = new news; 
        $news->title = $request->title;
        $news->details = $request->details;
        $news->category_id = $request->category_id; 
        $news->organization_id = $id;
        $news->save(); 

         if (!empty($logo)) {
            foreach ($logo as $l) {
                $news->image = $l['url'];
                $news->image_url = asset('/uploads/organization_news/'.$news->image);
                $news->save();
            
            }

        }

        return redirect()->to('/organization/'.$news->organization_id.'/news/manage')->with('message', 'News Added Successfully!');

    }

    public function news_manage($id){
        $news = news::where('organization_id', $id)->get(); 

        return view('organization_2.news.manage', compact('news'));
    }

    public function news_show($id, $news_id){
        $news = news::find($news_id);
        return view('organization_2.news.show', compact('news'));
    }

    public function news_edit($id,$news_id){
        $news = news::find($news_id);

        return view('organization_2.news.edit', compact('news'));
    }

    public function news_delete($id, $news_id){
        news::find($news_id)->delete(); 

        return 'ok';
    }

    public function news_update($id, $news_id, objRequest $request){
        $user_id = Auth::user()->id;
        Helper::uploadPhotos($request['filelist_photos'], config('constants.PHOTO_PATH.ORGANIZATION_NEWS'), $id, 1,
            1, config('constants.PHOTO.ORGANIZATION_NEWS'), $user_id);
      
        $logo = Photo::select('url')->where('imageable_type',
            config('constants.PHOTO.ORGANIZATION_NEWS'))->where('imageable_id', $id)->where('user_id',
            Auth::user()->id)->where('is_album_cover', 1)->get()->toArray();
       

        $news = news::find($news_id); 
        $news->title = $request->title;
        $news->details = $request->details;
        $news->category_id = $request->category_id; 
        $news->organization_id = $id; 
        $news->save(); 

         if (!empty($logo)) {
            foreach ($logo as $l) {
                $news->image = $l['url'];
                $news->image_url = asset('/uploads/organization_news/'.$news->image);
                $news->save();
                Organization::where('id', $id)->update(['logo' => $l['url']]);
                //echo $l['url'];exit;
            }

        }

        return redirect()->to('/organization/'.$news->organization_id.'/news/manage')->with('message', 'News Updated Successfully!');
    }

    public function news_toggle($id, $news_id){
        $news = news::find($news_id);

        if($news->status==1)$news->status=0; 
        else $news->status=1; 

        $news->save(); 

        return 'Status Changed';
    }

}
