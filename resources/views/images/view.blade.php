@extends('layouts.app')

@section('content')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57b834e01f386c6b"></script>
<div class = "container">
	<div class = "row">
		<div class = "col-md-10" id = "image-container">
			<div id = "image-title">
				<h3 class="brand-font">{{$image->display_filename}}</h3>
                <hr>
			</div>
			<img class = "img-responsive" src="{{ route('image.serve', ['album_id' => $image->album_id, 'file' => $image->name ])}}">
			<div class = "uploader">
                <div class = "row">
                    <div class = "col-md-1">
                        <img class = "user-profile-pic img-rounded img-responsive" src="{{ route('account.avatar', $owner->avatar)}}">   
                    </div>
                    <div class = "col-md-5" id = "uploader-details">
                        <p><strong><a href="{{ url('/user/'. $owner->username)}}">{{ $owner->username}}</a></strong></p>
                        <p><strong>Total Images {{ $owner_images }}</strong> </p>
                    </div>
                </div>
            </div>
			<div class = "image-view-buttons">
				@if(!Auth::guest())
					<form id = "like-form" method = "POST" action = "{{ url('/images/like/'. $image->image_id) }}">
						{{ csrf_field() }}
						<button id = "liked-button" class =" {{ $liked ? 'liked' : ' '}}">
							<strong><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</strong>
						</button>
					</form>
					<button id = "image-report-button"><strong><i class="fa fa-flag" aria-hidden="true"></i> Report</strong></button>
					@if($image->user_id === Auth::user()->id)
						<button id = "image-update-button"><strong><span class="glyphicon glyphicon-save-file"></span> Update</strong></button>
						<form  action = "{{ url('/images/purge/' . $image->image_id)}}" method = "POST" id = "image-delete">
							{{ csrf_field() }}
							{{ method_field('DELETE')}}
							<button type = "submit">
								<strong><i class="fa fa-btn fa-trash"></i> Delete</strong>
							</button>
						</form>
					@endif
				@endif
			</div>
		</div>
		<div class = "col-md-2" id = "image-details">
			<h3 class = "text-right brand-font ">Details</h3>
			<h5  class = "text-right">Views: <strong>{{ $image->views}}</strong></h5>
			<h5  class = "text-right">Likes: <strong id = "likes-value">{{ $likes}}</strong></h5>
			<h5  class = "text-right">Category: <a href="{{ url('/browse/' . $image->category)}}">{{$image->category}}</a></h5>
			<h5  class = "text-right">Status: {{ $image->permission}}</h5>
			<h5  class = "text-right">Mime/Type: {{ $image->mime}}</h5>
			<h5  class = "text-right">Size: {{ round($image->size / 1000024,2)}} MB</h5>
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
    <hr>
	<div class = "row">
		<div class = "col-md-12">
			<h4 class = "brand-font">More from {{$owner->username}}</h4>
			<div id = "carousel-recommend">
				@foreach($suggestions as $suggest)
					<div class = "item">
						<a href="{{ url('/images/' . $suggest->name)}}">
							<img src="{{ route('image.serve', ['album_id' => $suggest->album_id, 'file' => $suggest->thumbnail ])}}">
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</div>

	<div class = "row">
		<div class ="col-md-6">
			<h3 class = "brand-font">Comments</h3>
			<table class = "table" id = "list-comments">
				@for($i = 0; $i<= $comments->count() - 1; $i++)				
					<tr>
						<td id = "comment-{{$comments[$i]->comment_id}}">
                            <div class = "comment-profile-pic">
                                <a href="{{ url('/user/'. $commenter[$i]->username)}}"><img class = "recent-user-avatar img-circle img-responsive" src="{{ route('account.avatar', $commenter[$i]->avatar)}}" class="img-circle" id = "user-profile-pic"></a>
                            </div>
                            <div class = "comment-details">
                                <p>
                                    <a href="{{ url('/user/'. $commenter[$i]->username)}}">{{ $commenter[$i]->username}} </a>
                                </p>
                                <p>{{$comments[$i]->comment}}</p>
                                @if(!Auth::guest())
                                    @if($comments[$i]->user_id == Auth::user()->id)
                                        <div class = "image-view-buttons">
                                            <form method = 'POST' action = "{{ url('images/comments/delete/' . $comments[$i]->comment_id)}}">
                                                {{ csrf_field() }}
                                                <button class = "delete-comment pull-right">
                                                    <strong><i class="fa fa-btn fa-trash"></i> Delete</strong>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endif
                            </div>
						</td>
					</tr>
				@endfor
				
			</table>

			@if(Auth::guest())
				<a href="{{ url('/login')}}">Login to Comment</a>
			@else
			<form id = "submit-comment" method = "post"  action = "{{ url('/images/comments/submit')}}">
				{!! csrf_field() !!}
				<div class = "form-group">
					<input type="hidden" name="id" value = "{{ $image->image_id}}">
				</div>
                {{ $comments->links()}}
				<div class = "form-group">
					<label for = "user-comment">Comment as {{ Auth::user()->username}}</label>
                     @if ($errors->has('user-comment'))
                        <span class="help-block">
                            <strong class = "error">{{ $errors->first('user-comment') }}</strong>
                        </span>
                    @endif
					<textarea class = "form-control" name = "user-comment"></textarea>
                   
				</div>
				<div class = "form-group">
					<input class = "btn btn-default pull-right" type="submit" name="Submit" value = "Post Comment">
				</div>
			</form>
			@endif
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
                            <form id = "update-image-form" method = "POST" action = "{{ url('images/update/' . $image->image_id)}}">
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
                            	<button id = "" class = "btn-custom" type = "submit"><span class="glyphicon glyphicon-save-file"></span> Update</button>
                            </div>
                            </form>               
                        </div>
                    </div>
                </div>
                <div class = "modal-footer">
                    <button type = "button" class = "btn-custom" data-dismiss = "modal"><i class="fa fa-times" aria-hidden="true"></i>  Close</button>
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
                            <form id = "form-report" method = "POST" action = "{{ url('images/report/')}}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="image" value = "{{$image->image_id}}" >
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "Offensive Content">Offensive
                                	</label>
                                </div>
                                <hr>
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "Spam">Spam
                                	</label>
                                </div>
                                <hr>
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "DMCA/Copyright">DMCA/Copyrighted Content
                                	</label>
                                </div>
                                <hr>
                                <div class = "radio">
                                	<label>
                                		<input type="radio" name="report" value = "NSFW/Adult Content">NSFW/Disturbing/Adult Content
                                	</label>
                                </div>
                                <hr>
                                <p class = "error" id = "error-report"></p>
                                <div class = "form-group">
                                	<input id= "report-form-submit" type="submit" name="submit" class = "btn-custom" value="Report">
                                </div>
                            </form>               
                        </div>
                    </div>
                </div>
                <div class = "modal-footer">
                    <button name = "submit" type = "button" class = "btn-custom" data-dismiss = "modal"><i class="fa fa-times" aria-hidden="true"></i>  Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
	
@endsection