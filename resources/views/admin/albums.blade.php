@extends('layouts.admin')
@section('title')
	Albums
@endsection
@section('content')
	<table class = "table">
		<tr>
			<th></th>
			<th class = "text-right">Owner ID</th>
			<th class = "text-right">Album ID</th>
			<th class = "text-right">Name</th>
			<th class = "text-right">Description</th>
			<th class = "text-right">Location</th>
			<th class = "text-right">Permission</th>
			<th class = "text-right">Created</th>
		</tr>
		<tr class = "text-right">
			@foreach($albums as $album)
				<td><a href="{{ url('/admin/albums/'. $album->album_id)}}">View Album</a></td>
				<td><a href="{{ url('/admin/users/'. $album->user_id)}}">View user: {{ $album->user_id }}</a></td>
				<td>{{ $album->album_id }}</td>
				<td>{{ $album->name }}</td>
				<td>{{ $album->description }}</td>
				<td>{{ $album->path }}</td>
				<td>{{ $album->permission }}</td>
				<td>{{ $album->created_at }}</td>
			@endforeach
		</tr>
	</table>
@endsection