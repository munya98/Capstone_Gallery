@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-offset-3 col-md-6">
				<form method = "post" action = "{{ url('user/password/reset')}}">
					{{ csrf_field() }}
					<div class = "form-group">
						<label for = "username">Username</label>
						<input type="text" name="username" class = "custom-input">
						@if ($errors->has('username'))
                            <span class="help-block">
                                <strong class = "error">{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
					</div>
					<div class = "form-group text-center">
						<button class = "btn-custom" type = "submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection