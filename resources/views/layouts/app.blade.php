<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Capstone</title>

    <!-- Fonts -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arvo:100,300,400,700">
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css')}}">
</head>
<body id="app-layout">
    <nav class = "navbar navbar-default">
        <div class = "container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand brand-font" href="{{url('/')}}">Capstone</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">About</a></li>
                <li><a href="{{url('/browse')}}">Browse</a></li>
                <li><a href="{{ url('images/upload')}}">Upload</a></li> 
                @if(Auth::guest())
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Log in/Sign Up <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('/login')}}">Login</a></li>
                        <li><a href="{{ url('/register')}}">Sign Up</a></li>
                    </ul>
                </li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{Auth::user()->username}} 
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @role('Admin')
                        <li><a href="{{ url('/admin')}}">Admin Panel</a></li>
                        @endrole
                        <li><a href="{{ url('/account') }}"> <i class="fa fa-user" aria-hidden="true"></i> My Account</a></li>
                        <li><a href="{{ url('/albums')}}"> <i class="fa fa-folder-open" aria-hidden="true"></i> My Albums</a></li>
                        <li><a href="{{ url ('/images')}}"> <i class="fa fa-picture-o" aria-hidden="true"></i> My Images</a></li>
                        <li><a href="{{ url('/logout') }}"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                    </ul>
                </li>
                @endif
              </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    @yield('content')
    <footer>
        <div class = "container">
        <hr>
            <p class = "text-right">Capstone 2016</p>
        </div>
    </footer>
</body>
<!-- JavaScripts -->
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.js"></script>
    <script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.js"></script>
    <script type="text/javascript" src = "{{ asset('js/app.js')}}"></script>
   
</html>
