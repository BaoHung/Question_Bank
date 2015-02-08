<!DOCTYPE html>
<html>
    <head>
        <title>Add question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/q_add.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <script src="../js/modernizr.custom.js"></script>
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#a_add').click(function () {
                    $('.answers').append('<div class="answer">' +
                            '               <textarea class="a-textarea" placeholder="Enter answer here..." ></textarea>' +
                            '               <div class="answer-tool" >' +
                            '                   <label><input type="checkbox" >Correct</label>' +
                            '                   <input class="a-remove" type="button" value="Remove this answer"/>' +
                            '               </div>' +
                            '           </div>');
                });
                $('body').on('click', '.a-remove', function () {
                    if ($('.answer').length > 2)
                        $(this).parents('.answer').remove();
                    else {
                        alert('A question must have at least two answers!');
                    }
                });
                $('body').on('change', '#SubjectList', function () {
                    if ($('#SubjectList').val() != 0) {
                        $.ajax({
                            url: 'getChapter.php',
                            type: 'GET',
                            data: {subject_id: $('#SubjectList').val()},
                            success: function (data) {
                                $('#ChapterList').html('<option value="0" selected>All</option>');
                                for (i = 0; i < parseInt(data); i++) {
                                    $('#ChapterList').append('<option value="' + (i + 1) + '" >' + (i + 1) + '</option>');
                                }
                            }
                        });
                    } else {
                        $('#ChapterList').html('<option value="0" selected>All</option>');
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">Add new question</h1>
        <form class="add-form">
            <span>Question</span>
            <textarea class="q-textarea" placeholder="Enter question here..."></textarea>
            <div class="filter_style">            
                Subject
                <span class="custom-dropdown">
                    <select id="SubjectList" name="subject" class="option">
                        <option value="0" selected>All</option>
                        <?php
                        $Subjects = simplexml_load_file("../xml/Subjects.xml");
                        foreach ($Subjects->children() as $Subject) {
                            ?>
                            <option value="<?= $Subject['id'] ?>"><?= $Subject->Subject_Name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </span>
                Chapter
                <span class="custom-dropdown">
                    <select id="ChapterList" name="chapter" class="option">
                        <option value="0" selected>All</option>
                    </select>
                </span>
                Level
                <span class="custom-dropdown">
                    <select id="LevelList" name="level" class="option">
                        <option value="0" selected>All</option>
                        <?php
                        $Levels = simplexml_load_file("../xml/Levels.xml");
                        foreach ($Levels->children() as $Level) {
                            ?>
                            <option value="<?= $Level['id'] ?>"><?= $Level->Level_Name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </span>
                Scrambled
                <span class="custom-dropdown">
                    <select>
                        <option selected>All</option>
                        <option>Yes</option>
                        <option>No</option>
                    </select>
                </span>
                Type
                <span class="custom-dropdown">
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
                </span>
            </div>
            <input id="a_add" type="button" value="Add answer" />

            <!--Answers-->
            <div class="answers">
                <span>Answers</span>
                <div class="answer">
                    <textarea class="a-textarea" placeholder="Enter answer here..." ></textarea>
                    <div class="answer-tool" >
                        <label><input type="checkbox" >Correct</label>
                        <input class="a-remove" type="button" value="Remove this answer"/>
                    </div>                                
                </div>
                <div class="answer">
                    <textarea class="a-textarea" placeholder="Enter answer here..." ></textarea>
                    <div class="answer-tool" >
                        <label><input type="checkbox" >Correct</label>
                        <input class="a-remove" type="button" value="Remove this answer"/>
                    </div>                                
                </div>
            </div>

        </form>
    </body>
</html>