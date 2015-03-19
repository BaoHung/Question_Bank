<?php

$id = filter_input(INPUT_POST, 'id');
$password = filter_input(INPUT_POST, 'password');

$result = array(
    'mode' => 'edit',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");

foreach ($Accounts->children() as $A) {
    if ($id == $A['id']) {
        $A->Password = $password;
        break;
    }
}

$result['completed'] = $Accounts->asXML("../xml/Accounts.xml");
$result['message'] = 'Account edited successfully';

echo json_encode($result);
