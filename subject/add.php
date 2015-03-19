<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php
$id = filter_input(INPUT_GET, 'id');
$Subjects = simplexml_load_file("../xml/Subjects.xml");
$Subject = NULL;
if ($id != "") {
    foreach ($Subjects->children() as $S) {
        if ($S['id'] == $id) {
            $Subject = $S;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add subject</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/a_add.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
        <script>
            $.urlParam = function (name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                else {
                    return results[1] || 0;
                }
            }

            $(document).ready(function () {
                $('form').submit(function () {
                    if ($('form input[name="subject_name"]').val().trim().length == 0) {
                        alert("Please enter subject name.");
                    } else if ($('form input[name="subject_code"]').val().trim().length == 0) {
                        alert("Please enter subject code.");
                    } else {
                        url = "";
                        if ($.urlParam('id') == null) {
                            url = 'addToXML.php';
                        } else {
                            url = 'editToXML.php';
                        }
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: $.urlParam('id'),
                                subject_name: $('form input[name="subject_name"]').val(),
                                subject_code: $('form input[name="subject_code"]').val(),
                                chapter: $('form input[name="chapter"]').val()
                            },
                            success: function (data) {
                                alert(data.message)
                                if (data.completed) {
                                    window.location.href = "view.php";
                                }
                            }}
                        );
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php
        include '../layout/header.php';
        ?>

        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">
            <?= !is_null($Subject) ? 'Edit subject' : 'Add new subject' ?>
        </h1>
        <form class="acc-form" onsubmit="return false;">
            <div style="text-align: center">
                <div>
                    <label>Subject name:</label>
                    <input style="margin-left: 4.1em" type="text" name="subject_name" required
                           value="<?= !is_null($Subject) ? $Subject->Subject_Name : '' ?>"/>
                </div>
                <div>
                    <label>Subject code:</label>
                    <input style="margin-left: 4.4em" type="text" name="subject_code" required
                           value="<?= !is_null($Subject) ? $Subject->Subject_Code : '' ?>"/>
                </div>
                <div>
                    <label>Number of chapters:</label>
                    <input type="number" min="1" max="30" required name="chapter"
                           value="<?= !is_null($Subject) ? $Subject['number_of_chapter'] : '' ?>"/>
                </div>
            </div>
            <input id="s_add" type="submit" value="Add" />      
        </form>
    </body>
</html>
