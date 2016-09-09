@extends('account.overview')

@section('account')
	<h2 class = 'text-right brand-font'>Social</h2>
	<hr>
	<div class = "col-md-9">
		<div class = "row" >
			<div class ="col-md-12">
				<form method = "POST" action = "{{ url('/account/social')}}">
					{{ csrf_field() }}
					<div class = "form-group">
						<p class = "text-right"><label for = "twitter">Twitter (Full Url)</label></p>
						<input class = "custom-input" type="text" name="twitter">
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "instagram">Instagram</label></p>
						<input class = "custom-input" type="text" name="instagram">
					</div>
					<div class = "form-group">
						<p class = "text-right"><label for = "facebook">Facebook</label></p>
						<input class = "custom-input" type="text" name="facebook">
					</div>
					<div class = "form-group">
						<button class ="btn-custom" name = "submit" ><span class="glyphicon glyphicon-floppy-open"></span> Update</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection