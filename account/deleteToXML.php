<?php
session_start();

$id = filter_input(INPUT_POST, 'id');
$currentAccountID = $_SESSION["accountID"];

$result = array(
    'mode' => 'delete',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

if ($id == $currentAccountID) {
    $result['completed'] = FALSE;
    $result['message'] = 'You cannot remove your own account.';
} else {
    $Accounts = simplexml_load_file("../xml/Accounts.xml");

    foreach ($Accounts->children() as $A) {
        if ($id == $A['id']) {
            $A['removed'] = '1';
            break;
        }
    }

    $result['completed'] = $Accounts->asXML("../xml/Accounts.xml");
    $result['message'] = 'Account removed successfully';
}
echo json_encode($result);
