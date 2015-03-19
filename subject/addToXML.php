<?php

$name = filter_input(INPUT_POST, 'subject_name');
$code = filter_input(INPUT_POST, 'subject_code');
$chapter = filter_input(INPUT_POST, 'chapter');

$result = array(
    'mode' => 'create',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Subjects = simplexml_load_file("../xml/Subjects.xml");

foreach ($Subjects->children() as $S) {
    $id = $S['id'];
    if ($S->Subject_Code == $code) {
        $result['completed'] = FALSE;
        $result['message'] = 'Subject not created. Eror: Subject code already exists.';
        echo json_encode($result);
        return;
    } else if ($S->Subject_Name == $name) {
        $result['completed'] = FALSE;
        $result['message'] = 'Subject not created. Eror: Subject name already exists.';
        echo json_encode($result);
        return;
    }
}

$Account = $Subjects->addChild('Subject');
$Account->addAttribute('id', $id + 1);
$Account->addAttribute('number_of_chapter', $chapter);
$Account->addChild('Subject_Name', $name);
$Account->addChild('Subject_Code', $code);

$result['completed'] = $Subjects->asXML("../xml/Subjects.xml");;
$result['message'] = 'Subject created successfully.';

echo json_encode($result);
