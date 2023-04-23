<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="index.php"><img class="logo_icon img-responsive" src="fav_icon.png" alt="#" /></a>
            </div>
        </div>
        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img"><img class="img-responsive" src="images/layout_img/user_img.jpg" alt="#" /></div>
                <div class="user_info">
                    <h6><?php echo  $_SESSION['name'] ?> </h6>
                    <p><span class="online_animation"></span> Online</p>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">
        <h4> Welcome !</h4>
        <ul class="list-unstyled components">
            <li>
                <a href="index.php"><i class="fa fa-home brown_color"></i>
                    <span>HOME</span>
                </a>
            </li>
            <li><?php
                if ($_SESSION['role'] == "admin") {
                ?>
                    <a href="update.php"><i class="fa fa-gear red_color"></i>
                        <span>UPDATE DASHBOARD</span>
                    </a>
                <?php
                }
                ?>
            </li>

            <li>
                <a href="profile.php"><i class="fa fa-user yellow_color"></i>
                    <span>OUR TEAM</span>
                </a>

            </li>
            <li>
                <a target="_blank" href="https://drive.google.com/file/d/1RZGkxP_B3jA7nHKPNCdkcMzhJx0Zs-md/view?usp=sharing"><i class="fa fa-building-o orange_color"></i> <span>ORGANISATION STRUCTURE</span>
                </a>
            </li>

            <li>
                <a target="_blank" href="https://docs.google.com/spreadsheets/d/1Sar5XJZmyjRMKqV5p61Hhqpa9EtkKU5Q/edit?usp=sharing&ouid=112714247812264427302&rtpof=true&sd=true"><i class="fa fa-group purple_color2"></i> <span>MANVAASAM CALENDAR</span>
                </a>
            </li>

            <!-- <li>
                <a target="_blank" href="https://docs.google.com/spreadsheets/d/1igHelslcTp1xkGbmvWJO20tlkdUidxSe_LmC7KjJaYs/edit?usp=sharing"><i class="fa fa-bullhorn red_color"></i> <span>POSTER DASHBOARD</span>
                </a> -->
            </li>
            <li>
                <a target="_blank" href="https://mail.google.com/mail/u/0/#inbox"><i class="fa fa-envelope-o blue1_color"></i>
                    <span>CHECK EMAIL</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://app.slack.com/client/T02JN4H1J7Q/C02K7J1PNAV"><i class="fa fa-slack  green_color"></i> <span>SLACK</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://manvaasam.com/Emp_Login/payroll.html"><i class="fa fa-money yellow_color"></i> <span>PAYROLL</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://manvaasamteam.atlassian.net/jira/projects"><i class="fa fa-briefcase purple_color"></i> <span>JIRA</span>
                </a>
            </li>
            <li><a href="documentCentre.php"><i class="fa fa-file-pdf-o red_color"></i> <span>DOCUMENT CENTRE</span>
                </a>
            </li>
            <li><a href="entertainment.php"><i class="fa fa-film blue1_color"></i> <span>ENTERTAINMENT ZONE</span>
                </a>
            </li>
            <li>
                <a href="studyarea.php">
                    <i class="fa fa-book yellow_color"></i> <span>STUDY AREA</span>
                </a>
            </li>

            <!-- <li>
                <a target="_blank" href="https://manvaasam.com/Emp_Login/adminChat.php"><i class="fa fa-comments purple_color2"></i> <span>CHAT</span>
                </a>
            </li> -->
            <li>
                <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScB_GcicEKjAgJJG5rKfSYCMLAIfmHtEJ1MF3lvRfEcxMBQcA/viewform"><i class="fa fa-bar-chart-o green_color"></i> <span>REIMBURSMENT</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfbtQL8r6Am_Ds3fRMi2o3GfapkgMogTEP2bNkZItagqabFMQ/viewform"><i class="fa fa-tags yellow_color"></i> <span>SHOP WITH CREDIT</span>
                </a>
            </li>
            <li>
                <a href="https://manvaasam.com/admin/" target="_blank">
                    <i class="fa fa-mobile-phone brown_color"></i> <span>MOBILE APP ADMIN</span>
                </a>
            </li>
            <li>
                <a href="https://www.manvaasam.in/" target="_blank">
                    <i class="fa fa-shopping-cart purple_color"></i> <span>SHOPPING</span>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScYTJxUOmli7MwBpqKHZ6YqGPxkkIpCKCrl7sNhKDNBUYorMw/viewform">
                    <i class="fa fa-power-off red_color"></i> <span>LEAVE TEAM</span>
                </a>
            </li>
        </ul>
    </div>
</nav>