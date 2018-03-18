@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col s12 m6 offset-m3">
				<div class="card row">
					<div class="card-content row">
						<span class="card-title">Register</span>
						<form method="POST" action="{{ route('register') }}" id="register-form">
							{{ csrf_field() }}
							<div class="input-field">								
								<input id="name" name="name" type="text" class="validate {{ $errors->has('name') ? ' invalid' : '' }}" value="{{ old('name') }}" required>
								<label for="name">Name</label>
							</div>
							<div class="input-field">								
								<input id="email" name="email" type="email" class="validate {{ $errors->has('email') ? ' invalid' : '' }}" value="{{ old('email') }}" required>
								<label for="email">Email</label>
							</div>
							<div class="input-field">								
								<input id="password" name="password" type="password" class="validate {{ $errors->has('password') ? ' invalid' : '' }}" minlength="6" data-length="999" required>
								<label for="password" data-error="Passwords must meet requirement">Password</label>
							</div>
							<div class="input-field">								
								<input id="password-confirm" name="password_confirmation" type="password" class="validate" minlength="6" data-length="999" required>
								<label for="password-confirm" data-error="Passwords must match">Confirm Password</label>
							</div>
							<div class="no-margin-bottom">
								<button type="submit" class="btn btn-primary">Register</button>
							</div>
						</form>
					</div>
				</div>
			</div>
    </div>
</div>
@endsection
