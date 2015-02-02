<html>
    <head>
        <title>Question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-1.11.2.js"></script>
        <script>
            $(document).ready(function () {
                GETparams = new Object();

                $('#SubjectList').change(function () {
                    sendRequest();
                });

                $('#SearchButton').click(function () {
                    sendRequest();
                });
                
                function sendRequest() {

                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {  // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            $("#Questions").html(xmlhttp.responseText);
                        }
                    }
                    xmlhttp.open("GET", "getQuestion.php?subject_id=" + encodeURIComponent($('#SubjectList').val())
                            + '&q=' + encodeURIComponent($('#Search').val()), true);
                    xmlhttp.send();
                    //abc
                }
            });
        </script>
    </head>
    <body>
        <?php include '../layout/header.php'; ?>
        <h1>Question</h1>
        <span>Select a subject</span>
        <select id="SubjectList" name="subject">
            <option value="0" selected="">All</option>
            <?php
            $Subjects = simplexml_load_file("../xml/Subjects.xml");
            foreach ($Subjects->children() as $Subject) {
                ?>
                <option value="<?= $Subject['id'] ?>"><?= $Subject->Subject_Name ?></option>
                <?php
            }
            ?>
        </select>
        <br/>
        <input id="Search" type="text" name="search" placeholder="Search a question"/>
        <button id="SearchButton">Search</button>

        <ul id="Questions">
            <?php
            $Questions = simplexml_load_file("../xml/Questions.xml");
            foreach ($Questions->children() as $Question) {
                ?>
                <li value="<?= $Question['id'] ?>"><?= $Question->Content ?></li>
                <ul>
                    <?php
                    foreach ($Question->Answer as $Answer) {
                        if ($Answer['correct'] == 'true') {
                            ?>
                            <li style="font-weight: bold"><?= $Answer ?></li>
                                <?php
                            } else {
                                ?>
                            <li><?= $Answer ?></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </ul>
        <?php include '../layout/footer.php'; ?>
    </body>
</html>

