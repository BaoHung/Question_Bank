<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php

header('Content-Type: application/json; charset=utf-8');

$Exams = simplexml_load_file("../xml/Exams.xml");
$subject_id = filter_input(INPUT_GET, 'subject_id');

$exmasToReturn = array();

foreach ($Exams->children() as $Exam) {
    if (
            (is_null($subject_id) || strlen($subject_id) == 0 || $subject_id == 0 || $Exam['id'] == $subject_id)
    ) {
        array_push($exmasToReturn, $Exam);
    }
}
echo json_encode($exmasToReturn);
?>