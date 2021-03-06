<?php

$subject_id = filter_input(INPUT_POST, 'subject_id');
$level_id = filter_input(INPUT_POST, 'level_id');
$type_id = filter_input(INPUT_POST, 'type_id');
$chapter = filter_input(INPUT_POST, 'chapter');
$scrambled = filter_input(INPUT_POST, 'scrambled');
$answers = json_decode(filter_input(INPUT_POST, 'answers'));
$content = filter_input(INPUT_POST, 'content');

$id = 0;

$result = array(
    'mode' => 'create',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Questions = simplexml_load_file("../xml/Questions.xml");

foreach ($Questions->children() as $Q) {
    $id = $Q['id'];
}

$Question = $Questions->addChild('Question');
$Question->addAttribute('id', $id + 1);
$Question->addAttribute('level_id', $level_id);
$Question->addAttribute('type_id', $type_id);
$Question->addAttribute('subject_id', $subject_id);
$Question->addAttribute('scrambled', $scrambled);
$Question->addAttribute('chapter', $chapter);

$Question->addChild('Content', $content);

foreach ($answers as $answer => $correct) {
    $Answer = $Question->addChild('Answer', $answer);
    $Answer->addAttribute('correct', $correct);
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Questions->asXML());
if ($dom->save('../xml/Questions.xml') == FALSE) {
    $result['completed'] = FALSE;
    $result['message'] = 'Question not created. Error: Cannot save to flie.';
} else {
    $result['completed'] = TRUE;
    $result['message'] = 'Question created successfully.';
}

echo json_encode($result);
