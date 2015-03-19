<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
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
        <style rel="stylesheet" type="text/css">
            #paging{
                text-align: center;
                margin-bottom: 50px;
            }
            #paging a, #paging span{
                margin: 0 25px;
            }
            #paging a{
                font-weight: bold;
            }
            #paging a:hover{
                color:red;
            }
        </style>
        <script src="../js/modernizr.custom.js"></script>
        <script src="../js/jquery-1.11.2.min.js"></script>
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

                $('body').on('change', '.option', function () {
                    if ($(this).attr('id') == 'SubjectList') {
                        sendRequest(0);
                    } else {
                        sendRequest($('#ChapterList').val());
                    }
                });

                $('body').on('submit', 'form', function () {
                    sendRequest($('#ChapterList').val());
                });

                $('#Search').keyup(function () {
                    sendRequest($('#ChapterList').val());
                });

                $('body').on('click', '.icon-trash', function () {
                    if (confirm("Do you want to delete this question?")) {
                        id = $(this).attr('id');
                        $.ajax({
                            url: 'deleteToXML.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                            success: function (data) {
                                alert(data.message);
                                if (data.completed) {
                                    window.location.href = "view.php";
                                }
                            }}
                        );
                    }
                });

                function sendRequest($chapter) {
                    $.ajax({
                        url: 'getQuestion.php',
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
        <form onsubmit="return false;">
            <!--Search Box-->
            <div class="field" id="searchform">
                <input type="text" id="Search" name="search" autocomplete="off" placeholder="Search question here . . ." />
                <input type="submit" id="SearchButton" value="Search" />
            </div>

            <!--Filter-->
            <div class="filter_style">
                <a href="../question/add.php">
                    <input type="button" value=" + Add new question" id="q_add" style="background-color: #3552c7"/>
                </a>
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
            $index = 1;
            $countQuestion = 0;

            // Count questions
            foreach ($Questions->children() as $Question) {
                if (!isset($Question['removed'])) {
                    $countQuestion++;
                }
            }

// Pagination
            try {

                // Find out how many items are in the table
                $total = $countQuestion;

                // How many items to list per page
                $limit = 20;

                // How many pages will there be
                $pages = ceil($total / $limit);

                // What page are we currently on?
                $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                    'options' => array(
                        'default' => 1,
                        'min_range' => 1,
                    ),
                )));

                // Calculate the offset for the query
                $offset = ($page - 1) * $limit;

                // Some information to display to the user
                $start = $offset + 1;
                $end = min(($offset + $limit), $total);

                // Result

                foreach ($Questions->children() as $Question) {
                    if ($index >= $start && $index <= $end && !isset($Question['removed'])) {
                        ?>
                        <div class="question">
                            <div class="q_content">            
                                <div class="content"><?= $Question->Content ?></div>
                                <div class="q_tool_group">
                                    <div class="q_tool"><a href="../question/add.php?id=<?= $Question['id'] ?>"><span class="icon-pen"></span></a></div>
                                    <div class="q_tool"><a href="javascript: void(0)"><span id="<?= $Question['id'] ?>" class="icon-trash"></span></a></div>
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
                    $index++;
                }

                // The "back" link
                $prevlink = ($page > 1) ?
                        '<a href="?page=1" title="First page">First</a> '
                        . '<a href="?page=' . ($page - 1) . '" title="Previous page">Previous</a>' :
                        '<span class="disabled">First</span> <span class="disabled">Previous</span>';

                // The "forward" link
                $nextlink = ($page < $pages) ?
                        '<a href="?page=' . ($page + 1) . '" title="Next page">Next</a> '
                        . '<a href="?page=' . $pages . '" title="Last page">Last</a>' :
                        '<span class="disabled">Next</span> <span class="disabled">Last</span>';

                // Display the paging information
                echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </p></div>';
            } catch (Exception $e) {
                echo '<p>', $e->getMessage(), '</p>';
            }
            ?>
        </div>
    </body>
</html>

