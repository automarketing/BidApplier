@extends('admin.home.el.infolist_form')
@section('form')
    <?php $data = object_get($item, 'data', []); ?>
    <div class="form-group">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" value="{{object_get($item,'name',old('name')) }}"/>
    </div>

    <div class="form-group">
        <label class="form-label">Enabled</label>
        {!! Form::select('active',['0'=>'no','1'=>'yes'],object_get($item,'active',old('active'))) !!}
    </div>
    <div class="form-group">
        <label class="form-label">Weight</label>
        <input class="form-control" name="weight" value="{{ object_get($item,'weight',old('weight')) }}"/>
    </div>

    <div class="form-group">
        <label class="form-label">Image</label>
        @if ($item)
            <img src="{{Helper::getImagePath($item->image,$item->type)}}" class="img-responsive" style="height:100px"/>
        @endif
        <input type="file" name="image"/>
    </div>

    <div class="form-group">
        <label class="form-label">H1</label>
        <input class="form-control" name="data[h1]" value="{{ array_get($data,'h1',old('data.h1')) }}"/>
    </div>

    <div class="form-group">
        <label class="form-label">H2</label>
        <input class="form-control" name="data[h2]" value="{{  array_get($data,'h2',old('data.h2')) }}"/>
    </div>

    <div class="form-group">
        <label class="form-label">H3</label>
        <input class="form-control" name="data[h3]" value="{{  array_get($data,'h3',old('data.h3')) }}"/>
    </div>

@endsection
