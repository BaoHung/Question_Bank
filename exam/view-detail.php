<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php
$examID = filter_input(INPUT_GET, 'id');
?>
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
                $('body').on('click', '.icon-trash', function () {
                    if (confirm("Do you want to delete this exam?")) {
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
        <?php
        $Exams = simplexml_load_file("../xml/Exams.xml");
        foreach ($Exams->children() as $Exam) {
            if ($Exam['id'] == $examID) {
                echo '<h1>' . $Exam->Exam_Name . '</h1>';
                break;
            }
        }
        ?>

        <!--Filter-->
        <div class="filter_style">
            <a href="add.php?id=<?= $examID ?>">
                <input type="button" value=" + Edit this exam" id="e_edit" style="background-color: #3552c7"/>
            </a>
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
                <label><?= $Exam['duration'] ?> mins</label>
            </div>
            <div>
                <label style="color: #ffffff" >Number of questions:</label>
                <label><?= $Exam['number_of_question'] ?></label>
            </div>

            <input type="button" value="Show all answers" id="show_all"/>
        </div>


        <!--Question-->
        <?php
        $Q_Es = simplexml_load_file("../xml/Question_Exams.xml");
        $matched_Q_E;
        $question_ids = array();
        foreach ($Q_Es->children() as $Q_E) {
            if ($Q_E['exam_id'] == $examID) {
                $matched_Q_E = $Q_E;
                foreach ($Q_E->Question_ID as $id) {
                    if (!isset($id['removed'])) {
                        array_push($question_ids, intval($id));
                    }
                }
                break;
            }
        }

        $Questions = simplexml_load_file("../xml/Questions.xml");
        foreach ($Questions->children() as $Question) {
            if (in_array($Question['id'], $question_ids) && !isset($Question['removed'])) {
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
