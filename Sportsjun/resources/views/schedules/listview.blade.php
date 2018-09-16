<input type="hidden" name="limit" id="limit" value="{{$limit}}"/>
<input type="hidden" name="offset" id="offset" value="{{$offset}}"/>


    <div class="col-sm-12 viewmoreclass">
    <div class="row">
        @if(count($matchScheduleData))
        @foreach($matchScheduleData as $schedule)
        <div id="schedule_{{$schedule['id']}}" class="schedule_list clearfix">
	        <div class="deskview hidden-xs">
	            <div id="teamone_{{$schedule['scheduleteamone']['id']}}" class="col-sm-3 score_view_img">
                <p><!--<img src="{{ asset('/uploads/'.config('constants.PHOTO_PATH.TEAMS_FOLDER_PATH').'/'.$schedule['scheduleteamone']['url']) }}" onerror="this.onerror=null;this.src='{{ asset('/images/default-profile-pic.jpg') }}';" height="30" width="30">-->
				 {!! Helper::Images($schedule['scheduleteamone']['url'],config('constants.PHOTO_PATH.TEAMS_FOLDER_PATH'),array('class'=>'img-circle img-border','height'=>90,'width'=>90) )!!}</p>
                
            </div>    
            
	            <div id="center_div" class="col-sm-6">
                <p class="vs_text">
                     <span>
                         <a href="{{ url('/team/members',[$schedule['a_id']]) }}">
                         {{$schedule['scheduleteamone']['name']}}
                         </a>
                     </span> 
                        vs 
                    <span>@if(isset($schedule['scheduleteamtwo']['name']))
                            <a href="{{ url('/team/members',[$schedule['b_id']]) }}">{{$schedule['scheduleteamtwo']['name']}}
                            </a>
                          @else  
                            {{trans('message.bye')}}
                          @endif  
                    </span>
                </p>
                
                <?php 
                        $schedule['match_start_date'] = trim($schedule['match_start_date']);
                        if (strpos($schedule['match_start_date'], ':') == false)
                        {
                                $schedule['match_start_date'] = DateTime::createFromFormat('d/m/Y', $schedule['match_start_date'])->format('jS F, Y');
                        }
                        else
                        {
                                $schedule['match_start_date'] = DateTime::createFromFormat('d/m/Y g:i A', $schedule['match_start_date'])->format('jS F, Y g:i A');
                        }
                    ?>
                
                <p class="vs_date">
                    <span>{{ $schedule['match_start_date'] }}</span>
                    <span class='sports_text'>{{ isset($schedule['sport']['sports_name'])?$schedule['sport']['sports_name']:'' }}</span>
                    @if($schedule['match_type']!='other')
                            <span class='match_type_text'>({{ $schedule['match_type']=='odi'?strtoupper($schedule['match_type']):ucfirst($schedule['match_type']) }})</span>
                    @endif
                </p>  
                
                <?php 
                        if (strpos($schedule['match_start_date'], ':') == false) {
                                $schedule['match_start_date'] .= ' 00:00 AM'; 
                        }
                ?>
                
                @if(isset($schedule['winner_text']))
                <p>
                    <span style="color:rgba(0,0,0,0.5)">
                        @if($schedule['winner_text']==trans('message.schedule.pending'))
                            {{ trans('message.schedule.invitationpending') }}
                        @elseif($schedule['winner_text']==trans('message.schedule.rejected'))
                            {{ trans('message.schedule.invitationrejected') }}
                        @else    
                            <a href="{{ url('match/scorecard/edit/'.$schedule['id']) }}" class="add_score_but">{{$schedule['winner_text']}}</a>
                        @endif    
                    </span>
                </p>
                @elseif($isOwner)
                <p><span><a href="#" id="scheduleEdit_{{$schedule['id']}}" onclick="editMatchSchedule({{$schedule['id']}},{{$isOwner}},'','myModal')" class="add_score_but">Edit</a></span></p>
                @elseif(strtotime($schedule['match_start_date']) < time())
                        <p><span><a href="{{ url('match/scorecard/view/'.$schedule['id']) }}" class="add_score_but">{{trans('message.schedule.viewscore')}}</a></span></p>
                @endif
                 
             </div>
            
	            <div id="teamtwo_{{$schedule['scheduleteamtwo']['id']}}" class="col-sm-3 score_view_img">
                <p><!--<img src="{{ asset('/uploads/'.config('constants.PHOTO_PATH.TEAMS_FOLDER_PATH').'/'.$schedule['scheduleteamtwo']['url']) }}" onerror="this.onerror=null;this.src='{{ asset('/images/default-profile-pic.jpg') }}';" height="30" width="30">-->
				 {!! Helper::Images($schedule['scheduleteamtwo']['url'],config('constants.PHOTO_PATH.TEAMS_FOLDER_PATH'),array('class'=>'img-circle img-border','height'=>90,'width'=>90) )!!}</p>
                
            </div>
            </div>
            <div class="mobview hidden-sm hidden-lg">
                <div class="row">
                	<div id="teamone" class="col-xs-5 score_view_img">
                        <p>
                            {!! Helper::Images($schedule['scheduleteamone']['url'],config('constants.PHOTO_PATH.TEAMS_FOLDER_PATH'),array('class'=>'img-circle img-border','height'=>90,'width'=>90) )!!}
                        </p>
                        <p class="vs_text">
                            <span>
                                <a href="{{ url('/team/members',[$schedule['a_id']]) }}">{{$schedule['scheduleteamone']['name']}}
                                </a>    
                            </span></p>
                    </div> 
                    <div id="teamtwo" class="col-xs-5 score_view_img">
                        <p>
                        	{!! Helper::Images($schedule['scheduleteamtwo']['url'],config('constants.PHOTO_PATH.TEAMS_FOLDER_PATH'),array('class'=>'img-circle img-border','height'=>90,'width'=>90) )!!}
                        </p>
                        <p class="vs_text">
                            <span>@if(isset($schedule['scheduleteamtwo']['name']))
                                <a href="{{ url('/team/members',[$schedule['b_id']]) }}">{{$schedule['scheduleteamtwo']['name']}}
                                </a>
                              @else  
                                {{trans('message.bye')}}
                              @endif  
                            </span>
                        </p>
                    </div>    
                </div>
                
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <p>
                        <span>{{ $schedule['match_start_date'] }}</span>
                        <span class='sports_text'>{{ isset($schedule['sport']['sports_name'])?$schedule['sport']['sports_name']:'' }}</span>
                        @if($schedule['match_type']!='other')
                            <span class='match_type_text'>({{ $schedule['match_type']=='odi'?strtoupper($schedule['match_type']):ucfirst($schedule['match_type']) }})</span>
                        @endif
                    </p>  
                    @if(isset($schedule['winner_text']))
                        @if($schedule['winner_text']=='Edit') 
                            <p><span><a href="#" id="scheduleEdit_{{$schedule['id']}}" onclick="editMatchSchedule({{$schedule['id']}}, 1, '','myModal')" class="add_score_but">Edit</a></span></p>
                        @elseif($schedule['winner_text']==trans('message.schedule.pending'))
                            <p><span style="color:rgba(0,0,0,0.5)">{{ trans('message.schedule.invitationpending') }}</span></p>
                        @elseif($schedule['winner_text']==trans('message.schedule.rejected'))
                            <p><span style="color:rgba(0,0,0,0.5)">{{ trans('message.schedule.invitationrejected') }}</span></p>
                        @else    
                            <p><span><a href="{{ url('match/scorecard/edit/'.$schedule['id']) }}" class="add_score_but">{{$schedule['winner_text']}}</a></span></p>
                        @endif    
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div class="col-xs-6 col-centered">
            {{ trans('message.schedule.noschedule')}}
        </div>
        @endif
    </div>
    </div>
    <div class="clearfix"></div>
    @if($matchScheduleDataTotalCount>count($matchScheduleData)) 
    <!--<div  id="viewmorediv">
        <div id="viewmorebutton" class="btn btn-view">{{ trans('message.view_more') }}</div>
    </div>-->
    
    
<div id="viewmorediv">
    <a id="viewmorebutton" class="view_tageline_mkt">
        <span class="market_place"><i class="fa fa-arrow-down"></i> <label>{{ trans('message.view_more') }}</label></span>
    </a>
</div>
    @endif
  




<script type="text/javascript">
            $(document).ready(function() {
    $("#offset").val({{$offset}});        
    if ($("#viewmorediv").length) {
    $('#viewmorebutton').on("click", function(e) {
    var params = { limit:{{$limit}}, offset:$("#offset").val(), month:$("#currentMonth").val(),
            year:$("#currentYear").val(), teamId:{{$teamId}}, sportsId:{{$sportsId}}, isOwner:{{$isOwner}}  };
            viewMore(params, '{{URL('team/viewmorelist')}}');
    });
            global_record_count = {{$matchScheduleDataTotalCount}}
    }

    });
</script>