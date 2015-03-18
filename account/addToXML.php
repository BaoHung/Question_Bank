<?php

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$fullname = filter_input(INPUT_POST, 'fullname');
$role = filter_input(INPUT_POST, 'role');
$id = 0;

$result = array(
    'mode' => 'create',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");

foreach ($Accounts->children() as $A) {
    $id = $A['id'];
    if ($A->Email == $email) {
        $result['completed'] = FALSE;
        $result['message'] = 'Account not created.\r\n Email already exists.';
        echo json_encode($result);
        return;
    }
}

$Account = $Accounts->addChild('Account');
$Account->addAttribute('id', $id + 1);
$Account->addAttribute('role', $role);
$Account->addChild('Email', $email);
$Account->addChild('Password', $password);
$Account->addChild('FullName', $fullname);

$Accounts->asXML("../xml/Accounts.xml");

$result['completed'] = TRUE;
$result['message'] = 'Account created successfully.';

echo json_encode($result);
