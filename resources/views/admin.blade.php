@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <h1 class="no-margin-top">Admin</h1>
    <p>Change your account settings here.</p>
  </div>
  <div class="col s12 no-gutter">
    <h3>Change Roles</h3>
    <p>Roles can be changed in bulk. Select users to change, choose the role you want to change to click submit.</p>
     <?php $roles = $data["roles"]; ?>
      @if($data["users"])
      <div class="row">
        <table class="striped centered">
          <thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Change Role?</th>
						</tr>
					</thead>
          @foreach($data["users"] as $user)
          <tbody>
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ ucfirst($roles[$user->role_id]) }}</td>
              <td>
                <input type="checkbox" name="change_role[{{ $loop->index }}]" value="{{ $user->id }}" class="filled-in change-role" id="change-role-{{ $loop->index }}" style="display:none;" />
                <label for="change-role-{{ $loop->index }}" style="padding:0.8rem;"></label>
              </td>
            </tr>
          </tbody>
          @endforeach
          <tfoot>
            <tr>
              <td colspan="1" style="text-align:left;">Choose a role:</td>
							<td colspan="2" style="text-align:left;">
                @if($roles)
                <div class="input-field" style="display:inline;">
                  <select name="roles" id="roles">
                    <option value="">Choose role...</option>
                    @foreach($roles as $key => $value)
                      <option value="{{ $key }}">{{ ucfirst($value) }}</option>
                    @endforeach
                  </select>
                </div>
                @endif
              </td>	
							<td colspan="2" style="text-align:right;">
								<div id="loader" class="preloader-wrapper big" style="width:5rem; height:5rem; margin-right:2.4rem;">
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
								<button id="change-roles" class="btn disabled" style="float:right;">Change Roles</button>
							</td>
						</tr>
          </tfoot>
        </table>
      </div>
      @endif
  </div>
</div>
@endsection
