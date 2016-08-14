@extends('layouts.app')

@section('content')
	<div class = "container">
		<h1 class = "text-center brand-font">Browse By Categories</h1>
		<ul class = "browse-categories">
			@foreach($categories as $category)
				<li><a href="{{ url('/browse/' . $category->name)}}"><button class = "btn-custom">{{$category->name}}</button></a></li>
			@endforeach
		</ul>
		<div class = "row">
			<p class = "text-center">Suggest a Category</p>
			<div class = "col-md-offset-4 col-md-4">
				<form method = "POST" action = "{{ url('browse/category')}}">
					{{ csrf_field() }}
					<input type="text" name="suggest" class = "custom-input" placeholder="Cateogry..." value = "{{ old('suggest') }}"><br><br>
					@if($errors->has('suggest'))
						<p class = "error">{{ $errors->first() }}</p>
					@endif
					@if(session('suggestion'))
						<p class = "success">{{ session('suggestion') }}</p>
					@endif
					<div class = "text-center">
						<button class = "btn-custom text-center">Suggest</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection