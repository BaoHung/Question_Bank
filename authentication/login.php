<?php

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

$isCorrectInfo = FALSE;

foreach ($Accounts->children() as $Account) {
    if ($username == $Account->Email && $password == $Account->Password && !isset($Account['removed'])) {
        $isCorrectInfo = TRUE;
        session_start();
        $_SESSION["accountID"] = $Account['id']->__toString();
        break;
    }
}
echo json_encode($isCorrectInfo);
