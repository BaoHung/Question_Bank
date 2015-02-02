<form action="add.php" method="get">
    <select id="SubjectList" name="subject_id" class="option">
        <?php
        $Subjects = simplexml_load_file("../xml/Subjects.xml");
        foreach ($Subjects->children() as $Subject) {
            ?>
            <option value="<?= $Subject['id'] ?>"><?= $Subject->Subject_Name ?></option>
            <?php
        }
        ?>
    </select>
    <input type="submit" value="Add an exam"/>
</form>