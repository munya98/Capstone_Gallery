$(document).ready(function(){
	$('#password-reset').submit(function(e){
        if (!confirm('Are you sure you want to reset the password ?')) {
            e.preventDefault();
        }
    });
	var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            percentPosition: true,
            columnWidth: '.grid-sizer',
        });
    // layout Isotope after each image loads
        $grid.imagesLoaded().progress( function() {
            $grid.masonry();
        });
})