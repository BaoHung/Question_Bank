<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Home</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <link rel="stylesheet" type="text/css" href="css/tooltip.css" />
        <script src="js/modernizr.custom.js"></script>    
        <script src="js/cbpTooltipMenu.min.js"></script>
    </head>
    <body>
        <?php
        include './layout/header.php';
        ?>

        <!--Hover items-->
        <ul class="grid cs-style-3" style="padding-left: 100px;padding-top: 150px;padding-bottom: 50px;">
            <li>
                <figure>
                    <img src="images/4.png" alt="img04">
                    <figcaption>
                        <h3>Question</h3>
                        <a href="">Take a look</a>
                    </figcaption>
                </figure>
            </li>
            <li>
                <figure>
                    <img src="images/1.png" alt="img01">
                    <figcaption>
                        <h3>Exam</h3>
                        <a href="">Take a look</a>
                    </figcaption>
                </figure>
            </li>			
        </ul>
        <?php
        include 'layout/footer.php';
        ?>
    </body>
</html>