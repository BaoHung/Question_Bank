<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
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
        $result['message'] = 'Subject not created. Error: Subject code already exists.';
        echo json_encode($result);
        return;
    } else if (RemoveSign($S->Subject_Name) == RemoveSign($name)) {
        $result['completed'] = FALSE;
        $result['message'] = 'Subject not created. Error: Subject name already exists.';
        echo json_encode($result);
        return;
    }
}

$Subject = $Subjects->addChild('Subject');
$Subject->addAttribute('id', $id + 1);
$Subject->addAttribute('number_of_chapter', $chapter);
$Subject->addChild('Subject_Name', $name);
$Subject->addChild('Subject_Code', $code);


$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($Subjects->asXML());
if ($dom->save('../xml/Subjects.xml') == FALSE) {
    $result['completed'] = FALSE;
    $result['message'] = 'Subject not created. Error: Cannot save to flie.';
} else {
    $result['completed'] = TRUE;
    $result['message'] = 'Subject created successfully.';
}

echo json_encode($result);
