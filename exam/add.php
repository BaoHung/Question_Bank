<ul id="Questions">
    <?php
    $Questions = simplexml_load_file("../xml/Questions.xml");
    foreach ($Questions->children() as $Question) {
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
    ?>
</ul>