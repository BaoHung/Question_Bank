<html>
    <head>
        <title>Question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-1.11.2.js"></script>
        <script>
            $(document).ready(function () {
                $('#Questions button').click(function () {
                    $id = $(this).siblings('li').val();
                    $.get("../question/getQuestion.php", {
                        id: $id
                    }, function (data) {
                        $("#AddedQuestons").append(data);
                    }, "html");
                });
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <ul id="Questions">
            <?php
            $subject_id = filter_input(INPUT_GET, 'subject_id');
            $Questions = simplexml_load_file("../xml/Questions.xml");
            foreach ($Questions->children() as $Question) {
                if ($Question['subject_id'] == $subject_id) {
                    ?>
                    <div>
                        <li value="<?= $Question['id'] ?>"><?= $Question->Content ?></li>
                        <button>Add</button>
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
                    </div>
                    <?php
                }
            }
            ?>
        </ul>

        <div>
            ADDED QUESTIONS
            <ul id="AddedQuestons"></ul>
        </div>
        <?php include '../layout/footer.php'; ?>
    </body>
</html>