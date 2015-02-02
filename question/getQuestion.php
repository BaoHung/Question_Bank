<?php
$Questions = simplexml_load_file("../xml/Questions.xml");
$subject_id = filter_input(INPUT_GET, 'subject_id');
$query = filter_input(INPUT_GET, 'q');
$level_id = filter_input(INPUT_GET, 'level_id');
$type_id = filter_input(INPUT_GET, 'type_id');
$chapter = filter_input(INPUT_GET, 'chapter');

foreach ($Questions->children() as $Question) {
    if (
            ($query === '' || strpos(strtolower($Question->Content), strtolower($query)) !== FALSE) &&
            ($subject_id == 0 || $Question['subject_id'] == $subject_id) &&
            ($level_id == 0 || $Question['level_id'] == $level_id) &&
            ($type_id == 0 || $Question['type_id'] == $type_id) &&
            ($chapter == 0 || $Question['chapter'] == $chapter)
    ) {
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