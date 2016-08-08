@extends('account.overview')

@section('account')
	<h2 class = 'text-right brand-font'>Account Details</h2>
	<hr>
	<div class = "col-md-9">
		<div class = "row" >
			<div class ="col-md-12">
				<form>
					<div class = "form-group">
						<p class = "text-right"><label for = "name">Name</label></p>
						<input class = "custom-input" type="text" name="name" value="{{Auth::user()->name}}" readonly>
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "username">Username</label></p>
						<input class = "custom-input" type="text" name="username" value="{{Auth::user()->username}}" readonly>
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "question">Question</label></p>
						<input class = "custom-input" type="text" name="question" value="{{Auth::user()->question}}" readonly>
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "avatar">Avatar</label></p>
						<input class = "custom-input" type="text" name="avatar" value="{{Auth::user()->avatar}}" readonly>
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "created">Account Created</label></p>
						<input class = "custom-input" type="text" name="created" value="{{Auth::user()->created_at}}" readonly>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection