<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */
        $Levels = simplexml_load_file("../xml/Levels.xml");

        if (isset($_GET["Level_Name"])) {
            $Level_ID = $_GET["Level_Name"];
            $level = $Levels->addChild('Level');
            $level->addAttribute('id', $Levels->count());
            $level->addChild('Level_Name', $Level_ID);

            $Levels->asXML('../xml/Levels.xml');
            echo 'Added';
        }
        ?>
        <a href="view.php">View Levels</a>
        <h1>Add a level</h1>
        <form>
            Level Name: <input type="text" name="Level_Name" >
            <input type="submit" value="Add" >
        </form>
    </body>
</html>

