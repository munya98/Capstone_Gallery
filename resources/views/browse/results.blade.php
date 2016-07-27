@extends('layouts.app')

@section('content')
	<div class = "container">
    <h1 class = "text-center brand-font">{{ $category }}</h1>
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
    </div>
	</div>
@endsection