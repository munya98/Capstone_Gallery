@extends('account.overview')

@section('account')
	<h2 class = 'text-right brand-font'>Delete Account</h2>
	<hr>
	<div class = "col-md-9">
		<div class = "row">
			<div class ="col-md-12">
				<form id = "action-purge" method = "post" action = "{{ url('account/purge/' . Auth::user()->id)}}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<div class = "form-group">
						<button type="submit" name="Purge" class = "btn-custom"> <span class="glyphicon glyphicon-alert"></span> DELETE ACCOUNT !</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection