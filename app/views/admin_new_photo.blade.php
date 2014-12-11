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
        $('#userList').multiSelect({ 
            selectableHeader: 'Cannot view:',
            selectionHeader: 'Can view:'
        });
      });
    </script>
@endif
@stop

@section("content")

@if($errors->count() > 0)
<fieldset><legend>Submission errors:</legend>
@foreach($errors->all() as $message)
	<div class='error'>{{ $message }}</div>
@endforeach
</fieldset>
@endif

  {{ Form::open(array("url"=>"/admin/newPhoto/".$galleryId, 'files'=>TRUE)) }}

<fieldset><legend>New Image details:</legend>

@if($gallery->restricted)

    {{ Form::label('userList', 'Restricted gallery - only selected users can view the image.') }}
    <br/>
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

  {{ Form::label('file','Image:') }}
  {{ Form::file('file') }}

  <br/>

  {{ Form::label('thumb','Thumb:') }}
  {{ Form::file('thumb') }}

  <br/>
</fieldset>
  <!-- submit buttons -->
  {{ Form::submit('Upload') }}
  
  <!-- reset buttons -->
  {{ Form::reset('Reset') }}
  
  {{ Form::close() }}
@stop
