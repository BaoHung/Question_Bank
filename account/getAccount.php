<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php

header('Content-Type: application/json; charset=utf-8');

$Accounts = simplexml_load_file("../xml/Accounts.xml");
$query = filter_input(INPUT_POST, 'q');
$role = filter_input(INPUT_POST, 'role');

$accountsToReturn = array();

foreach ($Accounts->children() as $Account) {
    $query = strtolower(RemoveSign($query));
    $name = strtolower(RemoveSign($Account->FullName));
    if (
            (is_null($query) || strlen($query) == 0 || $query === '' || strpos($name, $query) !== FALSE) &&
            (is_null($role) || $role == -1 || $Account['role'] == $role)
    ) {
        array_push($accountsToReturn, $Account);
    }
}
echo json_encode($accountsToReturn);

?>