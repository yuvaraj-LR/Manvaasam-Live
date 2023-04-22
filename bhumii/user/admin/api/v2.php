<?php

session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
ini_set('log_errors', true);
ini_set('error_log', './php-error.log');
include("./config.php");

$keyId = 'rzp_live_PnH6hXuq0ds6JA';
$keySecret = '1uuH5tmj6QJg4L8dVEB4B72i';

$displayCurrency = 'INR';


$db = new Connection();
$conn = $db->getConnection();
$json["data"] = [];
$json["error"] = array("code" => "#200", "description" => "Success.");

error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('Asia/Calcutta');

$emailRegex  =  '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
$phoneRegex  =  '/^[0-9]{10}$/';
$nameRegex   =  '/^[a-zA-Z ]{2,30}$/';


function sendGCM($title, $message, $id)
{
    $serverKey = 'AAAAel_rNa0:APA91bHHyhQFwHQKe7vG-z1WTeatPPFEdyRBk9YHlwHsx72LoeQ34K3_1YG9rlQlLaWf4fKyBujaDBXlcw1SNU3FuYsTEIpbg_wFRCaL9dD4xsVXNEvfKE82iLFAyPi1s0nJEknsfigM';
    $serverKey = '';
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
        'registration_ids' => $id,
        'data' => array(
            "title" => $title,
            "message" => $message,
        )
    );
    $fields = json_encode($fields);
    $headers = array(
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (isset($_REQUEST["mode"])) {
    $mode = $_REQUEST["mode"];
    if ($mode == 'login') {
        if (isset($_REQUEST["email"]) && isset($_REQUEST["password"])) {
            try {
                $email = trim(htmlspecialchars($_REQUEST["email"]));
                $password = trim(htmlspecialchars($_REQUEST["password"]));
                $regid = trim(htmlspecialchars($_REQUEST["regid"] ?? ""));
                if (trim($email) == "" || trim($password) == "") {
                    $json["error"] = array("code" => "#400", "description" => "Please enter email and password.");
                    echo json_encode($json);
                    exit;
                }
                if (strlen($password) < 5) {
                    $json["error"] = array("code" => "#400", "description" => "Password must be at least 5 characters.");
                    echo json_encode($json);
                    exit;
                }
                $sql = "SELECT * FROM users WHERE (email = :email OR username = :username OR phone = :phone) AND password = :password";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":username", $email);
                $stmt->bindParam(":phone", $email);
                $stmt->bindParam(":password", $password);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if (count($result) > 0) {
                    $id = $result[0]["id"];
                    $sql = "UPDATE users SET regid = :regid WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":regid", $regid);
                    $stmt->bindParam(":id", $id);
                    $stmt->execute();
                    $token = getSessionToken($conn, $result[0]['email'], $id);
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                    $json["data"] = array(
                        "token" => $token,
                        "id" => $id,
                        "username" => $result[0]["username"],
                        "phone" => $result[0]["phone"],
                        "photo" => $result[0]["photo"],
                        "name" => $result[0]["fullname"],
                        "email" => $result[0]["email"],
                        "role" => $result[0]["role"],
                        "pro" => $result[0]["pro"],
                        "about" => $result[0]["about"],
                        "website" => $result[0]["website"],
                        "country" => $result[0]["country"],
                        "skills" => explode(",", $result[0]["skills"] ?? ""),
                        "created_at" => strtotime($result[0]["created_at"]) * 1000,
                    );
                    for ($k = 0; $k < count($json['data']['skills']); $k++) {
                        if ($json['data']['skills'][$k] == "") {
                            unset($json['data']['skills'][$k]);
                        }
                    }
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $result[0]["email"];
                    $_SESSION['fullname'] = $result[0]["fullname"];
                    $_SESSION['username'] = $result[0]["username"];
                    $_SESSION['email'] = $result[0]["email"];
                    $_SESSION['role'] = $result[0]["role"];
                    $_SESSION['token'] = $token;
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                } else {
                    $json["error"] = array("code" => "#400", "description" => "Invalid email or password.");
                }
            } catch (Exception $e) {
                $json["error"] = array("code" => "#500", "description" => $e->getMessage());
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "email and password are required.");
        }
    } else if ($mode == 'forgotpass') {
        if (isset($_REQUEST['username'])) {
            $username = trim(htmlspecialchars($_REQUEST['username']));
            $sql = "SELECT * FROM users WHERE username = :username OR email = :email1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email1", $username);
            $stmt->execute();
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                $username = $result[0]["username"];
                $email = $result[0]["email"];
                $sql = "DELETE FROM forgot_password WHERE username = :username";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":username", $username);
                $stmt->execute();
                $token = uniqid() . md5(time()) . rand(0, 9999);
                $created_at = date("Y-m-d H:i:s");
                $sql = "INSERT INTO forgot_password (username, email, token, created_at) VALUES (:username, :email, :token, :created_at)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":token", $token);
                $stmt->bindParam(":created_at", $created_at);
                $stmt->execute();
                $json["error"] = array("code" => "#200", "description" => "Success.");
                $json["data"] = array(
                    "username" => $result[0]["username"],
                    "created_at" => strtotime($created_at) * 1000,
                );
                $subject = "Forgot Password";
                $message = "Hi " . $result[0]["fullname"] . ",<br/><br/>";
                $message .= "You have requested to reset your password. Please click the link below to reset your password:<br/><br/>";
                $message .= "<a href='https://manvaasam.com/admin/forgotpass.php?token=" . $token . "'>https://manvaasam.com/admin/forgotpass.php?token=" . $token . "</a><br/><br/>";
                $message .= "If you did not request to reset your password, please ignore this email.<br/><br/>";
                $message .= "Regards,<br/>";
                $message .= "Team Manvaasam";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: no-reply@manvaasam.com\r\n";
                mail($email, $subject, $message, $headers);
            } else {
                $json["error"] = array("code" => "#400", "description" => "The username or email is not registered.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Please fill all fields.");
        }
    } else if ($mode == 'adminlogin') {
        if (isset($_REQUEST["email"]) && isset($_REQUEST["password"])) {
            try {
                $email = trim(htmlspecialchars($_REQUEST["email"]));
                $password = trim(htmlspecialchars($_REQUEST["password"]));
                $regid = trim(htmlspecialchars($_REQUEST["regid"] ?? ""));
                if (trim($email) == "" || trim($password) == "") {
                    $json["error"] = array("code" => "#400", "description" => "Please enter email and password.");
                    echo json_encode($json);
                    exit;
                }
                if (strlen($password) < 5) {
                    $json["error"] = array("code" => "#400", "description" => "Password must be at least 5 characters.");
                    echo json_encode($json);
                    exit;
                }
                $sql = "SELECT * FROM users WHERE (email = :email OR username = :username) AND password = :password AND role = 'admin'";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":username", $email);
                $stmt->bindParam(":password", $password);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if (count($result) > 0) {
                    $id = $result[0]["id"];
                    $sql = "UPDATE users SET regid = :regid WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":regid", $regid);
                    $stmt->bindParam(":id", $id);
                    $stmt->execute();
                    $token = getSessionToken($conn, $result[0]['email'], $id);
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                    $json["data"] = array(
                        "token" => $token,
                        "id" => $id,
                        "username" => $result[0]["username"],
                        "photo" => $result[0]["photo"],
                        "name" => $result[0]["fullname"],
                        "email" => $result[0]["email"],
                        "role" => $result[0]["role"],
                        "pro" => $result[0]["pro"],
                        "about" => $result[0]["about"],
                        "website" => $result[0]["website"],
                        "country" => $result[0]["country"],
                        "skills" => explode(",", $result[0]["skills"] ?? ""),
                        "created_at" => strtotime($result[0]["created_at"]) * 1000,
                    );
                    for ($k = 0; $k < count($json['data']['skills']); $k++) {
                        if ($json['data']['skills'][$k] == "") {
                            unset($json['data']['skills'][$k]);
                        }
                    }
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $result[0]["email"];
                    $_SESSION['fullname'] = $result[0]["fullname"];
                    $_SESSION['username'] = $result[0]["username"];
                    $_SESSION['email'] = $result[0]["email"];
                    $_SESSION['role'] = $result[0]["role"];
                    $_SESSION['token'] = $token;
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                } else {
                    $json["error"] = array("code" => "#400", "description" => "Invalid email or password.");
                }
            } catch (Exception $e) {
                $json["error"] = array("code" => "#500", "description" => $e->getMessage());
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "email and password are required.");
        }
    } else if ($mode == 'register') {
        if (isset($_REQUEST["email"]) && isset($_REQUEST["phone"]) && isset($_REQUEST["password"]) && isset($_REQUEST["fullname"])) {
            try {
                $email = trim(htmlspecialchars($_REQUEST["email"]));
                $password = trim(htmlspecialchars($_REQUEST["password"]));
                $fullname = trim(htmlspecialchars($_REQUEST["fullname"]));
                $phone = trim(htmlspecialchars($_REQUEST["phone"]));
                $regid = trim(htmlspecialchars($_REQUEST["regid"] ?? ""));
                if (trim($email) == "" || trim($password) == "" || trim($fullname) == "") {
                    $json["error"] = array("code" => "#400", "description" => "Please fill all fields.");
                    echo json_encode($json);
                    exit;
                }
                if (!preg_match($emailRegex, $email)) {
                    $json["error"] = array("code" => "#400", "description" => "Invalid email.");
                    echo json_encode($json);
                    exit;
                }
                if (strlen($password) < 6) {
                    $json["error"] = array("code" => "#400", "description" => "Password must be at least 6 characters.");
                    echo json_encode($json);
                    exit;
                }
                if (!preg_match($nameRegex, $fullname)) {
                    $json["error"] = array("code" => "#400", "description" => "Invalid name.");
                    echo json_encode($json);
                    exit;
                }
                if (!preg_match($phoneRegex, $phone)) {
                    $json["error"] = array("code" => "#400", "description" => "Invalid phone number.");
                    echo json_encode($json);
                    exit;
                }
                $username = explode("@", $email)[0] . "_" . rand(0, 9999);
                $role = "user";
                $created_at = date("Y-m-d H:i:s");
                $updated_at = date("Y-m-d H:i:s");
                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if (count($result) == 0) {
                    $sql = "INSERT INTO users (email, phone, password, fullname, username, role,created_at,updated_at,regid) VALUES (:email, :phone, :password, :fullname, :username, :role, :created_at, :updated_at, :regid)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":phone", $phone);
                    $stmt->bindParam(":password", $password);
                    $stmt->bindParam(":fullname", $fullname);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":role", $role);
                    $stmt->bindParam(":created_at", $created_at);
                    $stmt->bindParam(":updated_at", $updated_at);
                    $stmt->bindParam(":regid", $regid);
                    $stmt->execute();
                    $id = $conn->lastInsertId();
                    $token = getSessionToken($conn, $email, $id);
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;
                    $_SESSION['token'] = $token;
                    $json["data"] = array(
                        "token" => $token,
                        "id" => $id,
                        "username" => $username,
                        "phone" => $phone,
                        "photo" => "",
                        "name" => $fullname,
                        "email" => $email,
                        "role" => $role,
                        "pro" => "0",
                        "about" => "",
                        "website" => "",
                        "country" => "",
                        "skills" => [],
                        "created_at" => strtotime($created_at) * 1000,
                    );
                    $json["error"] = array("code" => "#200", "description" => "Register success.");
                } else {
                    $json["error"] = array("code" => "#400", "description" => "Email already exists.");
                }
            } catch (Exception $e) {
                $json["error"] = array("code" => "#500", "description" => $e->getMessage());
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "email and password are required.");
        }
    } else if ($mode == 'refresh') {
        if (isset($_REQUEST['token']) && isset($_REQUEST['email'])) {
            $token = trim(htmlspecialchars($_REQUEST['token']));
            $email  = trim(htmlspecialchars($_REQUEST['email']));
            try {
                $regid = trim(htmlspecialchars($_REQUEST["regid"] ?? ""));
                $userAuth  = validateSessionToken($conn, $token, $email);
                if ($userAuth) {
                    $username  = $userAuth['username'];
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                    $sql = "UPDATE users SET regid = :regid WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":regid", $regid);
                    $stmt->bindParam(":id", $userAuth["id"]);
                    $stmt->execute();

                    $sql = "SELECT * FROM users WHERE email = :email";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":email", $email);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $json["data"] = array(
                        "token" => $token,
                        "id" => $result["id"],
                        "username" => $result["username"],
                        "photo" => $result["photo"],
                        "name" => $result["fullname"],
                        "email" => $result["email"],
                        "role" => $result["role"],
                        "pro" => $result["pro"],
                        "about" => $result["about"],
                        "website" => $result["website"],
                        "country" => $result["country"],
                        "skills" => explode(",", $result["skills"] ?? ""),
                        "created_at" => strtotime($result["created_at"]) * 1000,
                    );
                    for ($k = 0; $k < count($json['data']['skills']); $k++) {
                        if ($json['data']['skills'][$k] == "") {
                            unset($json['data']['skills'][$k]);
                        }
                    }
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['email'] = $result["email"];
                    $_SESSION['fullname'] = $result["fullname"];
                    $_SESSION['username'] = $result["username"];
                    $_SESSION['email'] = $result["email"];
                    $_SESSION['role'] = $result["role"];
                    $_SESSION['token'] = $token;
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                } else {
                    $sql = "SELECT * FROM users WHERE email = :email";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":email", $email);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    if (count($result) != 0) {
                        $token = getSessionToken($conn, $email, $result[0]["id"]);
                        $_SESSION['id'] = $result[0]['id'];
                        $_SESSION['email'] = $result[0]["email"];
                        $_SESSION['fullname'] = $result[0]["fullname"];
                        $_SESSION['username'] = $result[0]["username"];
                        $_SESSION['email'] = $result[0]["email"];
                        $_SESSION['role'] = $result[0]["role"];
                        $_SESSION['token'] = $token;
                        $json["data"] = array(
                            "token" => $token,
                            "id" => $result[0]["id"],
                            "username" => $result[0]["username"],
                            "photo" => $result[0]["photo"],
                            "name" => $result[0]["fullname"],
                            "email" => $result[0]["email"],
                            "role" => $result[0]["role"],
                            "pro" => $result[0]["pro"],
                            "about" => $result[0]["about"],
                            "website" => $result[0]["website"],
                            "country" => $result[0]["country"],
                            "skills" => explode(",", $result[0]["skills"] ?? ""),
                            "created_at" => strtotime($result[0]["created_at"]) * 1000,
                        );
                        for ($k = 0; $k < count($json['data']['skills']); $k++) {
                            if ($json['data']['skills'][$k] == "") {
                                unset($json['data']['skills'][$k]);
                            }
                        }
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                    } else {
                        $json["error"] = array("code" => "#400", "description" => "Invalid token.");
                    }
                }
            } catch (Exception $e) {
                $json["error"] = array("code" => "#500", "description" => $e->getMessage());
            }
        } else {
            $json["error"] = array("code" => "#401", "description" => "Invalid token.");
        }
    } else if ($mode == "glogin") {
        $json["error"] = array("code" => "#400", "description" => "Invalid request.");
        if (isset($_REQUEST["email"]) && isset($_REQUEST["name"]) && isset($_REQUEST["id"]) && isset($_REQUEST["photo"])) {
            try {
                $regid = trim(htmlspecialchars($_REQUEST["regid"] ?? ""));
                $created_at = date("Y-m-d H:i:s");
                $email = trim(htmlspecialchars($_REQUEST["email"]));
                $name = trim(htmlspecialchars($_REQUEST["name"]));
                $id = trim(htmlspecialchars($_REQUEST["id"]));
                $photo = trim(htmlspecialchars($_REQUEST["photo"]));
                if (trim($email) == ""  || trim($name) == "") {
                    $json["error"] = array("code" => "#400", "description" => "You must provide an email and name.");
                    echo json_encode($json);
                    exit;
                }
                $sql = "SELECT * FROM users WHERE email = :email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $result = $stmt->fetchAll();
                if (count($result) > 0) {
                    $id = $result[0]["id"];
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                    $token = getSessionToken($conn, $email, $id);
                    $sql = "UPDATE users SET photo = :photo,regid = :regid, updated_at = :updated_at WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":photo", $photo);
                    $stmt->bindParam(":regid", $regid);
                    $stmt->bindParam(":updated_at", $created_at);
                    $stmt->bindParam(":id", $id);
                    $stmt->execute();
                    $json["data"] = array(
                        "token" => $token,
                        "id" => $id,
                        "username" => $result[0]["username"],
                        "photo" => $photo,
                        "name" => $result[0]["fullname"],
                        "email" => $result[0]["email"],
                        "role" => $result[0]["role"],
                        "pro" => $result[0]["pro"],
                        "about" => $result[0]["about"],
                        "website" => $result[0]["website"],
                        "country" => $result[0]["country"],
                        "skills" => explode(",", $result[0]["skills"] ?? ""),
                        "created_at" => strtotime($result[0]["created_at"]) * 1000,
                    );
                    for ($k = 0; $k < count($json['data']['skills']); $k++) {
                        if ($json['data']['skills'][$k] == "") {
                            unset($json['data']['skills'][$k]);
                        }
                    }
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $result[0]["email"];
                    $_SESSION['fullname'] = $result[0]["fullname"];
                    $_SESSION['username'] = $result[0]["username"];
                    $_SESSION['email'] = $result[0]["email"];
                    $_SESSION['role'] = $result[0]["role"];
                    $_SESSION['token'] = $token;
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                } else {
                    $email = trim(htmlspecialchars($_REQUEST["email"]));
                    $password = uniqid();
                    $fullname = trim(htmlspecialchars($_REQUEST["name"]));
                    if (trim($email) == "" || trim($password) == "" || trim($fullname) == "") {
                        $json["error"] = array("code" => "#400", "description" => "Please fill all fields.");
                    } else {
                        $username = explode("@", $email)[0] . "_" . rand(0, 9999);
                        $role = "user";
                        $created_at = date("Y-m-d H:i:s");
                        $updated_at = date("Y-m-d H:i:s");

                        $sql = "INSERT INTO users (email, password, fullname, username, role, created_at,updated_at,photo,regid ) VALUES (:email, :password, :fullname, :username, :role, :created_at, :updated_at, :photo, :regid)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":email", $email);
                        $stmt->bindParam(":password", $password);
                        $stmt->bindParam(":fullname", $fullname);
                        $stmt->bindParam(":username", $username);
                        $stmt->bindParam(":role", $role);
                        $stmt->bindParam(":created_at", $created_at);
                        $stmt->bindParam(":updated_at", $updated_at);
                        $stmt->bindParam(":photo", $photo);
                        $stmt->bindParam(":regid", $regid);
                        $stmt->execute();
                        $id = $conn->lastInsertId();
                        $token = getSessionToken($conn, $email, $id);
                        $_SESSION['id'] = $id;
                        $_SESSION['email'] = $email;
                        $_SESSION['fullname'] = $fullname;
                        $_SESSION['username'] = $username;
                        $_SESSION['email'] = $email;
                        $_SESSION['role'] = $role;
                        $_SESSION['token'] = $token;
                        $json["data"] = array(
                            "token" => $token,
                            "id" => $id,
                            "photo" => $photo,
                            "username" => $username,
                            "name" => $fullname,
                            "email" => $email,
                            "role" => $role,
                            "pro" => "0",
                            "created_at" => strtotime($created_at) * 1000,
                            "about" => "",
                            "website" => "",
                            "country" => "",
                            "skills" => [],
                        );
                        $json["error"] = array("code" => "#200", "description" => "Register success.");
                    }
                }
            } catch (Exception $e) {
                $json["error"] = array("code" => "#500", "description" => $e->getMessage());
            }
        }
    } else if ($mode == "addcourse") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["category"]) && isset($_REQUEST["price"]) && isset($_REQUEST["content"]) && isset($_REQUEST["author"]) && isset($_REQUEST["images"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $name = $_REQUEST["name"];
                        $category = $_REQUEST["category"];
                        $content = $_REQUEST["content"];
                        $author = $_REQUEST["author"];
                        $price = $_REQUEST["price"];
                        $images = $_REQUEST["images"];
                        $link = $_REQUEST["payment"];
                        $name = htmlspecialchars($name);
                        $category = htmlspecialchars($category);
                        $content = htmlspecialchars($content);
                        $author = htmlspecialchars($author);
                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $status = "public";
                        $downloads = 0;
                        $created_at = date("Y-m-d H:i:s");
                        $sql = "INSERT INTO course (status, title, link, category, content, author, created_at, updated_at,images,price) VALUES (:status, :title, :link, :category, :content, :author, :created_at, :updated_at,:images,:price)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":link", $link);
                        $stmt->bindParam(":category", $category);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":author", $author);
                        $stmt->bindParam(":created_at", $created_at);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->bindParam(":images", $images);
                        $stmt->bindParam(":price", $price);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");

                        $regids = array();
                        $sql = "SELECT regid FROM users WHERE regid != ''";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $regids[] = $row["regid"];
                        }
                        sendGCM($name, "New Course uploaded", $regids);
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "editcourse") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["category"]) && isset($_REQUEST["price"]) && isset($_REQUEST["content"]) && isset($_REQUEST["author"]) && isset($_REQUEST["images"]) && isset($_REQUEST["courseid"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $name = $_REQUEST["name"];
                        $category = $_REQUEST["category"];
                        $content = $_REQUEST["content"];
                        $author = $_REQUEST["author"];
                        $price = $_REQUEST["price"];
                        $images = $_REQUEST["images"];
                        $status = $_REQUEST["status"] ?? "public";
                        $courseid = $_REQUEST["courseid"];
                        $link = $_REQUEST["payment"];
                        $name = htmlspecialchars($name);
                        $category = htmlspecialchars($category);
                        $content = htmlspecialchars($content);
                        $author = htmlspecialchars($author);
                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $status = "public";
                        $downloads = 0;
                        $created_at = date("Y-m-d H:i:s");

                        $sql = "UPDATE course SET title = :title,  link = :payment,  status = :status, category = :category, content = :content, author = :author, updated_at = :updated_at, images = :images, price = :price WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":payment", $link);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":category", $category);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":author", $author);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->bindParam(":images", $images);
                        $stmt->bindParam(":price", $price);
                        $stmt->bindParam(":id", $courseid);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                        $regids = array();
                        $sql = "SELECT regid FROM users WHERE regid != ''";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $regids[] = $row["regid"];
                        }
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "deletecourse") {
        $courseid = $_REQUEST["courseid"];
        $sql = "UPDATE course SET status = :status1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $status = "deleted";
        $stmt->bindParam(":status1", $status);
        $stmt->bindParam(":id", $courseid);
        $stmt->execute();
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $regids = array();
    } else if ($mode == "addClass") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["category"]) && isset($_REQUEST["content"]) && isset($_REQUEST["author"]) && isset($_REQUEST["images"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $name = $_REQUEST["name"];
                        $category = $_REQUEST["category"];
                        $content = $_REQUEST["content"];
                        $author = $_REQUEST["author"];
                        $price = $_REQUEST["price"];
                        $images = $_REQUEST["images"];
                        $link = $_REQUEST["payment"];
                        $youtube = $_REQUEST["youtube"];

                        $name = htmlspecialchars($name);
                        $category = htmlspecialchars($category);
                        $content = htmlspecialchars($content);
                        $author = htmlspecialchars($author);
                        $youtube = htmlspecialchars($youtube);
                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $status = "public";
                        $downloads = 0;
                        $created_at = date("Y-m-d H:i:s");
                        // https://www.youtube.com/watch?v=9bZkp7q19f0
                        $youtubeRegexp = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/';

                        $sql = "INSERT INTO class (status, title, link, category, content, author, created_at, updated_at,images,price,youtube) VALUES (:status, :title, :payment, :category, :content, :author, :created_at, :updated_at, :images, :price, :youtube)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":payment", $link);
                        $stmt->bindParam(":category", $category);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":author", $author);
                        $stmt->bindParam(":created_at", $created_at);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->bindParam(":images", $images);
                        $stmt->bindParam(":price", $price);
                        $stmt->bindParam(":youtube", $youtube);

                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");

                        $regids = array();
                        $sql = "SELECT regid FROM users WHERE regid != ''";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $regids[] = $row["regid"];
                        }
                        sendGCM($name, "New class uploaded", $regids);
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "editClass") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["category"]) && isset($_REQUEST["price"]) && isset($_REQUEST["content"]) && isset($_REQUEST["author"]) && isset($_REQUEST["images"]) && isset($_REQUEST["youtube"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $name = $_REQUEST["name"];
                        $category = $_REQUEST["category"];
                        $content = $_REQUEST["content"];
                        $author = $_REQUEST["author"];
                        $price = $_REQUEST["price"];
                        $images = $_REQUEST["images"];
                        $link = $_REQUEST["payment"];
                        $youtube = $_REQUEST["youtube"];
                        $classid = $_REQUEST["classid"];

                        $name = htmlspecialchars($name);
                        $category = htmlspecialchars($category);
                        $content = htmlspecialchars($content);
                        $author = htmlspecialchars($author);
                        $youtube = htmlspecialchars($youtube);
                        $status = "public";
                        $downloads = 0;
                        $created_at = date("Y-m-d H:i:s");
                        // https://www.youtube.com/watch?v=9bZkp7q19f0
                        $youtubeRegexp = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/';

                        $sql = "UPDATE class SET status = :status, title = :title, link = :payment, category = :category, content = :content, author = :author, updated_at = :updated_at, images = :images, price = :price, youtube = :youtube WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":payment", $link);
                        $stmt->bindParam(":category", $category);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":author", $author);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->bindParam(":images", $images);
                        $stmt->bindParam(":price", $price);
                        $stmt->bindParam(":youtube", $youtube);
                        $stmt->bindParam(":id", $classid);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "deleteclass") {
        $classid = $_REQUEST["classid"];
        $sql = "UPDATE class SET status = :status1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $status = "deleted";
        $stmt->bindParam(":status1", $status);
        $stmt->bindParam(":id", $classid);
        $stmt->execute();
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $regids = array();
    } else if ($mode == "addlesson") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["content"]) && isset($_REQUEST["youtube"]) && isset($_REQUEST["classid"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $name = $_REQUEST["name"];
                        $content = $_REQUEST["content"];
                        $youtube = $_REQUEST["youtube"];
                        $classid = $_REQUEST["classid"];
                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $status = "public";
                        $downloads = 0;
                        $created_at = date("Y-m-d H:i:s");
                        // https://www.youtube.com/watch?v=9bZkp7q19f0
                        $youtubeRegexp = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/';
                        
                        $sql = "INSERT INTO lesson (status, title, content, created_at, classid, youtube) VALUES (:status, :title, :content, :created_at, :classid, :youtube)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":created_at", $created_at);
                        $stmt->bindParam(":classid", $classid);
                        $stmt->bindParam(":youtube", $youtube);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");

                        $regids = array();
                        $sql = "SELECT regid FROM users WHERE regid != ''";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $regids[] = $row["regid"];
                        }
                        sendGCM($name, "New class uploaded", $regids);
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "editlesson") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["content"]) && isset($_REQUEST["youtube"]) && isset($_REQUEST["lessonid"]) && isset($_REQUEST["classid"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $name = $_REQUEST["name"];
                        $content = $_REQUEST["content"];
                        $youtube = $_REQUEST["youtube"];
                        $lessonid = $_REQUEST["lessonid"];
                        $classid = $_REQUEST["classid"];
                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $status = "public";
                        $downloads = 0;
                        $created_at = date("Y-m-d H:i:s");
                        // https://www.youtube.com/watch?v=9bZkp7q19f0
                        $youtubeRegexp = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/';

                        $sql = "UPDATE lesson SET title = :title, content = :content, youtube = :youtube, classid = :classid WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":youtube", $youtube);
                        $stmt->bindParam(":classid", $classid);
                        $stmt->bindParam(":id", $lessonid);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "deletelesson") {
        $classid = $_REQUEST["lessonid"];
        $sql = "UPDATE lesson SET status = :status1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":status1", $status1);
        $stmt->bindParam(":id", $classid);
        $stmt->execute();
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $regids = array();
    } else if ($mode == "addevent") {
        if (isset($_REQUEST["title"]) && isset($_REQUEST["content"]) && isset($_REQUEST["images"]) && isset($_REQUEST["payment"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $title = $_REQUEST["title"];
                        $content = $_REQUEST["content"];
                        $images = $_REQUEST["images"];
                        $payment = $_REQUEST["payment"];
                        $date  = $_REQUEST["date"];
                        $title = htmlspecialchars($title);
                        $content = htmlspecialchars($content);
                        $date = htmlspecialchars($date);
                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $created_at = date("Y-m-d H:i:s");
                        $status = "public";
                        $created_at = date("Y-m-d H:i:s");
                        $sql = "INSERT INTO event (id, title,status, content, images, payment, date, created_at, updated_at) VALUES (:id, :title, :status, :content, :images, :payment, :date, :created_at, :updated_at)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":id", $id);
                        $stmt->bindParam(":title", $title);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":images", $images);
                        $stmt->bindParam(":payment", $payment);
                        $stmt->bindParam(":date", $date);
                        $stmt->bindParam(":created_at", $created_at);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                        $regids = array();
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "editevent") {
        if (isset($_REQUEST["title"]) && isset($_REQUEST["content"]) && isset($_REQUEST["images"]) && isset($_REQUEST["payment"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $title = $_REQUEST["title"];
                        $content = $_REQUEST["content"];
                        $images = $_REQUEST["images"];
                        $payment = $_REQUEST["payment"];
                        $id = $_REQUEST["eventid"];
                        $status = $_REQUEST['status'];
                        $date  = $_REQUEST["date"];
                        $title = htmlspecialchars($title);
                        $status = htmlspecialchars($status);
                        $content = htmlspecialchars($content);
                        $payment = htmlspecialchars($payment);
                        $date = htmlspecialchars($date);
                        $created_at  = date("Y-m-d H:i:s");
                        $sql = "UPDATE event SET title = :title, content = :content, images = :images,status = :status, payment = :payment, date = :date, updated_at = :updated_at WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":title", $title);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":images", $images);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":payment", $payment);
                        $stmt->bindParam(":date", $date);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->bindParam(":id", $id);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "deleteevent") {
        $eventid = $_REQUEST["eventid"];
        $sql = "UPDATE event SET status = :status1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $status = "deleted";
        $stmt->bindParam(":status1", $status);
        $stmt->bindParam(":id", $eventid);
        $stmt->execute();
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $regids = array();
    } else if ($mode == "addjob") {
        if (isset($_REQUEST["title"]) && isset($_REQUEST["knowledge"]) && isset($_REQUEST["expirience"]) && isset($_REQUEST["salary"]) && isset($_REQUEST["location"]) && isset($_REQUEST["content"]) && isset($_REQUEST["registerlink"]) && isset($_REQUEST["contactperson"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $title = $_REQUEST["title"];
                        $knowledge = $_REQUEST["knowledge"];
                        $expirience = $_REQUEST["expirience"];
                        $salary = $_REQUEST["salary"];
                        $location = $_REQUEST["location"];
                        $content = $_REQUEST["content"];
                        $registerlink = $_REQUEST["registerlink"];
                        $contactperson = $_REQUEST["contactperson"];
                        $title = htmlspecialchars($title);
                        $knowledge = htmlspecialchars($knowledge);
                        $expirience = htmlspecialchars($expirience);
                        $salary = htmlspecialchars($salary);
                        $location = htmlspecialchars($location);
                        $description = htmlspecialchars($content);
                        $registerlink = htmlspecialchars($registerlink);
                        $contactperson = htmlspecialchars($contactperson);

                        $id = time() . "_" . substr(uniqid(), 0, 10);
                        $status = "public";
                        $created_at = date("Y-m-d H:i:s");
                        $sql = "INSERT INTO job (status, title, knowledge, expirience, salary, location, description, registerlink, contactperson, created_at, updated_at) VALUES (:status, :title, :knowledge, :expirience, :salary, :location, :description, :registerlink, :contactperson, :created_at, :updated_at)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":title", $title);
                        $stmt->bindParam(":knowledge", $knowledge);
                        $stmt->bindParam(":expirience", $expirience);
                        $stmt->bindParam(":salary", $salary);
                        $stmt->bindParam(":location", $location);
                        $stmt->bindParam(":description", $description);
                        $stmt->bindParam(":registerlink", $registerlink);
                        $stmt->bindParam(":contactperson", $contactperson);
                        $stmt->bindParam(":created_at", $created_at);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");

                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "editjob") {
        if (isset($_REQUEST["title"]) && isset($_REQUEST["knowledge"]) && isset($_REQUEST["expirience"]) && isset($_REQUEST["salary"]) && isset($_REQUEST["location"]) && isset($_REQUEST["content"]) && isset($_REQUEST["registerlink"]) && isset($_REQUEST["contactperson"])) {
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                $fullname = $_SESSION['fullname'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $title = $_REQUEST["title"];
                        $knowledge = $_REQUEST["knowledge"];
                        $expirience = $_REQUEST["expirience"];
                        $salary = $_REQUEST["salary"];
                        $location = $_REQUEST["location"];
                        $content = $_REQUEST["content"];
                        $registerlink = $_REQUEST["registerlink"];
                        $contactperson = $_REQUEST["contactperson"];
                        $status = $_REQUEST["status"];
                        $id = $_REQUEST["jobid"];
                        $title = htmlspecialchars($title);
                        $knowledge = htmlspecialchars($knowledge);
                        $expirience = htmlspecialchars($expirience);
                        $salary = htmlspecialchars($salary);
                        $location = htmlspecialchars($location);
                        $description = htmlspecialchars($content);
                        $registerlink = htmlspecialchars($registerlink);
                        $contactperson = htmlspecialchars($contactperson);
                        $status = htmlspecialchars($status);
                        $id = htmlspecialchars($id);

                        $status = "public";
                        $created_at = date("Y-m-d H:i:s");
                        $sql = "UPDATE job SET title = :title, knowledge = :knowledge, expirience = :expirience, salary = :salary, status = :status, location = :location, description = :description, registerlink = :registerlink, contactperson = :contactperson, updated_at = :updated_at WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":title", $title);
                        $stmt->bindParam(":knowledge", $knowledge);
                        $stmt->bindParam(":expirience", $expirience);
                        $stmt->bindParam(":salary", $salary);
                        $stmt->bindParam(":location", $location);
                        $stmt->bindParam(":description", $description);
                        $stmt->bindParam(":registerlink", $registerlink);
                        $stmt->bindParam(":contactperson", $contactperson);
                        $stmt->bindParam(":updated_at", $created_at);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":id", $id);
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");

                        // $regids = array();
                        // $sql = "SELECT regid FROM users WHERE regid != ''";
                        // $stmt = $conn->prepare($sql);
                        // $stmt->execute();
                        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        // foreach ($result as $row) {
                        //     $regids[] = $row["regid"];
                        // }
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "deletejob") {
        $jobid = $_REQUEST["jobid"];
        $sql = "UPDATE job SET status = :status1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $status = "deleted";
        $stmt->bindParam(":status1", $status);
        $stmt->bindParam(":id", $jobid);
        $stmt->execute();
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $regids = array();
    } else if ($mode == "getcourses") {
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $sql = "SELECT * FROM course WHERE status='public' ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $json["data"] = array();
        foreach ($result as $row) {
            $keyswords = explode(',', $row['category']);
            $images = $row['images'];
            if (strpos($images, ',') == true) {
                $images = explode(",", $images);
            } else {
                $images = array(
                    $images
                );
            }
            $json["data"][] = array(
                "id" => $row["id"],
                "title" => $row["title"],
                "images" => $images,
                "category" => $keyswords,
                "author" => $row["author"],
                "price" => $row["price"] ?? "0",
                "link" => $row["link"] ?? "",
                "created_at" => strtotime($row["created_at"]) * 1000,
                "content" => htmlspecialchars_decode($row["content"]),
            );
        }
    } else if ($mode == "addbook") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["category"]) && isset($_REQUEST["content"]) && isset($_REQUEST["author"])) {
            if (isset($_FILES['pdf'])) {
                if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                    $authId = $_SESSION['token'];
                    $username = $_SESSION['email'];
                    $fullname = $_SESSION['fullname'];
                    try {
                        $userAuth  = validateSessionToken($conn, $authId, $username);
                        if ($userAuth) {
                            $name = $_REQUEST["name"];
                            $category = $_REQUEST["category"];
                            $content = $_REQUEST["content"];
                            $author = $_REQUEST["author"];
                            $name = htmlspecialchars($name);
                            $category = htmlspecialchars($category);
                            $content = htmlspecialchars($content);
                            $author = htmlspecialchars($author);
                            $id = time() . "_" . substr(uniqid(), 0, 10);
                            $pdf = $_FILES['pdf'];
                            $pdfName = $id . ".pdf";
                            $pdfPath = $uploadsDirectory . "pdf/" . $pdfName;
                            $status = "public";
                            $created_at = date("Y-m-d H:i:s");
                            move_uploaded_file($pdf["tmp_name"], $pdfPath);
                            $pdfSize = filesize($pdfPath);

                            $sql = "INSERT INTO books (size, status, title, category, content, author, pdf, created_at, updated_at) VALUES (:size, :status,  :title, :category, :content, :author, :pdf, :created_at, :updated_at)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(":size", $pdfSize);
                            $stmt->bindParam(":status", $status);
                            $stmt->bindParam(":title", $name);
                            $stmt->bindParam(":category", $category);
                            $stmt->bindParam(":content", $content);
                            $stmt->bindParam(":author", $author);
                            $stmt->bindParam(":pdf", $pdfName);
                            $stmt->bindParam(":created_at", $created_at);
                            $stmt->bindParam(":updated_at", $created_at);
                            $stmt->execute();

                            $img = new imagick();
                            $img->setResolution(300, 300);
                            $img->readImage($pdfPath . "[0]");
                            $img->setImageFormat('jpeg');
                            $img->setImageCompression(Imagick::COMPRESSION_JPEG);
                            $img->setImageCompressionQuality(40);
                            $thumbnailPath = $uploadsDirectory . "thumbnails/" . $pdfName . ".jpg";
                            $img->writeImage($thumbnailPath);
                            $img->destroy();

                            $json["error"] = array("code" => "#200", "description" => "Success.");
                        } else {
                            $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                        }
                    } catch (Exception $e) {
                        $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                    }
                } else {
                    $json["error"] = array("code" => "#600", "description" => "Session expired.");
                }
            } else {
                $json["error"] = array("code" => "#400", "description" => "PDF file is required.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "editbook") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["category"]) && isset($_REQUEST["content"]) && isset($_REQUEST["author"]) && isset($_REQUEST["id"]) && isset($_REQUEST["status"])) {
            $pdfName = "";
            if (isset($_FILES['pdf'])) {
                $id = time() . "_" . substr(uniqid(), 0, 10);
                $pdf = $_FILES['pdf'];
                $pdfName = $id . ".pdf";
                $pdfPath = $uploadsDirectory . "pdf/" . $pdfName;
                move_uploaded_file($pdf["tmp_name"], $pdfPath);
                $fileSize = filesize($pdfPath);
                // get first page of pdf as image
                $img = new imagick();
                $img->setResolution(300, 300);
                $img->readImage($pdfPath . "[0]");
                $img->setImageFormat('jpeg');
                $img->setImageCompression(Imagick::COMPRESSION_JPEG);
                $img->setImageCompressionQuality(40);
                $thumbnailPath = $uploadsDirectory . "thumbnails/" . $pdfName . ".jpg";
                $img->writeImage($thumbnailPath);
                $img->destroy();
            }
            if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
                $authId = $_SESSION['token'];
                $username = $_SESSION['email'];
                try {
                    $userAuth  = validateSessionToken($conn, $authId, $username);
                    if ($userAuth) {
                        $id = $_REQUEST["id"];
                        $name = $_REQUEST["name"];
                        $category = $_REQUEST["category"];
                        $content = $_REQUEST["content"];
                        $author = $_REQUEST["author"];
                        $status = $_REQUEST["status"];
                        $name = htmlspecialchars($name);
                        $category = htmlspecialchars($category);
                        $content = htmlspecialchars($content);
                        $author = htmlspecialchars($author);
                        $status = htmlspecialchars($status);
                        $updated_at = date("Y-m-d H:i:s");
                        $sql = "UPDATE books SET 
                                title = :title,
                                category = :category,
                                content = :content,
                                author = :author,
                                status = :status,
                                updated_at = :updated_at";
                        if ($pdfName != "") {
                            $sql .= ", pdf = :pdf";
                            $sql .= ", size = :size";
                        }
                        $sql .= " WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(":id", $id);
                        $stmt->bindParam(":title", $name);
                        $stmt->bindParam(":category", $category);
                        $stmt->bindParam(":content", $content);
                        $stmt->bindParam(":author", $author);
                        $stmt->bindParam(":status", $status);
                        $stmt->bindParam(":updated_at", $updated_at);
                        if ($pdfName != "") {
                            $stmt->bindParam(":pdf", $pdfName);
                            $stmt->bindParam(":size", $fileSize);
                        }
                        $stmt->execute();
                        $json["error"] = array("code" => "#200", "description" => "Success.");
                    } else {
                        $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
                    }
                } catch (Exception $e) {
                    $json["error"] = array("code" => "#500", "description" => $e->getMessage());
                }
            } else {
                $json["error"] = array("code" => "#600", "description" => "Session expired.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "deletebook") {
        $bookid = $_REQUEST["bookid"];
        $sql = "UPDATE books SET status = :status1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $status = "deleted";
        $stmt->bindParam(":status1", $status);
        $stmt->bindParam(":id", $bookid);
        $stmt->execute();
        $json["error"] = array("code" => "#200", "description" => "Success.");
        $regids = array();
    } else if ($mode == "contactMessage") {
        if (isset($_REQUEST["name"]) && isset($_REQUEST["email"]) && isset($_REQUEST["message"]) && isset($_REQUEST["phone"])) {
            $nameRegex = "/^[a-zA-Z ]*$/";
            $emailRegex = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/";
            $phoneRegex = "/^[0-9]{10}$/";
            try {
                $name = $_REQUEST["name"] ?? "";
                $email = trim($_REQUEST["email"] ?? "");
                $message = $_REQUEST["message"] ?? "";
                $priority = $_REQUEST["priority"] ?? "";
                $contactmode = $_REQUEST["contactmode"] ?? "";
                $type = $_REQUEST["type"] ?? "";
                $phone = $_REQUEST["phone"] ?? "";
                if ($name == "" || $email == "" || $message == "" || $phone == "") {
                    $json["error"] = array("code" => "#400", "description" => "Name, email, phone and message are required.");
                } else if (!preg_match($emailRegex, $email)) {
                    $json["error"] = array("code" => "#400", "description" => "Invalid email.");
                } else if (!preg_match($phoneRegex, $phone)) {
                    $json["error"] = array("code" => "#400", "description" => "Invalid phone.");
                } else {
                    if (isset($_SESSION["fullname"])) {
                        $name = $_SESSION["fullname"];
                    }
                    if (isset($_SESSION["email"])) {
                        $email = $_SESSION["email"];
                    }
                    if (!preg_match($emailRegex, $email)) {
                        $json["error"] = array("code" => "#400", "description" => "Invalid email.");
                        echo json_encode($json);
                        exit;
                    }
                    if (!preg_match($phoneRegex, $phone)) {
                        $json["error"] = array("code" => "#400", "description" => "Invalid phone number.");
                        echo json_encode($json);
                        exit;
                    }
                    $name = htmlspecialchars($name);
                    $email = htmlspecialchars($email);
                    $message = htmlspecialchars($message);
                    $created_at = date("Y-m-d H:i:s");
                    $status = "opened";
                    $sql = "INSERT INTO messages (name, email, message, priority, contactmode, phone, type, created_at, status) VALUES (:name, :email, :message, :priority, :contactmode, :phone, :type, :created_at, :status)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":name", $name);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":message", $message);
                    $stmt->bindParam(":priority", $priority);
                    $stmt->bindParam(":contactmode", $contactmode);
                    $stmt->bindParam(":phone", $phone);
                    $stmt->bindParam(":type", $type);
                    $stmt->bindParam(":created_at", $created_at);
                    $stmt->bindParam(":status", $status);
                    $stmt->execute();

                    $sql = "SELECT regid FROM users WHERE role = 'admin'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $regids = array();
                    foreach ($result as $row) {
                        $regids[] = $row["regid"];
                    }
                    sendGCM("New message from " . $name, $message, $regids);
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                }
            } catch (Exception $e) {
                $json["error"] = array("code" => "#500", "description" => $e->getMessage());
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Username and password are required.");
        }
    } else if ($mode == "closeMessage") {
        $id = $_REQUEST["id"] ?? "";
        if ($id == "") {
            $json["error"] = array("code" => "#400", "description" => "Invalid request.");
        } else {
            $sql = "UPDATE messages SET status = 'closed' WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $json["error"] = array("code" => "#200", "description" => "Success.");
        }
    } else if ($mode == "openMessage") {
        $id = $_REQUEST["id"] ?? "";
        if ($id == "") {
            $json["error"] = array("code" => "#400", "description" => "Invalid request.");
        } else {
            $sql = "UPDATE messages SET status = 'opened' WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $json["error"] = array("code" => "#200", "description" => "Success.");
        }
    } else if ($mode == "deleteMessage") {
        $id = $_REQUEST["id"] ?? "";
        if ($id == "") {
            $json["error"] = array("code" => "#400", "description" => "Invalid request.");
        } else {
            $sql = "DELETE FROM messages WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $json["error"] = array("code" => "#200", "description" => "Success.");
        }
    } else if ($mode == "vote") {
        if (isset($_REQUEST["token"]) && isset($_REQUEST["email"]) && isset($_REQUEST["vote"]) && isset($_REQUEST["type"]) && isset($_REQUEST["id"]) && isset($_REQUEST["username"]) && isset($_REQUEST["forusername"])) {
            $token = $_REQUEST["token"];
            $email = trim($_REQUEST["email"]);
            $vote = $_REQUEST["vote"];
            $type = $_REQUEST["type"];
            $id = $_REQUEST["id"];
            $username = $_REQUEST["username"];
            $forusername = $_REQUEST["forusername"];
            $updated_at = date("Y-m-d H:i:s");
            $userAuth  = validateSessionToken($conn, $token, $email);
            if ($userAuth) {
                $sql = "SELECT * FROM votes WHERE username = :username AND type = :type AND forid = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":type", $type);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $vote = (int)$vote;
                $oldVote = (int)$row["vote"];
                if ($row) {
                    $sql = "UPDATE votes SET vote = :vote, updated_at = :updated_at WHERE username = :username AND type = :type AND forid = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":vote", $vote);
                    $stmt->bindParam(":updated_at", $updated_at);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":type", $type);
                    $stmt->bindParam(":id", $id);
                    $stmt->execute();
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                } else {
                    $sql = "INSERT INTO votes (forid, type, username, vote, updated_at) VALUES (:forid, :type, :username, :vote, :updated_at)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":forid", $id);
                    $stmt->bindParam(":type", $type);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":vote", $vote);
                    $stmt->bindParam(":updated_at", $updated_at);
                    $stmt->execute();
                    $json["error"] = array("code" => "#200", "description" => "Success.");
                }
                $sql = "UPDATE users SET points = points + :vote WHERE username = :forusername";
                if ($oldVote == 0 && $vote == 1) {
                    $vote = 1;
                } else if ($oldVote == 0 && $vote == -1) {
                    $vote = -1;
                } else if ($oldVote == 1 && $vote == 0) {
                    $vote = -1;
                } else if ($oldVote == -1 && $vote == 0) {
                    $vote = 1;
                } else if ($oldVote == 1 && $vote == -1) {
                    $vote = -2;
                } else if ($oldVote == -1 && $vote == 1) {
                    $vote = 2;
                }
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":vote", $vote);
                $stmt->bindParam(":forusername", $forusername);
                $stmt->execute();
            } else {
                $json["error"] = array("code" => "#401", "description" => "Unauthorized.");
            }
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "sendNotification") {
        if (isset($_REQUEST["title"]) && isset($_REQUEST["message"])) {
            $title = $_REQUEST["title"];
            $message = $_REQUEST["message"];
            $sql = "SELECT regid FROM users WHERE regid != ''";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $regids[] = $row["regid"];
            }
            sendGCM($title, $message, $regids);
        } else {
            $json["error"] = array("code" => "#400", "description" => "Name, category and content are required.");
        }
    } else if ($mode == "updateDetails") {
        $names = $_REQUEST['name'];
        $times = $_REQUEST['time'];
        $links = $_REQUEST['link'];
        $interviewName = $_REQUEST['interviewName'];
        $interviewTime = $_REQUEST['interviewTime'];
        $interviewLink = $_REQUEST['interviewLink'];
        $eventName = $_REQUEST['eventName'];
        $eventDate = $_REQUEST['eventDate'];
        $eventMentor = $_REQUEST['eventMentor'];
        $eventLink = $_REQUEST['eventLink'];
        $eventRecording = $_REQUEST['eventRecordings'];
        $events = array();
        for ($i = 0; $i < count($eventName); $i++) {
            $events[$i]['event'] = $eventName[$i];
            $events[$i]['date'] = $eventDate[$i];
            $events[$i]['mentor'] = $eventMentor[$i];
            $events[$i]['link'] = $eventLink[$i];
            $events[$i]['recording'] = $eventRecording[$i];
        }
        $meetings = array();
        for ($i = 0; $i < count($names); $i++) {
            $meetings[$i]['name'] = $names[$i];
            $meetings[$i]['time'] = $times[$i];
            $meetings[$i]['link'] = $links[$i];
            $meetings[$i]['recording'] = $interviewName[$i];
        }
        $data = json_encode(array(
            'meets' => $meetings,
            'interview' => array(
                'name' => $interviewName,
                'description' => $interviewTime,
                'link' => $interviewLink
            ),
            'events' => $events
        ));
        file_put_contents("json/dashboard.json", $data, JSON_PRETTY_PRINT);
        $json = array();
        $json['error'] = array(
            'code' => '200',
            'message' => 'Dashboard updated successfully'
        );
        $json['data'] = array();
    } else if ($mode == "addUser") {
        if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['phone'])) {
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $phone = $_REQUEST['phone'];
            $course = $_REQUEST['course'];
            $password = $_REQUEST['password'];
            $adminsJson = json_decode(file_get_contents(__DIR__ . "/json/users.json"), true);
            if (isset($adminsJson[$email])) {
                $json['error'] = array("code" => "402", "message" => "User already exists");
            } else {
                $adminsJson[$email] = array(
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone,
                    "course" => $course,
                    "password" => $password,
                    "updated_at" => date("Y-m-d H:i:s"),
                    "created_at" => date("Y-m-d H:i:s"),
                );
                file_put_contents(__DIR__ . "/json/users.json", json_encode($adminsJson, JSON_PRETTY_PRINT));
                $json["error"] = array("code" => "200", "message" => "User added successfully");
                $json["data"] = $adminsJson[$email];
            }
        } else {
            $json['error'] = array("code" => "402", "message" => "Invalid request");
        }
    } else if ($mode == "updateUser") {
        if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['phone'])) {
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $phone = $_REQUEST['phone'];
            $course = $_REQUEST['course'];

            $adminsJson = json_decode(file_get_contents(__DIR__ . "/json/users.json"), true);
            if (isset($adminsJson[$email])) {
                $adminsJson[$email] = array(
                    "name" => $name,
                    "email" => $email,
                    "phone" => $phone,
                    "course" => $course,
                    "password" => $adminsJson[$email]['password'],
                    "created_at" => $adminsJson[$email]["created_at"],
                    "updated_at" => date("Y-m-d H:i:s")
                );
                file_put_contents(__DIR__ . "/json/users.json", json_encode($adminsJson, JSON_PRETTY_PRINT));
                $json["error"] = array("code" => "200", "message" => "User Updated successfully.");
                $json["data"] = $adminsJson[$email];
            } else {
                $json["error"] = array("code" => "400", "message" => "User does not exist.");
            }
        } else {
            $json['error'] = array("code" => "402", "message" => "Invalid request");
        }
    } else if ($mode == "deleteUser") {
        if (isset($_REQUEST['email'])) {
            $email = $_REQUEST['email'];
            $adminsJson = json_decode(file_get_contents(__DIR__ . "/json/users.json"), true);
            if (isset($adminsJson[$email])) {
                unset($adminsJson[$email]);
                file_put_contents(__DIR__ . "/json/users.json", json_encode($adminsJson, JSON_PRETTY_PRINT));
                $json["error"] = array("code" => "200", "message" => "User deleted successfully.");
            } else {
                $json["error"] = array("code" => "400", "message" => "User does not exist.");
            }
        } else {
            $json['error'] = array("code" => "402", "message" => "Invalid request");
        }
    } else if ($mode == "auth") {
        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];
            $adminsJson = json_decode(file_get_contents(__DIR__ . "/json/users.json"), true);
            if (isset($adminsJson[$email])) {
                if ($adminsJson[$email]['password'] == $password) {
                    $json["error"] = array("code" => "200", "message" => "User authenticated successfully.");
                    $json["data"] = $adminsJson[$email];
                } else {
                    $json["error"] = array("code" => "400", "message" => "Invalid password.");
                }
            } else {
                $json["error"] = array("code" => "400", "message" => "User does not exist.");
            }
        }
    } else if ($mode == "upload") {
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $extensions = array("jpg", "jpeg", "png", "gif");
            $fileExt = explode('.', $fileName);
            $fileActualExt = PATHINFO($fileName, PATHINFO_EXTENSION);
            $fileNameNew = $fileExt[0] . "_" . uniqid('', true) . "." . $fileActualExt;
            $fileDestination = "images/" . $fileNameNew;
            if (in_array($fileActualExt, $extensions) || $type == "assets") {
                if ($fileSize < 1024 * 1024 * 100) {
                    if (move_uploaded_file($fileTmpName, $fileDestination)) {
                        if ($type == "images") {
                            $json["data"] = array("id" => $fileNameNew, "image_url" => $baseUrl . "uploads/images/" . $fileNameNew, "type" => $fileExt, "size" => $fileSize);
                        } else if ($type == "assets") {
                            $json["data"] = array("id" => $fileNameNew, "image_url" => $baseUrl . "uploads/assets/" . $fileNameNew, "type" => $fileExt, "size" => $fileSize);
                        }
                    } else {
                        $json["error"] = array("code" => "#500", "description" => "Error uploading file.");
                    }
                } else {
                    $json["error"] = array("code" => "#500", "description" => "File size is too big.");
                }
            } else {
                $json["error"] = array("code" => "#500", "description" => "File type is not supported.");
            }
        } else {
            $json["error"] = array("code" => "#500", "description" => "Invalid request.");
        }
    } else {
        $json['error'] = array("code" => "#403", "description" => "Invalid mode.");
    }
} else {
    $json["error"] = array("code" => "#403", "description" => "Mode is required.");
}
unset($json["regid"]);
echo json_encode($json);
