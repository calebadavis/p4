<!-- /app/views/signup.blade.php -->
@extends("_master")

@section("title")
    Sign Up
@stop

@section ("content")
<h1>Sign up</h1>

{{ Form::open(array('url' => '/signup')) }}

    Email<br>
    {{ Form::text('email') }}<br><br>

    First Name<br>
    {{ Form::text('first_name') }}<br><br>

    Last Name<br>
    {{ Form::text('last_name') }}<br><br>

    Password:<br>
    {{ Form::password('password') }}<br><br>

    {{ Form::submit('Submit') }}

{{ Form::close() }}
@stop