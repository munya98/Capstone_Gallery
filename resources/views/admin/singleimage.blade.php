@extends('layouts.admin')
@section('title')
	{{ $image->display_filename }}
@endsection
@section('content')
	<div class = "row">
		<div class = "col-md-9">
			<img class = "img-responsive module" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
		</div>
		<div class = "col-md-3">
			<h3 class = "text-right">Details</h3>
			<h5>Views: <strong>{{ $image->views}}</strong></h5>
			<h5>Likes: <strong>{{ $likes}}</strong></h5>
			<h5>Category: <a href="{{ url('/browse/' . $image->category)}}">{{$image->category}}</a></h5>
			<h5>Status: {{ $image->permission}}</h5>
			<h5>Mime/Type: {{ $image->mime}}</h5>
			<h5>Size: {{ round($image->size / 1000000,2)}} MB</h5>
			<h5>Dimensions: {{ $image->width}} x {{ $image->height}}</h5>
			<h5>Uploaded At: {{ date('Y-m-d', strtotime($image->created_at))}}</h5>
			<form id = "image-delete" action = "{{ url('admin/delete/image/' . $image->image_id)}}" method = "POST">
				{{ csrf_field() }}
				<button type = "submit" class = "user-view-profile-button">
					<strong><i class="fa fa-btn fa-trash"></i> Delete</strong>
				</button>
			</form>
			<h3 class = "text-right">Reports</h3>
			@foreach($reports as $report)
				<h5>{{ $report->reason }}</h5>
			@endforeach
			{{ $reports->links() }}
		</div>
	</div>
@endsection

