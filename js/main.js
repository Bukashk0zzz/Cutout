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

    $.get('/api.php?data=main', function(data) {
        $('#temperature').html(data.temperature);
        $('#humidity').html(data.humidity);
        $('#time').html(data.time);
        $('#temperature_o').html(data.temperature_o);
        $('#humidity_o').html(data.humidity_o);
        $('#time_action').html(data.time_action);
        $('#volume').val(data.volume);
    });

    var temperatureTodayData = {
        labels: [],
        datasets: [
            {
                label: "Humidity",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,0.8)",
                data: []
            },
            {
                label: "Temperature",
                fillColor: "rgba(247,70,74,0.2)",
                strokeColor: "rgba(247,70,74,1)",
                pointColor: "rgba(247,70,74,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(247,70,74,0.8)",
                data: []
            }
        ]
    };

    var temperatureTodayOutdoorData = {
        labels: [],
        datasets: [
            {
                label: "Humidity outdoor",
                fillColor: "rgba(253,180,92,0.2)",
                strokeColor: "rgba(253,180,92,1)",
                pointColor: "rgba(253,180,92,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(253,180,92,0.8)",
                data: []
            },
            {
                label: "Temperature outdoor",
                fillColor: "rgba(70,191,189,0.2)",
                strokeColor: "rgba(70,191,189,1)",
                pointColor: "rgba(70,191,189,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(70,191,189,0.8)",
                data: []
            }
        ]
    };

    var temperatureTodayAllData = {
        labels: [],
        datasets: [
            {
                label: "Humidity",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,0.8)",
                data: []
            },
            {
                label: "Temperature",
                fillColor: "rgba(247,70,74,0.2)",
                strokeColor: "rgba(247,70,74,1)",
                pointColor: "rgba(247,70,74,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(247,70,74,0.8)",
                data: []
            },
            {
                label: "Humidity outdoor",
                fillColor: "rgba(253,180,92,0.2)",
                strokeColor: "rgba(253,180,92,1)",
                pointColor: "rgba(253,180,92,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(253,180,92,0.8)",
                data: []
            },
            {
                label: "Temperature outdoor",
                fillColor: "rgba(70,191,189,0.2)",
                strokeColor: "rgba(70,191,189,1)",
                pointColor: "rgba(70,191,189,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(70,191,189,0.8)",
                data: []
            }
        ]
    };

    var pirTodayData = {
        labels: [],
        datasets: [
            {
                label: "PIR",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: []
            }
        ]
    };

    var ctx1 = $("#temperatureToday").get(0).getContext("2d"),
        myLineChart1 = new Chart(ctx1).Line(temperatureTodayData, {
            responsive: true,
            pointHitDetectionRadius : 3,
            multiTooltipTemplate: "<%=datasetLabel%>: <%=value%>"
        });

    var ctx2 = $("#temperatureTodayOutdoor").get(0).getContext("2d"),
        myLineChart2 = new Chart(ctx2).Line(temperatureTodayOutdoorData, {
            responsive: true,
            pointHitDetectionRadius : 3,
            multiTooltipTemplate: "<%=datasetLabel%>: <%=value%>"
        });

    var ctx3 = $("#temperatureTodayAll").get(0).getContext("2d"),
        myLineChart3 = new Chart(ctx3).Line(temperatureTodayAllData, {
            responsive: true,
            pointHitDetectionRadius : 3,
            multiTooltipTemplate: "<%=datasetLabel%>: <%=value%>"
        });

    var ctx4 = $("#pirToday").get(0).getContext("2d"),
        myLineChart4 = new Chart(ctx4).Radar(pirTodayData, {
            responsive: true,
            pointHitDetectionRadius : 3,
            multiTooltipTemplate: "<%=datasetLabel%>: <%=value%>"
        });

    body.on('click','.commandStart',function(e){
        preloader.on();
        e.preventDefault();
        e.stopPropagation();

        var el = $(this),
            id = el.attr('data-id');

        $.get('/api.php?id='+id);

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
});