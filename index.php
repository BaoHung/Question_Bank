<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        $array = simplexml_load_file("xml/Levels.xml");
        foreach ($array->Level as $level) {
            echo $level->Level_Name;
        }
        
        
        ?>
    </body>
</html>
