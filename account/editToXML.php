<?php

$id = filter_input(INPUT_POST, 'id');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$fullname = filter_input(INPUT_POST, 'fullname');
$role = filter_input(INPUT_POST, 'role');

$result = array(
    'mode' => 'edit',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");

foreach ($Accounts->children() as $A) {
    if ($id == $A['id']) {
        $A['role'] = $role;
        $A->Email = $email;
        $A->Password = $password;
        $A->FullName = $fullname;
        break;
    }
}

$Accounts->asXML("../xml/Accounts.xml");

$result['completed'] = TRUE;
$result['message'] = 'Account edited successfully';

echo json_encode($result);
