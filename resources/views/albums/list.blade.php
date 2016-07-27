@extends('layouts.app')

@section('content')
<div class = "container">
	<div class = "row">
        <div class = "col-md-12">
        	<img class = "avatar-display img-circle img-responsive" src="{{ route('account.avatar', Auth::user()->avatar)}}" class="img-circle" id = "user-profile-pic">
            <h4 class = "text-center">{{ Auth::user()->username}}'s Albums</h4>
            <div style= "text-align:center">
                <button type = "button" class = "btn-custom" data-toggle = "modal" data-target = "#createAlbum" id = "home-create-album-button"><span class = "glyphicon glyphicon-plus" aria-hidden = "true"></span> Create Album
                    </button>
            </div>
        </div>
    </div><br>
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
    <!-- Modal -->
    <div class ="modal fade" id = "create-album-modal" role = "dialog">
        <div class = "modal-dialog">
            <!-- Content-->
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">Create Album</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <form method = "POST" action = "{{ url('/albums/create')}}">
                            {!! csrf_field() !!}
                            {{ method_field('PUT') }}
                                <div class = "form-group">
                                    <label for = "album-Title">Album Title</label>
                                    <input class = "custom-input" type="text" name="album-Title" value = "{{ old('album-Title')}}">
                                </div>
                                <div class = "form-group">
                                    <label for = "album-Description">Description</label>
                                    <textarea class = "custom-textarea" type="textarea" name="album-Description" rows = "4"></textarea>
                                </div>
                                <div class = "form-group">
                                    <label>Permission</label><br>
                                    <label class = "radio-inline"><input type="radio" name="album-Permission" value="public">Public</label>
                                    <label class = "radio-inline"><input type="radio" name="album-Permission" value="private">Private</label>
                                </div>
                                <div class = "form-group">
                                    <button class = "btn-custom" type="submit" name="submit"><i class="fa fa-plus" aria-hidden="true"></i> Create Album</button>
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
    @if(Session::has('status'))
        <h4 class = "text-center success session-status">{{Session::get('status')}}</h4>
    @endif
    @if(Session::has('create-status'))
        <h4 class = "text-center error session-status">{{Session::get('create-status')}}</h4>
    @endif
    <div class = "grid">
        <div class = "grid-sizer col-md-4"></div>
        @foreach($albums as $album)
            <div class = "grid-item col-md-4">
                <figure>
                    <a href="{{ url('albums/' . $album->name)}}">
                        <img  class = "img-responsive" src="{{ route('album.thumbnail', $album->thumbnail)}}">
                    </a>
                    <figcaption>
                        <h2>{{$album->name}}</h2>
                        <p>{{$album->description}}</p>
                        <p><a href="{{ url('albums/' . $album->name)}}">View Album</a></p>
                    </figcaption>
                </figure>
            </div>
        @endforeach
    </div>
</div>
@endsection




