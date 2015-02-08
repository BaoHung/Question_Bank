<!DOCTYPE html>
<html>
    <head>
        <title>Add question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <link rel="stylesheet" type="text/css" href="css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="css/a_add.css" />
        <link rel="stylesheet" type="text/css" href="css/filter.css" />
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/modernizr.custom.js"></script>
    </head>
    <body>
        <?php include 'layout/header.php'; ?>

        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">Change Your Password</h1>
        <form class="acc-form">
            <div>
                <div>
                    <label>Old Password:</label>
                    <input style="margin-left: 4.9em" type="text" />
                </div>
                <div>
                    <label>New Password:</label>
                    <input style="margin-left: 4.6em" type="text" />
                </div>
                <div>
                    <label>Retype New Password:</label>
                    <input type="text" />
                </div>
            </div>
            <input id="cp_save" type="submit" value="Save" />      
        </form>
    </body>
</html>
