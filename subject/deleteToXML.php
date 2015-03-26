<?php

$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'delete',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Subjects = simplexml_load_file("../xml/Subjects.xml");

foreach ($Subjects->children() as $S) {
    if ($id == $S['id']) {
        $S['removed'] = '1';
        break;
    }
}

$result['completed'] = $Subjects->asXML("../xml/Subjects.xml");;
$result['message'] = 'Subject removed successfully';

echo json_encode($result);
