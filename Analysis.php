<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Home</title>        
        <link rel="stylesheet" type="text/css" href="css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <link rel="stylesheet" type="text/css" href="css/tooltip.css" />
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/modernizr.custom.js"></script>
        <script src="js/jquery.canvasjs.min.js"></script>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'subject/getSubject.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index, subject) {
                            attr = subject['@attributes'];
                        });
                    }}
                );

                var options = {
                    title: {
                        text: "Number of questions in each subjects"
                    },
                    animationEnabled: true,
                    data: [
                        {
                            type: "column", //change it to line, area, bar, pie, etc

                            dataPoints: [
                                {label: 'PHP', y: 20},
                                {label: 'HTML', y: 20},
                            ]
                        }
                    ]
                };

                $("#chartContainer").CanvasJSChart(options);
            });
        </script>
    </head>
    <body>
        <?php
        include 'layout/header.php';
        ?>
        <div style="display: block;text-align: center;margin: 1% 5% 1% 5%">
            <img src="images/graph_chart.jpg" alt="">           
        </div>
        <div id="chartContainer" style="height: 300px; width: 60%; margin: auto"></div>
    </body>
</html>
