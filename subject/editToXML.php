<?php

$name = filter_input(INPUT_POST, 'subject_name');
$code = filter_input(INPUT_POST, 'subject_code');
$chapter = filter_input(INPUT_POST, 'chapter');
$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'edit',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Subjects = simplexml_load_file("../xml/Subjects.xml");

foreach ($Subjects->children() as $S) {
    if ($id == $S['id']) {
        $S['number_of_chapter'] = $chapter;
        $S->Subject_Name = $name;
        $S->Subject_Code = $code;
        break;
    }
}

$result['completed'] = $Subjects->asXML("../xml/Subjects.xml");;
$result['message'] = 'Subject edited successfully';

echo json_encode($result);
