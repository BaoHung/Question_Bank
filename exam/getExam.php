<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php

header('Content-Type: application/json; charset=utf-8');

$Exams = simplexml_load_file("../xml/Exams.xml");
$id = filter_input(INPUT_GET, 'id');

$exmasToReturn = array();

foreach ($Exams->children() as $Exam) {
    if (
            (is_null($id) || strlen($id) == 0 || $id == 0 || $Exam['id'] == $id)
    ) {
        array_push($exmasToReturn, $Exam);
    }
}
echo json_encode($exmasToReturn);
?>