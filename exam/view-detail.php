<!DOCTYPE html>
<html>
    <head>
        <title>Exam Detail</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu_icon.css" />
        <link rel="stylesheet" type="text/css" href="../css/q_view.css" />
        <script src="../js/modernizr.custom.js"></script>
        <script src="../js/jquery-1.11.2.min.js"></script>
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
                $('.icon-trash').click(function () {
                    if (confirm("Do you want to delete this question?")) {
                        // TODO
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php
        include '../layout/header.php';
        ?>

        <!--Exam Name-->
        <h1>HTML101_FUHL_SP2015_FE_143765</h1>

        <!--Filter-->
        <div class="filter_style">
            <input type="button" value=" + Edit this exam" id="e_edit" style="background-color: #3552c7"/>
            <div>
                <label style="color: #ffffff" >Subject:</label>
                <label>HTML 101</label>                
            </div>
            <!--            <div>
                            <label style="color: #ffffff" >Examination:</label>
                            <label>Final</label>
                        </div>-->
            <div>
                <label style="color: #ffffff" >Duration:</label>
                <label>60 mins</label>
            </div>
            <div>
                <label style="color: #ffffff" >Number of questions:</label>
                <label>20</label>
            </div>

            <input type="button" value="Show all answers" id="show_all"/>
        </div>


        <!--Question-->
        <?php
        $Questions = simplexml_load_file("../xml/Questions.xml");
        foreach ($Questions->children() as $Question) {
            if ($Question['subject_id'] == 1) {
                ?>
                <div class="question">
                    <div class="q_content">            
                        <div class="content"><?= $Question->Content ?></div>
                        <div class="q_tool_group">
                            <div class="q_tool"><a href="../question/add.php?id=<?= $Question['id'] ?>"><span class="icon-pen"></span></a></div>
                            <div class="q_tool"><a href="javascript: void(0)"><span class="icon-trash"></span></a></div>
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
    </body>
</html>
