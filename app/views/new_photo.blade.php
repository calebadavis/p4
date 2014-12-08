<!--app/views/new_photo.blade.php-->

<?php
    $galleryList = array();
    foreach ($galleries as $gallery) {
        $galleryList[$gallery->id] = $gallery->name;
    }
?>

<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  {{ HTML::style('css/multi-select.css') }}
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#userList').multiSelect();
      });
    </script>


  <title>
   Upload File
  </title>
 </head>
 <body>

  {{ Form::open(array('action'=>'PhotoController@postNew', 'files'=>TRUE)) }}

    <select multiple="multiple" id="userList" name="userList[]">

      @foreach ($users as $user)
      <option value='{{$user->id}}'>{{$user->email}}</option> 
      @endforeach

    </select>

    {{ HTML::script('js/jquery.multi-select.js') }}

  
  {{ Form::label('gallery', 'Gallery:') }}
  {{ Form::select('gallery', $galleryList) }}
  <br/>

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
 </body>
</html>
