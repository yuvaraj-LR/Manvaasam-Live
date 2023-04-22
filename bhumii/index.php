<?php
session_start();
if (!isset($_REQUEST['isMobile'])) {
    if (!isset($_SESSION['email']) || !isset($_SESSION['fullname'])) {
        include "index.html";
        exit;
    }
}
include("./user/admin/api/config.php");
$pageId = "index";
$classId = "index";

if (isset($_GET['pageId'])) {
    $pageId = $_GET['pageId'];
} else {
    $pageId = "index";
}
if (isset($_GET['classId'])) {
    $classId = $_GET['classId'];
} else {
    $classId = "";
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./image/fav_icon.png" type="image/png" />
    <title>Bhumii Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="./admin/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="./admin/css/dashboard.css" type="text/css" />
    <script src="./admin/js/jquery.min.js"></script>
    <script src="./admin/js/richtext.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="./admin/js/sweetalert.js"></script>
    <script src="./admin/js/custom.js"></script>

    <style>
        .nav-link {
            color: black;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        <!--<div class="page-wrapper">-->
        <div>
            <nav class="navbar navbar-expand-sm bg-white shadow-sm">
                <div class="container-fluid">
                    <a class="navbar-brand mr-5" href="#">Bhumii Courses Portal</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link mr-3" href="index.php?pageId=index<?= isset($_GET['isMobile']) ? "&isMobile=true" : "" ?>">Courses</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mr-3" href="index.php?pageId=helpcenter<?= isset($_GET['isMobile']) ? "&isMobile=true" : "" ?>">Help Centre</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mr-3" href="https://www.gnanasuriabahavan.com/?view=magazine" target="_blank">NewsFeed</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mr-3" href="logout.php"">Logout</a>
                            </li>
                        </ul>
                        <span class="navbar-text d-flex justify-content-center">
                            <div class="social d-flex justify-content-center">
                                <a class="mx-2 nav-link" href="https://www.gnanasuriabahavan.com/?view=magazine" target="_blank" style="font-size: 30px;">
                                    <i class="fab fa-blogger"></i>
                                </a>
                                <a class="mx-2 nav-link" href="https://www.youtube.com/@bhumii5200/videos" target="_blank" style="font-size: 30px;">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </span>
                    </div>
                </div>
            </nav>


            <div id="dynamic-content" class="container p-3">
                <?php
                if ($pageId == "index") {
                    include "./user/stdcomponents/classrooms.php";
                } else if ($pageId == "class") {
                    include "./user/stdcomponents/class.php";
                } else if ($pageId == "helpcenter") {
                    include "./user/stdcomponents/helpcenter.php";
                }
                ?>
            </div>
            <hr />
            <footer class="footer text-center bg-grey">
                Created by <a href="#">Bhumii</a>
            </footer>
        </div>
    </div>
</body>

</html>