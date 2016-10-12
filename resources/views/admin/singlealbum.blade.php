@extends('layouts.admin')
@section('title')
	{{ $album->name }}
@endsection
@section('content')
	<div class = "row">
		<div class = "col-md-6">
			<p>Album Description</p>
			<p>{{ $album->description }}</p>
			<p>Location: {{ $album->path }}</p>
			<p>Permission: {{ $album->permission }}</p>
			<form method = "POST" action = "{{ url('/albums/update/' . $album->album_id)}}">
            	{!! csrf_field() !!}
            	<div class = "form-group">
            		<input type="hidden" name="old-album-name" value = "{{ $album->name }}">
            		<input type="hidden" name="old-album-permission" value = "{{$album->permission}}">
            	</div>
                <div class = "form-group">
                    <label for = "album-Title">Album Title</label>
                    <input type="text" name="album-Title" value = "{{$album->name}}" class = "form-control">
                </div>
                <div class = "form-group">
                    <label for = "album-Description">Description</label>
                    <textarea type="textarea" name="album-Description" class = "form-control" rows = "4" value = "{{ old('album-Description')}}"></textarea>
                </div>
                <div class = "form-group">
                    <label>Permission</label><br>
                    <label class = "radio-inline"><input type="radio" name="album-Permission" value="public">Public</label>
                    <label class = "radio-inline"><input type="radio" name="album-Permission" value="private">Private</label>
                </div>
                <div class = "form-group">
                    <button class = "btn btn-default" type="submit" name="submit"><span class="glyphicon glyphicon-floppy-open"></span> Update</button>
                </div>
            </form>          
		</div>
		<div class = "col-md-6">
			<form id = "confirm-delete" action = "{{ url('/albums/purge/' . $album->album_id) }}" method= "POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" id="delete-album-{{ $album->album_id }}" class="btn-custom">
                    <i class="fa fa-btn fa-trash"></i> Delete Album
                </button>
            </form>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-12">
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
		</div>
	</div>
@endsection