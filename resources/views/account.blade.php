@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <h1 class="no-margin-top">Account</h1>
  </div>
  <div class="col s12 m6 no-gutter">
    <h3>Change Password</h3>
    <p>Passwords should be a minimum of 6 characters</p>
    <form method="POST" action="{{ route('changepassword') }}" id="change-pass-form">
      <div class="row">
        {{ csrf_field() }}
        <div class="input-field">
          <input id="current-password" name="current_password" type="password" class="validate {{ $errors->has('current_password') ? ' invalid' : '' }}" minlength="1" required>
          <label for="current-password">Current password</label>
        </div>
        <div class="input-field">
          <input id="new-password" name="new_password" type="password" class="validate {{ $errors->has('new_password') ? ' invalid' : '' }}" minlength="6" data-length="999" required>
          <label for="new-password" data-error="Passwords must meet requirement">Password</label>
        </div>      
        <div class="input-field">
          <input id="new-password-confirmation" name="new_password_confirmation" type="password" minlength="6" data-length="999" required>
          <label for="new-password-confirmation" data-error="Passwords must match">Confirm password</label>
        </div>
        <div class="no-margin-bottom">
          <button type="submit" class="btn btn-primary">Change Password</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
