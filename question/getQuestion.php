<?php

header('Content-Type: application/json; charset=utf-8');

$Questions = simplexml_load_file("../xml/Questions.xml");
$question_id = filter_input(INPUT_POST, 'subject_id');
$query = filter_input(INPUT_POST, 'q');
$level_id = filter_input(INPUT_POST, 'level_id');
$type_id = filter_input(INPUT_POST, 'type_id');
$chapter = filter_input(INPUT_POST, 'chapter');
$scrambled = filter_input(INPUT_POST, 'scrambled');
$id = filter_input(INPUT_POST, 'id');

$questionsToReturn = array();

foreach ($Questions->children() as $Question) {
    if (
            (is_null($query) || strlen($query) == 0 || $query === '' || strpos(strtolower($Question->Content), strtolower($query)) !== FALSE) &&
            (is_null($question_id) || $question_id == 0 || $Question['subject_id'] == $question_id) &&
            (is_null($level_id) || $level_id == 0 || $Question['level_id'] == $level_id) &&
            (is_null($type_id) || $type_id == 0 || $Question['type_id'] == $type_id) &&
            (is_null($chapter) || $chapter == 0 || $Question['chapter'] == $chapter) &&
            (is_null($scrambled) || $scrambled == '0' || $Question['scrambled'] == $scrambled) &&
            (is_null($id) || strlen($id) == 0 || $Question['id'] == $id)
    ) {
        array_push($questionsToReturn, $Question);
    }
}
echo json_encode($questionsToReturn);
?>