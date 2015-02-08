<!DOCTYPE html>
<html>
    <head>
        <title>Add question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/a_add.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
    </head>
    <body>
        <?php
        include '../layout/header.php';
        ?>

        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">Add new subject</h1>
        <form class="acc-form" action="view.php">
            <div style="text-align: center">
                <div>
                    <label>Subject name:</label>
                    <input style="margin-left: 4.1em" type="text" />
                </div>
                <div>
                    <label>Subject code:</label>
                    <input style="margin-left: 4.4em" type="text" />
                </div>
                <div>
                    <label>Number of chapters:</label>
                    <input type="text" />
                </div>
            </div>
            <input id="s_add" type="submit" value="Add" />      
        </form>
    </body>
</html>
