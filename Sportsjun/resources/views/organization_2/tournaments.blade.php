 @extends(Helper::check_if_org_template_enabled()?'layouts.organisation':'layouts.app') 
 @section('content') 
  <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-header"><div class="ph-mark"><div class="glyphicon glyphicon-menu-right"></div></div> Tournaments</h2>
                        @if($is_owner)
                          <div class="create-btn-link"><a href="/organization/{{$organisation->id}}/new_tournament" class="wg-cnlink" >Create New Tournament</a></div>
                        @endif
                    </div>
            </div>

<div  class="col-sm-9" >
    <div class=" tournament_profile">
       
        @if(count($parent_tournaments)) 
            <div class="group_no clearfix">
                <h4 class="stage_head">Tournaments</h4>
            </div>        

            @foreach($parent_tournaments as $parent_tournament)
            
             <div class="t_details">
                <div class="   row main_tour" style="margin-top: 10px">
                    <div class='col-sm-12'> 
                       <div class='t_tltle' style="padding-left:30px;"><div><h3> {{ $parent_tournament->name }}

                       </h3>
                            <span class="pull-right"><button class="btn btn-event" href="javascript:void(0);" data-toggle="modal" data-target="#overall_standing_{{$parent_tournament->id}}">Overall Standing</button></span>
                       </div></div>
                    </div>                    
                       
                                            <div class="col-md-2 col-sm-3 col-xs-12 text-center">
                                              <!--<img class="img-circle img-border" src="http://localhost/sportsjun/public/images/sunrisers_hyd.png" style="width: 90%;height:90%;">-->
                                                <!--<img class="img-circle img-border" src="{{ asset('/uploads/'.config('constants.PHOTO_PATH.TOURNAMENT').'/'.$parent_tournament['logo']) }}" onerror="this.onerror=null;this.src='{{ asset('/images/default-profile-pic.jpg') }}';" style="width: 90%;height:90%;">-->

                        {!! Helper::Images($parent_tournament['logo'],config('constants.PHOTO_PATH.TOURNAMENT'),array('height'=>90,'width'=>90,'class'=>'img-circle img-border img-scale-down') )!!}
                                            </div>
                                            <div class="col-md-10 col-sm-9 col-xs-12">
                                                    <div class="t_tltle">
                                                        <div class="pull-left">
                                                            {{ $parent_tournament['name'] }}
                                                        </div>
                                                        <div class="pull-right ed-btn">
                                                            @if(Auth::check() && (Auth::user()->id==$parent_tournament['owner_id'] || Auth::user()->id==$parent_tournament['manager_id']))
                                                            <a href="{{ route('tournaments.edit',[$parent_tournament['id']])}}" class="edit" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fa fa-pencil"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <ul class="t_tags">
                                                        <li>Created By: <span class="green"><a target="_blank" href="{{ url('/editsportprofile/'.$parent_tournament['created_by'])}}">{{ $parent_tournament->creator->name }}</a></span></li>
                                                        <li>Owner: <span class="green"><a target="_blank" href="{{ url('/editsportprofile/'.$parent_tournament['owner_id'])}}">{{ $parent_tournament->owner->name }}</a></span></li>
                                                        <li>Manager: <span class="green"><a target="_blank" href="{{ url('/editsportprofile/'.$parent_tournament['manager_id'])}}">{{ $parent_tournament->manager?$parent_tournament->manager->id:'' }}</a></span></li>
                                                    </ul>
                                                    <p class="lt-grey">{{ $parent_tournament['description'] }}</p>
                                                    @if($parent_tournament->tournaments)
                                                    <a href="#" class="show_sub_tournament" parent_tour_id = "{{$parent_tournament['id']}}">Tournament events: {{ $parent_tournament->tournaments->count() }}</a>
                                                    @endif
                                            </div>
                                    </div>
                                                                               
                   
<div id="subtournament_{{$parent_tournament['id']}}" class="row " style="display: none">

                    @foreach($parent_tournament->tournaments as $lis)
                     <div class="sub_tour clearfix">

                    <div class="search_thumbnail right-caption">

                        <div class="col-md-2 col-sm-3 col-xs-12 text-center">
                            {!! Helper::Images( $lis->logo ? $lis->logo : $parent_tournament->logo ,'tournaments',array('height'=>90,'width'=>90,'class'=>'img-circle img-border img-scale-down img-responsive') )!!}
                        </div>
                        <div class="col-md-10 col-sm-9 col-xs-12">
                            <div class="t_tltle">
                                <div class="pull-left">Event: <a
                                        @if (!(isset($is_widget) && ($is_widget)))
                                        href="{{ url('/gettournamentdetails').'/'.$lis->id }}"
                                    @else
                                        href="#" style="pointer-events:none;text-decoration: none"
                                   @endif id="{{'touname_'.$lis->id}}"><i class="fa fa-link"></i> {{ $lis->name }}</a></div>
                                <p class="search_location t_by">{{ $lis->location }}</p>
                            </div>
                            <div class="clearfix"></div>
                            <p>Tournament Type: {{ $lis->type }}</p>
                            @if($lis->prize_money)
                                <p>Prize Money: {{ $lis->prize_money }}₹</p>
                            @endif
                            @if(isset($lis->winnerName))
                            <div class="m-y-10 red search-results-tournament-winner">Winner: <span>{{ $lis->winnerName }}</span></div>
                            @endif
                            <div class="m-y-10 {{ $lis->statusColor }}">{{ Helper::displayDate($lis->start_date,1) }} to {{ Helper::displayDate($lis->end_date,1) }}</div>
                            <ul class="t_tags">
                                <li>
                                    Status: <span class="green">{{ $lis->status }}</span>
                                </li>
                                @if(isset($sports_array[$lis->sports_id]))
                                <li>
                                    Sport: <span class="green">{{$sports_array[$lis->sports_id]}}</span>
                                </li>
                                @endif
                                @if($lis->enrollment_fee) 
                                <li>
                                    Enrollment Fee: <span class="green">{{$lis->enrollment_fee}}</span>
                                </li>
                                @endif
                                <li class="pull-right">
                                    <button class='btn schedule_but_new' href="javascript:void(0);" data-toggle="modal" data-target="#event_points_{{$lis->id}}">Event Points </button>
                                </li>
                            </ul>
                            @if($lis->description)
                            <p class="lt-grey">{{$lis->description}}</p>
                            @endif
                         
                        <div class="sj_actions_new">
                            <?php if(!in_array($lis['id'],$exist_array) && (!empty($lis['end_date'] && $lis['end_date']!='0000-00-00')?strtotime($lis['end_date']) >= strtotime(date(config('constants.DATE_FORMAT.DB_STORE_DATE_FORMAT'))):strtotime($lis['start_date']) >= strtotime(date(config('constants.DATE_FORMAT.DB_STORE_DATE_FORMAT'))))) {?>
                            <div class="sb_join_tournament_main" id="{{$lis['id']}}" spid="{{$lis['sports_id']}}" val="{{!empty($lis['schedule_type'])?(($lis['schedule_type']=='individual')?'PLAYER_TO_TOURNAMENT':'TEAM_TO_TOURNAMENT'):''}}">

        @if($lis['enrollment_type'] == 'online' && $lis->bankaccount !== null && $lis->bankaccount->varified == 1)
                                     

            @if($lis->is_sold_out==1)
                                <a href="#" class="sj_add_but"><span><i class="fa fa-check"></i>Sold Out / Registrations closed</span></a>
            @else

                           
                @if($lis->total_enrollment==0)
                                <a  class="sj_add_but_closed"><span><i class="fa fa-check"></i>Registrations closed</span></a>
                @else

                            
                    @if($open_dt_tm < $current_dt_tm && $close_dt_tm > $current_dt_tm) 
                               <a href="{{ url('/tournaments/eventregistration').'/'.$lis['id'] }}" class="sj_add_but_closed"><span><i class="fa fa-check"></i>Event Registration (Online Payment)</span></a>
                               @elseif($open_dt_tm > $current_dt_tm)
                                <a  class="sj_add_but_closed"><span><i class="fa fa-check"></i>Registration Not Started</span></a>
                    @elseif($close_dt_tm < $current_dt_tm)
                              <a  class="sj_add_but_closed"><span><i class="fa fa-check"></i>Registration Closed</span></a>
                    @else
                              <a  class="sj_add_but_closed"><span><i class="fa fa-check"></i>Registration Not Available</span></a>
                    @endif

                              
                @endif
                              

            @endif

                             

        @else
                            <a href="#" class="sj_add_but"><span><i class="fa fa-check"></i> Event Registration (Offline Payment)</span></a>
        @endif
                            </div>

                            
                            
                            <?php }?>  

                                <div class="follow_unfollow_tournament" id="follow_unfollow_tournament_{{$lis['id']}}" uid="{{$lis['id']}}" val="TOURNAMENT" flag="{{ in_array($lis['id'],$follow_array)?0:1 }}"><a href="#" id="follow_unfollow_tournament_a_{{$lis['id']}}" class="{{ in_array($lis['id'],$follow_array)?'sj_unfollow':'sj_follow' }}"><span id="follow_unfollow_tournament_span_{{$lis['id']}}"><i class="{{ in_array($lis['id'],$follow_array)?'fa fa-remove':'fa fa-check' }}"></i>{{ in_array($lis['id'],$follow_array)?'Unfollow':'Follow' }}</span></a></div> 

                        </div>
                    </div>
                </div>
                
                <div class=''>
                    <p>&nbsp;</p>
                    <hr class="red">
                </div>

                @include('organization.event_points')

    </div>
                @endforeach

                     @can('createTeam', $orgInfoObj)
                          
                          <center>   <a href='/tournaments/{{$parent_tournament->id}}/edit' class='btn btn-tiny btn-primary'> Add Event</a> </center>
                      @endcan
                         
                </div>
                
            @include('organization.overall_standing')
        </div>
        @endforeach 
        @else
        <div class="sj-alert sj-alert-info sj-alert-sm">No tournament conducted by the organization.</div>
        @endif
    </div>
</div>



@include('organization_2._sidebar')
@include ('widgets.teamspopup')

@endsection


@section('end_scripts')

    <script>
            $(document).ready(function(){
                $(".show_sub_tournament").click(function(){
                    parent_id = $(this).attr('parent_tour_id');
                    $("#subtournament_"+parent_id).slideToggle("1500");
                });
            });
        </script>


        <script type="text/javascript">
            $(document.body).on('click', '.sb_join_tournament_main .sj_add_but' ,function(){        
        var sport_id = $(this).attr('spid');
        var val = $(this).attr('val');
        var id = $(this).attr('id');
        var title = $("#touname_"+id).html();
        var jsflag = 'Tournaments';

        console.log(title)
        if(val === 'PLAYER_TO_TOURNAMENT')
        {
            id = [$(this).attr('id')];
            var user_id = '{{ Auth::user()->id }}';
            $.confirm({
                title: 'Confirm',
                content: "Do you want to join "+title+"?",
                confirm: function() {
                    $.post(base_url+'/team/saverequest',{flag:val,player_tournament_id:user_id,team_ids:id},function(response,status){
                        if(status == 'success')
                        {
                            if(response.status == 'success')
                            {
                                 $.alert({
                                    title: "Alert!",
                                    content: 'Request sent successfully.'
                                });
                                $("#hid_flag").val('');
                                $("#hid_val").val('');
                            }
                            else if(response.status == 'exist')
                            {
                                $.alert({
                                    title: "Alert!",
                                    content: 'Request already sent.'
                                });
                                $("#hid_flag").val('');
                                $("#hid_val").val('');              
                            }
                            else
                            {
                                $.alert({
                                    title: "Alert!",
                                    content: 'Failed to send the request.'
                                });
                                $("#hid_flag").val('');
                                $("#hid_val").val('');                          
                            }
                        }
                        else
                        {
                            $.alert({
                                title: "Alert!",
                                content: 'Failed to send the request.'
                            });
                            $("#hid_flag").val('');
                            $("#hid_val").val('');
                        }
                    })              
                },
                cancel: function() {
                    // nothing to do
                }
            });   
        }
        else
        {
            generateteamsdiv(sport_id,val,id,title,jsflag); 
        }
    }); 
        </script>
@stop