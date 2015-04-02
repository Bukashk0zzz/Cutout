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

    $('.modal-trigger').leanModal();

    body.on('click','.commandStart',function(e){
        preloader.on();
        e.preventDefault();
        e.stopPropagation();

        var el = $(this),
            id = el.attr('data-id');

        $.get('/?id='+id);

        if (id == 1) {
            Materialize.toast('Restarted!', 3000);
        } else if (id == 2 || id == 6 || id == 4 || id == 5) {
            Materialize.toast('Make some noise!', 3000);
        } else if (id == 3) {
            Materialize.toast('I killed that bitch!', 3000);
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
    });

    var ctx = $("#temperatureToday").get(0).getContext("2d"),
        myLineChart = new Chart(ctx).Line(temperatureTodayData, {
            responsive: true,
            pointHitDetectionRadius : 3,
            multiTooltipTemplate: "<%=datasetLabel%>: <%=value%>"
        });

    var ctx2 = $("#pirToday").get(0).getContext("2d"),
        myLineChart = new Chart(ctx2).Radar(pirTodayData, {
            responsive: true,
            pointHitDetectionRadius : 3,
            multiTooltipTemplate: "<%=datasetLabel%>: <%=value%>"
        });

});