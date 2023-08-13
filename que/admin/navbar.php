<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header is-small-screen">

    <?php if ($_SESSION['login_type'] == 1) : ?>
        <!-- DARK DASHBOARD || ADMIN -->
        <header class="mdl-layout__header bg-dark">
            <div class="mdl-layout__header-row">
                <div class="mdl-layout-spacer"></div>
                <ul class="mdl-menu mdl-list mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right mdl-shadow--2dp messages-dropdown" for="inbox">

                </ul>

                <div class="avatar-dropdown" id="icon">
                    <span>

                    </span>
                    <img src="dist/images/card.jpg">
                </div>

                <!-- Account dropdawn-->
                <ul class="mdl-menu mdl-list mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp account-dropdown" for="icon">
                    <li class="mdl-list__item mdl-list__item--two-line">
                        <span class="mdl-list__item-primary-content">
                            <!-- <span class="material-icons mdl-list__item-avatar"></span> -->
                            <img src="dist/images/card.jpg">&nbsp;
                            <?php
                            echo $_SESSION['login_name'] . "!"
                            ?>
                        </span>
                    </li>
                    <!-- <li class="list__item--border-top"></li>
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">account_circle</i>
                            My account
                        </span>
                    </li>
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">check_box</i>
                            My tasks
                        </span>
                        <span class="mdl-list__item-secondary-content">
                            <span class="label background-color--primary">3 new</span>
                        </span>
                    </li>
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">perm_contact_calendar</i>
                            My events
                        </span>
                    </li>
                    <li class="list__item--border-top"></li>
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">settings</i>
                            Settings
                        </span>
                    </li> -->

                    <li class="mdl-menu__item mdl-list__item" data-toggle="modal" data-target="#exampleModal">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon text-color--secondary">exit_to_app</i>
                            Log out
                        </span>
                    </li>
                </ul>

            </div>
        </header>

    <?php else : ?>
        <!-- GREEN DASHBOARD || REGISTRAR -->
        <header class="mdl-layout__header bg-success">
            <div class="mdl-layout__header-row">
                <div class="mdl-layout-spacer"></div>

                <!-- Notifications dropdown-->
                <ul class="mdl-menu mdl-list mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right mdl-shadow--2dp notifications-dropdown" for="notification">

                </ul>

                <div class="avatar-dropdown" id="icon">
                    <span>

                    </span>
                    <img src="dist/images/card.jpg">
                </div>

                <ul class="mdl-menu mdl-list mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp account-dropdown" for="icon">
                    <li class="mdl-list__item mdl-list__item--two-line">
                        <span class="mdl-list__item-primary-content">
                            <!-- <span class="material-icons mdl-list__item-avatar"></span> -->
                            <img src="dist/images/card.jpg">
                            <?php
                            echo $_SESSION['login_name'] . "!"
                            ?>
                        </span>
                    </li>
                    <li class="list__item--border-top"></li>
                    <!-- <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <a class="material-icons mdl-list__item-icon" href="index.php?page=password">account_circle</a>
                            Change password
                        </span>
                    </li> -->
                    <!-- <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">check_box</i>
                            My tasks
                        </span>
                        <span class="mdl-list__item-secondary-content">
                            <span class="label background-color--primary">3 new</span>
                        </span>
                    </li>
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">perm_contact_calendar</i>
                            My events
                        </span>
                    </li>
                    <li class="list__item--border-top"></li>
                    <li class="mdl-menu__item mdl-list__item">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon">settings</i>
                            Settings
                        </span>
                    </li> -->

                    <li class="mdl-menu__item mdl-list__item" data-toggle="modal" data-target="#exampleModal">
                        <span class="mdl-list__item-primary-content">
                            <i class="material-icons mdl-list__item-icon text-color--secondary">exit_to_app</i>
                            Log out
                        </span>
                    </li>
                </ul>

            </div>
        </header>

    <?php endif; ?>

    <!-- ADMIN || NAVIGATION BAR -->
    <div class="mdl-layout__drawer">
        <header><img src="../dist/images/cct-logos.png" width="50" height="50" alt="">CCT-SHS</header>
        <div class="scroll__wrapper" id="scroll__wrapper">
            <div class="scroller" id="scroller">
                <div class="scroll__container" id="scroll__container">
                    <nav class="mdl-navigation">
                        <div class="sidebar-list">
                            <!-- 1 ADMIN || 2 REGISTRAR -->
                            <?php if ($_SESSION['login_type'] == 1) : ?>
                                <a class="mdl-navigation__link mdl-navigation__link--current" href="index.php?page=dashboard">
                                    <i class="material-icons" role="presentation">dashboard</i>
                                    Home
                                </a>
                                <hr>
                                <a class="mdl-navigation__link" href="index.php?page=users">
                                    <i class="material-icons">person</i>
                                    Account
                                </a>
                                <!-- <a class="mdl-navigation__link" href="index.php?page=que-dashboard">
                                    <i class="material-icons">smart_display</i>
                                    Dispaly Queue
                                </a> -->
                                <div class="sub-navigation">
                                    <a class="mdl-navigation__link">
                                        <i class="material-icons">pages</i>
                                        Queue
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                    <div class="mdl-navigation">
                                        <a class="mdl-navigation__link" href="index.php?page=transactions">
                                            Transaction
                                        </a>
                                        <a class="mdl-navigation__link" href="index.php?page=windows">
                                            Window
                                        </a>
                                        <!-- <a class="mdl-navigation__link" href="index.php?page=uploads">
                                            Uploads
                                        </a> -->
                                        <a class="mdl-navigation__link" href="index.php?page=qrcode">
                                            Generate QR code
                                        </a>
                                        <!-- <a class="mdl-navigation__link" href="index.php?page=notification">
                                            Notification
                                        </a> -->
                                    </div>
                                </div>

                                <!-- REGISTRAR || NAVIGATION BAR -->
                            <?php else : ?>
                                <a class="mdl-navigation__link mdl-navigation__link--current" href="index.php?page=dashboard">
                                    <i class="material-icons" role="presentation">home</i>
                                    Home
                                </a>
                                <a class="mdl-navigation__link" href="index.php?page=home">
                                    <i class="material-icons" role="presentation">dashboard</i>
                                    Serve
                                </a>
                                <a class="mdl-navigation__link" href="index.php?page=notification">
                                    <i class="material-icons" role="presentation">notifications</i>
                                    Notifications
                                </a>
                                <a class="mdl-navigation__link" href="index.php?page=list">
                                    <i class="material-icons" role="presentation">list</i>
                                    List queue
                                </a>
                            <?php endif; ?>

                        </div>
                        <div class="mdl-layout-spacer"></div>
                        <hr>
                        <a class="mdl-navigation__link" href="#">
                            <!-- <i class="material-icons" style="color: green" role="presentation">person</i> -->
                            <center>
                            <img src="../dist/images/cct-logos.png" width="175" height="175" alt="">
                            </center>
                            <?php
                            // echo $_SESSION['login_name'] . "!"
                            ?>
                        </a>

                    </nav>
                    <script>
                        $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
                    </script>
                </div>
            </div>
            <div class='scroller__bar' id="scroller__bar"></div>
        </div>
    </div>
