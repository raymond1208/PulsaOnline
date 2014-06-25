@extends('layouts/default')

@section('content')
<div class="row">
	<div class="col-md-12">

		<?php $customView = 'admin.user.account'; ?>
		@if(View::exists($customView))
		@include($customView)
		@else

		<div class="page-header">
			<h1>Account</h1>
		</div>

		<ul class="nav nav-tabs" id="tabs">
			<li class="active"><a href="#profile">{{ Lang::get('general.update_profile') }}</a></li>
			<li><a href="#password">{{ Lang::get('general.update_password') }}</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="profile">
				<br>

				{{ Form::open(array('url' => 'update-profile', 'class' => 'form-horizontal')) }}

				<div class="form-group {{ $errors->has('first_name') ? 'error' : '' }}">
					<label for="Name" class="col-md-2 control-label">First Name</label>

					<div class="col-lg-4">
						<input type="text" placeholder="First name" name="first_name" value="{{ $user->first_name }}" class="form-control">
					</div>
				</div>

				<div class="form-group {{ $errors->has('last_name') ? 'error' : '' }}">
					<label for="Name" class="col-md-2 control-label">Last Name</label>

					<div class="col-lg-4">
						<input type="text" placeholder="Last name" name="last_name" value="{{ $user->last_name }}" class="form-control">
					</div>
				</div>

				<div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
					<label for="Name" class="col-md-2 control-label">Email</label>
					<div class="col-lg-4">
						<input type="email" placeholder="Email" name="email" value="{{ $user->email }}" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-4 col-lg-offset-2">
						<input type="submit" class="btn" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;" value="{{ Lang::get('general.save') }}">
					</div>
				</div>

				<?php $customView = 'admin.user.additional.profile'; ?>
				@if(View::exists($customView))
				@include($customView)
				@endif

				{{ Form::close() }}
			</div>


			<div class="tab-pane" id="password">
				<br>

				{{ Form::open(array('url' => 'update-password', 'class' => 'form-horizontal')) }}

				{{ $errors->has('password') ? '<p>Minimum password length is 6</p>' : '' }}

				<div class="form-group {{ $errors->has('last_name') ? 'error' : '' }}">
					<label for="Name" class="col-md-2 control-label">Current Password</label>
					<div class="col-lg-2">
						<input type="password" name="current_password" class="form-control">
					</div>
				</div>

				<div class="form-group {{ $errors->has('last_name') ? 'error' : '' }}">
					<label for="Name" class="col-md-2 control-label">New Password</label>
					<div class="col-lg-2">
						<input type="password" name="password" class="form-control">
					</div>
				</div>

				<div class="form-group {{ $errors->has('last_name') ? 'error' : '' }}">
					<label for="Name" class="col-md-2 control-label">Confirm New Password</label>
					<div class="col-lg-2">
						<input type="password" name="password_confirmation" class="form-control">
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-4 col-lg-offset-2">
						<input type="submit" class="btn" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;" value="{{ Lang::get('general.save') }}">
					</div>
				</div>


				{{ Form::close() }}

			</div>
		</div>

		@endif

	</div>
</div>

@stop