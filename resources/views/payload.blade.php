@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
			<h1>Payloads</h1>
			@if($payloads)
				<table class="striped centered">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Status</th>
							<th>Resend?</th>
						</tr>
					</thead>
					<tbody>
					@foreach($payloads as $payload)		
						<tr>
							<td>{{ $payload->id }}</td>
							<td>{{ $payload->name }}</td>
							<td>{{ $payload->email }}</td>
							<td>Sent placeholder</td>
							<td>
								<input type="checkbox" name="resend[{{ $loop->index }}]" value="{{ $payload->id }}" class="filled-in resend-bgl" id="resend-{{ $loop->index }}" style="display:none;" />
								<label for="resend-{{ $loop->index }}" style="padding:0.8rem;"></label>
							</td>
						</tr>						
					@endforeach
					</tbody>
					<tfoot>
						<tr>						
							<td colspan="3" style="text-align:right;">&nbsp;</td>	
							<td colspan="2" style="text-align:right;">
								<div id="resend-loader" class="preloader-wrapper big" style="width:5rem; height:5rem; margin-right:2.4rem;">
									<div class="spinner-layer spinner-green-only">
										<div class="circle-clipper left">
											<div class="circle"></div>
										</div><div class="gap-patch">
											<div class="circle"></div>
										</div><div class="circle-clipper right">
											<div class="circle"></div>
										</div>
									</div>
								</div>
								<button id="resend-bgl" class="btn disabled" style="float:right;">Resend Emails</button>
							</td>
						</tr>
					</tfoot>
				</table>
			@endif
	</div>
</div>
@endsection
