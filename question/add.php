<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php
$questionID = filter_input(INPUT_GET, 'id');
$Questions = simplexml_load_file("../xml/Questions.xml");
$Question = NULL;
if ($questionID != "") {
    foreach ($Questions->children() as $Q) {
        if ($Q['id'] == $questionID) {
            $Question = $Q;
            break;
        }
    }
}
?>
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
            countCorrectAnswer = 0;

            $.urlParam = function (name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                else {
                    return results[1] || 0;
                }
            }

            function validated() {
                if ($('form textarea[name="content"]').val().trim().length == 0) {
                    alert("Please enter question.");
                    return false;
                }

                $('form .answers textarea[name="answer"]').each(function () {
                    if ($(this).val().trim().length == 0) {
                        alert('Answer cannot be empty.');
                        return false;
                    }
                });

                countCorrectAnswer = 0;
                $('form .answers input[type="checkbox"]').each(function () {
                    if ($(this).hasClass('checked')) {
                        countCorrectAnswer++;
                    }
                });

                if (countCorrectAnswer < 1) {
                    alert('There must be at least one correct answer.');
                    return false;
                }

                return true;
            }

            $(document).ready(function () {
                /*
                 chapterOfQuestion = 0;
                 
                 $.ajax({// Get chapter of editing question
                 url: 'getQuestion.php',
                 type: 'POST',
                 data: {
                 id: $.urlParam('id')
                 },
                 success: function (data) {
                 $.each(data, function (index, question) {
                 chapterOfQuestion = question['@attributes'].chapter;
                 });
                 }
                 });
                 
                 $.ajax({// Get chapter of subject
                 url: 'getChapter.php',
                 type: 'GET',
                 data: {subject_id: $('#SubjectList').val()},
                 success: function (data) {
                 if (chapterOfQuestion == 0) {
                 $('#ChapterList').html('<option value="" selected>None</option>');
                 } else {
                 $('#ChapterList').html('<option value="">None</option>');
                 }
                 for (i = 0; i < parseInt(data); i++) {
                 if (chapterOfQuestion == i + 1) {
                 $('#ChapterList').append('<option selected value="' + (i + 1) + '" >' + (i + 1) + '</option>');
                 } else {
                 $('#ChapterList').append('<option value="' + (i + 1) + '" >' + (i + 1) + '</option>');
                 }
                 }
                 }
                 });
                 */
                $('form .answers input[type="checkbox"]').each(function () {
                    if ($(this).attr('checked') !== undefined) {
                        $(this).addClass('checked');
                        countCorrectAnswer++;
                    }
                });

                $('#a_add').click(function () {
                    $('.answers').append('<div class="answer">' +
                            '               <textarea required class="a-textarea" placeholder="Enter answer here..." required></textarea>' +
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
                                $('#ChapterList').html('<option value="" selected>None</option>');
                                for (i = 0; i < parseInt(data); i++) {
                                    $('#ChapterList').append('<option value="' + (i + 1) + '" >' + (i + 1) + '</option>');
                                }
                            }
                        });
                    } else {
                        $('#ChapterList').html('<option value="" selected>None</option>');
                    }
                });

                $('body').on('click', 'form .answers input[type="checkbox"]', function () {
                    $(this).toggleClass('checked');
                });

                $('form').submit(function () {
                    alert($('#TypeList').val());
                });

            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">
            <?= !is_null($Question) ? 'Edit question' : 'Add new question' ?>
        </h1>
        <form class="add-form" onsubmit="return false;">
            <span>Question</span>
            <textarea name="content" class="q-textarea" placeholder="Enter question here..." required><?php
                if (!is_null($Question)) {
                    echo $Question->Content;
                }
                ?></textarea>
            <div class="filter_style">            
                Subject
                <span class="custom-dropdown">
                    <select id="SubjectList" name="subject" class="option" required>
                        <option value="">None</option>
                        <?php
                        $Subjects = simplexml_load_file("../xml/Subjects.xml");
                        $numberOfChapter = 0;
                        foreach ($Subjects->children() as $Subject) {
                            if (!is_null($Question) && strcoll($Question['subject_id'], $Subject['id']) == 0) {
                                $numberOfChapter = $Subject['number_of_chapter'];
                                ?>
                                <option selected value="<?= $Subject['id'] ?>"><?= $Subject->Subject_Name ?></option>
                                <?php
                            } else {
                                ?>
                                <option  value="<?= $Subject['id'] ?>"><?= $Subject->Subject_Name ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </span>
                Chapter
                <span class="custom-dropdown">
                    <select id="ChapterList" name="chapter" class="option" required>
                        <option value="">None</option>
                        <?php
                        for ($i = 1; $i <= $numberOfChapter; $i++) {
                            ?>
                            <option value="<?= $i ?>" <?= $i == $Question['chapter'] ? 'selected' : '' ?> ><?= $i ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </span>
                Level
                <span class="custom-dropdown">
                    <select id="LevelList" name="level" class="option" required>
                        <?php
                        $Levels = simplexml_load_file("../xml/Levels.xml");
                        foreach ($Levels->children() as $Level) {
                            if (!is_null($Question)) {
                                ?>                        
                                <option selected value="<?= $Level['id'] ?>"><?= $Level->Level_Name ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?= $Level['id'] ?>"><?= $Level->Level_Name ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </span>
                Scrambled
                <span class="custom-dropdown">
                    <select required>
                        <?php
                        if (!is_null($Question)) {
                            if ($Q['scrambled'] == 'true') {
                                ?>
                                <option selected>Yes</option>
                                <option>No</option>
                                <?php
                            } else {
                                ?>
                                <option>Yes</option>
                                <option selected>No</option>
                                <?php
                            }
                        } else {
                            ?>
                            <option>Yes</option>
                            <option>No</option>
                            <?php
                        }
                        ?>

                    </select>
                </span>
                Type
                <span class="custom-dropdown">
                    <select id="TypeList" name="type" class="option" required>
                        <option value="" selected>None</option>
                        <?php
                        $Types = simplexml_load_file("../xml/Types.xml");
                        foreach ($Types->children() as $Type) {
                            ?>
                            <option value="<?= $Type['id'] ?>" 
                                    <?= $Type['id']->__toString() == $Question['type_id'] ? 'selected' : '' ?> >
                                        <?= $Type->Type_Name ?>
                            </option>
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
                <?php
                if (!is_null($Question)) {
                    foreach ($Question->Answer as $Answer) {
                        ?>
                        <div class="answer">
                            <textarea required name="answer" class="a-textarea" placeholder="Enter answer here..." ><?= $Answer ?></textarea>
                            <div class="answer-tool" >
                                <label>
                                    <input type="checkbox"
                                           <?= $Answer['correct'] == 'true' ? 'checked' : '' ?> >Correct
                                </label>
                                <input class="a-remove" type="button" value="Remove this answer"/>
                            </div>                                
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="answer">
                        <textarea required name="answer" class="a-textarea" placeholder="Enter answer here..."  required></textarea>
                        <div class="answer-tool" >
                            <label><input type="checkbox" >Correct</label>
                            <input class="a-remove" type="button" value="Remove this answer"/>
                        </div>                                
                    </div>
                    <div class="answer">
                        <textarea required name="answer" class="a-textarea" placeholder="Enter answer here..." required></textarea>
                        <div class="answer-tool" >
                            <label><input type="checkbox" >Correct</label>
                            <input class="a-remove" type="button" value="Remove this answer"/>
                        </div>                                
                    </div>
                    <?php
                }
                ?>
            </div>
            <input style="margin-left: 47%" id="a_save" type="submit" value="Save" />
        </form>
    </body>
</html>