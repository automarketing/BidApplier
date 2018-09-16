@extends('layouts.app')
@section('content')
  <style>
    .error{
        color:red;
        font-weight: normal;
    }
    
  </style>


<?php 

    $team_a_name = $user_a_name;
    $team_b_name = $user_b_name;

    $match_data[0]['tournament_id']!=null?$disabled='readonly':$disabled='';
    $match_settings   =   Helper::getMatchSettings($match_data[0]['tournament_id'],$match_data[0]['sports_id']);

    $team_a_id=$match_data[0]['a_id'];
    $team_b_id=$match_data[0]['b_id'];

    $player_a_ids=$match_data[0]['player_a_ids'];
    $player_b_ids=$match_data[0]['player_b_ids'];

    $pp_ids = [];



    $match_details=json_decode($match_data[0]['match_details']);
    $old_match_details=$match_details;
      if($match_data[0]['game_type']=='rubber'){
          if(count($rubber_details))
            $match_details=json_decode($rubber_details['match_details']);
            isset($match_details->preferences)? $match_details = $match_details: $match_details = $old_match_details;
      }

    isset($match_details->preferences)?$preferences=$match_details->preferences:[];
    

    ${'team_'.$match_data[0]['a_id'].'_score'}='0 sets';
    ${'team_'.$match_data[0]['b_id'].'_score'}='0 sets'; 

    $team_a_info='';
    $team_b_info='';
?>

<style>
   
    input:read-only { 
    background-color: #f4f4f4;

}
.button_add, .button_add:hover, .button_add:active{
   color:green;
  background: none;
  border: 0px #fff inset;
}
.button_remove, .button_remove:hover, .button_add:active{
  color:red;
  background: none;
  border: 0px #fff inset;
}

.main_tour{
    background: #111;
}

td,th{
  height: 60px;
  border: 1px inset black;
}

.border td{
    border: 1px inset #ddd !important;
}

.btn-pink, .btn-pink:active{
    background: #9050ff;
    color: white;
}
.btn-arrow{
    background: #fd9242;
    color: black;
    height:65px;
    border-radius: 50%;
    margin-left: 10px;
    width: 65px;
    padding: 0px !important;
}

.a_s:hover{
  background: #ffdddd;
}
.a_s{
    cursor: pointer;
    font-size: 20px !important;
}


</style>
<div class="col_standard archery_scorecard ">
    <div id="team_vs" class="ac_bg">
      <div class="container">
         

                @if(!is_null($match_data[0]['tournament_id']))
                <div class='row'>
                    <div class='col-xs-12'>
                        <center>
                          <a href="/tournaments/groups/{{$tournamentDetails['id']}}">
                                    <h4 class="team_name">    {{$tournamentDetails['name']}} Tournament </h4>
                                  </a>
                                
                       </center>
                    </div>
                </div>
            @endif

            <div class="row">
              <div class="col-xs-12">
                  <div class="match_loc">
                      {{ date('jS F , Y',strtotime($match_data[0]['match_start_date'])).' - '.date("g:i a", strtotime($match_data[0]['match_start_time'])).(($match_data[0]['facility_name']!='')?' , '.$match_data[0]['facility_name']:'').(($match_data[0]['address']!='')?' , '.$match_data[0]['address']:'') }}
                    </div>
                </div>
            </div>
			<h5 class="scoreboard_title">Archery Scorecard @if($match_data[0]['match_type']!='other')
											<span class='match_type_text'>({{ $match_data[0]['match_type']=='odi'?strtoupper($match_data[0]['match_type']):ucfirst($match_data[0]['match_type'])}} , {{ucfirst($match_data[0]['match_category'] )}})</span>
									@endif</h5>

            <h5 class="scoreboard_title"> No of Athlets : {{$match_obj->archery_players()->count()}} </h5>
        </div>
          @if (session('status'))
          <div class="alert alert-success">{{ session('status') }}</div>
          @endif
    </div>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
    <div class="form-inline">
    @if($match_data[0]['hasSetupSquad'] && $match_data[0]['match_status']!='completed' )
          <br>
       <div id='end_match_button'>
    
           <button type="button" class="btn btn-danger" onclick="end_match_archery()"> End Match</button>
     
        </div>
    @endif
 @if($isValidUser && $isForApprovalExist && ($match_data[0]['winner_id']>0 || $match_data[0]['is_tied']>0 || $match_data[0]['has_result'] == 0))    
      <button style="text-align:center;" type="button" onclick="forApproval();" class=" btn btn-primary">Send Score for Approval</button>
      @endif


	@if($match_data[0]['match_status']=='completed')
	<div class="form-group">
    	<label class="win_head">Winner</label> 
        <h3 class="win_team">{{ ($match_data[0]['a_id']==$match_data[0]['winner_id'])?$user_a_name:$user_b_name }}</h3>
    </div>
	@else

     

	@endif
    <p class="match-status mg"><a href="{{ url('user/album/show').'/match'.'/0'.'/'.$action_id }}"><span class="fa" style="float: left; margin-left: 8px;  "><img src=" {{ asset('/images/sc-gallery.png') }}" height="18" width="22"></span> <b>Media Gallery</b></a></p>
        @include('scorecards.share')
         <BR><BR><BR>
        <p class="match-status">@include('scorecards.scorecardstatus')</p>
    </div>



<!-- Setup Squad -->

   <div class="row">
          <div class="col-sm-12">

      @if(!$match_data[0]['hasSetupSquad'] )     


            <div class="clearfix">
            <div class="row">
                <div class="col-sm-12" id='list_rounds'>
                    @include('scorecards.archery.rounds')
                </div>
            </div>

              <!-- Schedule Type is single -->
           
                  <div class="row">
                    <div class="col-sm-12">
                       <div class="col-sm-6">
                        <center>    <h4 class="team_fall table_head">  {{$match_data[0]['schedule_type']=='player'?'Players':'Teams'}}</h4> </center>
                             <table class="table table-striped table-bordered">
                               @foreach($players as $player)
                                    <tr>
                                      <td style="height:25px;">

                                       {{$match_data[0]['schedule_type']=='player'?$player->player_name:$player->team_name}} <br>

                                      </td>
                                    </tr>
                                  @endforeach
                              </table>
                                                 
                        </div>
                      </div>
                    </div>


              <!-- Schedule Type is Team -->

            
                  <!-- If schedule type is player, then we need to select the players. -->




            <div class="row">
            
              <div class="col-sm-12">
                <br>
                  <hr>
                  <div class="pull-left">

               <span color='red'><b>Note :</b></span> Please add round to this match to score further &nbsp;&nbsp;&nbsp;

                <a href='javascript:void(0)' class="btn btn-danger" data-toggle='modal' data-target='#new_round_modal'>
                  <i class="fa fa-plus"></i>
                  Add new round
                  </a>
              </div>


            

              </div>
            </div>

          <!-- New round Modal -->

          <div id='new_round_modal' class="fade modal modal-tiny tossDetail" tabindex="-1" >
               <div class="modal-dialog sj_modal sportsjun-forms">
                 <div class="modal-content">
                    <div class="modal-header text-center">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4>New Round</h4>
                                  </div>
                      <div class="alert alert-danger" id="div_failure1"></div>
                      <div class="alert alert-success" id="div_success1" style="display:none;"></div>
                    <div class="modal-body">
                    <center>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class='section'>
                                    <label class="field label">Distance</label><br>
                                    <input type="number" name="distance" id='distance' class="gui-input" step="5" min="0">
                                </div>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-sm-12">
                                <div class='section'>
                                    <label class="field label">Number of Arrows</label>
                                    <br>
                                    <input type="number" name="number_of_arrows" id='number_of_arrows' class="gui-input">
                                </div>
                            </div>
                        </div>   
                      </center>   

                    </div>


                  <div class="modal-footer">
                    <button type='button' class='btn btn-primary' onclick="add_round()" >Add Round</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>

          </div>

          <!-- End of New round Modal -->

   
<!-- End of Squad Setup -->

  @else 

<!-- Start Scoring -->
<div class="row">
    <div class='col-sm-12'>
     <span class='pull-right'>   
        <a href='javascript:void(0)' onclick="enableManualEditing(this)" style="color:#123456;">edit <i class='fa fa-pencil'></i></a> 
        <span> &nbsp; &nbsp; </span>
        <a href='javascript:void(0)' data-toggle='modal' data-target='#updatePreferencesModal' style='color:#123456;'> settings <i class='fa fa-gear fa-danger'></i></a>
        <span> &nbsp; &nbsp; </span>
    </span>
    </div>
  </div>
  
    <div class="row">

      <div class="col-sm-12">

        <div class="table-responsive">

          <table class="table table-striped table-bordered border" border="1">
            <thead>
              <tr class="thead">
                <th>  </th>
                @foreach($match_obj->archery_rounds as $round)
                <th> {{$round->distance}} Mts </th>
                @endforeach
                <th> Total</th>
              </tr>
            </thead>

            <tbody>
            <?php $p_index=1;?>
              <!-- If Team -->
            
            @if($match_data[0]['schedule_type']=='player')
                  @foreach($players as $player)
                     <tr>
                          <td>{{$player->player_name}} <br>
                            <b>{{$player->team_name}}</b> </td>
                      @foreach($match_obj->archery_rounds as $round)
                        <td class="a_s player_{{$p_index}}_round_{{$round->round_number}} player_{{$player->id}}_round_{{$round->round_number}}" player_id='{{$player->id}}' user_id='{{$player->user_id}}' round_number="{{$round->round_number}}" round_id="{{$round->id}}"> {{$player->{'round_'.$round->round_number} }} </td>

                        <?php $p_index++;?>
                      @endforeach
                        <td class='player_{{$player->id}}_total text-primary' style="font-size:20px">{{$player->total}}
                        </td>
                    </tr>
                  @endforeach
            @else
                  @foreach($players as $player)
                     <tr>
                          <td><b>{{$player->team_name}}</b> <br>
                         </td>
                      @foreach($match_obj->archery_rounds as $round)

                    <?php  $team_player = ScoreCard::get_archery_team_player($player->id, $round);?>
                        <td class="a_s player_{{$p_index}}_round_{{$round->round_number}} a_s team_{{$player->team_id}}_round_{{$round->round_number}}  player_{{$player->id}}_round_{{$round->round_number}}" player_id="{{$team_player['id']}}" user_id="{{$team_player['user_id']}}" round_number="{{$round->round_number}}" round_id="{{$round->id}}" team_id='{{$player->team_id}}' team_player_id='{{$player->id}}'>
                                <span  class="team_{{$player->team_id}}_round_{{$round->round_number}}_score"> {{$player->{'round_'.$round->round_number} }} </span>
                            <br> <span style="font-size: 14px" class="team_{{$player->team_id}}_round_{{$round->round_number}}_player_name">{{$team_player['player_name']}}</span>
                        </td>

                        <?php $p_index++;?>
                      @endforeach
                        <td class='player_{{$player->id}}_total text-primary team_{{$player->team_id}}_total' style="font-size:20px">{{$player->total}}
                        </td>
                    </tr>
                  @endforeach


            @endif
           
            </tbody>
          </table>

        </div>


        <div id='load_round_details' style="display:none">
              
        </div>

      </div>
    </div>


    <input type="hidden" id='match_id' value="{{$match_obj->id}}">
    <input type="hidden" id='tournament_id' value="{{$match_obj->tournament_id}}">
    <input type="hidden" id='selected_user_id'  value=''>
    <input type="hidden" id='selected_round_number' value="">
    <input type="hidden" id='selected_round_id' value="">
    <input type="hidden" id='selected_player_id' value="">
    <input type="hidden" id='selected_arrow_number' value="">
    <input type="hidden" id='team_player_id' name="">
    <input type="hidden" id='edit_is_allowed' value="0">


    @if($match_data[0]['schedule_type']=='team')

       <?php $pp_ids = [];?>
                    @foreach($player_or_team_ids as $pt_id)
                      @if(!empty($pt_id))
                      <?php $pp_ids[] = $pt_id;?>

             <div id='modal_player_team_{{$pt_id}}' class="fade modal modal-tiny tossDetail" tabindex="-1" >
               <div class="modal-dialog sj_modal sportsjun-forms">
                 <div class="modal-content">
                    <div class="modal-header text-center">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4>Select Player - {{$player_or_team_list[$pt_id]['name']}}</h4>
                                  </div>
                      <div class="alert alert-danger" id="div_failure1"></div>
                      <div class="alert alert-success" id="div_success1" style="display:none;"></div>
                    <div class="modal-body">

                  <div style="">
                      <div id='{{$pt_id}}_players_list'>
                        <select class="form-control" id='select_team_player_{{$pt_id}}'>
                            @foreach($player_or_team_list[$pt_id]->TeamPlayers as $pr)
                              <option value="{{$pr->user->id}}">{{$pr->user->name}}</option>
                            @endforeach
                        </select>
                      </div>                   

                  </div>
                </div>
                  <div class="modal-footer">
                    <button type='button' class='btn btn-primary' onclick="choose_player_to_score({{$pt_id}})" >Select Player </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clear_selected()">Cancel</button>
                  </div>

                </div>
                </div>
              </div>

                     @endif
             @endforeach
    @endif

<!-- End Scoring -->


  <div id="updatePreferencesModal" class="modal fade">
            <div class="modal-dialog sj_modal sportsjun-forms">
              <div class="modal-content">
                   <div class="modal-header text-center">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 style="color:white">Update Preferences</h4>
                                  </div>
                <div class="alert alert-danger" id="div_failure1"></div>
                <div class="alert alert-success" id="div_success1" style="display:none;"></div>
                <div class="modal-body">

                <form onsubmit="" id='updatePreferencesForm'>
                  <div class='row'>
               
                      <div class="col-sm-12">
                        <div class="form-group">
                          <div class="col-sm-4">
                              Round 
                          </div>
                          <div class="col-sm-4">
                              Distance 
                          </div>
                          <div class="col-sm-4">
                              Number of Arrows
                          </div>
                          </div>

                          @foreach($match_obj->archery_rounds as $round)
                            <br>
                            <div class="row">
                              <div class="form-group">
                              <div class="col-sm-12">
                            <div class="col-sm-4">
                              Round {{$round->round_number}}
                            </div>
                            <div class="col-sm-4">
                              <input type='text' class="form-control gui-input" name='round_{{$round->id}}_distance' placeholder="distance" value="{{$round->distance}}" {{ScoreCard::round_has_started($round->id,$match_obj->id, $match_obj->tournament_id)?'readonly':''}}>
                            </div>
                            <div class="col-sm-4">
                                <input type='text' class="form-control gui-input" name='round_{{$round->id}}_number_of_arrows' placeholder="number of arrows" value="{{$round->number_of_arrows}}" {{ScoreCard::round_has_started($round->id,$match_obj->id, $match_obj->tournament_id)?'readonly':''}}>
                            </div>
                            </div>
                            </div>
                            </div>

                          @endforeach
                        <input type="hidden" name="match_id" value="{{$match_obj->id}}">
                      </div>
                      </div>
                    </div>    
                  </form>
                  </div>            

                    <div class="modal-footer">
                    <button class='button btn btn-primary ' onclick="return updatePreferencesSave(this)" type='submit'> Save</button></center>
                    <button type="button" class="button btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

<!-- End Match -->

   
   @endif


  <script type="text/javascript">

    var match_id     = $('#match_id').val();

      function add_round(){
        var distance = $('#distance').val();
        var number_of_arrows = $('#number_of_arrows').val();
        var match_id         = {{$match_data[0]['id']}}

        if(distance<0 || number_of_arrows<0){
            $.confirm({
                title:'Alert',
                content:'Please enter a valid number!'
            });

            return
        }
        
          $.ajax({
              type:'post',
              url:'/match/archery/add_round',
              data:{distance:distance,number_of_arrows:number_of_arrows,match_id:match_id},
              success:function(response){
                  $('#list_rounds').html(response);
                  $('#new_round_modal').modal('hide');
                  $('#distance').val('');
                  $('#number_of_arrows').val('');
              },
              error:function(){

              }
          })
      }


      function start_scoring(){
          $.confirm({
              title:'Alert!',
              content:'Do you want to save and start scoring?',
              confirm:function(){
                  $.ajax({
                      url:'/match/archery/start_scoring',
                      type:'post',
                      data:{ match_id:{{$match_obj->id}} },
                      success:function( ){
                          window.location = window.location;
                      },
                      error:function(){
                          alert('An error occured retry!');
                      }
                  })
              }
          })
      }

        function load_players(){
            var number_of_players = $('#number_of_player').val(); 
            var player_or_team_ids =  {!!json_encode($pp_ids)!!};   


            html =[];

            for(i=1; i<=number_of_players; i++){

                $.each(player_or_team_ids, function(key,pt_id){
                  html[pt_id] += "<select name='"+pt_id+"_player_"+i+"' class='select_players_"+pt_id+" form-control' ></select> <br>";
               
                })
              
            }

             $.each(player_or_team_ids, function(key,pt_id){   
                      

            $('#select_'+pt_id+'_players').html(html[pt_id]);
            $('.select_players_'+pt_id).html($('#'+pt_id+'_players_list').html());
               
              })


            $('#save_players').show();           
        }

        function insert_players(){
            var data = $('#insert_players').serialize();

            $.ajax({
                url:'/match/archery/insert_players',
                type:'post',
                data:data,
                success:function(){
                    $('#save_players').hide();
                }
            })
        }
  </script>


  <!-- Scoring -->

  <script type="text/javascript">
    
      $('.a_s').click(function(){
          if($(this).hasClass('selected')){
              $(this).removeClass('selected').css({background:'inherit'})
              clear_selected();
              $('#load_round_details').hide();
          }
          else{

         var schedule_type = "{{$match_obj->schedule_type}}";
              $('.a_s').removeClass('selected').css({background:'inherit'});
              $(this).css({background:'#ff8888'}).addClass('selected');
              $('#selected_arrow_number').val('');

              $('#selected_round_number').val($(this).attr('round_number'))
              $('#selected_user_id').val($(this).attr('user_id'))
              $('#selected_round_id').val($(this).attr('round_id'))
              $('#selected_player_id').val($(this).attr('player_id')) 
              $('#team_player_id').val($(this).attr('team_player_id'))

              if($(this).attr('user_id')==''){
                  $('#modal_player_team_'+$(this).attr('team_id') ).modal();
              }

              else if( $('#edit_is_allowed').val()=='1' && (schedule_type=='team') ) {               
                   $('#modal_player_team_'+$(this).attr('team_id') ).modal();
              }

              else{

              $.ajax({
                  url:'/match/archery/load_arrow',
                  type:'post',
                  data:{round_id:$('#selected_round_id').val(),player_id:$('#selected_player_id').val(),match_id:$('#match_id').val()},
                  success:function(response){
                      $('#load_round_details').html(response);
                      $('#load_round_details').show();
                  }
              }) 

            }
          }

      })


      function btn_arrow_click(that){
           $('.btn-arrow').css({background:'#fd9242',color:'black'});
           $('#selected_arrow_number').val($(that).attr('arrow_number'));
           $(that).css({background:'green',color:'white'})
           $('.btn-pink').css({background:'#9050ff'});
      }

      

      //$('.player_1_round_1').css({background:'#ff8888'}).addClass('selected');

      //initialization

      function init(player_round_details){

        var that= $('.'+player_round_details);
        var schedule_type = "{{$match_obj->schedule_type}}";

              $('.a_s').removeClass('selected').css({background:'inherit'});
              $(that).css({background:'#ff8888'}).addClass('selected');
              $('#selected_arrow_number').val('');

              $('#selected_round_number').val($(that).attr('round_number'))
              $('#selected_user_id').val($(that).attr('user_id'))
              $('#selected_round_id').val($(that).attr('round_id'))
              $('#selected_player_id').val($(that).attr('player_id'))
              $('#team_player_id').val($(that).attr('team_player_id'))

              if($(that).attr('user_id')==''){
                    $('#modal_player_team_'+$(that).attr('team_id') ).modal();
              }
              else if( $('#edit_is_allowed').val()==1 && schedule_type=='team' ) {
                   $('#modal_player_team_'+$(that).attr('team_id') ).modal();
              }

              else{

                $.ajax({
                    url:'/match/archery/load_arrow',
                    type:'post',
                    data:{round_id:$('#selected_round_id').val(),player_id:$('#selected_player_id').val(),match_id:$('#match_id').val()},
                    success:function(response){
                        $('#load_round_details').html(response);
                        $('#load_round_details').show();
                    }
                }) 
            }
        }

        function init_player(){
          init('player_1_round_1')
        }

      $(document).ready(function(){
          setTimeout(init_player,1000)
        //init();
      })

      function choose_player_to_score(team_id){
          var round_number = $('#selected_round_number').val();
          var round_id     = $('#selected_round_id').val()
          var player_id    = $('.team_'+team_id+'_round_'+round_number).attr('team_player_id');
          var select_user  = $('#select_team_player_'+team_id).val();
          var match_id     = $('#match_id').val();
          var tournament_id = $('#tournament_id').val();
        
          $.ajax({
              url:'/match/archery/select_team_player',
              data:{round_number:round_number,round_id:round_id,team_id:team_id,player_id:player_id,user_id:select_user,tournament_id:tournament_id,match_id:match_id},
              type:'post',
              success:function(response){
                  $('#modal_player_team_'+team_id ).modal('hide');
                  var that = $('.team_'+team_id+'_round_'+round_number);

                  $(that).attr('player_id',response.id);
                  $(that).attr('user_id',response.user_id);
                  $('.team_'+team_id+'_round_'+round_number+'_player_name').html(response.player_name);

                  init("team_"+team_id+"_round_"+round_number+"");
                  $('#edit_is_allowed').val(0);
              }
          })


      }

      function clear_selected(){
          $('#selected_round_number').val('');
          $('#selected_user_id').val('');
          $('#selected_round_id').val('');
          $('#selected_player_id').val('');
          $('#selected_arrow_number').val('');
          $('#team_player_id').val('')
        //  $('#edit_is_allowed').val(0);
      }


      function btn_pink_click(that){
          $('.btn-pink').css({background:'#9050ff'});

            var round_number = $('#selected_round_number').val();
            var user_id      = $('#selected_user_id').val();
            var round_id     = $('#selected_round_id').val();
            var player_id    = $('#selected_player_id').val();
            var arrow_number = $('#selected_arrow_number').val();     
            var team_player_id = $('#team_player_id').val();       
            var value        = $(that).attr('value');
            var schedule_type ="{{$match_obj->schedule_type}}";

            var attr = $(that);

        if(round_number==''){
            $.alert({
                title:'Alert',
                content:'Please select a player',
              })
          return false;
        }

        if(arrow_number==''){
            $.alert({
                title:'Alert',
                content:'Please select an Arrow',
              })
          return false;
        }

          $.ajax({
              url:'/match/archery/arrow_scoring',
              type:'post',
              data:{match_id:match_id,user_id:user_id,arrow_number:arrow_number,round_number:round_number,round_id:round_id,player_id:player_id,value:value,schedule_type:schedule_type, team_player_id:team_player_id},
              success:function(response){
                  attr.css({background:'green'});

                  if(schedule_type=='team'){
                      team_id = response.team_id;
                  }else team_id = '';

                  for(i=1;i<=10;i++){
                      $('.player_'+player_id+'_round_'+i).html(response['round_'+i]);
                      $('.team_'+team_id+'_round_'+i+'_score').html(response['round_'+i]);
                  }

                  $('.player_'+player_id+'_total').html(response.total);
                  $('.team_'+team_id+'_total').html(response.total);

                  $('#arrow_'+arrow_number).html(value);
              },
              error:function(){
                  //attr.css({background:'green'});
              }
          })
          
      }


      function end_match_archery(){

        $.confirm({
            title:"Alert!",
            content:"Are you sure you want to end this match?",
            confirm:function(){
                $.ajax({
                  url:'/match/archery/end_match',
                  type:'post',
                  data:{match_id:match_id},
                  success:function(){
                      window.location = window.location;
                  }
              })
            }
        })

            
      }
  </script>


  <script type="text/javascript">
       function updatePreferencesSave(){
          var data=$('#updatePreferencesForm').serialize();

          $.confirm({
            title:"Alert",
            content: "Update Preferences?",
            confirm: function(){
                                  $.ajax({
                                  url:base_url+"/match/archery/update_settings",
                                  type:'post', 
                                  data:data,
                                  success:function(){
                                      window.location=window.location
                                  }         

                                 })
                             }
            })
            
          return false;
     }

     function enableManualEditing(){
         $.confirm({
            title:"Alert",
            content: "Click on a square to change the player",
            confirm: function(){
                      $('#edit_is_allowed').val(1);    
                             }
            })
     }
  </script>






@stop