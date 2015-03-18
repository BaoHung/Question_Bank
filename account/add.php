<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<?php
$id = filter_input(INPUT_GET, 'id');
$Accounts = simplexml_load_file("../xml/Accounts.xml");
$Account = NULL;
if ($id != "") {
    foreach ($Accounts->children() as $A) {
        if ($A['id'] == $id) {
            $Account = $A;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Add account</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home_component.css" />
        <link rel="stylesheet" type="text/css" href="../css/home.css" />
        <link rel="stylesheet" type="text/css" href="../css/tooltip.css" />
        <link rel="stylesheet" type="text/css" href="../css/a_add.css" />
        <link rel="stylesheet" type="text/css" href="../css/filter.css" />
        <script src="../js/jquery-1.11.2.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
        <script src="../js/jquery.md5.js"></script>

        <script>
            function validateEmail($email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test($email);
            }
            $(document).ready(function () {
                $('form').submit(function () {
                    if (!validateEmail($('form input[name="email"]').val())) {
                        alert("Please enter your email.");
                    } else if ($('form input[name="email"]').val().split('@').slice(1) != 'fpt.edu.vn') {
                        alert("ok");
                    } else if ($('form input[name="password"]').val().length < 8) {
                        alert("Password must contain at least 8 characters.");
                    } else if ($('form input[name="password"]').val() != $('form input[name="confirm_password"]').val()) {
                        alert("Password confirmation does not match.");
                    } else {
                        $.ajax({
                            url: 'addToXML.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                email: $('form input[name="email"]').val(),
                                password: $.md5($('form input[name="password"]').val()),
                                fullname: $('form input[name="fullname"]').val(),
                                role: $('form select[name="role"]').val()
                            },
                            success: function (data) {
                                if (data.added) {
                                    alert('Account created successfully');
                                } else {
                                    alert('Account not created.\r\n' + data.message);
                                }
                            }}
                        );
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php include'../layout/header.php'; ?>

        <!--Add Question-->
        <h1 style="text-align: center;font-weight: 300;">
            <?= !is_null($Account) ? 'Edit account' : 'Create new account' ?>
        </h1>
        <form class="acc-form" action="addToXML.php" method="POST" onsubmit="return false;">
            <div>
                <div>
                    <label>Email:</label>
                    <input style="margin-left: 2.8em" type="text" name="email" required
                           value="<?= !is_null($Account) ? $Account->Email : '' ?>"/>
                </div>
                <div>
                    <label>Full name:</label>
                    <input style="margin-left: 0.8em" type="text" name="fullname" required
                           value="<?= !is_null($Account) ? $Account->FullName : '' ?>"/>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" required />
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="confirm_password" required />
                </div>
                <label>Role:</label>
                <span style="margin-left: 3em" class="custom-dropdown">
                    <select name="role" style="padding: 0.3em 2em 0.1em 0.1em">
                        <?php
                        if (!is_null($Account)) {
                            if ($Account['role'] == 0) {
                                ?>  
                                <option selected value="0">Administrator</option>
                                <option value="1">Lecturer</option>  
                                <?php
                            } else {
                                ?>  
                                <option value="0">Administrator</option>
                                <option selected value="1">Lecturer</option>  
                                <?php
                            }
                        } else {
                            ?>  
                            <option value="0">Administrator</option>
                            <option value="1">Lecturer</option>  
                            <?php
                        }
                        ?>
                    </select>
                </span>
            </div>
            <input id="acc_save" type="submit" value="Create" />      
        </form>
    </body>
</html>
