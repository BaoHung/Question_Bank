<?php

$subject_id = filter_input(INPUT_POST, 'subject_id');
$level_id = filter_input(INPUT_POST, 'level_id');
$type_id = filter_input(INPUT_POST, 'type_id');
$chapter = filter_input(INPUT_POST, 'chapter');
$scrambled = filter_input(INPUT_POST, 'scrambled');
$answers = json_decode(filter_input(INPUT_POST, 'answers'));
$content = filter_input(INPUT_POST, 'content');

$id = filter_input(INPUT_POST, 'id');

$result = array(
    'mode' => 'edit',
    'completed' => FALSE,
    'message' => ''
);

header('Content-Type: application/json; charset=utf-8');

$Questions = simplexml_load_file("../xml/Questions.xml");

foreach ($Questions->children() as $Q) {
    if ($id == $Q['id']) {
        $Q['level_id'] = $level_id;
        $Q['type_id'] = $type_id;
        $Q['subject_id'] = $subject_id;
        $Q['scrambled'] = $scrambled;
        $Q['chapter'] = $chapter;

        $t = "";
        $Q->Content = $content;
        while (isset($Q->Answer)) {
            foreach ($Q->Answer as $A) {
                $nodeToDelete = dom_import_simplexml($A);
                $nodeToDelete->parentNode->removeChild($nodeToDelete);
            }
        }

        foreach ($answers as $answer => $correct) {
            $Answer = $Q->addChild('Answer', $answer);
            $Answer->addAttribute('correct', $correct);
        }

        break;
    }
}

$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Questions->asXML());
if ($dom->save('../xml/Questions.xml') == FALSE) {
    $result['completed'] = FALSE;
    $result['message'] = 'Question not edited. Error: Cannot save to flie.';
} else {
    $result['completed'] = TRUE;
    $result['message'] = 'Question edited successfully.';
}


echo json_encode($result);
