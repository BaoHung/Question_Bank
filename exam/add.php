<html>
    <head>
        <title>Question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include '../layout/referances.php'; ?>
        <script>
            $(document).ready(function () {
                questionIndex = 0;
                $('#Questions button').click(function () {
                    $id = $(this).siblings('li').val();
                    $.ajax({
                        url: '../question/getQuestion.php',
                        type: 'POST',
                        data: {id: $id},
                        success: function (data) {
                            $.each(data, function (index, question) {
                                $("#AddedQuestons").append('<li value="">' + question.Content + '</li>');
                                $("#AddedQuestons").append(
                                        '<input type="hidden" name="question_id[]"' +
                                        '       value="' + question['@attributes'].id + '"/>');
                            });
                        },
                        dataType: 'json'
                    });
                });
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <ul id="Questions">
            <?php
            $question_id = filter_input(INPUT_GET, 'subject_id');
            $Questions = simplexml_load_file("../xml/Questions.xml");
            foreach ($Questions->children() as $Question) {
                if ($Question['subject_id'] == $question_id) {
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
            <form action="addExam.php" method="POST">
                <ul id="AddedQuestons"></ul>
                <input type="hidden" name="subject_id" value="<?= $question_id ?>"/>
                Duration <input type="number" name="duration" />
                Name <input type="text" name="name" />
                <input type="submit" value="Add Exam"/>
            </form>
        </div>
        <?php include '../layout/footer.php'; ?>
    </body>
</html>