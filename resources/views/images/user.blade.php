@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-2">
				<img class = "img-circle img-responsive" src="{{ route('account.avatar', $user->avatar)}}" class="img-circle" id = "user-avatar-display">
			</div>
			<div class = "col-md-6">
				<div class = "user-display-details">
					<h5> {{ $user->username}} </h5>
					<h5> {{ $album_count}} Album(s) </h5>
					<h5> {{ $img_count }} Image(s) </h5>
					<p> Bio:</p>
					<p> He's on his way, he's about to get paid, he's on his way to hollywood (change this later, hardcorded).</p>
				</div>
			</div>
			<div class = "row">
				<div class="col-md-12">
					<h5>Latest <i class="fa fa-caret-down" aria-hidden="true"></i></h5>
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