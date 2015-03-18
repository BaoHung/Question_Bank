<div>            
    <!--Header-->
    <ul id="cbp-tm-menu" class="cbp-tm-menu">
        <li style="width: 20%;">
            <a href="/">Question Bank</a>

        </li>
        <li style="visibility: visible;width: 11%;text-align: center">
            <a href="/question/view.php">Question</a>               
        </li>
        <li style="visibility: visible;width: 11%;text-align: center">
            <a href="/exam/view.php">Exam</a>                      
        </li>
        <li style="visibility: visible;width: 11%;text-align: center">
            <a href="/Analysis.php">Analysis</a>
        </li>
        <li style="visibility: visible;width: 16%;text-align: center">
            <a href="/Control_Panel.php">Control Panel</a>
            <ul class="cbp-tm-submenu">
                <li><a href="/subject/view.php" class="cbp-tm-icon-archive">Subject</a></li>
                <li><a href="/account/view.php" class="cbp-tm-icon-users">Account</a></li>                    
            </ul>
        </li>

        <?php
        // $Account from /session.php
        if (isset($Account) && !empty($Account)) {
            ?>

            <li style="width: 28%;text-align: right">
                <a href="#"><?= $Account->FullName ?></a>
                <ul class="cbp-tm-submenu">
                    <li><a href="/Change_Pass.php" class="cbp-tm-icon-cog">Change password</a></li>
                    <li><a href="/authentication/logout.php" class="cbp-tm-icon-contract">Log out</a></li>                    
                </ul>
            </li>

            <?php
        }
        ?>

    </ul>

    <!--Script Tooltip-->
    <script src="/js/cbpTooltipMenu.min.js"></script>
    <script>
        var menu = new cbpTooltipMenu(document.getElementById('cbp-tm-menu'));
    </script>
</div>