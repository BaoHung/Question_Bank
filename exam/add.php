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
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <!--Left-->

        <div class="left">            
            <!--Search Box-->
            <div class="field" id="searchform">
                <input type="text" id="search_content" placeholder="Search question here . . ." />
                <input type="submit" id="search_btn" value="Search" />
            </div>
            <!--Filter-->
            <div class="filter_style">
                <div style="display: block">
                    Chapter
                    <span class="custom-dropdown">
                        <select>
                            <option>All</option>
                            <option>1</option>
                            <option selected>2</option>  
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
            <?php
            $Questions = simplexml_load_file("../xml/Questions.xml");
            foreach ($Questions->children() as $Question) {
                ?>
                <div class="question">
                    <div class="q_content">            
                        <div class="content"><?= $Question->Content ?></div>
                        <div class="q_tool_group">
                            <button class="qe_btn">Add</button>
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


        <!--Right-->
        <div class="right">
            <!--Exam info-->
            <div class="e-info">
                <div style="display: flex">
                    Exam Name <input type="text" />
                </div>

                Subject
                <span class="custom-dropdown">
                    <select>
                        <option selected>All</option>
                        <option>HTML101</option>
                        <option>CSS101</option>
                        <option>PHP101</option>
                    </select>
                </span>
                Time <input style="width: 6em" type="text" /> mins                  

                <div style="display: flex;">
                    Number of questions:<label style="color: #ffffff;margin-left: 1em" >20</label>                                
                </div>
            </div>
            <div class="question">
                <div class="q_content">            
                    <div class="content">What does XML stand for?</div>
                    <div class="q_tool_group">
                        <button class="qe_btn">Remove</button>
                    </div>
                </div>

                <div class="a_panel">
                    <div>X-Markup Language</div>
                    <div><u>eXtensible Markup Language</u></div>
                    <div>Example Markup Language</div>
                    <div>eXtra Modern Link</div>
                </div>
            </div>
            <div class="question">
                <div class="q_content">            
                    <div class="content">There is a way of describing XML data, how?</div>
                    <div class="q_tool_group">
                        <button class="qe_btn">Remove</button>
                    </div>
                </div>

                <div class="a_panel">
                    <div>XML uses a description node to describe data</div>
                    <div><u>XML uses a DTD to describe the data</u></div>
                    <div>XML uses XSL to describe data</div>
                </div>
            </div>
            <a href="view.php">
                <button style="margin-left: 50%" class="qe_btn">Save</button>
            </a>
        </div>
    </body>
</html>
