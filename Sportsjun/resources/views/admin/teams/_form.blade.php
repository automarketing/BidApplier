<style type="text/css">
.ui-widget-content{ z-index:100 !important; height:150px; overflow-y:auto;}
</style>
<div class="row">

<div class="section col-sm-6">
    	<label class="form_label">{{   trans('message.team.fields.name') }}<span  class='required'>*</span> </label>
	<label for="firstname" class="field prepend-icon">
		 {!! Form::text('name',null, array('required','class'=>'gui-input','id'=>'name','placeholder'=> trans('message.team.fields.name'))) !!}
        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
		<label for="firstname" class="field-icon"><i class="fa fa-user"></i></label>  
	</label>
</div>
<div class="section col-sm-6">
    	<label class="form_label">{{   trans('message.team.fields.sports') }}<span  class='required'>*</span> </label>
	<label class="field select">
		{!! Form::select('sports_id',$sports,null,array('required','class'=>'gui-input','id'=>'sports_id')) !!}
		@if ($errors->has('sports_id')) <p class="help-block">{{ $errors->first('sports_id') }}</p> @endif
		<i class="arrow double"></i>                    
	</label>  
</div>
</div>
@include ('common.upload')
@include ('common.uploadfield', ['uploadLimit' => '1','field'=>'logo','fieldname'=>'Choose Team Logo'])
@if(isset($team))
@include('common.editphoto',['photos'=>$team->photos,'type'=>'teams'])
@endif
<div class="row">
<div class="section col-sm-6">
    	<label class="form_label">{{   trans('message.team.fields.organization') }}</label>
	<label class="field select">
		 {!! Form::select('organization_id',$organization,null, array('class'=>'gui-input','id'=>'organization_id','placeholder'=>'Select Organization')) !!}
        @if ($errors->has('organization_id')) <p class="help-block">{{ $errors->first('organization_id') }}</p> @endif
		<i class="arrow double"></i>                    
	</label>  
</div>
<div class="section col-sm-6">
    <label class="form_label">{{   trans('message.team.fields.level') }} </label>
	<label class="field select">
		 {!! Form::select('team_level',$enum,null, array('class'=>'gui-input','placeholder'=>'Select Level of Team')) !!}
        @if ($errors->has('team_level')) <p class="help-block">{{ $errors->first('team_level') }}</p> @endif
		<i class="arrow double"></i>                    
	</label>  
</div>
</div>


<div class="row">
<div class="section col-sm-6">
    	<label class="form_label">{{ trans('message.team.fields.gender') }}<span  class='required'>*</span></label>
	<div class="option-group field">
		<label for="female" class="option">
			{!! Form::radio('gender', 'female',null, array('class'=>'gui-input','id'=>'female')) !!}{{ trans('message.team.fields.female') }}
			<span class="radio"></span>
		</label>
		<label for="male" class="option">
			{!! Form::radio('gender', 'male',null, array('class'=>'gui-input','id'=>'male')) !!}{{ trans('message.team.fields.male') }}  	
			<span class="radio"></span>              
		</label>
		<label for="other" class="option">
			{!! Form::radio('gender', 'other',null, array('class'=>'gui-input','id'=>'other')) !!}{{ trans('message.team.fields.other') }}     
			<span class="radio"></span>            
		</label>
		@if ($errors->has('gender')) <p class="help-block">{{ $errors->first('gender') }}</p> @endif			 
	</div>
</div>

<div class="section col-sm-12">
    <label class="form_label">{{   trans('message.team.fields.owner') }}<span  class='required'>*</span> </label>
	<label for="firstname" class="field prepend-icon">
		 
		@if(!empty($owner_name))
		{!! Form::text('team_owner_id', $owner_name, array('required','class'=>'gui-input','placeholder'=>"Owner Name",'id'=>'team_owner_id' )) !!}
		@else
			{!! Form::text('team_owner_id', null, array('required','class'=>'gui-input','placeholder'=> "Owner Name",'id'=>'team_owner_id' )) !!}
		@endif
		
			<input type="hidden" id="user_id" name="user_id" value="{{ !empty($team['team_owner_id'])?$team['team_owner_id']:'' }}" >

		<label for="firstname" class="field-icon"><i class="fa fa-user"></i></label>  
	</label>
</div>

</div><!-- end section --> 
	
@include ('common.address',['mandatory' => ''])
<div class="row">
  <div class="col-sm-6">
   <div class="section">
    <div class="option-group field">
        <label class="option block">
            {!! Form::checkbox('player_available', 1, null, ['id' => 'player_available', 'class'=>'gui-input']) !!}
            <span class="checkbox"></span> {{ trans('message.team.fields.isavailable') }}
            @if ($errors->has('player_available')) <p class="help-block">{{ $errors->first('player_available') }}</p> @endif
        </label>
    </div>
   </div>
   </div>
    <div class="col-sm-6">
    <div class="section">
       <div class="option-group field">
        <label class="option block">
            {!! Form::checkbox('team_available', 1, null, ['id' => 'team_available', 'class'=>'gui-input']) !!}
            <span class="checkbox"></span> {{ trans('message.team.fields.teamavailable') }}
            @if ($errors->has('team_available')) <p class="help-block">{{ $errors->first('team_available') }}</p> @endif
        </label>
       </div>
    </div>
   </div>
</div>
<br/>
<div class="row">
<div class="col-sm-12">
<div class="section">
    	<label class="form_label">{{   trans('message.team.fields.description') }} </label>
	<label for="comment" class="field prepend-icon">
		 {!! Form::textarea('description', null, array('class'=>'gui-textarea','style'=>'resize:none','rows'=>3,'id'=>'description','placeholder'=> trans('message.team.fields.description') )) !!}
        @if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
		<label for="comment" class="field-icon"><i class="fa fa-comments"></i></label>
	</label>
</div>
</div>
</div>
<script>
$(function () {
	   $("#team_owner_id").autocomplete({
			source: "{{ url('tournaments/getUsers') }}",
			minLength: 3,
			response: function(event, ui) {
				if (!ui.content.length) {
					var noResult = { value:"",label:"No results found" };
					ui.content.push(noResult);
					$("[name='team_owner_id']").val('');
				} else {
				   // $("#response").empty();
				}
			},
			select: function( event, ui ) {
				$('#user_id').val(ui.item.id);
			}
		});
});
</script>
