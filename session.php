<?php

session_start();

$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}

// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 60 * 10;

if (isset($_SESSION["accountID"]) && (!empty($_SESSION["accountID"]) || $_SESSION["accountID"] == 0 )) {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    $Accounts = simplexml_load_file("$root/xml/Accounts.xml");
    $UserAccount = NULL;
    $id = $_SESSION["accountID"];
    foreach ($Accounts->children() as $A) {
        if ($A['id'] == $id) {
            if (isset($required_role)) {
                if ($required_role == $A['role']) {
                    $UserAccount = $A;
                } else {
                    header('Location: /');
                }
            } else {
                $UserAccount = $A;
            }
            break;
        }
    }
} else {
    header('Location: /login.php');
}