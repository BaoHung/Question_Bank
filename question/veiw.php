<html>
    <head>
        <title>Question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-1.11.2.js"></script>
        <script>
            $(document).ready(function () {

                $('.option').change(function () {
                    sendRequest();
                });

                $('#SubjectList').change(function () {
                    $.get("getChapter.php", {
                        subject_id: $('#SubjectList').val()
                    }, function (data) {
                        $('#ChapterList').html('<option value="0" selected>All</option>');
                        for (i = 0; i < parseInt(data); i++) {
                            $('#ChapterList').append('<option value="' + (i + 1) + '" >' + (i + 1) + '</option>');
                        }
                    }, "html");
                });

                $('form').submit(function () {
                    sendRequest();
                });

                function sendRequest() {
                    $.get("getQuestion.php", {
                        subject_id: $('#SubjectList').val(),
                        level_id: $('#LevelList').val(),
                        type_id: $('#TypeList').val(),
                        chapter: $('#ChapterList').val(),
                        q: $('#Search').val()
                    }, function (data) {
                        htmlStr = '';
                        $.each(data, function (index, item) {
                            attr = item['@attributes'];
                            htmlStr += '<li value="' + attr.id + '">' + item.Content + '</li>'
                                    + '<ul>'
                                    + ''
                                    + '</ul>';
                        });
                        $("#Questions").html(htmlStr);
                    }, "json");
                }
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <h1>Question</h1>
        <form onsubmit="return false;">
            <span>Select a subject</span>
            <select id="SubjectList" name="subject" class="option">
                <option value="0" selected="">All</option>
                <?php
                $Subjects = simplexml_load_file("../xml/Subjects.xml");
                foreach ($Subjects->children() as $Subject) {
                    ?>
                    <option value="<?= $Subject['id'] ?>"><?= $Subject->Subject_Name ?></option>
                    <?php
                }
                ?>
            </select>

            <span>Select a chapter</span>
            <select id="ChapterList" name="chapter" class="option">
                <option value="0" selected="">All</option>
            </select>

            <span>Select a level</span>
            <select id="LevelList" name="level" class="option">
                <option value="0" selected="">All</option>
                <?php
                $Levels = simplexml_load_file("../xml/Levels.xml");
                foreach ($Levels->children() as $Level) {
                    ?>
                    <option value="<?= $Level['id'] ?>"><?= $Level->Level_Name ?></option>
                    <?php
                }
                ?>
            </select>

            <span>Select a type</span>
            <select id="TypeList" name="type" class="option">
                <option value="0" selected>All</option>
                <?php
                $Types = simplexml_load_file("../xml/Types.xml");
                foreach ($Types->children() as $Type) {
                    ?>
                    <option value="<?= $Type['id'] ?>"><?= $Type->Type_Name ?></option>
                    <?php
                }
                ?>
            </select>

            <br/>
            <input id="Search" type="text" name="search" placeholder="Search a question"/>
            <input id="SearchButton" type="submit" value="Search"></button>
        </form>

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
        <?php include '../layout/footer.php'; ?>
    </body>
</html>

