<?php
session_start();
$json = file_get_contents('dashboard.json');
$data = json_decode($json, true);

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    if ($_SESSION['role'] == "admin") {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $newUpdate = array(
                'generalUpdates'   =>     $_POST["generalUpdates"],
                'upcomingMeetings' =>     $_POST["upcomingMeetings"],
                'heroOfTheWeek'    =>     $_POST["heroOfTheWeek"],
                'taskCompleted'    =>     $_POST["taskCompleted"],
                'topStats'         =>     $_POST["topStats"],
                'socialMedia'      =>     $_POST["socialMedia"],
                'ytLink'           =>     $_POST["ytLink"],
                'employeeCount'    =>     $_POST["employeeCount"]
            );

            $final_data = json_encode($newUpdate);
            if (file_put_contents('dashboard.json', $final_data)) {
                $message = "File JSON updated successfully";
                header("Location: index.php");
                exit();
            } else {
                $message = "There is some error";
            }
        }

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
                                                <h2 class="text-uppercase">Update Dashboard</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <form class="form-card  p-4" method="post">
                                            <div class="row justify-content-between text-left">
                                                <div class="form-group col-md-12 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">General Updates<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" id="generalUpdates" name="generalUpdates" placeholder="General Updates goes here"><?php echo $data['generalUpdates']; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Upcoming Meetings<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" id="upcomingMeetings" name="upcomingMeetings" placeholder="Upcoming Meeting Details"><?php echo $data['upcomingMeetings']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row justify-content-between text-left">
                                                <div class="form-group col-md-12 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Hero Of The Week<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" id="heroOfTheWeek" name="heroOfTheWeek" placeholder="Details of the hero"><?php echo $data['heroOfTheWeek']; ?></textarea>
                                                </div>
                                                <div class="form-group col-md-12 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Pending Tasks<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" type="text" id="taskCompleted" name="taskCompleted" placeholder="Pending Task Details"><?php echo $data['taskCompleted']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row justify-content-between text-left">
                                                <div class="form-group col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Stats on Top<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" id="topStats" name="topStats" placeholder="Community, FTE, Intern, Projects"><?php echo $data['topStats']; ?></textarea>
                                                </div>
                                                <div class="form-group col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Social Media Reach (not needed)<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" id="socialMedia" name="socialMedia" placeholder="Followers in social media"><?php echo $data['socialMedia']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row justify-content-between text-left">
                                                <div class="form-group col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Thought for the Day - YouTube<span class="text-danger"> *</span></label>
                                                    <textarea rows="5" class="form-control" id="ytLink" name="ytLink"><?php echo $data['ytLink']; ?></textarea>
                                                </div>
                                                <div class="form-group col-sm-6 flex-column d-flex">
                                                    <label class="form-control-label px-3 ">Total Employee count<span class="text-danger"> *</span></label>
                                                    <textarea class="form-control" type="text" id="employeeCount" name="employeeCount"><?php echo $data['employeeCount']; ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row justify-content-end">
                                                <input type="hidden" name="lastUpdated" value="<?php echo date('Y-m-d H:i:s'); ?>">
                                                <div class="form-group col-sm-6">
                                                    <button type="submit" class="btn-block p-3 btn-success">UPDATE</button>
                                                </div>
                                            </div>
                                        </form>
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
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>