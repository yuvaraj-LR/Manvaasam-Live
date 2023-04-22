<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
   include 'config.php';
   $date = date("Y-m-d");
   $json = file_get_contents('dashboard.json');
   $data = json_decode($json, true);
   $creditsJson = json_decode(file_get_contents('credits.json'), true);
   try {
      $stats = explode("\r\n", $data['topStats']);
      $hero =  explode("\r\n", $data['heroOfTheWeek']);
      $updates = explode("\r\n", $data['generalUpdates']);
      $meetings = explode("\r\n", $data['upcomingMeetings']);
      $social = explode("\r\n", $data['socialMedia']);
      $pendingTasks = explode("\r\n", $data['taskCompleted']);
   } catch (Exception $e) {
   }

?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
      <?php include_once 'inc/head.php'; ?>
   </head>

   <body class="dashboard dashboard_1">
      <div class="full_container">
         <div class="inner_container">
            <?php include_once 'inc/sidebar.php'; ?>
            <div id="content">
               <?php include_once 'inc/header.php'; ?>
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2 class="text-uppercase">Manvaasam Dashboard</h2>
                           </div>
                        </div>
                     </div>

                     <div class="row column1">
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-users yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= explode(": ", $stats[0])[1]; ?></p>
                                    <p class="head_couter"><?= explode(": ", $stats[0])[0]; ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-address-card-o blue1_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= explode(": ", $stats[1])[1]; ?></p>
                                    <p class="head_couter"><?= explode(": ", $stats[1])[0]; ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-id-badge green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= explode(": ", $stats[2])[1]; ?></p>
                                    <p class="head_couter"><?= explode(": ", $stats[2])[0]; ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-bar-chart red_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?= explode(": ", $stats[3])[1]; ?></p>
                                    <p class="head_couter"><?= explode(": ", $stats[3])[0]; ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>


                     <!-- graph -->
                     <div class="row column2 graph margin_bottom_30">
                        <div class="col-md-l2 col-lg-12">
                           <div class="white_shd full">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Pending Tasks</h2>
                                 </div>
                              </div>
                              <div class="full graph_revenue">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="content">
                                          <div class="area_chart">
                                             <!-- <canvas height="120" id="canvas"></canvas> -->
                                             <canvas id="barChart" style="width: 100%; height:50;"></canvas>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end graph -->
                     <div class="row column3">
                        <!-- testimonial -->
                        <div class="col-md-6">
                           <div class="dark_bg full margin_bottom_20">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>HERO OF THE WEEK</h2>
                                 </div>
                              </div>
                              <div class="full graph_revenue">
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="content testimonial">
                                          <div id="testimonial_slider" class="carousel slide" data-ride="carousel">
                                             <!-- Wrapper for carousel items -->
                                             <div class="carousel-inner">
                                                <div class="item carousel-item active">
                                                   <div class="img-box"><img src="<?= explode(": ", $hero[0])[1]; ?>" alt=""></div>
                                                   <p class="testimonial"><?= explode(": ", $hero[1])[1]; ?></p>
                                                   <p class="overview"><b><?= explode(": ", $hero[2])[1]; ?></b><?= explode(": ", $hero[3])[1]; ?></p>
                                                </div>
                                                <!--<div class="item carousel-item">-->
                                                <!--   <div class="img-box"><img src="images/layout_img/user_img.jpg" alt=""></div>-->
                                                <!--   <p class="testimonial">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae..</p>-->
                                                <!--   <p class="overview"><b>Michael Stuart</b>Seo Founder</p>-->
                                                <!--</div>-->
                                                <!--<div class="item carousel-item">-->
                                                <!--   <div class="img-box"><img src="images/layout_img/user_img.jpg" alt=""></div>-->
                                                <!--   <p class="testimonial">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae..</p>-->
                                                <!--   <p class="overview"><b>Michael Stuart</b>Seo Founder</p>-->
                                                <!--</div>-->
                                             </div>
                                             <!-- Carousel controls -->
                                             <!--<a class="carousel-control left carousel-control-prev" href="#testimonial_slider" data-slide="prev">-->
                                             <!--<i class="fa fa-angle-left"></i>-->
                                             <!--</a>-->
                                             <!--<a class="carousel-control right carousel-control-next" href="#testimonial_slider" data-slide="next">-->
                                             <!--<i class="fa fa-angle-right"></i>-->
                                             <!--</a>-->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- end testimonial -->
                        <!-- progress bar -->
                        <div class="col-md-6">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>THOUGHT FOR THE DAY</h2>
                                 </div>
                              </div>
                              <div class="embed-responsive embed-responsive-16by9">
                                 <iframe class="embed-responsive-item" src="<?= $data['ytLink']; ?>" allowfullscreen></iframe>
                              </div>
                           </div>
                        </div>
                        <!-- end progress bar -->
                     </div>
                     <div class="row column4 graph">
                        <div class="col-md-6 margin_bottom_30">
                           <div class="dash_blog">
                              <div class="dash_blog_inner">
                                 <div class="dash_head">
                                    <h3><span><i class="fa fa-calendar"></i>&ensp; GENERAL UPDATES</span><span class="plus_green_bt"><a href="#">+</a></span></h3>
                                 </div>
                                 <div class="list_cont">
                                    <p>Every day is a new Opportunity :)</p>
                                 </div>
                                 <div class="task_list_main">
                                    <ul class="task_list">
                                       <?
                                       foreach ($updates as $update) {
                                          $info = explode(": ", $update);
                                          echo "<li><strong> $info[1] </strong> <br> $info[0] </li>";
                                       }
                                       ?>
                                       <!--<li><a href="#">Meeting about plan for Admin Template 2018</a><br><strong>10:00 AM</strong></li>-->
                                    </ul>
                                 </div>
                                 <div class="read_more">
                                    <div class="center"><a class="main_bt read_bt" href="https://manvaasamteam.atlassian.net/jira/projects" target="_blank">JIRA</a></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="dash_blog">
                              <div class="dash_blog_inner">
                                 <div class="dash_head">
                                    <h3><span><i class="fa fa-comments-o"></i>&ensp; UPCOMING MEETINGS</span><span class="plus_green_bt"><a href="#">+</a></span></h3>
                                 </div>
                                 <div class="list_cont">
                                    <p>Come on, Let's Catchup !</p>
                                 </div>
                                 <div class="msg_list_main">
                                    <ul class="msg_list">
                                       <?
                                       foreach ($meetings as $meeting) {
                                          $info = explode(": ", $meeting);
                                          echo "<li><span> <span class=\"name_user\"> $info[0] </span> <span class=\"msg_user\"> $info[1] </span> </span></li>";
                                       }
                                       ?>

                                       <!--<li>-->
                                       <!--   <span><img src="images/layout_img/msg2.png" class="img-responsive" alt="#" /></span>-->
                                       <!--   <span>-->
                                       <!--   <span class="name_user">Herman Beck</span>-->
                                       <!--   <span class="msg_user">Sed ut perspiciatis unde omnis.</span>-->
                                       <!--   <span class="time_ago">12 min ago</span>-->
                                       <!--   </span>-->
                                       <!--</li>-->

                                    </ul>
                                 </div>
                                 <div class="read_more">
                                    <div class="center"><a class="main_bt read_bt" href="https://meet.google.com/kbi-dkxy-axo" target="_blank">DAILY MEET</a></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>


                  <!--social media section-->

                  <div class="row column1 social_media_section">
                     <div class="col-md-3 col-lg-2">
                        <div class="full socile_icons fb margin_bottom_30">
                           <div class="social_icon">
                              <i class="fa fa-facebook"></i>
                           </div>
                           <div class="social_cont d-flex justify-content-center ml-4">
                              <ul>
                                 <li>
                                    <span><strong><?= explode(": ", $social[0])[1]; ?></strong></span>
                                    <span>Friends</span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-lg-2">
                        <div class="full socile_icons ig margin_bottom_30">
                           <div class="social_icon">
                              <i class="fa fa-instagram"></i>
                           </div>
                           <div class="social_cont d-flex justify-content-center ml-4">
                              <ul>
                                 <li>
                                    <span><strong><?= explode(": ", $social[1])[1]; ?></strong></span>
                                    <span>Followers</span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-lg-2">
                        <div class="full socile_icons linked margin_bottom_30">
                           <div class="social_icon">
                              <i class="fa fa-linkedin"></i>
                           </div>
                           <div class="social_cont d-flex justify-content-center ml-4">
                              <ul>
                                 <li>
                                    <span><strong><?= explode(": ", $social[2])[1]; ?></strong></span>
                                    <span>Connections</span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-lg-2">
                        <div class="full socile_icons wp margin_bottom_30">
                           <div class="social_icon">
                              <i class="fa fa-whatsapp"></i>
                           </div>
                           <div class="social_cont d-flex justify-content-center ml-4">
                              <ul>
                                 <li>
                                    <span><strong><?= explode(": ", $social[3])[1]; ?></strong></span>
                                    <span>Contacts</span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-3 col-lg-2">
                        <div class="full socile_icons yt margin_bottom_30">
                           <div class="social_icon">
                              <i class="fa fa-youtube"></i>
                           </div>
                           <div class="social_cont d-flex justify-content-center ml-4">
                              <ul>
                                 <li>
                                    <span><strong><?= explode(": ", $social[4])[1]; ?></strong></span>
                                    <span>Subscribers</span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-lg-2">
                        <div class="full socile_icons tg margin_bottom_30">
                           <div class="social_icon">
                              <i class="fa fa-telegram"></i>
                           </div>
                           <div class="social_cont d-flex justify-content-center ml-4">
                              <ul>
                                 <li>
                                    <span><strong><?= explode(": ", $social[5])[1]; ?></strong></span>
                                    <span>Contacts</span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     <!--<div class="col-md-3 col-lg-2">-->
                     <!--   <div class="full socile_icons tw margin_bottom_30">-->
                     <!--      <div class="social_icon">-->
                     <!--         <i class="fa fa-twitter"></i>-->
                     <!--      </div>-->
                     <!--      <div class="social_cont">-->
                     <!--         <ul>-->
                     <!--            <li>-->
                     <!--               <span><strong><?= explode(": ", $social[6])[1]; ?></strong></span>-->
                     <!--               <span>Followers</span>-->
                     <!--            </li>-->
                     <!--         </ul>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->
                  </div>
                  <!--social media ending-->


                  <!-- footer -->

                  <!-- end dashboard inner -->
               </div>
            </div>
         </div>
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
         <script src="js/chart_custom_style1.js"></script>

         <script>
            function openNav() {
               document.getElementById("mySidenav").style.width = "300px";
            }

            function closeNav() {
               document.getElementById("mySidenav").style.width = "0";
            }

            setInterval(function() {
               var formData = new FormData();
               formData.append('emp_id', 'MT0021K');
               formData.append('emp_name', 'Kavyapriya');
               var xhr = new XMLHttpRequest();
               xhr.open('POST', 'iAmAlive.php', true);
               xhr.onload = function() {
                  if (this.status == 200) {
                     console.log("Time Logged");
                  }
               }
               xhr.send(formData);

            }, 10000);
            <?php
            $noTaskTeam = array();
            $noTaskCount = array();
            $noTaskColor = array();

            for ($i = 0; $i < count($pendingTasks); $i++) {
               $name = explode(": ", $pendingTasks[$i])[0];
               $count = explode(": ", $pendingTasks[$i])[1];
               // Convert name to a hash
               $hash = md5($name);
               // Take the first six characters of the hash
               $hex = substr($hash, 0, 6);
               // Return the hex color
               $color = '#' . $hex;
               array_push($noTaskTeam, $name);
               array_push($noTaskCount, $count);
               array_push($noTaskColor, $color);
            }
            echo "
            var noTaskTeam = " . json_encode($noTaskTeam) . ";
            var noTaskCount = " . json_encode($noTaskCount) . ";
            var noTaskColor = " . json_encode($noTaskColor) . ";
            ";
            ?>
            var ctxB = document.getElementById("barChart").getContext('2d');
            var myBarChart = new Chart(ctxB, {
               type: 'bar',
               data: {
                  labels: noTaskTeam,
                  datasets: [{
                     label: "Pending Tasks",
                     data: noTaskCount,
                     backgroundColor: noTaskColor,
                     borderWidth: 1
                  }]
               },
               options: {
                  scales: {
                     yAxes: [{
                        ticks: {
                           beginAtZero: true
                        }
                     }]
                  }
               }
            });
            // timerPunch
         </script>


   </body>

   </html>
<?php
} else {
   header("Location: login.php");
   exit();
}
?>