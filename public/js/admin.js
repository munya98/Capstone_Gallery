$(document).ready(function(){
    $('#confirm-delete').submit(function(e){
        if (!confirm('Are you sure you want to delete this album ?')) {
            e.preventDefault();
        }
    });
	$('#password-reset').submit(function(e){
        if (!confirm('Are you sure you want to reset the password ?')) {
            e.preventDefault();
        }
    });
    $('#image-delete').submit(function(e){
        if (!confirm('Are you sure you want to delete this image ?')) {
            e.preventDefault();
        }
    })
	var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            percentPosition: true,
            columnWidth: '.grid-sizer',
        });
    // layout Isotope after each image loads
        $grid.imagesLoaded().progress( function() {
            $grid.masonry();
        });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#admin-user-search').bind('change paste keyup',function(){
        $.ajax({
            url: 'search/user',
            method: 'post',
            dataType: 'json',
            data: {term : $(this).val()},
            success : function(data){
                $("tr:has(td)").remove();
                var table = "";
                $.each(data, function(key, value){
                    table += '<tr><td>'
                          +  '<a href = "users/' + value.id + '"' + '>View<a/>'
                          +  '</td><td>'
                          +  value.name
                          +  '</td><td>'
                          +  value.username
                          +  '</td><td>'
                          +  value.active
                          +  '</td><td>'
                          +  value.created_at
                          +  '</td><td>'
                          +  value.updated_at
                          +  '</td><tr>';
                });
                $("#users-table").append(table);
                console.log(data);
            }
        })
    })
})