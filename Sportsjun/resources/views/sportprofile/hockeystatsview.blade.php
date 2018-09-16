@if (count($sportsPlayerStatistics))
    <h4><b>{{ config('constants.SOCCER_STATS.SOCCER_STATISTICS')}}</b></h4>
    <div class="table-responsive stats-table">
    <table class="table">
        <thead>
            <tr>
                <th>{{ config('constants.STATISTICS.MATCHES')}}</th>
                <th>{{ config('constants.SOCCER_STATS.YELLOW_CARDS')}}</th>
                <th>{{ config('constants.SOCCER_STATS.RED_CARDS')}}</th>
                <th>{{ config('constants.SOCCER_STATS.GOALS_SCORED')}}</th>
<!--                <th>{{ config('constants.SOCCER_STATS.GOALS_SAVED')}}</th>
                <th>{{ config('constants.SOCCER_STATS.GOALS_ASSIST')}}</th>
                <th>{{ config('constants.SOCCER_STATS.GOALS_PENALTIES')}}</th>-->
            </tr>
        </thead>
        <tbody>
            @foreach($sportsPlayerStatistics as $statistic)  
            <tr>
                <td>{{$statistic->matches}}</td>
                <td>{{$statistic->yellow_cards}}</td>
                <td>{{$statistic->red_cards}}</td>
                <td>{{$statistic->goals_scored}}</td>
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