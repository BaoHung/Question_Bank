<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php
$exam_id = filter_input(INPUT_GET, 'id');
$Questions = simplexml_load_file("../xml/Questions.xml");
$Exams = simplexml_load_file("../xml/Exams.xml");
$Q_E = simplexml_load_file("../xml/Question_Exams.xml");
$QuestionIDs = NULL;
$subject_id = 0;
$Exam = NULL;
if ($exam_id != "") {
    foreach ($Exams->children() as $E) {
        if ($E['id'] == $exam_id) {
            $Exam = $E;
            break;
        }
    }
    $QuestionIDs = array();
    foreach ($Q_E as $pair) {
        if ($pair['exam_id'] == $exam_id) {
            foreach ($pair->Question_ID as $qid) {
                if (!isset($id['removed'])) {
                    array_push($QuestionIDs, intval($qid));
                }
            }
        }
    }

    foreach ($Questions as $Question) {
        if (in_array($Question['id'], $QuestionIDs)) {
            $subject_id = $Question['subject_id'];
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/searchbox.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <link rel="stylesheet" type="text/css" href="../css/q_view.css" />
        <link rel="stylesheet" type="text/css" href="../css/e_add.css" />
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
        <script>
            $(document).ready(function () {
                $('body').on('click', '.content', function () {
                    $(this).parent().parent().find('.a_panel').toggleClass("a_toggle");
                });

                $("#show_all").click(function () {
                    if ($(this).hasClass("clicked")) {
                        $(".a_panel").removeClass("a_toggle");
                        $(this).removeClass("clicked");
                        $(this).css("background-color", "#67A1DA");
                        $(this).val("Show all answers");
                    } else {
                        $(".a_panel").addClass("a_toggle");
                        $(this).addClass("clicked");
                        $(this).css("background-color", "#5788B8");
                        $(this).val("Hide all answers");
                    }
                });

                $('body').on('click', '.add', function () {
                    idExisted = false;
                    idToAdd = $(this).parents('.question').attr('id');
                    $('#ChosenQuestions .question').each(function () {
                        if (idToAdd == $(this).attr('id')) {
                            idExisted = true;
                        }
                    });

                    if (!idExisted) {
                        $('#ChosenQuestions').append(
                                '<div class="question" id=' + idToAdd + '>' +
                                $(this).parents('.question').html()
                                .replace('<button class="qe_btn add">Add</button>',
                                        '<button class="qe_btn remove">Remove</button>') +
                                '</div>');
                    } else {
                        alert('Question alrady exist in exam.');
                    }

                    $('#numberOfQuestion').html($('#ChosenQuestions .question').length);
                });

                $('body').on('click', '.remove', function () {
                    $(this).parents('.question').remove();
                    $('#numberOfQuestion').html($('#ChosenQuestions .question').length);
                });

                $('#SubjectList').change(function () {
                    $(this).attr('disabled', '');
                    if ($('#SubjectList').val() != 0) {
                        $.ajax({
                            url: '../question/getChapter.php',
                            type: 'GET',
                            data: {subject_id: $('#SubjectList').val()},
                            success: function (data) {
                                $('#ChapterList').html('<option value="0" selected>All</option>');
                                for (i = 0; i < parseInt(data); i++) {
                                    $('#ChapterList').append('<option value="' + (i + 1) + '" >' + (i + 1) + '</option>');
                                }
                            }
                        });
                    }
                });

                $('#Search').keyup(function () {
                    sendRequest($('#ChapterList').val());
                });

                $.urlParam = function (name) {
                    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    if (results == null) {
                        return null;
                    }
                    else {
                        return results[1] || 0;
                    }
                }

                $('body').on('submit', 'form', function () {
                    if ($('#ChosenQuestions .question').length < 1) {
                        alert('There must be at least one question in an exam.');
                    } else {
                        url = "";
                        if ($.urlParam('id') == null) {
                            url = 'addToXML.php';
                        } else {
                            url = 'editToXML.php';
                        }

                        question_ids = [];

                        $('#ChosenQuestions .question').each(function () {
                            question_ids.push($(this).attr('id'));
                        });

                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: $.urlParam('id'),
                                number_of_question: $('#ChosenQuestions .question').length,
                                duration: $('#duration').val(),
                                exam_name: $('#exam_name').val(),
                                question_ids: JSON.stringify(question_ids)
                            },
                            success: function (data) {
                                alert(data.message);
                                if (data.completed) {
                                    window.location.href = "view.php";
                                }
                            }
                        });
                    }
                });

                $('body').on('change', '.option', function () {
                    if ($(this).attr('id') == 'SubjectList') {
                        sendRequest(0);
                    } else {
                        sendRequest($('#ChapterList').val());
                    }
                });

                function sendRequest($chapter) {
                    $.ajax({
                        url: '../question/getQuestion.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            subject_id: $('#SubjectList').val(),
                            level_id: $('#LevelList').val(),
                            type_id: $('#TypeList').val(),
                            chapter: $chapter,
                            scrambled: $('#Scrambled').val(),
                            q: $('#Search').val()
                        },
                        success: function (data) {
                            htmlStr = '';
                            $.each(data, function (index, question) {
                                attr = question['@attributes'];
                                answerStr = '';
                                $.each(question.Answer, function (index, answer) {
                                    if (index == question.CorrectIndex) {
                                        answerStr += '<div><u>' + answer + '</u></div>';
                                    } else {
                                        answerStr += '<div>' + answer + '</div>';
                                    }
                                });
                                htmlStr += '<div class="question" id="' + attr.id + '">' +
                                        '       <div class="q_content">' +
                                        '           <div class="content">' + question.Content + '</div>' +
                                        '           <div class="q_tool_group">' +
                                        '              <button class="qe_btn add">Add</button>' +
                                        '           </div>' +
                                        '       </div>' +
                                        '       <div class="a_panel">' + answerStr +
                                        '       </div>' +
                                        '   </div>';
                            });
                            $("#Questions").html(htmlStr);
                        }}
                    );
                }
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <!--Left-->

        <div class="left">            
            <!--Search Box-->
            <div class="field" id="searchform">
                <input type="text" id="Search" autocomplete="off" placeholder="Search question here . . ." />
                <input type="submit" id="search_btn" value="Search" />
            </div>
            <!--Filter-->
            <div class="filter_style">
                <div style="display: block">
                    Chapter
                    <span class="custom-dropdown">
                        <select id="ChapterList" class="option">
                            <option value="" selected>All</option>
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
                </div>
                <div style="display: block">
                    Scrambled
                    <span class="custom-dropdown">
                        <select id="Scrambled" name="scrambled" class="option">
                            <option value="0" selected>All</option>
                            <option value="true">Yes</option>
                            <option value="false">No</option>
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
                <div style="display: block">
                    <input type="button" value="Show all answers" id="show_all"/>                    
                </div>
            </div>


            <!--Question-->
            <div id="Questions">
                <?php
                $Questions = simplexml_load_file("../xml/Questions.xml");
                if ($subject_id != 0) {
                    foreach ($Questions->children() as $Question) {
                        if (!isset($Question['removed'])) {
                            if ($subject_id == 0 || ($subject_id != 0 && intval($Question['subject_id']) == $subject_id)) {
                                ?>
                                <div class="question" id="<?= $Question['id'] ?>">
                                    <div class="q_content">            
                                        <div class="content"><?= $Question->Content ?></div>
                                        <div class="q_tool_group">
                                            <button class="qe_btn add">Add</button>
                                        </div>
                                    </div>
                                    <div class="a_panel">
                                        <?php
                                        foreach ($Question->Answer as $Answer) {
                                            if ($Answer['correct'] == 'true') {
                                                ?>
                                                <div><u><?= $Answer ?></u></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div><?= $Answer ?></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                }
                ?>
            </div>
        </div>


        <!--Right-->
        <div class="right">
            <!--Exam info-->
            <form onsubmit="return false;">
                <div class="e-info">
                    <div style="display: flex">
                        Exam Name <input id="exam_name" type="text" autocomplete="off" required
                                         value="<?= !is_null($Exam) ? $Exam->Exam_Name : '' ?>" />
                    </div>

                    Subject
                    <span class="custom-dropdown">
                        <select id="SubjectList" required class="option" <?= $subject_id == 0 ? '' : 'disabled' ?>>
                            <option value="" disabled selected>Choose a subject</option>
                            <?php
                            $Subjects = simplexml_load_file("../xml/Subjects.xml");
                            foreach ($Subjects->children() as $Subject) {
                                if (!isset($Subject['removed'])) {
                                    ?>
                                    <option <?= $subject_id != 0 && intval($Subject['id']) == $subject_id ? 'selected' : '' ?>
                                        value="<?= $Subject['id'] ?>">
                                            <?= $Subject->Subject_Name ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </span>
                    Time <input style="width: 6em" id="duration" type="number" min="10" max="90" required
                                value="<?= !is_null($Exam) ? $Exam['duration'] : '' ?>" /> minutes                  

                    <div style="display: flex;">
                        Number of questions: 
                        <label style="color: #ffffff;margin-left: 1em" id="numberOfQuestion">
<?= !is_null($Exam) ? $Exam['number_of_question'] : '0' ?>
                        </label>                                
                    </div>
                </div>
                <div id="ChosenQuestions">
                    <?php
                    if (!is_null($Exam)) {
                        foreach ($Questions as $Question) {
                            if (in_array($Question['id'], $QuestionIDs) && !isset($Question['removed'])) {
                                ?>
                                <div class="question" id="<?= $Question['id'] ?>">
                                    <div class="q_content">            
                                        <div class="content"><?= $Question->Content ?></div>
                                        <div class="q_tool_group">
                                            <button class="qe_btn remove">Remove</button>
                                        </div>
                                    </div>

                                    <div class="a_panel">
                                        <?php
                                        foreach ($Question->Answer as $Answer) {
                                            if ($Answer['correct'] == 'true') {
                                                ?>
                                                <div><u><?= $Answer ?></u></div>
                                                <?php
                                            } else {
                                                ?>
                                                <div><?= $Answer ?></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <input type="submit" style="margin-left: 50%" class="qe_btn" value="Save" />
            </form>
        </div>
    </body>
</html>
