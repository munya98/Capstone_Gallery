@extends('layouts.app')

@section('content')
<div class="container">
@if(count($errors) > 0)
    <div class = "row">
        <div class = "col-md-12">
            <div class = "alert alert-danger">
                <ul style = "padding-left: 10px;" > 
                    @foreach($errors->all() as $error)
                    <li> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
	<div class = "row">
		<div class = "col-md-9">
            <h3 class = "brand-font">{{ $album->name}}</h3>
            <hr>
			@if($images->count() <= 0)
                <p>This albums is empty :(</p>
            @else
            <div class = "grid">
                <div class = "grid-sizer col-md-4"></div>
                @foreach($images as $image)
                    <div class = "grid-item col-md-4">
                        <div class = "grid-item-content">
                            <a href="{{url('/images/'. $image->name)}}">
                                <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->thumbnail ])}}">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
			{{ $images->links()}}
            @endif
		</div>
		<div class = "col-md-3">
			<h3 class = "text-right brand-font">Album Details</h3>
			<hr>
			<p class = "text-right">Name: {{$album->name}}</p>
			<p class = "text-right">Description</p>
			<p class = "text-right">{{$album->description}}</p>
			<p class = "text-right">Permission: {{$album->permission}}</p>
			<p class = "text-right">Created: {{ date('Y-m-d', strtotime($album->created_at))}}</p>
            <button id = "upload-image-button" class = "btn-custom"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Image</button><br><br>
			<button id = "update-album-info" class = "btn-custom"><span class="glyphicon glyphicon-floppy-open"></span> Update Album Info</button><br><br>
			<form id = "confirm-delete" action = "{{ url('/albums/purge/' . $album->album_id) }}" method= "POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" id="delete-album-{{ $album->album_id }}" class="btn-custom">
                    <i class="fa fa-btn fa-trash"></i> Delete Album
                </button>
            </form><br>
		</div>
	</div>
	<!-- Modal -->
    <div class ="modal fade" id = "update-album-modal" role = "dialog">
        <div class = "modal-dialog">
            <!-- Content-->
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">Update {{$album->name}}</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <form method = "POST" action = "{{ url('/albums/update/' . $album->album_id)}}">
                            {!! csrf_field() !!}
                            	<div class = "form-group">
                            		<input type="hidden" name="old-album-name" value = "{{ $album->name }}">
                            		<input type="hidden" name="old-album-permission" value = "{{$album->permission}}">
                            	</div>
                                <div class = "form-group">
                                    <label for = "album-Title">Album Title</label>
                                    <input type="text" name="album-Title" value = "{{$album->name}}" class = "custom-input">
                                </div>
                                <div class = "form-group">
                                    <label for = "album-Description">Description</label>
                                    <textarea type="textarea" name="album-Description" class = "custom-textarea" rows = "4" value = "{{ old('album-Description')}}"></textarea>
                                </div>
                                <div class = "form-group">
                                    <label>Permission</label><br>
                                    <label class = "radio-inline"><input type="radio" name="album-Permission" value="public">Public</label>
                                    <label class = "radio-inline"><input type="radio" name="album-Permission" value="private">Private</label>
                                </div>
                                <div class = "form-group">
                                    <button class = "btn-custom" type="submit" name="submit"><span class="glyphicon glyphicon-floppy-open"></span> Update</button>
                                </div>
                            </form>               
                        </div>
                    </div>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn-custom" data-dismiss = "modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->

    <!-- Upload Image Modal -->
    <div class ="modal fade" id = "upload-image-modal" role = "dialog">
        <div class = "modal-dialog">
            <!-- Content-->
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">Upload Image To {{$album->name}}</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <form enctype="multipart/form-data" method = "POST" action = "{{ url('/images/upload')}}"> 
                                {!! csrf_field() !!}
                                <div class = "form-group">
                                    <label for = "name">Name</label>
                                    <input type="text" name="name" class = "custom-input">
                                </div>
                                <div class = "form-group">
                                    <label for = "image">Upload Image</label>
                                    <input type="file" name="image[]" class = "custom-input file" multiple>
                                </div>
                                <div class = "form-group">
                                    <label for = "album">Album Name</label>
                                    <input type="text" name="album" value = "{{ $album->name }}" readonly class = "custom-input">
                                </div>
                                <div class = "form-group">
                                    <label for = "category">Category</label>
                                    <select  name = "category" class = "custom-input">
                                        @foreach($categories as $category)
                                            <option value = "{{ $category->name}}">
                                                {{$category->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <button type = "submit" name = "submit" class = "btn-custom"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
                                </div>
                                
                            </form>   
                        </div>
                    </div>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn-custom" data-dismiss = "modal"><i class="fa fa-times" aria-hidden="true"></i>  Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection