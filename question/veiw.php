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
        <link rel="stylesheet" type="text/css" href="../css/menu_icon.css" />
        <script src="../js/modernizr.custom.js"></script>
        <script src="../js/jquery-1.11.2.js"></script>
        <script>
            $(document).ready(function () {

                $('body').on('click', '.content', function () {
                    $(this).parent().parent().find('.a_panel').toggleClass("a_toggle");
                });

                $('body').on('click', '#show_all', function () {
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

                $('body').on('change', '#SubjectList', function () {
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
                });

                $('body').on('change', '.option', function () {
                    sendRequest();
                });

                $('body').on('submit', 'form', function () {
                    sendRequest();
                });

                function sendRequest() {
                    $.ajax({
                        url: 'getQuestion.php',
                        type: 'POST',
                        data: {
                            subject_id: $('#SubjectList').val(),
                            level_id: $('#LevelList').val(),
                            type_id: $('#TypeList').val(),
                            chapter: $('#ChapterList').val(),
                            scrambled: $('#Scrambled').val(),
                            q: $('#Search').val()
                        },
                        success: function (data) {
                            htmlStr = '';
                            $.each(data, function (index, question) {
                                attr = question['@attributes'];
                                answerStr = '';
                                $.each(question.Answer, function (index, answer) {
                                    answerStr += '<div>' + answer + '</div>';
                                });
                                htmlStr += '<div class="question">' +
                                        '       <div class="q_content">' +
                                        '           <div class="content">' + question.Content + '</div>' +
                                        '           <div class="q_tool_group">' +
                                        '               <div class="q_tool"><a href=""><span class="icon-pen"></span></a></div>' +
                                        '               <div class="q_tool"><a href=""><span class="icon-trash"></span></a></div>' +
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
        <form onsubmit="return false;">
            <!--Search Box-->
            <div class="field" id="searchform">
                <input type="text" id="Search" name="search" placeholder="Search question here . . ." />
                <input type="submit" id="SearchButton" value="Search"></button>
            </div>

            <!--Filter-->
            <div class="filter_style">
                <input type="button" value=" + Add new question" id="q_add" style="background-color: #3552c7"/>
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
                <input type="button" value="Show all answers" id="show_all"/>
            </div>

        </form>

        <!--Question-->
        <div id="Questions">
            <?php
            $Questions = simplexml_load_file("../xml/Questions.xml");
            foreach ($Questions->children() as $Question) {
                ?>
                <div class="question">
                    <div class="q_content">            
                        <div class="content"><?= $Question->Content ?></div>
                        <div class="q_tool_group">
                            <div class="q_tool"><a href=""><span class="icon-pen"></span></a></div>
                            <div class="q_tool"><a href=""><span class="icon-trash"></span></a></div>
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
            ?>
        </div>
        <?php include '../layout/footer.php'; ?>
    </body>
</html>

