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
			<div class = "col-md-3 aside-menu">
				<h3 class = "text-center compenent-header"> CAPSTONE</h3>
				<hr>
			</div>
			<div class = "col-md-9 main-content">
				<div class = "component-header">
					<h3 class = "text-center">Admin Panel</h3>
					<hr>
					<P>HA</P>
				</div>
				@yield('content')
			</div>
		</div>	
	</div>
</body>
</html>