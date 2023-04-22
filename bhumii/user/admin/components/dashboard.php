<?php

$pageId = "index";
if (isset($_GET["id"])) {
    $pageId = $_GET["id"];
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="<?= $baseUrl ?>admin/css/richtext.min.css" type="text/css">
    <link rel="stylesheet" href="<?= $baseUrl ?>admin/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= $baseUrl ?>admin/css/dashboard.css" type="text/css" />
    <link rel="stylesheet" href="<?= $baseUrl ?>admin/css/dataTables.bootstrap4.min.css">
    <script src="<?= $baseUrl ?>admin/js/jquery.min.js"></script>
    <script src="<?= $baseUrl ?>admin/js/sweetalert.js"></script>
    <script src="<?= $baseUrl ?>admin/js/jquery.dataTables.min.js"></script>
    <script src="<?= $baseUrl ?>admin/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= $baseUrl ?>admin/js/bootstrap.min.js"></script>
    <script src="<?= $baseUrl ?>admin/js/jquery.richtext.min.js"></script>
    <script src="<?= $baseUrl ?>admin/js/custom.js"></script>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <?php include "./components/sidebar.php"; ?>
        <div class="page-wrapper mt-5">
            <div class="container-fluid">
                <?php
                if ($pageId == "courses") {
                    include "dashboard/courses.php";
                }  else if ($pageId == "class") {
                    include "dashboard/class.php";
                } elseif ($pageId == "editclass") {
                    include "dashboard/class/edit.php";
                } elseif ($pageId == "addclass") {
                    include "dashboard/class/add.php";
                } else if ($pageId == "lessons") {
                    include "dashboard/lessons.php";
                } elseif ($pageId == "editlesson") {
                    include "dashboard/lesson/edit.php";
                } elseif ($pageId == "addlesson") {
                    include "dashboard/lesson/add.php";
                } elseif ($pageId == "messages") {
                    include "dashboard/messages.php";
                } elseif ($pageId == "notification") {
                    include "dashboard/notification.php";
                } else {
                    include "dashboard/home.php";
                }
                ?>
            </div>
            <footer class="footer text-center"> Created by <a href="#">Bhumii</a></footer>
        </div>
    </div>
</body>

</html>