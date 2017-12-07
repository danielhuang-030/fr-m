@extends('layouts.user')

@section('style')
	<link href="{{ asset('assets/user/css/stepstyle.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('main')
	<div class="main-wrap">

		<div class="am-cf am-padding">
			<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">Reset Password</strong></div>
		</div>
		<hr/>

		@if (session()->has('status') > 0)
			<div class="am-alert am-alert-success" data-am-alert>
				<button type="button" class="am-close">&times;</button>
				<p>{{ session('status') }}</p>
			</div>
		@endif
		@if ($errors->count() > 0)
			<div class="am-alert am-alert-danger" data-am-alert>
				<button type="button" class="am-close">&times;</button>
				<p>{{ $errors->first() }}</p>
			</div>
		@endif
		<form class="am-form am-form-horizontal" action="{{ url('user/password') }}" method="post">

            {{ csrf_field() }}
			<div class="am-form-group">
				<label for="user-old-password" class="am-form-label">Old Password</label>
				<div class="am-form-content">
					<input type="password" id="user-old-password" name="old_password" value="{{ old('old_password') }}" placeholder="Old Password">
				</div>
			</div>
			<div class="am-form-group">
				<label for="user-new-password" class="am-form-label">New Password</label>
				<div class="am-form-content">
					<input type="password" id="user-new-password" name="password" placeholder="New Password">
				</div>
			</div>
			<div class="am-form-group">
				<label for="user-confirm-password" class="am-form-label">New Password Confirm</label>
				<div class="am-form-content">
					<input type="password" id="user-confirm-password" name="password_confirmation" placeholder="New Password Confirm">
				</div>
			</div>
			<div class="info-btn">
				<button class="am-btn am-btn-danger">Save</button>
			</div>

		</form>

	</div>
@endsection