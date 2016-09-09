 @extends('layouts.app')

@section('content')
	<div class = "container">
		<h2 class = "text-center brand-font">{{ Auth::user()->username}}'s Images</h2>
		<div class = "grid">
	        <div class = "grid-sizer col-md-4"></div>
	        @foreach($images as $image)
	            <div class = "grid-item col-md-4">
	                <div class = "grid-item-content">
	                    <a href="{{url('/images/'. $image->name)}}">
	                        <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->thumbnail ])}}">
	                    </a>
	                </div>
	            </div>
	        @endforeach
	    </div>
	</div>
@endsection