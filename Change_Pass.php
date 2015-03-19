<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add question</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="css/home.css" />
        <link rel="stylesheet" type="text/css" href="css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="css/a_add.css" />
        <link rel="stylesheet" type="text/css" href="css/filter.css" />
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/modernizr.custom.js"></script>
        <script src="js/jquery.md5.js"></script>
        <script>
            $(document).ready(function () {
                $('form').submit(function () {
                    if ($('#new').val() != $('#confirm').val()) {
                        alert('Please confirm your passwrod');
                    } else if ($('#new').val().trim().length < 8) {
                        alert('Password must contain at least 8 characters.');
                    } else {
                        $.ajax({
                            url: 'authentication/login.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                username: $('#email').val(),
                                password: $.md5($('#old').val())
                            },
                            success: function (authenticated) {
                                if (authenticated) {
                                    $.ajax({
                                        url: 'account/changePassword.php',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            id: $('#id').val(),
                                            password: $.md5($('#new').val())
                                        },
                                        success: function (data) {
                                            alert(data.message)
                                            if (data.completed) {
                                                window.location.href = "authentication/logout.php";
                                            }
                                        }}
                                    );
                                } else {
                                    alert("Wrong password");
                                }
                            }}
                        );
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php include 'layout/header.php'; ?>
        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">Change Your Password</h1>
        <form class="acc-form" onsubmit="return false;">
            <input id="email" type="hidden" value="<?= $UserAccount->Email ?>"/>
            <input id="id" type="hidden" value="<?= $UserAccount['id'] ?>"/>
            <div>
                <div>
                    <label>Old Password:</label>
                    <input style="margin-left: 4.9em" type="password" id="old" required />
                </div>
                <div>
                    <label>New Password:</label>
                    <input style="margin-left: 4.6em" type="password" id="new" required/>
                </div>
                <div>
                    <label>Retype New Password:</label>
                    <input type="password" required id="confirm"/>
                </div>
            </div>
            <input id="cp_save" type="submit" value="Save" />      
        </form>
    </body>
</html>
