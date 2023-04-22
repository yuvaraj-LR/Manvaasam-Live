<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    include './config.php';
    $db = new Database();
    $conn = $db->getConnection();
    $date = date("Y-m-d");
    $sql = "SELECT * FROM `leave` WHERE toDate >= :date";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $result = $stmt->fetchAll();
    // read Dashboard.json 
    $json = file_get_contents('dashboard.json');
    $data = json_decode($json, true);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="img.css">
        <link rel="shortcut icon" href="../image/fav_icon.png" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manvaasam Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="./leave/style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0-rc.1/Chart.js"></script>
        <script src="../assets/js/jquery-3.6.0.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
    </head>

    <body>
        <form action="./POST/activity.php" method="POST">
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Growth Tracker</h5>
                            <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Name :</label>
                                    <input type="text" name="name" id="name" required="" readonly="true" value="<?php echo $_SESSION['name']; ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="id">Employee Id :</label>
                                    <input type="text" name="id" id="id" required="" readonly="true" value="<?php echo $_SESSION['user_name']; ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="whatyoudo">What you Do Today :</label>
                                <input type="text" name="whatyoudo" id="whatyoudo" placeholder="Enter What you do Today" required="" />
                            </div>
                            <div class="form-group m-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="checkbox[]" id="checkbox1">
                                    <label class="form-check-label" for="checkbox1">
                                        Do you have any pending tasks ?
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="checkbox[]" id="checkbox2">
                                    <label class="form-check-label" for="checkbox2">
                                        Have you checked your email ?
                                    </label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="Mlogout.php" class="btn btn-secondary">Logout</a>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <nav class="navbar navbar-expand-lg navbar-light" style="position: fixed;width: 100vw;z-index: 1000;background: white;">
            <div class="container">
                <button class="navbar-toggler" style="display: block;" onclick="openNav()" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <span>
                        <?php
                        $creditsJson = json_decode(file_get_contents('./employee/credits.json'), true);

                        $points = 0;

                        if (!isset($creditsJson[$_SESSION['user_name']])) {
                            $creditsJson[$_SESSION['user_name']] = [];
                        }
                        for ($j = 0; $j < count($creditsJson[$_SESSION['user_name']]); $j++) {
                            $points += $creditsJson[$_SESSION['user_name']][$j]['credits'];
                        }
                        ?>
                        <a class="nav-link btn btn-primary text-white" href="employee/mypoints.php">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="20px" height="20px" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                                <g fill="currentColor">
                                    <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932c0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853c0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836c0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91c0 .542-.412.914-1.135.982V8.518l.087.02z" />
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11a5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
                                </g>
                            </svg>
                            &nbsp;<?php echo $points; ?>
                        </a>
                    </span>
                    <span>
                        <a href="Mlogout.php" class="nav-link btn btn-secondary text-white">Logout</a>
                    </span>
                    <!--<span>
                        <?php
                        if (isset($_SESSION['alreadypunched']) && $_SESSION['alreadypunched'] == "1") {
                        ?>
                            <a class="nav-link btn btn-danger text-white" href="punch.php?action=out">Punch Out <span id="timerPunch" style="font-size: 12px">00:00:00</span></a>
                        <?php
                        } else {
                        ?>
                            <a class="nav-link btn btn-success text-white" href="punch.php?action=in">Punch In</a>
                        <?php
                        }
                        ?>
                    </span>-->
                </div>
            </div>
        </nav>
        <div class="lastUpdated">
            <h5 class="date"><?= explode(" ", $data['lastUpdated'])[0]; ?></h5>
            <h5 class="time"><?= explode(" ", $data['lastUpdated'])[1]; ?></h5>
        </div>
        <div class="container py-5">
            <div class="p-3"></div>
            <div class="row">
                <div class="col-md-9">
                    <h4>Pending Tasks</h4>
                    <!--<canvas id="toChart2" style="width: 100%"></canvas>-->
                    <canvas id="barChart" style="width: 100%"></canvas>
                </div>
                <div class="col-md-3">
                    <div class="p-2"></div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Employee Count</h4>
                        </div>
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Team</th>
                                        <th scope="col">Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        $socialMedia = explode("\r\n", $data['employeeCount']);
                                        for ($i = 0; $i < count($socialMedia); $i++) {
                                            $socialMediaName = explode(": ", $socialMedia[$i])[0];
                                            $socialMediaFollowers = explode(": ", $socialMedia[$i])[1];
                                            echo "<tr>";
                                            echo "<td>" . $socialMediaName . "</td>";
                                            echo "<td>" . $socialMediaFollowers . "</td>";
                                            echo "</tr>";
                                        }
                                    } catch (Exception $e) {
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>General Update</h3>
                        </div>
                        <div class="card-body">
                            <?= $data['generalUpdate']; ?>
                        </div>
                    </div>
                </div>
                <!-- Social Media follwers count in table with linkedin, youtube, facebook, instagram -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Social Media</h3>
                        </div>
                        <div class="card-body">
                            <!-- table -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Media Name</th>
                                        <th scope="col">Followers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    try {
                                        // Linkedin: 12\r\nYoutube: 1000\r\nFacebook: 1000\r\nInstagram: 1000\r\n
                                        $socialMedia = explode("\r\n", $data['socialMedia']);
                                        for ($i = 0; $i < count($socialMedia); $i++) {
                                            $socialMediaName = explode(": ", $socialMedia[$i])[0];
                                            $socialMediaFollowers = explode(": ", $socialMedia[$i])[1];
                                            echo "<tr>";
                                            echo "<td>" . $socialMediaName . "</td>";
                                            echo "<td>" . $socialMediaFollowers . "</td>";
                                            echo "</tr>";
                                        }
                                    } catch (Exception $e) {
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Hero of the week award. with circular image and description -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Hero of the week</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="d-block">
                                <img src="hero.png" class="img-fluid rounded-circle" alt="" style="width: 100px;height:100px;object-fit:cover">
                            </div>
                            <br />
                            <?= $data['herodescription']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
            <div class="row">
                <div class="col-md-8">
                    <!-- Youtube Iframe video -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Youtube Video</h3>
                        </div>
                        <div class="card-body text-center">
                            <?= $data['ytLink']; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Take Assesment -->
                    <div class="card">
                        <div class="card-header">
                            <h3>Important Update</h3>
                        </div>
                        <div class="card-body">
                            <?= $data['feedbackDes']; ?>
                            <br />
                            <br />
                            <div class="text-center">
                                <a href="<?= $data['feedbackLink']; ?>" class="btn btn-success">Important Link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- Leave list -->
                        <div class="card-header">
                            <h3>Leave List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Leave ID</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($result as $row) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['user_name'] ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['typeOfLeave']; ?></td>
                                            <td><?php echo $row['fromDate']; ?></td>
                                            <td><?php echo $row['toDate']; ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                            <td>
                                                <a href="leave/leave_details.php?id=<?php echo $row['id']; ?>">View</a>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
            <div class="row">
            </div>
        </div>
        <?php
        $sql = "SELECT name as user_name, COUNT(user_name) as leaves FROM `leave` GROUP BY user_name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $sql = "SELECT name as user_name, timeSpend FROM `employees`";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $timeSpend = $stmt->fetchAll();
        ?>
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "300px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
            }

            setInterval(function() {
                var formData = new FormData();
                formData.append('emp_id', '<?php echo $_SESSION['user_name']; ?>');
                formData.append('emp_name', '<?php echo $_SESSION['name']; ?>');
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'iAmAlive.php', true);
                xhr.onload = function() {
                    if (this.status == 200) {
                        console.log("Time Logged");
                    }
                }
                xhr.send(formData);

            }, 10000);
            var noEmpTeam = [];
            var noEmpCount = [];
            var noEmpColor = [];
            var noTaskTeam = [];
            var noTaskCount = [];
            var noTaskColor = [];
            <?php
            try {
                $socialMedia = explode("\r\n", $data['employeeCount']);
                for ($i = 0; $i < count($socialMedia); $i++) {
                    $socialMediaName = explode(": ", $socialMedia[$i])[0];
                    $socialMediaFollowers = explode(": ", $socialMedia[$i])[1];
                    echo "noEmpTeam.push('" . $socialMediaName . "');\n";
                    echo "noEmpCount.push('" . $socialMediaFollowers . "');\n";
                    echo "noEmpColor.push('#" . substr(
                        dechex(crc32($socialMediaName)),
                        0,
                        6
                    ) . "');\n";
                }
                $socialMedia = explode("\r\n", $data['taskCompleted']);
                for ($i = 0; $i < count($socialMedia); $i++) {
                    $socialMediaName = explode(": ", $socialMedia[$i])[0];
                    $socialMediaFollowers = explode(": ", $socialMedia[$i])[1];
                    echo "noTaskTeam.push('" . $socialMediaName . "');\n";
                    echo "noTaskCount.push('" . $socialMediaFollowers . "');\n";
                    echo "noTaskColor.push('#" . substr(
                        dechex(crc32($socialMediaName)),
                        0,
                        6
                    ) . "');\n";
                }
            } catch (Exception $e) {
            }
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
            <?php
            if (isset($_SESSION['alreadypunched']) && $_SESSION['alreadypunched'] == "1") {
            ?>
                // timerPunch
                var intTime = <?php echo $_SESSION['punchtime']; ?>;
                var timer = setInterval(function() {
                    var date = new Date(intTime * 1000);
                    var cdate = new Date();
                    var diff = cdate.getTime() - date.getTime();
                    var diffSeconds = diff / 1000;
                    // if time more than 15 mins punch out
                    // if (diffSeconds > 900) {
                    // clearInterval(timer);
                    // window.location.href = "https://manvaasam.com/Emp_Login/punch.php?action=out";
                    // }
                    var HH = Math.floor(diffSeconds / 3600);
                    if (HH < 10) {
                        HH = "0" + HH;
                    }
                    var MM = Math.floor(diffSeconds % 3600 / 60);
                    if (MM < 10) {
                        MM = "0" + MM;
                    }
                    var SS = Math.floor(diffSeconds % 3600 % 60);
                    if (SS < 10) {
                        SS = "0" + SS;
                    }
                    var time = HH + ":" + MM + ":" + SS;
                    document.getElementById("timerPunch").innerHTML = time;
                }, 1000);
            <?php
            }
            ?>
            // timerPunch
        </script>
        <div id="mySidenav" class="sidenav" style="z-index: 100000;">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <img src="../img/manvaasam.jpg" alt="manvaasam logo" style="height: 150px; width: 150px; margin-left: 60px;"><br>
            <?php
            if ($_SESSION['role'] == "admin") {
            ?>
                <a height="18px" href="updateDashboard.php">Update Dashboard</a>
            <?php
            }
            ?>
            <a href="employee">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="0.96em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1408 1472">
                    <path d="M704 128q-144 0-225 106t-81 271q-1 205 132 325q17 16 12 41l-23 48q-11 24-32.5 37.5T396 995q-3 1-126.5 41T138 1080q-84 35-110 73q-28 63-28 319h1408q0-256-28-319q-26-38-110-73q-8-4-131.5-44T1012 995q-69-25-90.5-38.5T889 919l-23-48q-5-25 12-41q133-120 132-325q0-165-81-271T704 128z" fill="currentColor" />
                </svg>
                Profile</a>
            <a target="_blank" href="https://drive.google.com/file/d/1RZGkxP_B3jA7nHKPNCdkcMzhJx0Zs-md/view?usp=sharing"><img src="../img/Organisational .png" height="18px" width="18px"> Organization Structure</a>
            <a target="_blank" href="https://docs.google.com/spreadsheets/d/1HTaTExyCl4RCvR7ufBGFOaImGgyBAtJ7qPsLJeT-aM4/edit?usp=sharing"><img src="social-care.png" height="18px" width="18px"> Community</a>
            <a target="_blank" href="https://mail.google.com/mail/"><img src="../img/Gmail.png" style="height: 16px; width: 16px;"> Check Email</a>
            <a target="_blank" href="https://app.slack.com/client/T02JN4H1J7Q/C02K7J1PNAV">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <g fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.066 1a2.2 2.2 0 1 0 .001 4.4h2.2V3.2a2.202 2.202 0 0 0-2.2-2.2zm0 5.867H3.2a2.2 2.2 0 0 0 0 4.4h5.866a2.2 2.2 0 1 0 0-4.4z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M23 9.066a2.2 2.2 0 0 0-4.4 0v2.2h2.2a2.2 2.2 0 0 0 2.2-2.2zm-5.867 0V3.2a2.2 2.2 0 0 0-4.4 0v5.866a2.2 2.2 0 1 0 4.4 0z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.933 23a2.2 2.2 0 1 0 0-4.4h-2.2v2.2c-.001 1.213.984 2.198 2.2 2.2zm0-5.868H20.8a2.2 2.2 0 0 0 0-4.4h-5.866a2.2 2.2 0 0 0-.001 4.4z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1 14.933a2.2 2.2 0 0 0 4.4 0v-2.2H3.2a2.2 2.2 0 0 0-2.2 2.2zm5.867 0v5.866a2.2 2.2 0 0 0 4.4.001v-5.866a2.2 2.2 0 0 0-4.4-.001z" fill="currentColor"></path>
                    </g>
                </svg>&nbsp;Slack</a>
            <a href="payroll.html" target="_blank"><img src="../img/Payroll.png" height="15px" width="15px" /> Payroll</a>
            <a target="_blank" href="https://manvaasamteam.atlassian.net/jira/projects"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path d="M12.004 0c-2.35 2.395-2.365 6.185.133 8.585l3.412 3.413l-3.197 3.198a6.501 6.501 0 0 1 1.412 7.04l9.566-9.566a.95.95 0 0 0 0-1.344L12.004 0zm-1.748 1.74L.67 11.327a.95.95 0 0 0 0 1.344C4.45 16.44 8.22 20.244 12 24c2.295-2.298 2.395-6.096-.08-8.533l-3.47-3.469l3.2-3.2c-1.918-1.955-2.363-4.725-1.394-7.057z" fill="currentColor"></path>
                </svg>&nbsp;Jira</a>
            <a href="documentCenter.php" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1.5em" height="1.5em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <g fill="none">
                        <path d="M7 12.25a.75.75 0 1 1 1.5 0a.75.75 0 0 1-1.5 0zm.75 2.25a.75.75 0 1 0 0 1.5a.75.75 0 0 0 0-1.5zM7 18.25a.75.75 0 1 1 1.5 0a.75.75 0 0 1-1.5 0zm3.75-6.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zM10 15.25a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1-.75-.75zm.75 2.25a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5zm8.664-9.086l-5.829-5.828a.493.493 0 0 0-.049-.04a.626.626 0 0 1-.036-.03a2.072 2.072 0 0 0-.219-.18a.652.652 0 0 0-.08-.044l-.048-.024l-.05-.029c-.054-.031-.109-.063-.166-.087a1.977 1.977 0 0 0-.624-.138c-.02-.001-.04-.004-.059-.007A.605.605 0 0 0 12.172 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9.828a2 2 0 0 0-.586-1.414zM18.5 20a.5.5 0 0 1-.5.5H6a.5.5 0 0 1-.5-.5V4a.5.5 0 0 1 .5-.5h6V8a2 2 0 0 0 2 2h4.5v10zm-5-15.379L17.378 8.5H14a.5.5 0 0 1-.5-.5V4.621z" fill="currentColor" />
                    </g>
                </svg>
                Document Center
            </a>
            <!--not visible in webpage -->
           <!--<a href="./activity/index.php" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path d="M21 20h-1V5a1 1 0 0 0-2 0v15h-2V9a1 1 0 0 0-2 0v11h-2v-7a1 1 0 0 0-2 0v7H8v-3a1 1 0 0 0-2 0v3H4V3a1 1 0 0 0-2 0v18a1 1 0 0 0 1 1h18a1 1 0 0 0 0-2z" fill="currentColor" />
                </svg>
                Growth Tracker
            </a>-->
            <!--not visible in webpage -->
            <a target="_blank" href="entertainment.html">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path d="M21 3H3c-1.1 0-2 .9-2 2v8h2V5h18v16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" fill="currentColor" />
                    <circle cx="9" cy="10" r="4" fill="currentColor" />
                    <path d="M15.39 16.56C13.71 15.7 11.53 15 9 15s-4.71.7-6.39 1.56A2.97 2.97 0 0 0 1 19.22V22h16v-2.78c0-1.12-.61-2.15-1.61-2.66z" fill="currentColor" />
                </svg>
                Entertainment
            </a>
            <a href="main page/index.html" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 48 48">
                    <g fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39 13a3 3 0 0 0-3 3v2h6v-2a3 3 0 0 0-3-3zm3 7h-6v16.5l3 4.5l3-4.5V20z" fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6 9v30a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3H9a3 3 0 0 0-3 3zm14 6a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2h-8a1 1 0 0 1-1-1zm1 3a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2h-8zm-1 10a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2h-8a1 1 0 0 1-1-1zm1 3a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2h-8zm-9-3v3h3v-3h-3zm-1-2h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-5a1 1 0 0 1 1-1zm6.707-10.293a1 1 0 0 0-1.414-1.414L13 17.586l-1.293-1.293a1 1 0 0 0-1.414 1.414L13 20.414l4.707-4.707z" fill="currentColor" />
                    </g>
                </svg>
                Study Area
            </a>
            <a href="adminChat.php" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16">
                    <g fill="currentColor">
                        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793V2zm7.194 2.766a1.688 1.688 0 0 0-.227-.272a1.467 1.467 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 5.734 4C4.776 4 4 4.746 4 5.667c0 .92.776 1.666 1.734 1.666c.343 0 .662-.095.931-.26c-.137.389-.39.804-.81 1.22a.405.405 0 0 0 .011.59c.173.16.447.155.614-.01c1.334-1.329 1.37-2.758.941-3.706a2.461 2.461 0 0 0-.227-.4zM11 7.073c-.136.389-.39.804-.81 1.22a.405.405 0 0 0 .012.59c.172.16.446.155.613-.01c1.334-1.329 1.37-2.758.942-3.706a2.466 2.466 0 0 0-.228-.4a1.686 1.686 0 0 0-.227-.273a1.466 1.466 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 10.07 4c-.957 0-1.734.746-1.734 1.667c0 .92.777 1.666 1.734 1.666c.343 0 .662-.095.931-.26z" />
                    </g>
                </svg>
                Chat</a>
            <a target="_blank" href="https://forms.gle/L8VQ4TvXZNEfXr5s8"><img src="../img/Reimburement.png" height="20px" width="20px" />
                Reimbursement</a>
            <a href="https://docs.google.com/forms/d/e/1FAIpQLSfbtQL8r6Am_Ds3fRMi2o3GfapkgMogTEP2bNkZItagqabFMQ/viewform" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024">
                    <defs />
                    <path d="M945 412H689c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h256c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM811 548H689c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h122c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM477.3 322.5H434c-6.2 0-11.2 5-11.2 11.2v248c0 3.6 1.7 6.9 4.6 9l148.9 108.6c5 3.6 12 2.6 15.6-2.4l25.7-35.1v-.1c3.6-5 2.5-12-2.5-15.6l-126.7-91.6V333.7c.1-6.2-5-11.2-11.1-11.2z" fill="currentColor" />
                    <path d="M804.8 673.9H747c-5.6 0-10.9 2.9-13.9 7.7c-12.7 20.1-27.5 38.7-44.5 55.7c-29.3 29.3-63.4 52.3-101.3 68.3c-39.3 16.6-81 25-124 25c-43.1 0-84.8-8.4-124-25c-37.9-16-72-39-101.3-68.3s-52.3-63.4-68.3-101.3c-16.6-39.2-25-80.9-25-124c0-43.1 8.4-84.7 25-124c16-37.9 39-72 68.3-101.3c29.3-29.3 63.4-52.3 101.3-68.3c39.2-16.6 81-25 124-25c43.1 0 84.8 8.4 124 25c37.9 16 72 39 101.3 68.3c17 17 31.8 35.6 44.5 55.7c3 4.8 8.3 7.7 13.9 7.7h57.8c6.9 0 11.3-7.2 8.2-13.3c-65.2-129.7-197.4-214-345-215.7c-216.1-2.7-395.6 174.2-396 390.1C71.6 727.5 246.9 903 463.2 903c149.5 0 283.9-84.6 349.8-215.8c3.1-6.1-1.4-13.3-8.2-13.3z" fill="currentColor" />
                </svg>
                Shop with Credit</a>
           <!-- <a href="./leave/index.php"><img src="../img/Apply Leave.png" height="18px" width="18px" />
                Apply Leave</a>-->
                <a href="https://manvaasam.com/admin/"><img src="mobile-app.png" height="18px" width="18px"/>
                Mobile app Admin</a>
                <a href="https://manvaasam.com/empform.html"><img src="icons8-combi-ticket-50.png" height="18px" width="18px"/>
                Raise Ticket</a>
            <a href="https://www.manvaasam.in/" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2a9.985 9.985 0 0 1 8 4h-2.71a8 8 0 1 0 .001 12h2.71A9.985 9.985 0 0 1 12 22zm7-6v-3h-8v-2h8V8l5 4l-5 4z" />
                </svg>
                Shopping</a>
            <a href="https://forms.gle/obKft5sLgrnqeFWK8" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2a9.985 9.985 0 0 1 8 4h-2.71a8 8 0 1 0 .001 12h2.71A9.985 9.985 0 0 1 12 22zm7-6v-3h-8v-2h8V8l5 4l-5 4z" />
                </svg>
                Leave Team</a>
        </div>
        <style>
            .date {
                position: fixed;
                bottom: 4px;
                color: #101010;
                font-size: 18px;
                right: 16px;
                z-index: 1000;
            }

            .time {
                position: fixed;
                bottom: 30px;
                color: #101010;
                font-size: 17px;
                right: 16px;
                z-index: 1000;
            }

            .last {
                position: absolute;
                bottom: 5px;
                color: auto;
                font-size: 17px;
                right: 16px;

            }
        </style>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
?>