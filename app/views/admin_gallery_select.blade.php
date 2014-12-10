<!-- /app/views/admin_gallery_select.blade.php -->
@extends("_master")

@section("title")
Add/Modify/Delete a Photo
@stop

@section ("content")
<h1>Add/Modify/Delete a Photo</h1>

{{ Form::open(array('url' => '/admin/galleryAction')) }}

<?php
    $galleryList = array();
    foreach ($galleries as $gallery) {
        $galleryList[$gallery->id] = $gallery->name;
    }
?>

  <fieldset><legend>Select Gallery</legend>
    {{ Form::select('gallery', $galleryList) }}
  </fieldset>
  <fieldset><legend>Choose Action</legend>
    {{ Form::radio('action', 'new', true) }} New Photo
    <br/>
    {{ Form::radio('action', 'modify') }} Modify an Existing Photo
    <br/>
    {{ Form::radio('action', 'delete') }} Delete an Existing Photo
  </fieldset>
  {{ Form::submit('Submit') }}

{{ Form::close() }}
@stop