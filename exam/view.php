<!DOCTYPE html>
<html>
    <head>
        <title>Exam</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu_icon.css" />
        <link rel="stylesheet" type="text/css" href="../css/e_view.css" />
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
        <script language="JavaScript">
            $(document).ready(function () {
                $('.icon-trash').click(function () {
                    if (confirm("Do you want to delete this question?")) {
                        // TODO
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>

        <!--Exams-->
        <h1>Exams</h1>
        <!--Filter-->
        <div class="filter_style">
            <a href="add.php">
                <input type="button" value=" + Add new exam" id="e_add" style="background-color: #3552c7"/>
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
            <!--            Examination
                        <span class="custom-dropdown">
                            <select>
                                <option selected>All</option>
                                <option>Progress</option>
                                <option>MidTerm</option>  
                                <option>Final</option>                    
                            </select>
                        </span>            -->
        </div>


        <!--Question-->       
        <?php
        $Exams = simplexml_load_file("../xml/Exams.xml");
        foreach ($Exams->children() as $Exam) {
            ?>
            <div class="exam">
                <div class="e_content">            
                    <div class="content"><?= $Exam->Exam_Name ?></div>
                    <div class="e_tool_group">
                        <a href="add.php?id=<?= $Exam['id'] ?>"><div class="e_tool"><span class="icon-pen"></span></div></a>
                        <a href="javascript: void(0)"><div class="e_tool"><span class="icon-trash"></span></div></a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </body>

</html>
