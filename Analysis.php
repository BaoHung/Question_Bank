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
        <style>
            .chart{
                height: 300px; 
                width: 60%; 
                margin: 20px auto;
            }
        </style>
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: 'subject/getCountQuestion.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        q: 'count'
                    },
                    success: function (data) {
                        // column chart
                        var options = {
                            title: {
                                text: "Number of questions in each subject"
                            },
                            backgroundColor: "#F5DEB3",
                            animationEnabled: true,
                            data: [
                                {
                                    type: "column", //change it to line, area, bar, pie, etc
                                    dataPoints: data
                                }
                            ]
                        };

                        $("#columnChart").CanvasJSChart(options);
                    }}
                );


                $.ajax({
                    url: 'subject/getCountQuestion.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        q: 'percentage'
                    },
                    success: function (data) {
                        var chart = new CanvasJS.Chart("pieChart",
                                {
                                    title: {
                                        text: "Percentage of questions in each subject"
                                    },
                                    backgroundColor: "#F5DEB3",
                                    animationEnabled: true,
                                    legend: {
                                        verticalAlign: "bottom",
                                        horizontalAlign: "center"
                                    },
                                    data: [
                                        {
                                            type: "pie",
                                            showInLegend: true,
                                            toolTipContent: "{legendText}: <strong>{y}%</strong>",
                                            indexLabel: "{label} {y}%",
                                            startAngle: -20,
                                            dataPoints: data
                                        }
                                    ]
                                });
                        chart.render();
                    }}
                );
            });
        </script>
    </head>
    <body>
        <?php
        include 'layout/header.php';
        ?>
        <!--        <div style="display: block;text-align: center;margin: 1% 5% 1% 5%">
                    <img src="images/graph_chart.jpg" alt="">           
                </div>-->
        <div id="columnChart" class="chart"></div>
        <div id="pieChart" class="chart"></div>
    </body>
</html>
