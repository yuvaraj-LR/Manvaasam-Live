<?php
session_start();
include("./admin/api/config.php");
$db = new Connection();
$conn = $db->getConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.001.css" />
    <title>Courses - Manvaasam</title>
    
    <style>
        .header {
            margin-top: 6.5rem !important;
        }
        a {
          text-decoration: none;
        }

    /*navbar style*/
    </style>
</head>

<body>
     <?php include('navbar.php'); ?>

    <div class="container mt-3">
        <h1 class="header m-3">Manvaasam Courses</h1>
        <article class="job-card mobile-wrapper row">
            <?php
            $sql = "SELECT * FROM course WHERE status='public' ORDER BY id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            for ($i = 0; $i < count($result); $i++) {
                $images = explode(",", $result[$i]['images']);
            ?>
                <div class="col-md-6">
                    <div class="card">
                        <img src="./admin/uploads/images/<?php echo $images[0]; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div>
                                <h2><?php echo $result[$i]['title']; ?></h2>
                            </div>
                            <h6><b>Price : </b> Rs.<?php echo $result[$i]['price']; ?></h6>
                            <h6><b>Trainer : </b> <?php echo $result[$i]['author']; ?></h6>
                            <p>
                            <?php echo htmlspecialchars_decode($result[$i]['content']) ?>
                                                            
                            </p>
                            <br/>
                            <div class="skills-container m-0 p-0">
                                <?php
                                $allSkills = explode(",", $result[$i]['category']);
                                for ($j = 0; $j < count($allSkills); $j++) {
                                ?>
                                    <div class="skill"><?php echo $allSkills[$j]; ?></div>
                                <?php
                                }
                                ?>
                            </div>
                            <br/>
                            <div class="d-flex">
                                <div class="p-2">
                                    <a target="_blank" href="<?php echo $result[$i]['link']; ?>" class="btnAction apply">Buy Now</a>
                                </div>
                                <div class="p-2">
                                    <a target="_blank" href="#" class="btnAction apply">Share</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </article>
    </div>
    <style>
        article.job-card:hover,
        article.job-card:focus {
            background-color: rgba(0, 166, 194, .03);
            border-color: #b2e4ec;
        }

        .job-title {
            font-size: 16px;
            align-self: start;
            font-weight: 500;
            margin-top: 5px;
            padding: 0 24px;
        }

        .company-name {
            align-self: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
            padding: 0 24px;
        }

        .skills-container {
            align-self: center;
            padding-top: 10px;
            padding: 0 24px;
        }

        .skill {
            display: inline;
            color: #00a6c2;
            border-radius: 2px;
            background-color: rgba(0, 166, 194, .05);
            border: 1px solid rgba(0, 166, 194, .15);
            padding: 5px 8px;
            font-size: 12px;
        }

        .btnAction {
            display: block;
            width: 100%;
            cursor: pointer;
            border: 0;
            border-radius: 4px;
            font-size: 14px;
            padding: 6px 12px;
            z-index: 2;
        }

        .apply {
            background-color: #1ab059;
            color: #fff;
        }

        .save {
            background-color: #fff;
            border: 1px solid #a4a5a8;
            color: #777;
        }

        @media screen and (max-width: 700px) {
            .mobile-wrapper article {
                grid-template-columns: 60px auto;
                grid-template-rows: 35px 25px auto 40px;
                width: calc(100% - 32px);
                padding: 16px;
            }

            .mobile-wrapper .company-logo-img {
                height: 60px;
                width: 60px;
            }

            .mobile-wrapper .job-title {
                padding: 8px 16px 0 16px;
            }

            .mobile-wrapper .company-name {
                padding: 0 16px;
            }

            .mobile-wrapper .skills-container {
                padding: 16px 0;
            }

            .mobile-wrapper .btn-container {
                display: flex;
            }

            .mobile-wrapper .btn-container button {
                height: 38px;
                flex: 1;
                width: 0;
            }

            .mobile-wrapper .btn-container .apply {
                margin-right: 10px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>