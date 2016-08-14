@extends('layouts.admin')
@section('title')
	{{ $user->name }}
@endsection
@section('content')
	<div class ="row">
		<div class = "col-md-3">
			<img class = "img-circle img-responsive user-view-profile" src="{{ route('account.avatar', $user->avatar)}}">
			<p class = "text-center">Account Status: 
				@if($user->active == 1)
					<span class = "green"><strong>Active</strong></span>
				@else
					<span class = "red">Suspended</span>
				@endif
			</p>
			<p class = "text-center">Membership Level: </p>
			<p class = "text-center">Images: {{$images}}</p>
			<p class = "text-center">Albums: {{$albums}}</p>
			<p class = "text-center">Likes: {{$likes}}</p>
			<p> 
				@if(session()->has('status'))
					{{ session()->get('status') }}
				@endif
			</p>
			<form method = "post" action = "{{ url('admin/suspend/' . $user->id )}}">
				{{ csrf_field() }}
				<button  type = "submit" class = "user-view-profile-button">Suspend/Reinstate User</button>
			</form>
			<form id = "password-reset" method="post" action = "{{ url('admin/reset/' . $user->id )}}">
				{{ csrf_field() }}
				<button type  = "submit" class = "user-view-profile-button">Reset Password</button>
			</form>
		</div>
		<div class = "col-md-9">
			<form method = "post" action = "{{ url('admin/update/'. $user->id )}}">
				{{ csrf_field() }}
				<div class = "form-group">
					<label for = "name">Name</label>
					<input type="text" name="name" class = "form-control" value = "{{ $user->name }}">
				</div>
				<div class = "form-group">
					<label for = "username">Username</label>
					<input type="text" name="username" class = "form-control" value = "{{ $user->username }}" readonly>
				</div>
				<div class = "form-group">
					<label for = "question">Security Question</label>
					<input type="text" name="question" class = "form-control" value = "{{ $user->question }}">
				</div>
				<div class = "form-group">
					<label for = "answer">Security Answer</label>
					<input type="text" name="answer" class = "form-control" value = "{{ $user->answer }}">
				</div>
				<div class = "form-group">
					<label for = "bio">Bio</label>
					<textarea name = "bio" class = "form-control">{{ $user->bio }}</textarea>
				</div>
				<div class = "form-group">
					<label for = "joined">Joined On</label>
					<input type="text" name="joined" class = "form-control" value = "{{ $user->created_at }}" readonly>
				</div>
				<div class = "form-group">
					<label for = "updated">Last Updated</label>
					<input type="text" name="updated" class = "form-control" value = "{{ $user->updated_at }}" readonly>
				</div>
				<div class = "form-group">
					<button type = "submit" class = "pull-right btn btn-danger">Update User</button>
				</div>
			</form>
		</div>
	</div>
@endsection