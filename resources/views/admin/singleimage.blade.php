@extends('layouts.admin')
@section('title')
	{{ $image->display_filename }}
@endsection
@section('content')
	<div class = "row">
		<div class = "col-md-10">
			<img class = "img-responsive module" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
		</div>
	</div>
@endsection

