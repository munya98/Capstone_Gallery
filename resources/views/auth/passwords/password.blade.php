@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-offset-3 col-md-6">
				<form method = "post" action = "{{ url('/user/password/update')}}">
					{{ csrf_field() }}
					<input type="hidden" name="username" value = "{{ $user }}">
					<div class = "form-group">
						<label for = "question">New Password</label>
						<input class = "custom-input" type="password" name="password">
					</div>
					<div class = "form-group">
						<label for = "answer">Confirm Password</label>
						<input class = "custom-input" type="password" name="password_confirmation">
						@if ($errors->has('password'))
                            <span class="help-block">
                                <strong class = "error">{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
					</div>
					<div class = "form-group">
						<button class = "btn-custom">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
