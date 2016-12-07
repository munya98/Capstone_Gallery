@extends('layouts.admin')
@section('title')
	Reports
@endsection
@section('content')
	<div class = "row">
		<div class = "col-md-4">
			<h4>Categories</h4>
			<table class = "table text-center">
				<tr class = "text-center">
					<th>ID</th>
					<th>Name</th>
				</tr>
				@foreach($categories as $category)
				<tr class ="text-center">
					<td>{{ $category->category_id}}</td>
					<th>{{ $category->name}}</th>
				</tr>
				@endforeach
			</table>
			{{ $categories->links() }}
		</div>
		<div class = "col-md-4">
			<h4>Category Recommendations</h4>
			@if(Session::has('status'))
				<p>{{ Session::get('status')}}</p>
			@endif
			<table class = "table">
				<tr>
					<th>Add</th>
					<th>Delete</th>
					<th>ID</th>
					<th>Name</th>
				</tr>
				@foreach($suggestions as $suggestion)
					<tr>
						<td><a href="{{ url('/admin/cat/add/' . $suggestion->name)}}">Add</a></td>
						<td><a href="{{ url('/admin/cat/del/' . $suggestion->category_id )}}">Delete</a></td>
						<td>{{ $suggestion->category_id }}</td>
						<td>{{ $suggestion->name }}</td>
					</tr>
				@endforeach
			</table>
			{{ $suggestions->links() }}
		</div>
		<div class = "col-md-4">
			<h4>Image Reports</h4>
			<table class = "table">
				<tr>
					<th>View Image</th>
					<th>Image Reported</th>
					<th>Reason</th>
					<th>Report Date</th>
				</tr>
				@foreach($reports as $report)
					<tr>
						<td><a href="{{ url('/admin/images/'. $report->image_id )}}">View</a></td>
						<td>{{ $report->image_id }}</td>
						<td>{{ $report->reason }}</td>
						<td>{{ $report->created_at }}</td>
					</tr>
				@endforeach
			</table>
			{{ $reports->links() }}
		</div>
	</div>
@endsection