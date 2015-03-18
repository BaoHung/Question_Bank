<?php

session_start();

if (isset($_SESSION["accountID"]) && (!empty($_SESSION["accountID"]) || $_SESSION["accountID"] == 0 )) {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    var_dump($root);

    $Accounts = simplexml_load_file("$root/xml/Accounts.xml");
    $Account = NULL;
    $id = $_SESSION["accountID"];
    foreach ($Accounts->children() as $A) {
        if ($A['id'] == $id) {
            $Account = $A;
            break;
        }
    }
    var_dump($Account);
} else {
    header('Location: /Login.html');
}