<?php

$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'delete',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Exams = simplexml_load_file("../xml/Exams.xml");

foreach ($Exams->children() as $E) {
    if ($id == $E['id']) {
        $E['removed'] = '1';
        break;
    }
}

$result['completed'] = $Exams->asXML("../xml/Exams.xml");
$result['message'] = 'Account removed successfully';

echo json_encode($result);
