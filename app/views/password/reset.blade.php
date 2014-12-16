<!-- /app/views/password.reset.blade.php -->
@extends("_master")

@section("title")
    Log in
@stop

@section("content")

<form action="{{ action('RemindersController@postReset') }}" method="POST">
    <input type="hidden" name="token" value="{{ $token }}">
    <label for="email">e-mail</label>
    <input type="email" name="email">
    <label for="password">New Password:</label>
    <input type="password" name="password">
    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation">
    <input type="submit" value="Reset Password">
</form>

@stop