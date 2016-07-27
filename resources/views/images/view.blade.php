@extends('layouts.app')

@section('content')
<div class = "container">

	<div class = "row">
		<div class = "col-md-10">
			<h1 class="brand-font"> {{$image->display_filename}} </h1>
			<hr>
			<img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
		</div>
		<div class = "col-md-2">
			<h1 class = "text-right brand-font">Image Details</h1>
			<hr>
			<h5>Image Name : {{$image->display_filename}}</h5>
			<h5>Category : <a href="{{ url('/browse/' . $image->category)}}">{{$image->category}}</a></h5>
			<h5>Type : {{$image->mime}}</h5>
			<h5>Rating : {{$image->rating}}</h5>
			<h5>Views : {{$image->views}}</h5>
			<h5>Dimensions : {{ $image->width}} x {{ $image->height}}</h5>
			<h5>Uploaded At : {{ date('Y-m-d', strtotime($image->created_at))}}</h5>
			<h5>Owner: <a href="{{ url('/user/' . $owner)}}">{{$owner}}</a></h5>
			@if(Auth::guest())
				<a href="{{ url('/login')}}">Login to Report Image</a>
			@else
				@if($image->user_id === Auth::user()->id)
					<button class = "btn-custom">Delete Image</button><br><br>
				@endif
				<button class = "btn-custom" id = "image-report-button">Report</button>
				@if(count($errors) > 0)
                    <p class = "error">{{ $errors->first('report') }}</p>
                @endif
				@if(Session::has('status'))
		            <p class = "success">{{ Session::get('status')}}</p>
		        @endif
			@endif
			<h1 class = "brand-font text-right">Comments</h1>
			<hr>
			<table class = "table table-striped">
				@foreach($comments as $comment)					
					<tr>
						<td>
							<p class = "text-right">{{$comment->comment}}</p>
							<p>By: Wuju @ {{$comment->created_at}}</p>
						</td>
					</tr>
				@endforeach
				{{ $comments->links()}}
			</table>

			@if(Auth::guest())
				<a href="{{ url('/login')}}">Login to Comment</a>
			@else
			<form method = "post"  action = "{{ url('/images/comments/submit')}}">
				{!! csrf_field() !!}
				<div class = "form-group">
					<input type="hidden" name="id" value = "{{ $image->image_id}}">
				</div>
				<div class = "form-group">
					<label for = "user-comment">Comment as {{ Auth::user()->username}}</label>
					<textarea class = "form-control" name = "user-comment"></textarea>
				</div>
				<div class = "form-group">
					<input class = "btn btn-default" type="submit" name="Submit" value = "Submit Comment">
				</div>
			</form>
			@endif
		</div>
	</div>
	<!-- Modal -->
    <div class ="modal fade" id = "report-image-modal" role = "dialog">
        <div class = "modal-dialog">
            <!-- Content-->
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">Report Image</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <form id = "report-form" method = "POST" action = "{{ url('images/report/')}}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="image" value = "{{$image->image_id}}" >
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "offensive">Offensive
                                	</label>
                                </div>
                                <hr>
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "spam">Spam or Scam
                                	</label>
                                </div>
                                <hr>
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "dmca">DMCA Legal Stuff
                                	</label>
                                </div>
                                <hr>
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "nsfw">NSFW
                                	</label>
                                </div>
                                <hr>
                                <div class = "form-group">
                                	<input type="submit" name="submit" class = "btn-custom" value="Report">
                                </div>
                            </form>               
                        </div>
                    </div>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-primary" data-dismiss = "modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Ends -->

</div>
	
@endsection