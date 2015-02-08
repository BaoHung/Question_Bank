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
                $(".content").click(function () {
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
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>

        <!--Search Box-->
        <div class="field" id="searchform">
            <input type="text" id="search_content" placeholder="Search subject here . . ." />
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
        <div class="question">
            <div class="q_content">            
                <div class="content">1. HTML</div>
                <div class="q_tool_group">
                    <div class="q_tool"><a href=""><span class="icon-pen"></span></a></div>
                    <div class="q_tool"><a href=""><span class="icon-trash"></span></a></div>
                </div>
            </div>

            <div class="a_panel">
                <div>Subject code: HTML101</div>
                <div>Number of chapters: 8</div>
            </div>
        </div>
        <div class="question">
            <div class="q_content">            
                <div class="content">2. CSS</div>                
                <div class="q_tool_group">
                    <div class="q_tool"><a href=""><span class="icon-pen"></span></a></div>
                    <div class="q_tool"><a href=""><span class="icon-trash"></span></a></div>
                </div>
            </div>

            <div class="a_panel">
                <div>Subject code: CSS101</div>
                <div>Number of chapters: 10</div>
            </div>
        </div>
    </body>
</html>