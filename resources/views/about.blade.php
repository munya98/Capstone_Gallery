@extends('layouts.app')

@section('content')
<div class="container">
    <p>This image gallery blah blah blah is my Capstone Project/Fun Project/First Laravel Work</p>

    <p>So what I used is listed below</p>
    <ul>
    	<li>Laravel PHP Framework</li>
		<ul>
			<li>Plugins</li>
			<ul>
				<li>Intervention Image - to handle image uploads, resizing and more...  <a target="_blank" href="http://image.intervention.io/">Website</a></li>
				<li>Entrust - Add user roles <a target="_blank" href="https://github.com/Zizaco/entrust">Website</a></li>
			</ul>
		</ul>
		<li>MySQL Database</li>
		<li>Javascript</li>
		<ul>
			<li>Plugins</li>
			<ul>
				<li>JQuery</li>
				<li>Bootstrap JS - for modals and carousels <a target="_blank" href="http://getbootstrap.com/javascript/">Website</a></li>
				<li>Owl Carousel - small carousel under image display... <a target="_blank" href="http://owlgraphic.com/owlcarousel/index.html">Website</a></li>
				<li>JQuery Masonry - for the nice fancy layout for different sized images <a target="_blank" href="http://masonry.desandro.com/">Website</a></li>
				<li>Images Loaded - not exactly sure what this does but taking it out = bad <a target="_blank" href="http://imagesloaded.desandro.com/">Website</a></li>
			</ul>
		</ul>
		<li>CSS/Fonts</li>
		<ul>
			<li>CSS</li>
			<ul>
				<li>Bootstrap <a target="_blank" href="http://getbootstrap.com">Website</a></li>
			</ul>
			<li>Fonts</li>
			<ul>
				<li class = "brand-font">Lobster <a target="_blank" href="https://fonts.google.com/specimen/Lobster">Link</a></li>
				<li>Incosolata <a target="_blank" href="https://fonts.google.com/specimen/Inconsolata">Link</a></li>
			</ul>
		</ul>
    </ul>
</div>
@endsection
