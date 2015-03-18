<?php include $_SERVER["DOCUMENT_ROOT"] . '/session.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Account</title>
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
                $('body').on('click', '.content', function () {
                    $(this).parent().parent().find('.a_panel').toggleClass("a_toggle");
                });

                $("#show_all").click(function () {
                    if ($(this).hasClass("clicked")) {
                        $(".a_panel").removeClass("a_toggle");
                        $(this).removeClass("clicked");
                        $(this).css("background-color", "#67A1DA");
                        $(this).val("Show all account detail");
                    } else {
                        $(".a_panel").addClass("a_toggle");
                        $(this).addClass("clicked");
                        $(this).css("background-color", "#5788B8");
                        $(this).val("Hide all account detail");
                    }
                });

                $('body').on('click', '.icon-trash', function () {
                    if (confirm("Do you want to delete this account?")) {
                        id = $(this).attr('id');
                        $.ajax({
                            url: 'deleteToXML.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                            success: function (data) {
                                alert(data.message);
                                if (data.completed) {
                                    window.location.href = "view.php";
                                }
                            }}
                        );
                    }
                });

                $('#search_content').keyup(function () {
                    sendRequest();
                });

                $('select').change(function () {
                    sendRequest();
                });

                function sendRequest() {
                    $.ajax({
                        url: 'getAccount.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            q: $('#search_content').val(),
                            role: $('#role').val()
                        },
                        success: function (data) {
                            htmlStr = '';
                            $.each(data, function (index, account) {
                                attr = account['@attributes'];
                                htmlStr += '<div class="question">' +
                                        '<div class="q_content">' +
                                        '<div class="content">' + account.FullName + '</div>' +
                                        '<div class="q_tool_group">' +
                                        '<div class="q_tool"><a href="../account/add.php?id=' + attr.id + '"><span class="icon-pen"></span></a></div>' +
                                        '<div class="q_tool"><a href="javascript: void(0)"><span class="icon-trash"></span></a></div>' +
                                        '</div>' +
                                        '</div>' +
                                        '<div class="a_panel">' +
                                        '<div>Email: ' + account.Email + '</div>' +
                                        '<div>Password: ' + account.Password + '</div>' +
                                        '<div>Role: ' + (attr.role == 0 ? 'Administrator' : 'Lecturer') +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';
                            });
                            $("#Accounts").html(htmlStr);
                        }}
                    );
                }
            });
        </script>
    </head>
    <body>
        <?php
        include '../layout/header.php';
        ?>

        <!--Search Box-->
        <div class="field" id="searchform">
            <input type="text" id="search_content" autocomplete="off" placeholder="Search account here . . ." />
            <input type="submit" id="search_btn" value="Search">
        </div>
        <!--Filter-->
        <div style="" class="filter_style">
            <a href="add.php">
                <input type="button" value="+ Create new account" id="a_add" style="background-color: #3552c7"/>
            </a>
            Role
            <span class="custom-dropdown">
                <select id="role">
                    <option value="-1" selected="">All</option>
                    <option value="0">Administrator</option>
                    <option value="1">Lecturer</option>  
                </select>
            </span>
            <input type="button" value="Show all account detail" id="show_all"/>
        </div>

        <!--Question-->
        <div id="Accounts">
            <?php
            $Accounts = simplexml_load_file("../xml/Accounts.xml");
            foreach ($Accounts->children() as $Account) {
                if (!isset($Account['removed'])) {
                    ?>
                    <div class="question">
                        <div class="q_content">            
                            <div class="content"><?= $Account->FullName ?></div>
                            <div class="q_tool_group">
                                <div class="q_tool">
                                    <a href="../account/add.php?id=<?= $Account['id'] ?>">
                                        <span class="icon-pen"></span>
                                    </a>
                                </div>
                                <div class="q_tool">
                                    <a href="javascript: void(0)">
                                        <span class="icon-trash" id="<?= $Account['id'] ?>"></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="a_panel">
                            <div>Email: <?= $Account->Email ?></div>
                            <div>Password: <?= $Account->Password ?></div>
                            <div>Role: 
                                <?php
                                if ($Account['role'] == 0) {
                                    echo 'Administrator';
                                } else {
                                    echo 'Lecturer';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </body>
</html>
