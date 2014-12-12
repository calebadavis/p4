<!-- /app/views/admin_modify_photo.blade.php -->

<?php
    $gallery = Gallery::find($galleryId);
    if ($gallery->restricted) {
        $users = User::all();
    }
?>
@extends("_master")

@section("title")
    Manage Photos
@stop

@section("head")
{{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js") }}
{{ HTML::script("js/image-picker.js") }}
{{ HTML::style("css/image-picker.css") }}
@if($gallery->restricted)
{{ HTML::script("js/jquery.multi-select.js") }}  
{{ HTML::style('css/multi-select.css') }}
@endif
    <script type="text/javascript">
      $(document).ready(function() {
        $("#photoId").imagepicker({
          hide_select : false,
          show_label  : true
        });
@if($gallery->restricted)
        $('#userList').multiSelect({ 
            selectableHeader: 'Cannot view:',
            selectionHeader: 'Can view:'
        });

@endif
      });
    </script>
@stop

@section("content")

<h2>Modify Photo</h2>

{{ Form::open(array("url"=>"/admin/modifyPhoto")) }}

<!-- Only display user permission UI if current gallery is restricted -->

    <fieldset><legend>Photo attributes</legend>
    {{ Form::label('caption', 'Caption:') }}
    {{ Form::text('caption') }}

@if ($gallery->restricted)
    {{ Form::label('userList', 'Permitted Users:') }}
    <select multiple="multiple" id="userList" name="userList[]">
      @foreach ($users as $user)
      <option value='{{$user->id}}'>{{$user->email}}</option> 
      @endforeach
    </select>
@endif
    </fieldset>
    <fieldset><legend>Photo Selection</legend>
      <select class="image-picker" id="photoId" name="photoId">
@foreach ($gallery->photos as $photo)
        <option data-img-src="/images/{{$photo->thumb}}" value="{{$photo->id}}">{{$photo->file}}</option>
@endforeach
      </select>
    </fieldset>
    {{Form::submit("Save")}}
{{ Form::close() }}

@stop
