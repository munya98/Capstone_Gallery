@extends('layouts.app')
@section('content')
     
<div class = "container">
    <div class = "row">
        @if(Session::has('status'))
            <h3>{{ Session::get('status')}}</h3>
        @endif
        <div class = "col-md-6 col-md-offset-3">
            <h1 class = "text-center brand-font">Capstone</h1>
            <form method = "GET" action = "{{url('/search')}}">
                <div class = "form-group">
                    <input class = "search-input" type="text" name="search" placeholder="Search...">
                    @if(count($errors) > 0)
                        <p>{{ $errors->first() }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div><br>
    <ul class = "social-welcome">
        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</a></li>
        <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</a></li>
        <li><a href="#"><i class="fa fa-github-alt" aria-hidden="true"></i> Github</a></li>
    </ul>
    <h5>Latest Images</h5>

    <div class = "grid">
        <div class = "grid-sizer col-md-4"></div>
        @foreach($images as $image)
            <div class = "grid-item col-md-4">
                <div class = "grid-item-content">
                    <a href="{{url('/images/'. $image->name)}}">
                        <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    <div class = "text-center">
        {{ $images->links()}}
    </div>
</div>
@endsection
