@extends('layouts.app')

@section('content')
<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));
</script>
<div class = "container">
	<div class = "row">
		<div class = "col-md-10" id = "image-container">
			<div >
				<h3 class="brand-font">{{$image->display_filename}}</h3> 
			</div>
			<img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
			<div id = "upload-details">
				<p>Uploaded by <a href="{{ url('/user/'. $owner->username)}}">{{ $owner->username}}</a></p>
				@if($errors->has('report'))
                    <p class = "error">{{ $errors->first('report') }}</p>
                @endif
				@if(Session::has('status'))
		            <p class = "success">{{ Session::get('status')}}</p>
		        @endif
			</div>
			<div id = "image-view-buttons">
				@if(!Auth::guest())
					<form method = "POST" action = "{{ url('/images/like/'. $image->image_id) }}">
						{{ csrf_field() }}
						<button>
							<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like
						</button>
					</form>
					<button id = "image-share-button"><i class="fa fa-share" aria-hidden="true"></i> Share</button>
					<button id = "image-report-button"><i class="fa fa-flag" aria-hidden="true"></i> Report</button>
					@if($image->user_id === Auth::user()->id)
						<button id = "image-update-button"><span class="glyphicon glyphicon-save-file"></span> Update</button>
						<form  action = "{{ url('/images/purge/' . $image->image_id)}}" method = "POST" id = "image-delete">
							{{ csrf_field() }}
							{{ method_field('DELETE')}}
							<button type = "submit">
								<i class="fa fa-btn fa-trash"></i> Delete
							</button>
						</form>
					@endif
				@endif
			</div>
			<hr>
			<h4>More from {{$owner->username}}</h4>
			<div id = "carousel-recommend">
				@foreach($suggestions as $suggest)
					<div class = "item">
						<a href="{{ url('/images/' . $suggest->name)}}">
							<img src="{{ route('image.serve', ['album_id' => $suggest->album_id, 'file' => $suggest->name ])}}">
						</a>
					</div>
				@endforeach
			</div>
		</div>
		<div class = "col-md-2" id = "image-details">
			<h3 class = "text-right brand-font ">Details</h3>
			<h5  class = "text-right">Views: <strong>{{ $image->views}}</strong></h5>
			<h5  class = "text-right">Likes: <strong>{{ $likes}}</strong></h5>
			<h5  class = "text-right">Category: <a href="{{ url('/browse/' . $image->category)}}">{{$image->category}}</a></h5>
			<h5  class = "text-right">Status: {{ $image->permission}}</h5>
			<h5  class = "text-right">Mime/Type: {{ $image->mime}}</h5>
			<h5  class = "text-right">Size: {{ $image->size / 1000000}} MB</h5>
			<h5  class = "text-right">Dimensions: {{ $image->width}} x {{ $image->height}}</h5>
			<h5  class = "text-right">Uploaded At: {{ date('Y-m-d', strtotime($image->created_at))}}</h5>
			<h5 class = "text-right"><a href="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">Full Image</a>
		</div>
		<div class = "col-md-2">
			<h3 class = "text-right brand-font ">Other Categories</h3>
			<ul class = "text-right list-styles">
				@foreach($categories as $category)
					<li><a href="{{url('/browse/' . $category->name) }}">{{$category->name}}</a></li>
				@endforeach
			</ul>
		</div> 
	</div>
	<div class = "row">
		<div class ="col-md-6">
			<h3 class = "brand-font">Comments</h3>
			<hr>
			<table class = "table table-striped">
				@foreach($comments as $comment)					
					<tr>
						<td>
							<p class = "text-right">{{$comment->comment}}</p>
							<p>By: User @ {{$comment->created_at}}</p>
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
					<input class = "btn btn-default pull-right" type="submit" name="Submit" value = "Post Comment">
				</div>
			</form>
			@endif
		</div>
	</div>
	<div class ="row">
		<div class ="col-md-">
			
		</div>
	</div>
	<!-- Modal -->
    <div class ="modal fade" id = "update-image-modal" role = "dialog">
        <div class = "modal-dialog">
            <!-- Content-->
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">Update Image Details</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row">
                        <div class = "col-md-12">
                            <form id = "report-form" method = "POST" action = "{{ url('images/update/' . $image->image_id)}}">
                            {!! csrf_field() !!}
                            <div class = "form-group">
                            	<label for = "name">Name</label>
                            	<input  class = "custom-input" type="text" name="name" value = "{{ old('name') }}">
                            	@if($errors->has('name'))
                            		<p class = "error">{{ $errors->first('name')}}</p>
                            	@endif
                            </div>
                            <div class = "form-group">
                            	<label for = "category">Category</label>
                            	<select name = "category" class = "custom-input">
									@foreach($allcategories as $category)
										<option value = "{{ $category->name }}">
											{{ $category->name}}
										</option>
									@endforeach
								</select>
								@if($errors->has('category'))
                            		<p class = "error">{{ $errors->first('category')}}</p>
                            	@endif
                            </div>
                            <div class = "form-group">
                            	<button class = "btn-custom" type = "submit"><span class="glyphicon glyphicon-save-file"></span> Update</button>
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
    <!-- Modal -->
    <div class ="modal fade" id = "share-image-modal" role = "dialog">
        <div class = "modal-dialog">
            <!-- Content-->
            <div class = "modal-content">
                <div class = "modal-header">
                    <h4 class = "modal-title">Share</h4>
                </div>
                <div class = "modal-body">
                    <div class = "row">
                        <div class = "col-md-12 text-center">
							<a 	class="twitter-share-button" 
								href="https://twitter.com/share" 
								target="_blank"
								data-size = "large"
								data-text = "shared test image"
								data-hashtags = "test">
								Tweet
								<!-- <button class = "btn-custom">Tweet</button> -->
  							</a>
  							<div class="fb-share-button" 
								 data-href="asdaasd" 
								 data-layout="button"
								 data-size="large"
								 data-mobile-iframe="true">
								 <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Facebook</a>
							</div>
                        	<a href="//www.reddit.com/submit" onclick="window.location = '//www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false"> <img src="//www.redditstatic.com/spreddit10.gif" alt="submit to reddit" border="0" /> </a>
                        	<p><a href="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}" target="_blank">Direck Link</a></p>
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