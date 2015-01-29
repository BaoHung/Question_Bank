
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
        <a href="level-view.php">View Levels</a>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $Levels = simplexml_load_file("../xml/Levels.xml");


        if (isset($_GET["Level_ID"])) {
            $Level_ID = $_GET["Level_ID"];
            foreach ($Levels->Level as $level) {
                if($level->Level_ID == $Level_ID){
                    $nodeToDelete = dom_import_simplexml($level);
                    $nodeToDelete->parentNode->removeChild($nodeToDelete);
                    break;
                }
            }
            $Levels->asXML('../xml/Levels.xml');
            echo 'Deleted';
        }
        ?>

    </body>
</html>