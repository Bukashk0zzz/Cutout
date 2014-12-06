$(document).ready(function() {
    var body = $('body'),
        sliding = false;

    body.on('click','.commandStart',function(e){
        e.preventDefault();
        e.stopPropagation();

        var el = $(this),
            id = el.attr('data-id');

        $.get('/?id='+id);
    });

    $('input[type="range"]').rangeslider({
        polyfill: false,
        rangeClass: 'rangeslider',
        fillClass: 'rangeslider__fill',
        handleClass: 'rangeslider__handle'
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
        }, 2000);
    })
});