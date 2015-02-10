<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-Type: application/json; charset=utf-8');

$Subjects = simplexml_load_file("../xml/Subjects.xml");
$query = filter_input(INPUT_POST, 'q');

$subjectsToReturn = array();
foreach ($Subjects->children() as $Subject) {
    if (
            (is_null($query) || strlen($query) == 0 || $query === '' || strpos(strtolower($Subject->Subject_Name), strtolower($query)) !== FALSE)
    ) {
        array_push($subjectsToReturn, $Subject);
    }
}
echo json_encode($subjectsToReturn);
