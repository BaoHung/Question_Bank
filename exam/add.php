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
                array_push($QuestionIDs, intval($qid));
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
                $(".content").click(function () {
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

//                    $('#numberOfQuestion').html(($('#numberOfQuestion').html().trim() + 1));
                });

                $('body').on('click', '.remove', function () {
                    $(this).parents('.question').remove();
                    $('#numberOfQuestion').html(($('#numberOfQuestion').html().trim() - 1));
                });

                $('#search_content').keyup(function () {
//                    sendRequest($('#ChapterList').val());
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
                                htmlStr += '<div class="question">' +
                                        '       <div class="q_content">' +
                                        '           <div class="content">' + question.Content + '</div>' +
                                        '           <div class="q_tool_group">' +
                                        '               <div class="q_tool"><a href="../question/add.php?id=' + attr.id + '"><span class="icon-pen"></span></a></div>' +
                                        '               <div class="q_tool"><a href="javascript: void(0)"><span class="icon-trash"></span></a></div>' +
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
                <input type="text" id="search_content" autocomplete="off" placeholder="Search question here . . ." />
                <input type="submit" id="search_btn" value="Search" />
            </div>
            <!--Filter-->
            <div class="filter_style">
                <div style="display: block">
                    Chapter
                    <span class="custom-dropdown">
                        <select>
                            <option selected>All</option>
                            <option>1</option>
                            <option>2</option>  
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </span>
                    Level
                    <span class="custom-dropdown">
                        <select>
                            <option selected>All</option>
                            <option>Easy</option>
                            <option>Medium</option>  
                            <option>Hard</option>
                        </select>
                    </span>                    
                </div>
                <div style="display: block">
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
                        <select>
                            <option selected>All</option>
                            <option>Single choice</option>
                            <option>Multiple choice</option>
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
                foreach ($Questions->children() as $Question) {
                    if ($subject_id == 0 || ($subject_id != 0 && intval($Question['subject_id']) == $subject_id)) {
                        ?>
                        <div class="question">
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
                ?>
            </div>
        </div>


        <!--Right-->
        <div class="right">
            <!--Exam info-->
            <div class="e-info">
                <div style="display: flex">
                    Exam Name <input type="text" autocomplete="off" 
                                     value="<?= !is_null($Exam) ? $Exam->Exam_Name : '' ?>" />
                </div>

                Subject
                <span class="custom-dropdown">
                    <select>
                        <?php
                        $Subjects = simplexml_load_file("../xml/Subjects.xml");
                        foreach ($Subjects->children() as $Subject) {
                            ?>
                            <option <?= $subject_id != 0 && intval($Subject['id']) == $subject_id ? 'selected' : '' ?>
                                value="<?= $Subject['id'] ?>">
                                    <?= $Subject->Subject_Name ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </span>
                Time <input style="width: 6em" type="text" 
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
                        if (in_array($Question['id'], $QuestionIDs)) {
                            ?>
                            <div class="question">
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
            <a href="view.php">
                <button style="margin-left: 50%" class="qe_btn">Save</button>
            </a>
        </div>
    </body>
</html>
