<?php
session_start();

$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
// this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}

// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 300;

if (isset($_SESSION["accountID"]) && (!empty($_SESSION["accountID"]) || $_SESSION["accountID"] == 0 )) {
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    $Accounts = simplexml_load_file("$root/xml/Accounts.xml");
    $UserAccount = NULL;
    $id = $_SESSION["accountID"];
    foreach ($Accounts->children() as $A) {
        if ($A['id'] == $id) {
            $UserAccount = $A;
            header('Location: /');
            break;
        }
    }
}
?>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/login.css" />
        <link rel="stylesheet" type="text/css" href="css/login_form.css" />
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/jquery.md5.js"></script>
        <script>
            $(document).ready(function () {
                $('#login form').submit(function () {
                    $.ajax({
                        url: 'authentication/login.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            username: $('#username').val(),
                            password: $.md5($('#password').val())
                        },
                        success: function (authenticated) {
                            if (authenticated) {
                                window.location.href = "/index.php";
                            } else {
                                alert("Wrong email and password");
                            }
                        }}
                    );
                });
            });
        </script>
    </head>
    <body id="page">
        <ul class="cb-slideshow">
            <li><span>Image 01</span><div></div></li>
            <li><span>Image 02</span><div></div></li>
            <li><span>Image 03</span><div></div></li>
            <li><span>Image 04</span><div></div></li>
            <li><span>Image 05</span><div></div></li>
            <li><span>Image 06</span><div></div></li>
        </ul>

        <div class="container">
            <!-- Codrops top bar -->
            <section>				
                <div id="container_demo" >
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form onsubmit="return false;" action="index.php" autocomplete="on" method="POST"> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="e" > Your email</label>
                                    <input id="username" name="username" autocomplete="off" required type="text" placeholder="mymail@fpt.edu.vn"/>
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" autocomplete="off" required type="password" placeholder="Pay attention to CAPSLOCK" /> 
                                </p>
                                <p class="login button"> 
                                    <input type="submit" value="Login" /> 
                                </p>                                
                            </form>
                        </div>                        
                    </div>
                </div>  
            </section>
        </div>
    </body>
</html>
