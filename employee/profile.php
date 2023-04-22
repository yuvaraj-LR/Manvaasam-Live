<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
   include 'config.php';
   $db = new Database();
   $conn = $db->getConnection();
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
                     <div class="row column_title ">
                        <div class="col-md-12 ">
                           <div class="page_title">
                              <h2 class="text-uppercase">Team Manvaasam</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head d-flex justify-content-between">
                                 <div class="heading1 margin_0">

                                 </div>
                                 <?php if (($_SESSION['role'] == 'admin') || ($_SESSION['user_name'] == 'MT0001')) { ?>
                                    <div class="heading1 margin_0">

                                       <a href="AddNew.php" class="btn btn-success btn-sm m-0 ml-2 heading1 p-2">ADD NEW USER</a>
                                       <a href="studyarea/studyarea.php" class="btn btn-warning btn-sm m-0 ml-2 heading1 p-2">STUDY AREA UPDATE</a>

                                       <a href="UpdateCredit.php" class="btn btn-primary btn-sm  m-0 ml-2 heading1 p-2">UPDATE CREDITS</a>
                                       <a href="https://app.we360.ai/authenticate/login" target="_blank" class="btn btn-danger btn-sm  m-0 ml-2 heading1 p-2">360 PORTAL </a>
                                    </div>
                                 <?php }
                                 ?>
                              </div>
                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                    <?php
                                    $sql = "SELECT * FROM `employees`";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll();

                                    for ($i = 0; $i < count($result); $i++) {
                                    ?>
                                       <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 profile_details margin_bottom_30">
                                          <div class="contact_blog">
                                             <h4 class="brief"><?= $result[$i]['user_name'] ?></h4>
                                             <div class="contact_inner">
                                                <div class="left">
                                                   <h3><?= $result[$i]['name'] ?></h3>
                                                   <p><strong><?= $result[$i]['about'] ?></strong></p>

                                                </div>
                                                <div class="right">


                                                   <div class="profile_contacts">
                                                      <img class="img-responsive" src="images/layout_img/msg2.png" alt="#" />
                                                   </div>
                                                </div>
                                                <div class="bottom_list d-flex justify-content-around">
                                                   <div class="left_rating ">

                                                      &nbsp;
                                                      <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" color="#ffdf00" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                                                         <g fill="currentColor">
                                                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932c0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853c0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836c0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91c0 .542-.412.914-1.135.982V8.518l.087.02z" />
                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11a5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                                         </g>
                                                      </svg>
                                                      <?php
                                                      if (!isset($creditsJson[$result[$i]['user_name']])) {
                                                         $creditsJson[$result[$i]['user_name']] = [];
                                                      }
                                                      $points = 0;
                                                      for ($j = 0; $j < count($creditsJson[$result[$i]['user_name']]); $j++) {
                                                         $points += $creditsJson[$result[$i]['user_name']][$j]['credits'];
                                                      }

                                                      ?> <span style="width:2.3em;height:2.3em;float:right" class="ml-2 mt-1"> <?php echo $points; ?> </span>
                                                   </div>

                                                   <div class="right_button">
                                                      <?php
                                                      if ($result[$i]['user_name'] != $_SESSION['user_name']) {
                                                         if ($result[$i]['email'] != "") {
                                                            echo '<a href="mailto:' . $result[$i]['email'] . '" class="btn btn-info btn-sm">Send Mail</a> &nbsp;';
                                                         }
                                                         if ($result[$i]['phone'] != "") {
                                                            echo '<a href="tel:' . $result[$i]['phone'] . '" class="btn btn-info btn-sm">Call</a>';
                                                         }
                                                         if ($_SESSION['role'] == "admin") {

                                                            echo '</a>';

                                                            echo '&nbsp;<a href="EditProfile.php?user_name=' . $result[$i]["user_name"] . '"  class="btn btn-dark btn-sm" ><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="25px" height="15px" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M4.42 20.579a1 1 0 0 1-.737-.326a.988.988 0 0 1-.263-.764l.245-2.694L14.983 5.481l3.537 3.536L7.205 20.33l-2.694.245a.95.95 0 0 1-.091.004ZM19.226 8.31L15.69 4.774l2.121-2.121a1 1 0 0 1 1.415 0l2.121 2.121a1 1 0 0 1 0 1.415l-2.12 2.12l-.001.001Z"/></svg></a>';
                                                            if ($_SESSION['role'] == "admin" && $_SESSION['user_name'] == "MT0001") {
                                                               echo '&nbsp;<a href="DeleteProfile.php?user_name=' . $result[$i]["user_name"] . '"  onClick="alert(\'Are you sure ?\')" class="btn btn-danger btn-sm">Delete</a>';
                                                            }
                                                         }
                                                      } else {
                                                      ?>

                                                         <a href="EditProfile.php?user_name=<?= $result[$i]["user_name"] ?>" class="btn btn-dark btn-sm">EDIT PROFILE</a>
                                                      <?php
                                                      }
                                                      ?>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    <?php
                                    }
                                    ?>

                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
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