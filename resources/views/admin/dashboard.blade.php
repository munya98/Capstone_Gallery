@extends('layouts.admin')
@section('title')
	Dashboard
@endsection
@section('content')
	<div class = "row">
		<div class = "col-md-4 dashboard-module module">
			<h4>Total Users</h4>
			<hr>
			<h4 class = "text-right">{{ $totalUsers }}</h4>
		</div>
		<div class = "col-md-4 dashboard-module module">
			<h4>Total Images Uploaded</h4>
			<hr>
			<h4 class = "text-right">{{ $totalImages }}</h4>
		</div>
		<div class = "col-md-4 dashboard-module module">
			<h4>Total Albums Created</h4>
			<hr>
			<h4 class = "text-right">{{ $totalAlbums }}</h4>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-9 dashboard-module-images-recent module">
			<h4>Recently Uploaded Images</h4>
			<hr>
			<!-- <div class = "">
				
			</div> -->
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			  <!-- Indicators -->
			  <ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="5"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="6"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="7"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="8"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="9"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="10"></li>
			  </ol>

			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			  	
			    <div class="item active">
			      <img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $latestImage->album_id, 'file' => $latestImage->name ])}}">
			    </div>
			    @foreach($recentImages as $image)
					<div class ="item">
						<img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
					</div>
				@endforeach
			  </div>

			  <!-- Controls -->
			  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
			    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			    <span class="sr-only">Previous</span>
			  </a>
			  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
			    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
			  </a>
			</div>
		</div>
		<div class = "col-md-3 dashboard-module-recent-users module">
			<h4>Recent Users</h4>
			<hr>
			@foreach($recentUsers as $user)
				<div class = "recent-user">
					<img class = "recent-user-avatar img-circle img-responsive" src="{{ route('account.avatar', $user->avatar)}}" class="img-circle" id = "user-profile-pic">
					<p><strong>{{ $user->name}}</strong> goes by <strong>{{ $user->username}}</strong></p>
					<hr>
				</div>
			@endforeach
		</div>
	</div>
@endsection