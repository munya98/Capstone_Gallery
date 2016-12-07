@extends('layouts.admin')
@section('title')
	Images
@endsection
@section('content')
	<div class ="row">
		<div class = "grid">
	        <div class = "grid-sizer col-md-4"></div>
	        @foreach($images as $image)
	            <div class = "grid-item col-md-4">
	                <div class = "grid-item-content">
	                    <a href="{{url('admin/images/'. $image->image_id)}}">
	                        <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->thumbnail ])}}">
	                    </a>
	                </div>
	            </div>
	        @endforeach
    	</div>
    	{{ $images->links() }}
	</div>
@endsection