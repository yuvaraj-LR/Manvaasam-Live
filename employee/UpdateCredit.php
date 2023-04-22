<?php
session_start();
$json = file_get_contents('dashboard.json');
$data = json_decode($json, true);
include 'config.php';
$db = new Database();
$conn = $db->getConnection();
$date = date("Y-m-d");

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    if ($_SESSION['role'] == "admin") {

        $sql = "SELECT * FROM `employees`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_name = $_POST['user_name'];
            $credits = $_POST['credits'];
            $reason = $_POST['reason'];

            $sql = "SELECT * FROM `employees` WHERE user_name = :user_name";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $email = $result[0]['email'];
            $html = '<!DOCTYPE html>
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Your Credit Score updated</title>
            </head>
            <body class="">
                <div style="font-family: sans-serif;font-size: 14px;display: block;margin: 0 auto;max-width: 580px;padding: 10px;width: 100%;">
                    <h2 style="font-size:23px;font-weight:bold">Hi Manvaasam Team,</h2>
                    <h4 style="font-size:18px;font-weight:bold">Your Credit Score updated</h4>
                    <p>
                        Your Creatid score is updated. <br>
                        ' . intval($credits) . ' points
                    </p>
                    <p>
                        Reason.<br>
                        ' . $reason . '
                    </p>
                    <p>
                        Date.<br>
                        ' . $date . '
                    </p>
                    <div style="color: #999999;font-size: 12px;text-align: center">
                        Powered by
                        <a href="https://manvaasam.com">Manvaasam.com</a>.
                    </div>
                </div>
            </body>
            
            </html>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: 	Manvaasam <admin@manvaasam.com> ' . "\r\n";
            mail($email, "Manvaasam Credits", $html, $headers);
            $json = file_get_contents('credits.json');
            $data = json_decode($json, true);
            $date = date("Y-m-d H:i:s");
            $creditJson = array(
                'user_name' => $user_name,
                'credits' => intval($credits),
                'reason' => $reason,
                'date' => $date
            );
            $data[$user_name][] = $creditJson;
            $json = json_encode($data);
            file_put_contents('credits.json', $json);
            echo "<script>alert('Credit Added Successfully');</script>";
            echo "<script>window.location.href='UpdateCredit.php';</script>";
        }

        if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
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
                <link rel="stylesheet" href="formstyle.css">
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
                                                <h2 class="text-uppercase">Update Credit Points</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="signup-form">
                                            <form method="POST" class="leave-form" id="leave-form">
                                                <h2>Edit Credit Data</h2>
                                                <div class="form-group">
                                                    <label for="id">Employee Id :</label>
                                                    <!-- <input type="text" name="user_name" id="user_name" required="" readonly="true" value="<?php echo $user_name; ?>"> -->
                                                    <select name="user_name" id="id" class="form-control" required>
                                                        <option value="">Select Employee</option>
                                                        <?php
                                                        foreach ($allUsers as $user) {
                                                            echo "<option value='" . $user['user_name'] . "'>" . $user['user_name'] . " (" . $user['name'] . ")</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Credits</label>
                                                    <input type="number" name="credits" id="credits" placeholder="Credit Points (number)" required="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="reason">Reason:</label>
                                                    <input type="text" name="reason" id="reason" placeholder="Reason" required="">
                                                </div>
                                                <div class="form-submit">
                                                    <input type="reset" value="Reset All" class="submit" name="reset" id="reset">
                                                    <input type="submit" value="Submit Form" class="submit" name="submit" id="submit">
                                                </div>
                                            </form>
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
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
