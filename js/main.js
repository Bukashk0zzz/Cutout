$(document).ready(function() {
    var body = $('body'),
        sliding = false;

    preloader = new $.materialPreloader({
        position: 'top',
        height: '5px',
        col_1: '#159756',
        col_2: '#da4733',
        col_3: '#3b78e7',
        col_4: '#fdba2c',
        fadeIn: 200,
        fadeOut: 200
    });

    body.on('click','.commandStart',function(e){
        preloader.on();
        e.preventDefault();
        e.stopPropagation();

        var el = $(this),
            id = el.attr('data-id');

        $.get('/?id='+id);

        if (id == 1) {
            toast('Restarted!', 3000);
        } else if (id == 2) {
            toast('Make some noise!', 3000);
        } else if (id == 3) {
            toast('I killed that bitch!', 3000);
        }

        setTimeout(function(){
            preloader.off();
        }, 1000);
    });

    body.on('change','#volume',function(){
        preloader.on();
        if (sliding) {
            return true;
        }
        sliding = true;

        setTimeout(function(){
            var volume = $("#volume").val();
            $.get('/?volume='+volume);
            sliding = false;
        }, 200);

        setTimeout(function(){
            preloader.off();
        }, 1000);
    })
});