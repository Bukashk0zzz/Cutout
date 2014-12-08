$(document).ready(function() {
    var body = $('body'),
        sliding = false;

    body.on('click','.commandStart',function(e){
        e.preventDefault();
        e.stopPropagation();

        var el = $(this),
            id = el.attr('data-id');

        $.get('/?id='+id);
        toast('Done!', 3000)
    });

    body.on('change','#volume',function(){
        if (sliding) {
            return true;
        }
        sliding = true;

        setTimeout(function(){
            var volume = $("#volume").val();
            $.get('/?volume='+volume);
            sliding = false;
        }, 200);
    })
});