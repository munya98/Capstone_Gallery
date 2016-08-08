@extends('account.overview')

@section('account')
	<h2 class = 'text-right brand-font'>Update Account Details</h2>
	<hr>
	<div class = "col-md-9">
		<div class = "row">
			<div class ="col-md-12">
				<form method="POST" action = "{{ url('/account/edit')}}">
					{!! csrf_field() !!}
					<div class = "form-group">
						<p class = "text-right"><label for = "name">Name</label></p>
						<input class = "custom-input" type="text" name="name" value="{{Auth::user()->name}}">
						@if ($errors->has('name'))
                            <span class="help-block">
                                <strong class = "error">{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "username">Username</label></p>
						<input class = "custom-input" type="text" name="username" value="{{Auth::user()->username}}">
						@if($errors->has('username'))
							<span class = "help-block">
								<strong class = "error">{{ $errors->first('username')}}</strong>
							</span>
						@endif
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "question">Question</label></p>
						<input class = "custom-input" type="text" name="question" value="{{Auth::user()->question}}">
						@if($errors->has('question'))
							<span class = "help-block">
								<strong class = "error">{{ $errors->first('question')}}</strong>
							</span>
						@endif
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "question">Answer</label></p>
						<input class = "custom-input" type="text" name="answer" value="{{Auth::user()->answer}}">
						@if($errors->has('answer'))
							<span class = "help-block">
								<strong class = "error">{{ $errors->first('answer')}}</strong>
							</span>
						@endif
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "bio">Bio</label></p>
						<textarea class = "custom-textarea" name = "bio" rows="3">{{Auth::user()->bio}}</textarea>
						@if($errors->has('bio'))
							<span class = "help-block">
								<strong class = "error">{{ $errors->first('bio')}}</strong>
							</span>
						@endif
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "avatar">Avatar</label></p>
						<input class = "custom-input" type="text" name="avatar" value="{{Auth::user()->avatar}}" readonly>
					</div>
					<div class = "form-group">
						<button class = "btn-custom" type="Submit" name="Update"><span class="glyphicon glyphicon-floppy-open"></span> Update </button>
					</div>
				</form>
			</div>		
		</div>
	</div>
@endsection