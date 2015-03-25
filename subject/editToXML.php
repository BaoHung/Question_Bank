<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
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
$allSubjectNames = array();

foreach ($Subjects->children() as $S) {
    array_push($allSubjectNames, (string) $S->Subject_Name);
    
    var_dump(in_array(RemoveSign($name), $allSubjectNames));

    if ($id == $S['id']) {
        if (in_array(RemoveSign($name), $allSubjectNames)) {
            $S['number_of_chapter'] = $chapter;
            $S->Subject_Name = $name;
            $S->Subject_Code = $code;
            break;
        } else {
            $result['completed'] = FALSE;
            $result['message'] = 'Subject not created. Error: Subject name already exists.';
        }
    }
}
die('ok');

$result['completed'] = $Subjects->asXML("../xml/Subjects.xml");
$result['message'] = 'Subject edited successfully';

echo json_encode($result);
