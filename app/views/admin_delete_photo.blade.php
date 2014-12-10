<!-- /app/views/admin_delete_photo.blade.php -->

<?php
    $gallery = Gallery::find($galleryId);
    if ($gallery->restricted) {
        $users = User::all();
    }
?>
@extends("_master")

@section("title")
    Delete Photo
@stop

@section("head")
{{ HTML::script("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js") }}
{{ HTML::script("js/image-picker.js") }}
{{ HTML::style("css/image-picker.css") }}
    <script type="text/javascript">
      $(document).ready(function() {
        $("#photoId").imagepicker({
          hide_select : false,
          show_label  : true
        });
      });
    </script>
@stop

@section("content")

<h2>Delete Photo</h2>

{{ Form::open(array("url"=>"/admin/deletePhoto")) }}

<!-- Only display user permission UI if current gallery is restricted -->

    <fieldset><legend>Photo Selection</legend>
      <select class="image-picker" id="photoId" name="photoId">
@foreach ($gallery->photos as $photo)
        <option data-img-src="/images/{{$photo->thumb}}" value="{{$photo->id}}">{{$photo->file}}</option>
@endforeach
      </select>
    </fieldset>
    {{Form::submit("Delete")}}
{{ Form::close() }}

@stop
