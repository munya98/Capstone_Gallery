@extends('layouts.app')

@section('content')
<div class = "container">
	@if($images->count() <= 0)
		<p>Could not find any images matching "{{ $term }}"</p>
	@else
		<p class = "text-center">Images matching "{{ $term }}"</p>
		<div class = "grid">
        <div class = "grid-sizer col-md-6"></div>
        @foreach($images as $image)
            <div class = "grid-item col-md-6">
                <div class = "grid-item-content">
                    <a href="{{url('/images/'. $image->name)}}">
                        <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    </div>
	@endif
</div>
@endsection