<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['user_name'])) {
        include 'config.php';
        $user_name = $_GET['user_name'];
        $db = new Database();
        $conn = $db->getConnection();
        $date = date("Y-m-d");
        $sql = "SELECT * FROM `employees` WHERE user_name = :user_name";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_name', $user_name);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if (count($result) > 0) {
            $id = $result[0]['id'];
            $user_name = $result[0]['user_name'];
            $password = $result[0]['password'];
            $name = $result[0]['name'];
            $timeSpend = $result[0]['timeSpend'];
            $gForm = $result[0]['gForm'];
            $about = $result[0]['about'];
            $email = $result[0]['email'];
            $phone = $result[0]['phone'];
            $enable = $result[0]['enable'];
            $role = $result[0]['role'];
            if ($_SESSION['role'] == 'admin' || ($_SESSION['user_name'] == $user_name)) {
?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Edit Profile</title>
                    <link rel="icon" type="image/x-icon" href="images/fav_icon.png">
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,200&display=swap" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
                    <link rel="stylesheet" href="formstyle.css">
                </head>

                <body class="body">
                    <div class="main">
                        <div class="container" style="overflow-x: auto">
                            <div class="signup-form">
                                <form method="POST" class="leave-form" id="leave-form" enctype="multipart/form-data">
                                    <h2>Edit Profile Data</h2>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="name">Name :</label>
                                            <input type="text" name="name" id="name" required="" value="<?php echo $name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="id">Employee Id :</label>
                                            <input type="text" name="user_name" id="user_name" required="" readonly="true" value="<?php echo $user_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email ID :</label>
                                        <input type="email" name="email" id="email" placeholder="Enter Email" value="<?php echo $email; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone No :</label>
                                        <input type="number" name="phone" id="phone" placeholder="Enter Phone" value="<?php echo $phone; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="reason">About Yourself :</label>
                                        <input type="text" name="about" id="about" placeholder="Enter one liner about yourself" value="<?php echo $about; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="reason"> Select image to upload:</label>
                                        <input type="file" name="profileimg" id="profileimg" placeholder="upload your profile"  />
                                      
                                    </div>
                                   
                                    <?php
                                    if ($_SESSION['role'] == "admin") {
                                        echo '<div class="form-group">
                                    <label for="role">Role :</label>
                                    <select name="role" id="role" required="">';
                                        if ($role == "admin") {
                                            echo '<option value="admin" selected>Admin</option>
                                        <option value="employee">Employee</option>';
                                        } else {
                                            echo '<option value="admin">Admin</option>
                                        <option value="employee" selected>Employee</option>';
                                        }

                                        echo '
                                    </select>
                                </div>';
                                    }
                                    ?>
                                    <div class="form-submit">
                                        <input type="reset" value="Reset All" class="submit" name="reset" id="reset">
                                        <input type="submit" value="Submit Form" class="submit" name="submit" id="submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </body>

                </html>
<?php
            } else {
                echo 'You are not authorized to access this page';
            }
        } else {
            echo "No Employee Found";
        }
    } else {
        echo "Error: No id found";
    }
} else {
    include("config.php");
    $db = new Database();
    $conn = $db->getConnection();
    $name = $_POST['name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $about = $_POST['about'];
    $role = "employee";
    if (isset($_POST['role'])) {
        $role = $_POST['role'];
    }
    if(isset($_FILES['profileimg']))
    {
        echo "<pre>";
	print_r($_FILES['profileimg']);
	echo "</pre>";
    }
    if ($_SESSION['user_name'] == $user_name || $_SESSION['role'] == "admin") {
        $sql = "SELECT * FROM `employees` WHERE `user_name` = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $user_name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $sql = "UPDATE `employees` SET `name` = :name, `email` = :email, `phone` = :phone, `about` = :about, `role` = :role WHERE `user_name` = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":id", $user_name);
        $stmt->bindParam(":about", $about);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
        echo "<script>alert('Profile Updated Successfully');</script>";
        echo "<script>window.location.href='profile.php?user_name=$user_name';</script>";
    }
}
