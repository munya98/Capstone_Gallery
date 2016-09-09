@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-offset-3 col-md-6">
				<form id = "answer-confirm" method = "post" action = "{{ url('/user/password/answer')}}">
					{{ csrf_field() }}
					<input type="hidden" name="username" value = "{{ $user->username }}">
					<div class = "form-group">
						<label for = "question">Question</label>
						<input class = "custom-input" type="text" name="question" readonly value="{{ $user->question }}">
					</div>
					<div class = "form-group">
						<label for = "answer">Answer</label>
						<input class = "custom-input" type="text" name="answer">
						@if (Session::has('status'))
                            <span class="help-block">
                                <strong class = "error">{{Session::get('status') }}</strong>
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
