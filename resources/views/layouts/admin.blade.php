<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata:100,300,400,700">
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin.css')}}">
</head>
<body>
	<div class = "container-fluid">
		<div class = "row">
			<div class = "col-md-2 aside-menu">
				<h2 class = "text-center">Capstone</h2>
				<hr>
					<img class = "avatar-admin-display img-circle img-responsive" src="{{ route('account.avatar', Auth::user()->avatar)}}" id = "user-profile-pic">
					<p class = "text-center">{{ Auth::user()->name}}</p>
					<p class = "text-center">Administrator</p><br>
					<ul id = "aside-menu-list">
						<li><i class="fa fa-home" aria-hidden="true"></i> <a href="{{ url('/')}}">Main Site</a></li>
						<li><i class="fa fa-tachometer" aria-hidden="true"></i> <a href="{{ url('/admin')}}">Dashboard</a></li>
						<li><i class="fa fa-user" aria-hidden="true"></i> <a href="{{ url('/admin/users')}}">Users</a></li>
						<li><i class="fa fa-folder" aria-hidden="true"></i> <a href="{{ url('/admin/albums')}}">Albums</a></li>
						<li><i class="fa fa-camera" aria-hidden="true"></i> <a href="{{ url('/admin/images')}}">Images</a></li>
						<li><i class="fa fa-line-chart" aria-hidden="true"></i> <a href="{{ url('/admin/reports')}}">Reports</a></li>
						<li><i class="fa fa-sign-out" aria-hidden="true"></i> <a href="{{ url('/logout')}}">Logout</a></li>
					</ul>
			</div>
			<div class = "col-md-10" style="background-color: ">
				<h2>@yield('title')</h2>
				<hr>
				@yield('content')
				<footer>
					<hr>
					<p class = "text-right">2016 Capstone</p>
				</footer>
			</div>
		</div>
	</div>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.js"></script>
    <script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
    <script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.js"></script>
    <script type="text/javascript" src = "{{ asset('js/owl.carousel.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('js/admin.js')}}"></script>
</html>