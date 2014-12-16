<!-- /app/views/login.blade.php -->
@extends("_master")

@section("title")
    Log in
@stop

@section("content")
<h1>Log in</h1>

{{ Form::open(array('url' => '/login')) }}

    Email<br>
    {{ Form::text('email') }}<br><br>

    Password:<br>
    {{ Form::password('password') }}<br><br>

    {{ Form::checkbox('reset-password', 'reset')}}
    I forgot my password! Send me a reset e-mail!<br><br>

    {{ Form::submit('Submit') }}

{{ Form::close() }}
@stop