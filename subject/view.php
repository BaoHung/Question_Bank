<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Subject</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <link rel="stylesheet" type="text/css" href="../css/searchbox.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu_icon.css" />
        <link rel="stylesheet" type="text/css" href="../css/q_view.css" />
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
                        $(this).val("Show all subject detail");
                    } else {
                        $(".a_panel").addClass("a_toggle");
                        $(this).addClass("clicked");
                        $(this).css("background-color", "#5788B8");
                        $(this).val("Hide all subject detail");
                    }
                });
                $('body').on('click', '.icon-trash', function () {
                    if (confirm("Do you want to delete this subject?")) {
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

                $('#search_content').keyup(function () {
                    $.ajax({
                        url: 'getSubject.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            q: $('#search_content').val(),
                        },
                        success: function (data) {
                            htmlStr = '';
                            $.each(data, function (index, subject) {
                                attr = subject['@attributes'];
                                htmlStr += '<div class="question">' +
                                        '<div class="q_content">' +
                                        '<div class="content">' + subject.Subject_Name + '</div>' +
                                        '<div class="q_tool_group">' +
                                        '<div class="q_tool"><a href="add.php?id=' + attr.id + '"><span class="icon-pen"></span></a></div>' +
                                        '<div class="q_tool"><a href="javascript: void(0)"><span class="icon-trash"></span></a></div>' +
                                        '</div>' +
                                        '</div>' +
                                        '<div class="a_panel">' +
                                        '<div>Subject code: ' + subject.Subject_Code + '</div>' +
                                        '<div>Number of chapters: ' + attr.number_of_chapter + '</div>' +
                                        '</div>' +
                                        '</div>';
                            });
                            $("#Subjects").html(htmlStr);
                        }}
                    );
                });
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>

        <!--Search Box-->
        <div class="field" id="searchform">
            <input type="text" id="search_content" autocomplete="off" placeholder="Search subject here . . ." />
            <input type="submit" id="search_btn" value="Search">
        </div>
        <!--Filter-->
        <div class="filter_style">
            <a href="add.php">
                <input type="button" value="+ Add new subject" id="a_add" style="background-color: #3552c7"/>
            </a>
            <input type="button" value="Show all subject detail" id="show_all"/>
        </div>

        <!--Question-->
        <div id="Subjects">
            <?php
            $Subjects = simplexml_load_file("../xml/Subjects.xml");
            foreach ($Subjects->children() as $Subject) {
                if (!isset($Subject['removed'])) {
                    ?>
                    <div class="question">
                        <div class="q_content">            
                            <div class="content"><?= $Subject->Subject_Name ?></div>
                            <div class="q_tool_group">
                                <div class="q_tool"><a href="add.php?id=<?= $Subject['id'] ?>"><span class="icon-pen"></span></a></div>
                                <div class="q_tool"><a href="javascript: void(0)"><span class="icon-trash" id="<?= $Subject['id'] ?>"></span></a></div>
                            </div>
                        </div>

                        <div class="a_panel">
                            <div>Subject code: <?= $Subject->Subject_Code ?></div>
                            <div>Number of chapters: <?= $Subject['number_of_chapter'] ?></div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </body>
</html>
