<?php

header('Content-Type: application/json; charset=utf-8');

$Subjects = simplexml_load_file("../xml/Subjects.xml");
$Questions = simplexml_load_file("../xml/Questions.xml");

$query = filter_input(INPUT_POST, 'q');

$subject_id_name = array();

$countQuestionArray = array(
);

foreach ($Subjects->children() as $Subject) {
    $subject_id_name[$Subject['id'] . ''] = $Subject->Subject_Name . '';
    $countQuestionArray[$Subject->Subject_Name . ''] = 0;
}

foreach ($Questions->children() as $Question) {
    if (!isset($Question['removed'])) {
        foreach ($subject_id_name as $id => $name) {
            if ($Question['subject_id'] == $id) {
                $countQuestionArray[$name] ++;
            }
        }
    }
}

$arrayToReturn = array();

switch ($query) {
    case 'count':
        foreach ($countQuestionArray as $key => $value) {
            $arrayToReturn[] = array('label' => $key, 'y' => $value);
        }
        break;

    case 'percentage':
        foreach ($countQuestionArray as $key => $value) {
            $arrayToReturn[] = array('label' => $key, 'y' => number_format($value * 100 / $Questions->count(), 2, '.', ','), 'legendText' => $key);
        }
        break;

    default:
        break;
}


echo json_encode($arrayToReturn);
