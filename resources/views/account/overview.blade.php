@extends('layouts.app')

@section('content')
	<div class = "container">
		<div class = "row">
			<div class = "col-md-3">
				
				<h2 class = "text-left brand-font">Account Links</h2>
				<hr>
				<ul>
					<li><a href="{{url('/account')}}" > Overview </a></li>
					<li><a href="{{url('/account/avatar')}}" > Change Avatar </a></li>
					<li><a href="{{url('/account/edit')}}" > Edit </a></li>
					<li><a href="{{url('/account/password')}}" > Update Password </a></li>
					<li><a href="{{url('/account/purge')}}"> Delete Account</a></li>
				</ul>
			</div>
			@yield('account')
		</div>
	</div>
@endsection


				
				
				
				