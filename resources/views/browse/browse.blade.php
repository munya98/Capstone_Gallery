@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
	        @if(Session::has('status'))
	            <h3>{{ Session::get('status')}}</h3>
	        @endif
	        <div class = "col-md-6 col-md-offset-3">
	            <h1 class = "text-center brand-font">Search</h1>
	            <form method = "get" action = "{{ url('/search')}}">
	                <div class = "form-group">
	                    <input class = "search-input" type="text" name="search" placeholder="Search...">
	                    @if($errors->has('search'))
	                        <span class="help-block">
	                            <strong class = "error">{{ $errors->first('search') }}</strong>
	                        </span>
	                    @endif
	                </div>
	            </form>
	        </div>
	    </div>
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