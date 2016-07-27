@extends('account.overview')

@section('account')
	<h2 class = 'text-right brand-font'>Avatar</h2>
	<hr>
	<div class = "col-md-9">
		<h3 class = "text-center">Preview</h3>
		<img id = "avatar-preview" class = "img-circle" src="{{ route('account.avatar', Auth::user()->avatar)}}"><br>

		<form enctype="multipart/form-data" action = "{{ url('/account/avatar')}}" method="POST">
			 {!! csrf_field() !!}
			 <label for = "avatar">Update Profile Image</label>
			 <input class = "custom-form" type="file" name="avatar"><br>
			 <ul>
				@foreach($errors->all() as $error)
					<li class = "error">{{ $error}} </li>
				@endforeach
			 </ul>
			 <button class = "btn-custom" type="submit" name="submit"><i class="fa fa-wrench" aria-hidden="true"></i> Update </button>
		</form>
		@if(Session::has('status'))
			<h4 class = "success session-status">
				{{Session::get('status')}}
			</h4>
		@endif
	</div>
@endsection