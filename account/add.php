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
        <?php include'../layout/header.php'; ?>

        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">Create new account</h1>
        <form class="acc-form" action="view.php">
            <div>
                <div>
                    <label>Email:</label>
                    <input style="margin-left: 2.8em" type="text" />
                </div>
                <div>
                    <label>Fullname:</label>
                    <input style="margin-left: 0.8em" type="text" />
                </div>
                <div>
                    <label>Password:</label>
                    <input type="text" />
                </div>
                <label>Role:</label>
                <span style="margin-left: 3em" class="custom-dropdown">
                    <select style="padding: 0.3em 2em 0.1em 0.1em">
                        <option>Administrator</option>
                        <option>Lecturer</option>  
                    </select>
                </span>
            </div>
            <input id="acc_save" type="submit" value="Create" />      
        </form>
    </body>
</html>
