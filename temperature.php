<?php include_once('header.php'); ?>

    <div class="row" style="text-align: center;">
        <h4>Temperature</h4>
        <script>
            <?php list($labels,$data,$dataH) = $db->getTemperatureTodayData()?>
            temperatureTodayData = {
                labels: [<?=$labels?>],
                datasets: [
                    {
                        label: "Temperature Today",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [<?=$data?>]
                    }
                ]
            };
        </script>
        <canvas id="temperatureToday"></canvas>
    </div>

    <div class="row" style="text-align: center;">
        <h4>Humidity</h4>
        <script>
            humidityTodayData = {
                labels: [<?=$labels?>],
                datasets: [
                    {
                        label: "Humidity Today",
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: [<?=$dataH?>]
                    }
                ]
            };
        </script>
        <canvas id="humidityToday"></canvas>
    </div>


<?php
include_once('footer.php');
