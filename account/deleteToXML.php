<?php

$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'delete',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");

foreach ($Accounts->children() as $A) {
    if ($id == $A['id']) {
        $A['removed'] = '1';
        break;
    }
}

$Accounts->asXML("../xml/Accounts.xml");

$result['completed'] = TRUE;
$result['message'] = 'Account removed successfully';

echo json_encode($result);
