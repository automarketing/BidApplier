 <ul class="nav nav-tabs nav-justified">
  <li class="{{$rubber->rubber_number==$active_rubber?'active':$rubber->match_status}}">
      <a>
     <span class="pull-left hidden-xs">{{date('jS F , Y',strtotime($rubber['match_start_date'])).' - '.date("g:i a", strtotime($rubber['match_start_time']))}}</span>
        RUBBER {{$rubber->rubber_number}}   &nbsp; &nbsp; <span style='color:white'> [ {{$rubber->match_category}} , {{$rubber->match_type}} ]</span>
        <span class='pull-right'>{{strtoupper($rubber->rubber_number==$active_rubber?'PLAYING':$rubber->match_status)}}
        </span>
        </a>
</ul>

{!!$rubber->rubber_number==$active_rubber?"<br>":''!!}


    <div class="row">
    <div class="col-sm-12">
   <div class='table-responsive'>

    @if(isset($rubber_a_array['team_id']))
      <table class='table table-striped table-bordered'>
        <thead>
          <tr class='team_fall team_title_head'>
        
             <th>PLAYERS</th>

             @for($set_index=1; $set_index<=$set; $set_index++)
              <th>SET {{$set_index}}</th>
             @endfor
               <th>ACES </th>
              <th>D FAULTS </th>

          </tr>
        </thead>
        <tbody>
             <tr @if(!empty($rubber_a_array['team_id']) && ($rubber_a_array['team_id']==$rubber->winner_id)) class='winner_set' @endif>
           

            <td>  
             @if(!is_null($rubber_a_array['team_id']))<b>{{$rubber_a_array['team_name']}}</b><br>@endif {{$rubber_a_array['player_name_a']}} / {{$rubber_a_array['player_name_b']}}</td>

          @for($set_index=1; $set_index<=$set; $set_index++)
                 
               <td class='a_set{{$set_index}} ' >
                 @if($rubber_a_array['set'.$set_index] || $rubber_b_array['set'.$set_index]  )
                        <span class="score_data_bold">
             
                {{Helper::displayEmptyDash($rubber_a_array['set'.$set_index],'0')}}
                          </span>

                      <sup>
                      {{Helper::displayEmptyDash($rubber_a_array['set'.$set_index.'_tie_breaker'],'0')}}
                      </sup>
              @endif
             
               </td>
          @endfor
              <td> {{$rubber_a_array['aces']}}</td>
            <td>{{$rubber_a_array['double_faults']}} </td>
          
          </tr>

          <tr @if(!empty($rubber_b_array['team_id']) && ($rubber_b_array['team_id']==$rubber->winner_id)) class='winner_set' @endif>
         
            <td>
            @if(!is_null($rubber_b_array['team_id']))<b>{{$rubber_b_array['team_name']}}</b><br>@endif 
            {{$rubber_b_array['player_name_a']}} / {{$rubber_b_array['player_name_b']}}</td>
            @for($set_index=1; $set_index<=$set; $set_index++)
                  
               <td class='b_set{{$set_index}}  '>

               @if($rubber_a_array['set'.$set_index] || $rubber_b_array['set'.$set_index]  )
                      <span class="score_data_bold">
                       {{Helper::displayEmptyDash($rubber_b_array['set'.$set_index],'0')}}
                       
                        </span>

                        <sup>
                        {{Helper::displayEmptyDash($rubber_b_array['set'.$set_index.'_tie_breaker'],'0')}}
                        </sup>
                  @endif
                  
                </td>
          @endfor

            <td> {{$rubber_b_array['aces']}}</td>
            <td>{{$rubber_b_array['double_faults']}} </td>
        </tr>

        </tbody>
        </tbody>
      </table>

        @endif
    </div>


