$(document).ready(function() {
    body = $('body');

    body.on('click','.commandStart',function(e){
        e.preventDefault();
        e.stopPropagation();

        var el = $(this),
            id = el.attr('data-id');

        $.get('/?id='+id);
    });
});