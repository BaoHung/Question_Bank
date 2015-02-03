<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$subject_id = filter_input(INPUT_POST, 'subject_id');
if (isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];
    $Exmas = simplexml_load_file("../xml/Exams.xml");
    var_dump($Exmas);
    foreach ($question_id as $qid) {
        echo $qid;
    }
}