<!--app/views/admin_new_photo.blade.php-->

<?php
    $gallery = Gallery::find($galleryId);
    if ($gallery->restricted) {
        $users = User::all();
    }
?>

@extends("_master")

@section("title")
   Upload Photo
@stop

@section("head")
@if($gallery->restricted)
  {{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js") }}
  {{ HTML::script('js/jquery.multi-select.js') }}
  {{ HTML::style('css/multi-select.css') }}

    <script type="text/javascript">
      $(document).ready(function() {
        $('#userList').multiSelect();
      });
    </script>
@endif
@stop

@section("content")
  {{ Form::open(array("url"=>"/admin/newPhoto/".$galleryId, 'files'=>TRUE)) }}
@if($gallery->restricted)
    <select multiple="multiple" id="userList" name="userList[]">

      @foreach (User::all() as $user)
      <option value='{{$user->id}}'>{{$user->email}}</option> 
      @endforeach

    </select>

  <br/>
@endif
  {{ Form::label('caption', 'Caption:') }}
  {{ Form::text('caption') }}

  <br/>

  {{ Form::label('image','Image:') }}
  {{ Form::file('image') }}

  <br/>

  {{ Form::label('thumb','Thumb:') }}
  {{ Form::file('thumb') }}

  <br/>

  <!-- submit buttons -->
  {{ Form::submit('Upload') }}
  
  <!-- reset buttons -->
  {{ Form::reset('Reset') }}
  
  {{ Form::close() }}
@stop
