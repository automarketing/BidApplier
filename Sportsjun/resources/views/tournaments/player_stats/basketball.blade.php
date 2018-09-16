@if (count($player_standing))

<div class="row ">
    <div class="table-responsive stats-table teamStatsDiv" >
    <table class="table table-bordered table-striped " >
        <thead>
            <tr>
                <th>PLAYER </th>
                <th>TEAM </th>
                <th>MAT</th>
                <th>1 P</th>
                <th>2 P</th>
                <th>3 P</th>
                <th>T PTS</th>
                <th>{{ config('constants.BASKETBALL_STATS.FOULS')}}</th>
<!--                <th>{{ config('constants.BASKETBALL_STATS.GOALS_SAVED')}}</th>
                <th>{{ config('constants.BASKETBALL_STATS.GOALS_ASSIST')}}</th>
                <th>{{ config('constants.BASKETBALL_STATS.GOALS_PENALTIES')}}</th>-->
            </tr>
        </thead>
        <tbody>
            @foreach($player_standing as $statistic)
            <tr>
                <td>
                    @if (!Auth::guest())
                    <a href='/editsportprofile/{{$statistic->user_id}}' class="text-primary">
                    @endif
                        <span class='hidden-xs hidden-sm'>
 {!! Helper::Images($statistic->logo,'user_profile',array('class'=>'img-circle img-border ','height'=>52,'width'=>52), isset($to_print)?true:false )!!}

                </span>
                    {{$statistic->player_name}}
                        @if (!Auth::guest())
                    </a>
                        @endif
                </td>
                <td>
                    @if (Auth::guest())
                        {{$statistic->team_name}}
                    @else
                    <a href='/team/members/{{$statistic->team_id}}' class="text-primary">{{$statistic->team_name}}</a>
                    @endif

                </td>
                <td>{{$statistic->matches}}</td>
                <td>{{Helper::displayEmptyDash($statistic->points_1)}}</td>
                <td>{{Helper::displayEmptyDash($statistic->points_2)}}</td>
                <td>{{Helper::displayEmptyDash($statistic->points_3)}}</td>
                <td>{{Helper::displayEmptyDash($statistic->total_points)}}</td>
                <td {{$statistic->fouls>0?"class=red":''}}>{{Helper::displayEmptyDash($statistic->fouls)}}</td>
<!--                <td>{{$statistic->goals_saved}}</td>
                <td>{{$statistic->goal_assist}}</td>
                <td>{{$statistic->goal_penalties}}</td>-->
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    @else

    <div class="sj-alert sj-alert-info">
                       {{ trans('message.sports.nostats')}}
</div>
    @endif