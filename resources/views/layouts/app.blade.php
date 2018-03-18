<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<?php $user = Auth::user(); ?> 
<body>
	<nav>
		<div class="container">
			<div class="nav-wrapper">
				<a href="{{ url('/') }}"></a>
				<ul id="nav-mobile" class="right hide-on-med-and-down">
					<?php if(!$user): ?>
						<li><a href="{{ route('login') }}">Login</a></li>
						<li><a href="{{ route('register') }}">Register</a></li>
          <?php else: ?>
              <?php if($user->authorizeRoles(['administrator'])): ?>
                <li><a href="{{ route('payload') }}">Payload</a></li>
                <li><a href="{{ route('bgl') }}">Create Links</a></li>
              <?php endif; ?>
              <li><a class="dropdown-button" href="#!" data-activates="dropdown">{{ Auth::user()->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
              <!-- Dropdown Structure -->
              <ul id="dropdown" class="dropdown-content">
                <li>
                  <?php if($user->authorizeRoles(['administrator'])): ?>
                  <a href="{{ route('admin') }}">Admin</a>
                  <?php endif; ?>
                  <a href="{{ route('account') }}">Account</a>
                  <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                    Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </li>
              </ul>
          <?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
	<div id="app" class="container-wrapper">
		<div class="row">
		@if(session('success'))			
			<div class="container">
				<div class="card green lighten-5 alert">
					<div class="card-content green-text">
						<p>SUCCESS : {{ session('success') }}</p>
					</div>
					<button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			</div>
		@endif
		@if(session('failure'))
			<div class="container">
				<div class="card red lighten-5 alert">
					<div class="card-content red-text">
						<p>Error : {{ session('failure') }}</p>
					</div>
					<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			</div>
		@endif
		@if($errors->any())
			@foreach($errors->all() as $error)
				<div class="container">
					<div class="card red lighten-5 alert">
						<div class="card-content red-text">
								<p>Error : {{ $error }}</p>
						</div>
						<button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
				</div>
			@endforeach
		@endif
			@yield('content')
	</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
