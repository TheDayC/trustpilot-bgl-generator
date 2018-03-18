@extends('layouts.app')

@section('content')
	<div class="col s12 m4 offset-m4">
		<div class="card row">
			<div class="card-content row">
				<span class="card-title">Login</span>
				<form class="form-horizontal" method="POST" action="{{ route('login') }}">
					<div class="row">
					{{ csrf_field() }}
					<p class="input-field col s12">								
						<input id="email" name="email" type="email" class="validate{{ $errors->has('email') ? ' invalid' : '' }}" value="{{ old('email') }}" required>
						<label for="email">Email</label>
					</p>
					<p class="input-field col s12">								
						<input id="password" name="password" type="password" class="validate{{ $errors->has('password') ? ' invalid' : '' }}"  minlength="6" data-length="999" required>
						<label for="password" data-error="Passwords must meet requirement">Password</label>
					</p>
					<p class="col s12">
						<input type="checkbox" id="remember" class="filled-in" {{ old('remember') ? 'checked' : '' }}>
						<label for="remember">Remember Me</label>
					</p>
					<p class="no-margin-bottom">
						<button type="submit" class="btn btn-primary">Login</button>
					</p>
					</div>
				</form>
			</div>
			<div class="card-action">
				<a href="{{ route('password.request') }}">Forgot Your Password?</a>
			</div>
		</div>
	</div>
@endsection
