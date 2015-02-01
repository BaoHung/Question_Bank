<?php
$Questions = simplexml_load_file("../xml/Questions.xml");
$subject_id = $_GET['subject_id'];
$query = $_GET['q'];
if ($subject_id != 0) {
    $path = '//Questions/Question[@subject_id="' . $subject_id . '"]';
} else {
    $path = '//Questions/Question';
}
foreach ($Questions->xpath($path) as $Question) {
    if ($query === '' || strpos(strtolower($Question->Content), strtolower($query)) !== FALSE) {
        ?>
        <li value="<?= $Question['id'] ?>"><?= $Question->Content ?></li>
        <ul>
            <?php
            foreach ($Question->Answer as $Answer) {
                if ($Answer['correct'] == 'true') {
                    ?>
                    <li style="font-weight: bold"><?= $Answer ?></li>
                        <?php
                    } else {
                        ?>
                    <li><?= $Answer ?></li>
                    <?php
                }
            }
            ?>
        </ul>
        <?php
    }
}
?>