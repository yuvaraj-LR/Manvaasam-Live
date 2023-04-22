<?php
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER['SERVER_NAME'] == 'localhost') {
  $hostname = "localhost";
  $db_name = "manvaasam";
  $uname = "root";
  $password = "";
} else {
  $hostname = "127.0.0.1";
  $db_name = "u707479837_manvaasam";
  $uname = "u707479837_manvaasam";
  $password = "S!mbZN#u5|";
}


$conn = mysqli_connect($hostname,  $uname, $password, $db_name);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
