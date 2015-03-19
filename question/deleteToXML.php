<?php

$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'delete',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Questions = simplexml_load_file("../xml/Questions.xml");

foreach ($Questions->children() as $Q) {
    if ($id == $Q['id']) {
        $Q['removed'] = '1';
        break;
    }
}

$result['completed'] = $Questions->asXML("../xml/Questions.xml");
$result['message'] = 'Account removed successfully';

echo json_encode($result);
