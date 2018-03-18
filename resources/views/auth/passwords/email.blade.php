@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m6 offset-m3">
					@if (session('status'))
						<div class="card green alert alert-success">
							<div class="card-content white-text">{{ session('status') }}</div>
						</div>
					@endif
          <div class="card row">
						<div class="card-content row">
							
							<span class="card-title">Reset Password</span>
							<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
								{{ csrf_field() }}
								<div class="input-field">
									<label for="email">Email</label>
									<input id="email" name="email" type="email" class="validate {{ $errors->has('email') ? ' invalid' : '' }}" value="{{ old('email') }}" required autofocus>
								</div>					
								<div class="no-margin-bottom">
									<button type="submit" class="btn btn-primary">Send Password Reset Link</button>
								</div>
							</form>
						</div>
					</div>
        </div>
    </div>
</div>
@endsection
