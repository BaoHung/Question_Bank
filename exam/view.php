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
        <script src="../js/modernizr.custom.js"></script>

    </head>
    <body>
        <?php include '../layout/header.php'; ?>

        <!--Exams-->
        <h1>Exams</h1>
        <!--Filter-->
        <div class="filter_style">
            <input type="button" value=" + Add new exam" id="e_add" style="background-color: #3552c7"/>
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
        <div class="exam">
            <div class="e_content">            
                <div class="content">1. HTML101_FUHL_SP2015_FE_143765</div>
                <div class="e_tool_group">
                    <div class="e_tool"><a href=""><span class="icon-pen"></span></a></div>
                    <div class="e_tool"><a href=""><span class="icon-trash"></span></a></div>
                </div>

            </div>
        </div>
        <div class="exam">
            <div class="e_content">            
                <div class="content">2. CSS_PT1_Renew15_7345623251</div>
                <div class="e_tool_group">
                    <div class="e_tool"><a href=""><span class="icon-pen"></span></a></div>
                    <div class="e_tool"><a href=""><span class="icon-trash"></span></a></div>
                </div>

            </div>
        </div>
        <div class="exam">
            <div class="e_content">            
                <div class="content">3. HTML101_FUHL_QUIZ1_2_152436</div>
                <div class="e_tool_group">
                    <div class="e_tool"><a href=""><span class="icon-pen"></span></a></div>
                    <div class="e_tool"><a href=""><span class="icon-trash"></span></a></div>
                </div>

            </div>
        </div>

    </body>

</html>
