<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
   include 'config.php';
   $db = new Database();
   $conn = $db->getConnection();
   $date = date("Y-m-d");
   $sql = "SELECT * FROM `employees`";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $result = $stmt->fetchAll();
   $creditsJson = json_decode(file_get_contents('credits.json'), true);
?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <!--include fav icon to all pages-->
      <link rel="icon" type="image/x-icon" href="mainfav_icon.png">

      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="images/fevicon.png" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="css/colors.css" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="css/custom.css" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="js/semantic.min.css" />
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <style>
         .contact_inner {
            font-size: 14px;
         }

         .badge-points {
            font-size: 10px;

         }
      </style>
   </head>

   <body class="inner_page contact_page">
      <div class="full_container">
         <div class="inner_container">
            <!-- Sidebar  -->
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

                     <li><?php
                           if ($_SESSION['role'] == "admin") {
                           ?>
                           <a href="update.php"><i class="fa fa-gear red_color"></i>
                              <span>UPDATE DASHBOARD</span></a>
                        <?php
                           }
                        ?>
                     </li>

                     <li class="active">
                        <a href="profile.php"><i class="fa fa-user yellow_color"></i>
                           <span>OUR TEAM</span></a>

                     </li>
                     <li><a target="_blank" href="https://drive.google.com/file/d/1RZGkxP_B3jA7nHKPNCdkcMzhJx0Zs-md/view?usp=sharing"><i class="fa fa-building-o orange_color"></i> <span>ORGANISATION STRUCTURE</span></a></li>

                     <li><a target="_blank" href="https://docs.google.com/spreadsheets/d/1Sar5XJZmyjRMKqV5p61Hhqpa9EtkKU5Q/edit?usp=sharing&ouid=112714247812264427302&rtpof=true&sd=true"><i class="fa fa-group purple_color2"></i> <span>MANVAASAM CALENDER</span></a></li>

                     <li><a target="_blank" href="https://mail.google.com/mail/u/0/#inbox"><i class="fa fa-envelope-o blue1_color"></i>
                           <span>CHECK EMAIL</span></a>
                     </li>
                     <li><a target="_blank" href="https://app.slack.com/client/T02JN4H1J7Q/C02K7J1PNAV"><i class="fa fa-slack  green_color"></i> <span>SLACK</span></a>
                     </li>
                     <li><a target="_blank" href="payroll.php"><i class="fa fa-money yellow_color"></i> <span>PAYROLL</span></a>
                     </li>
                     <li><a target="_blank" href="https://manvaasamteam.atlassian.net/jira/projects"><i class="fa fa-briefcase purple_color"></i> <span>JIRA</span></a>
                     </li>
                     <li><a target="_blank" href="documentCentre.php"><i class="fa fa-file-pdf-o red_color"></i> <span>DOCUMENT CENTRE</span></a>
                     </li>
                     <li><a target="_blank" href="entertainment.php"><i class="fa fa-film blue1_color"></i> <span>ENTERTAINMENT ZONE</span></a>
                     </li>
                     <li>
                        <a target="_blank" href="studyarea.html">
                           <i class="fa fa-book yellow_color"></i> <span>STUDY AREA</span></a>
                     </li>

                     <!-- Chat Options Removed. -->

                     <!-- <li><a target="_blank" href="https://manvaasam.com/Emp_Login/adminChat.php"><i class="fa fa-comments purple_color2"></i> <span>CHAT</span></a></li> -->

                     <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScB_GcicEKjAgJJG5rKfSYCMLAIfmHtEJ1MF3lvRfEcxMBQcA/viewform"><i class="fa fa-bar-chart-o green_color"></i> <span>REIMBURSMENT</span></a>
                     </li>
                     <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfbtQL8r6Am_Ds3fRMi2o3GfapkgMogTEP2bNkZItagqabFMQ/viewform"><i class="fa fa-tags yellow_color"></i> <span>SHOP WITH CREDIT</span></a>
                     </li>
                     <li>
                        <a href="https://manvaasam.com/admin/" target="_blank">
                           <i class="fa fa-mobile-phone brown_color"></i> <span>MOBILE APP ADMIN</span></a>
                     </li>
                     <li>
                        <a href="https://www.manvaasam.in/" target="_blank">
                           <i class="fa fa-shopping-cart purple_color"></i> <span>SHOPPING</span></a>
                     </li>
                     <li>
                        <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScYTJxUOmli7MwBpqKHZ6YqGPxkkIpCKCrl7sNhKDNBUYorMw/viewform">
                           <i class="fa fa-power-off red_color"></i> <span>LEAVE TEAM</span></a>
                     </li>
                  </ul>
               </div>

            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
               <!-- topbar -->
               <?php
               $points = 0;

               if (!isset($creditsJson[$_SESSION['user_name']])) {
                  $creditsJson[$_SESSION['user_name']] = [];
               }
               for ($j = 0; $j < count($creditsJson[$_SESSION['user_name']]); $j++) {
                  $points += $creditsJson[$_SESSION['user_name']][$j]['credits'];
               }
               ?>
               <div class="topbar">
                  <nav class="navbar navbar-expand-lg navbar-light">
                     <div class="full">
                        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                        <div class="logo_section">
                           <a href="index.php"><img class="img-responsive" src="logo.png" alt="#" /></a>
                        </div>

                        <div class="right_topbar">
                           <div class="icon_info">
                              <ul>
                                 <li>
                                    <a href="#">
                                       <span class="btn btn-outline-light pr-2"> <i class="fa fa-rupee"></i> <?php echo $points; ?></span></a>
                                 </li>
                              </ul>
                              <ul class="user_profile_dd">
                                 <li>
                                    <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg" alt="#" /><span class="name_user"><?php echo  $_SESSION['name'] ?></span></a>
                                    <div class="dropdown-menu">
                                       <!--<a class="dropdown-item" href="profile.html">My Profile</a>-->
                                       <a href="EditProfile.php?user_name=<?= $_SESSION['user_name'] ?>" class="btn btn-info  btn-sm dropdown-item">EDIT PROFILE</a>
                                       <a class="dropdown-item" href="Mlogout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </nav>
               </div>
               <!-- end topbar -->
               <!-- dashboard inner -->






               <!-- jQuery -->
               <script src="js/jquery.min.js"></script>
               <script src="js/popper.min.js"></script>
               <script src="js/bootstrap.min.js"></script>
               <!-- wow animation -->
               <script src="js/animate.js"></script>
               <!-- select country -->
               <script src="js/bootstrap-select.js"></script>
               <!-- owl carousel -->
               <script src="js/owl.carousel.js"></script>
               <!-- chart js -->
               <script src="js/Chart.min.js"></script>
               <script src="js/Chart.bundle.min.js"></script>
               <script src="js/utils.js"></script>
               <script src="js/analyser.js"></script>
               <!-- nice scrollbar -->
               <script src="js/perfect-scrollbar.min.js"></script>
               <script>
                  var ps = new PerfectScrollbar('#sidebar');
               </script>
               <!-- custom js -->
               <script src="js/custom.js"></script>
               <!-- calendar file css -->
               <script src="js/semantic.min.js"></script>
   </body>

   </html>
<?php
} else {
   header("Location: login.php");
   exit();
}
?>