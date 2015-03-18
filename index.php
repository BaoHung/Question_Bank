<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <?php include 'layout/referances.php' ?>
    </head>
    <body>
        <?php
        include 'layout/header.php';
        ?>

        <!--Hover items-->
        <ul class="grid cs-style-3" style="padding-left: 100px;padding-top: 150px;padding-bottom: 50px;">
            <li>
                <figure>
                    <img src="images/subject2.png" alt="img04">
                    <figcaption>
                        <h3>Question 18/3</h3>
                        <a href="question/view.php">Take a look</a>

                    </figcaption>
                </figure>
            </li>
            <li>
                <figure>
                    <img src="images/exam.png" alt="img01">
                    <figcaption>
                        <h3>Exam</h3>
                        <a href="exam/view.php">Take a look</a>
                    </figcaption>
                </figure>
            </li>			
        </ul>
        <?php
        include 'layout/footer.php';
        ?>
    </body>
</html>