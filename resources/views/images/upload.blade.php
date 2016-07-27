@extends('layouts.app')

@section('content')
	<div class = "container">
	<div class = "row">
		<div class = "col-md-4 col-md-offset-4">
			<form enctype="multipart/form-data" method = "POST" action = "{{ url('/images/upload')}}"> 
			{!! csrf_field() !!}
			<div class = "form-group">
				<label for = "name">Name</label>
				<input type="text" name="name" class = "{{ $errors->has('name') ? ' custom-error-input' : 'custom-input' }}">
			</div>
			@if($errors->has('name'))
				<strong class = "error">{{ $errors->first('name')}}</strong>
			@endif
			<div class = "form-group">
				<label for = "image">Upload Image</label>
				<input type="file" name="image" class = "{{ $errors->has('image') ? 'error' : ''}}">
			</div>
			@if($errors->has('image'))
				<strong class = "error">{{ $errors->first('image')}}</strong>
			@endif
			<div class = "form-group">
				<label for = "album">Album Name</label>
				<select name = "album" class = "custom-input">
					@foreach($albums as $album)
						<option value = "{{ $album->name}}">
							{{ $album->name}}
						</option>
					@endforeach
				</select>
			</div>
			@if($errors->has('album'))
				<strong class = "error">{{ $errors->first('album')}}</strong>
			@endif
			<div class = "form-group">
				<label for = "category">Category</label>
				<select  name = "category" class = "custom-input">
					@foreach($categories as $category)
						<option value = "{{ $category}}">
							{{$category}}
						</option>
					@endforeach
				</select>
			</div>
			@if($errors->has('category'))
				<strong class = "error">{{ $errors->first('category')}}</strong>
			@endif
			<div class = "form-group">
				<button type="submit" name="submit" class = "btn-custom"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
			</div>
			
		</form>
		</div>
	</div>
		
	</div>
@endsection