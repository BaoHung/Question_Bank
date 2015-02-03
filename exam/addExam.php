<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$subject_id = filter_input(INPUT_POST, 'subject_id');
$duration = filter_input(INPUT_POST, 'duration');
$name = filter_input(INPUT_POST, 'name');
if (isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];
    $Exams = simplexml_load_file("../xml/Exams.xml");
    $examId = $Exams->count() + 1;
    $newExam = $Exams->addChild('Exam');
    $newExam->addAttribute('id', $Exams->count());
    $newExam->addAttribute('duration', $duration);
    $newExam->addAttribute('number_of_question', sizeof($question_id));
    $newExam->addChild('Exam_Name', $name);

    $Exams->asXML("../xml/Exams.xml");

    $Question_Exams = simplexml_load_file("../xml/Question_Exams.xml");
    foreach ($question_id as $qid) {
        $Question_Exam = $Question_Exams->addChild('Question_Exam');
        $Question_Exam->addAttribute('exam_id', $examId);
        $Question_Exam->addAttribute('question_id', $qid);
    }
    if ($Question_Exams->asXML("../xml/Question_Exams.xml")) {
        echo 'Exam Added';
    }
}