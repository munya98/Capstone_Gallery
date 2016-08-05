$(document).ready(function(){
    $("#home-create-album-button").click(function(){
        $("#create-album-modal").modal();
    });
    $("#image-report-button").click(function(){
        $("#report-image-modal").modal();
    });
    $("#update-album-info").click(function(){
        $("#update-album-modal").modal();
    })
    $("#upload-image-button").click(function(){
        $("#upload-image-modal").modal();
    });
    $("#image-share-button").click(function(){
        $("#share-image-modal").modal();
    });
    
    $('.dropdown-toggle').dropdown();
    //Album confirm delete
    $('#confirm-delete').submit(function(e){
        if (!confirm('Are you sure you want to delete this album ?')) {
            e.preventDefault();
        }
    });
    $('#image-delete').submit(function(e){
        if (!confirm('Are you sure you want to delete this image ?')) {
            e.preventDefault();
        }
    })
    $('#action-purge').submit(function(e){
        if (!confirm('Are you sure you want to delete your account?')) {
            e.preventDefault();
        }
    })
    $("#carousel-recommend").owlCarousel({
 
      autoPlay: 3000, //Set AutoPlay to 3 seconds
 
      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3]
 
  });
    $('.session-status').delay(4000).fadeOut("slow");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $('#report-form').submit(function(e){
    //     e.preventDefault();
    //     var x = $(this).serializeArray();
    //     //console.log(x);
    //     // $.ajax({
    //     //     url: '/images/report',
    //     //     dataType: 'json',
    //     //     type: 'post',
    //     //     data: {name : x},
    //     //     success : function(data) {
    //     //         console.log("dasdas");
    //     //     }
    //     // });

    //     $.post('/images/report', {report: x}, function(data){
    //         console.log(data)
    //     })
    // });
    var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            percentPosition: true,
            columnWidth: '.grid-sizer',
        });
    // layout Isotope after each image loads
        $grid.imagesLoaded().progress( function() {
            $grid.masonry();
        });
});