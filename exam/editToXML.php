<?php

$number_of_question = filter_input(INPUT_POST, 'number_of_question');
$duration = filter_input(INPUT_POST, 'duration');
$exam_name = filter_input(INPUT_POST, 'exam_name');

$question_ids = json_decode(filter_input(INPUT_POST, 'question_ids'));

$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'edit',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Exams = simplexml_load_file("../xml/Exams.xml");

foreach ($Exams->children() as $E) {
    if ($id == $E['id']) {
        $E['number_of_question'] = $number_of_question;
        $E['duration'] = $duration;

        $E->Exam_Name = $exam_name;
        break;
    }
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Exams->asXML());
$savedExam = $dom->save('../xml/Exams.xml');


// Save Q_E
$Q_Es = simplexml_load_file("../xml/Question_Exams.xml");
//$Q_E = $Q_Es->addChild('Question_Exam');
//$Q_E->addAttribute('exam_id', $id);

foreach ($Q_Es->children() as $Q_E) {
    if ($id == $Q_E['exam_id']) {
        while (isset($Q_E->Question_ID)) {
            foreach ($Q_E->Question_ID as $q) {
                $nodeToDelete = dom_import_simplexml($q);
                $nodeToDelete->parentNode->removeChild($nodeToDelete);
            }
        }
        foreach ($question_ids as $qid) {
            $Q_E->addChild('Question_ID', $qid);
        }
        break;
    }
}


$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Q_Es->asXML());
$savedQE = $dom->save('../xml/Question_Exams.xml');

if ($savedExam == FALSE) {
    $result['completed'] = FALSE;
    $result['message'] = 'Question not edited. Error: Cannot save to flie.';
} else {
    $result['completed'] = TRUE;
    $result['message'] = 'Question edited successfully.';
}


echo json_encode($result);
