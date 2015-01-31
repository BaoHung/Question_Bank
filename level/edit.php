
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
        <a href="view.php">View Levels</a>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $Levels = simplexml_load_file("../xml/Levels.xml");


        if (isset($_GET["Level_ID"]) && !isset($_GET["Level_Name"])) {
            $Level_ID = $_GET["Level_ID"];
            ?>
            <form>
                <input type="hidden" name="Level_ID" value="<?= $Level_ID ?>"/>
                Level Name: 
                <input type="text" name="Level_Name" 
                       value="<?= $Levels->xpath('//Levels/Level[@id="' . $Level_ID . '"]')[0]->Level_Name ?>" >
                <input type="submit" value="Save" >
            </form>
            <?php
        } else if (isset($_GET["Level_ID"]) && isset($_GET["Level_Name"])) {
            $Level_ID = $_GET["Level_ID"];
            $Level_Name = $_GET["Level_Name"];

            foreach ($Levels->children() as $level) {
                if ($level['id'] == $Level_ID)
                    $level->Level_Name = $Level_Name;
            }

//            $Levels->Level[$Level_ID - 1]->Level_Name = $Level_Name;
            $Levels->asXML('../xml/Levels.xml');
            echo 'Saved';
        }
        ?>

    </body>
</html>