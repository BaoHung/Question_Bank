<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// put your code here
$array = simplexml_load_file("../xml/Levels.xml");
foreach ($array->Level as $level) {
    echo $level->Level_Name;
}
?>