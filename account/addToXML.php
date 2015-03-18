<?php

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');
$fullname = filter_input(INPUT_POST, 'fullname');
$role = filter_input(INPUT_POST, 'role');
$id = 0;

$result = array(
    'added' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");

foreach ($Accounts->children() as $A) {
    $id = $A['id'];
    if ($A->Email == $email) {
        $result['added'] = FALSE;
        $result['message'] = 'Email already exists.';
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

$result['added'] = TRUE;
echo json_encode($result);
