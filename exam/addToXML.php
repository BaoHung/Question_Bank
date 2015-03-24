<?php

$number_of_question = filter_input(INPUT_POST, 'number_of_question');
$duration = filter_input(INPUT_POST, 'duration');
$exam_name = filter_input(INPUT_POST, 'exam_name');

$question_ids = json_decode(filter_input(INPUT_POST, 'question_ids'));

$id = 0;

$result = array(
    'mode' => 'create',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Exams = simplexml_load_file("../xml/Exams.xml");

foreach ($Exams->children() as $E) {
    $id = $E['id'];
}

$Exam = $Exams->addChild('Exam');
$Exam->addAttribute('id', $id + 1);
$Exam->addAttribute('number_of_question', $number_of_question);
$Exam->addAttribute('duration', $duration);

$Exam->addChild('Exam_Name', $exam_name);

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Exams->asXML());
$savedExam = $dom->save('../xml/Exams.xml');


// Save Q_E
$Q_Es = simplexml_load_file("../xml/Question_Exams.xml");
$Q_E = $Q_Es->addChild('Question_Exam');
$Q_E->addAttribute('exam_id', $id + 1);

foreach ($question_ids as $qid) {
    $Q_E->addChild('Question_ID', $qid);
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Q_Es->asXML());
$savedQE = $dom->save('../xml/Question_Exams.xml');


if ($savedExam == FALSE || $savedQE == FALSE) {
    $result['completed'] = FALSE;
    $result['message'] = 'Exam not created. Error: Cannot save to flie.';
} else {
    $result['completed'] = TRUE;
    $result['message'] = 'Exam created successfully.';
}

echo json_encode($result);
