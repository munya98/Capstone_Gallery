@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-12">
				<img class = "avatar-display img-circle img-responsive" src="{{ route('account.avatar', $user->avatar)}}" class="img-circle" id = "user-profile-pic">
				<h3 class = "text-center brand-font">{{$user->username}}'s Images</h3>
			</div>
			<div class = "row">
				<div class="col-md-12">
					<h5>Latest</h5>
						<div class = "grid">
					        <div class = "grid-sizer col-md-4"></div>
					        @foreach($images as $image)
					            <div class = "grid-item col-md-4">
					                <div class = "grid-item-content">
					                    <a href="{{url('/images/'. $image->name)}}">
					                        <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
					                    </a>
					                </div>
					            </div>
					        @endforeach
					    </div>
					{{ $images->links() }}
				</div>
			</div>
		</div>
	</div>
@endsection