@extends('layouts.app')
@section('content')
     
<div class = "container">
    <div class = "row">
        @if(Session::has('status'))
            <h3>{{ Session::get('status')}}</h3>
        @endif
        <div class = "col-md-6 col-md-offset-3">
            <h1 class = "text-center brand-font">Gallery</h1>
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
    </div><br>
    <ul class = "social-welcome">
        <!-- <li><a href="#"><i class="fa fa-twitter" target = "_blank" aria-hidden="true"></i> Twitter</a></li> -->
        <!-- <li><a href="#"><i class="fa fa-facebook-square" target="_blank" aria-hidden="true"></i> Facebook</a></li> -->
        <li><a href="https://github.com/munya98/Laravel-Image-Gallery" target="_blank"><i class="fa fa-github-alt" aria-hidden="true"></i> Github</a></li>
    </ul>
    <div class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:black;">Sort By<span class="caret"></span></a>
        <ul class="dropdown-menu">
            <li><a href="{{ url('/?sort=latest')}}">Latest</a></li> <!--  -->
            <li><a href="{{ url('/?sort=old')}}">Oldest</a></li>
            <li><a href="{{ url('/?sort=popular')}}">Most Viewed</a></li>
        </ul>
    </div>
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
    <div class = "text-center">
        {{ $images->links() }}
    </div>
</div>
@endsection
