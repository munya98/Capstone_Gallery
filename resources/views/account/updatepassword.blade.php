@extends('account.overview')

@section('account')
	<h2 class = 'text-right brand-font'>Update Password</h2>
	<hr>
	<div class = "col-md-9">
		<div class = "row">
			<div class ="col-md-12">
				@if(Session::has('status'))
					<h4 class = "session-status" >{{Session::get('status')}}</h4>
				@endif
				<form method = "POST" action = "{{ url('/account/password')}}">
				{!! csrf_field() !!}
				<div class = "form-group">
					<p class = "text-right"><label for = "name">Current Password (Required)</label></p>
					<input class = "custom-input" type="password" name="current">
					@if($errors->has('current'))
						<span class = "help-block">
							<strong class = "error">{{ $errors->first('current') }}</strong>
						</span>
					@endif
				</div>
				<div class = "form-group">
					<p class = "text-right"><label for = "new">New Password (Required)</label></p>
					<input class = "custom-input" type="password" name="password">
					@if($errors->has('password'))
						<span class = "help-block">
							<strong class = "error">{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
				<div class = "form-group">
					<p class = "text-right"><label for = "password_confirmation">Confirm New Password (Required)</label></p>
					<input class = "custom-input" type="password" name="password_confirmation">
					@if($errors->has('password_confirmation'))
						<span class = "help-block">
							<strong class = "error">{{ $errors->first('password_confirmation') }}</strong>
						</span>
					@endif
				</div>
				<div class = "form-group">
					<button type = "submit" value = "Submit" class = "btn-custom"><span class="glyphicon glyphicon-floppy-open"></span> Update </button>
				</div>
				</form>
				
			</div>
		</div>
	</div>
@endsection