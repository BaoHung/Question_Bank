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
        <a href="add.php">Add Level</a>
        <h1>View Levels</h1>
        <table>
            <tr>
                <th>Level ID</th>
                <th>Level Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php
            /*
             * To change this license header, choose License Headers in Project Properties.
             * To change this template file, choose Tools | Templates
             * and open the template in the editor.
             */


            // put your code here
            $Levels = simplexml_load_file("../xml/Levels.xml");
            foreach ($Levels->Level as $level) {
                ?>
                <tr>
                    <td><?= $level['id'] ?></td>
                    <td><?= $level->Level_Name ?></td>
                    <td><a href="edit.php?Level_ID=<?= $level['id'] ?>">Edit</a></td>
                    <td><a href="delete.php?Level_ID=<?= $level['id'] ?>">Delete</a></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>