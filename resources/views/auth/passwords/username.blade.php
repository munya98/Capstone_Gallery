@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-offset-3 col-md-6">
				<form method = "post" action = "">
					{{ csrf_field() }}
					<div class = "form-group">
						<label for = "username">Username</label>
						<input type="text" name="username" class = "custom-input" >
					</div>
					<div class = "form-group text-center">
						<button class = "btn-custom" type = "submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection