@extends('layouts.app')

@section('content')
	<div class = "container">
		<h1 class = "text-center brand-font">Browse By Categories</h1>
		<ul class = "browse-categories">
			@foreach($categories as $category)
				<li><a href="{{ url('/browse/' . $category)}}"><button class = "btn-custom">{{$category}}</button></a></li>
			@endforeach
		</ul>
	</div>
@endsection