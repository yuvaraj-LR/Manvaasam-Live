<div class="p-3">
    <div class="row">
        <?php
        $db = new Connection();
        $conn = $db->getConnection();
        $sql = "SELECT * FROM class where status='public' ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        for ($i = 0; $i < count($result); $i++) {
        ?>
            <div class="col-sm-6 col-md-6 col-lg-4">
                <div class="card">
                    <div class="image-box">
                        <img src="<?php echo "/user/admin/uploads/images/" . $result[$i]['images']  ?>" alt="" />
                        <a  href="index.php?pageId=class&classId=<?= $result[$i]['id'] ?><?= isset($_GET['isMobile']) ? "&isMobile=true" : ""?>" class="play-btn youtube"><i class="fa fa-play"></i></a>
                    </div>
                    <div class="card-content">
                        <h2 class="card-title"><?php echo $result[$i]['title'];  ?></h2>
                        <small class="sub-title">By <?php echo $result[$i]['author'];  ?></small>
                        <br />
                        <br />
                        <div>
                            <?php
                            $keywords = explode(",", $result[$i]['category']);
                            foreach ($keywords as $keyword) {
                                echo "<span class='tag mx-1'>{$keyword}</span>";
                            }
                            ?>
                        </div>
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            &nbsp; 5.0
                        </div>
                        <br />
                        <div class="lessonn">
                            <?php
                            $sql = "SELECT id FROM lesson where classid=" . $result[$i]['id'];
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $lesson = $stmt->fetchAll();
                            ?>
                            <div class="lesson">
                                <i class="fas fa-play-circle"></i>
                                <span class="lesson-title">This course consists of <?php echo count($lesson); ?> lessons</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <style>
        .card {
            background: #fff;
            width: 100%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border: none;
            overflow: hidden;
            transition: all 0.2s ease-in-out;
        }

        .card .image-box {
            height: 30vh;
            position: relative;
            border-radius: inherit;
            border: none;
            background: #70bee6;
        }

        .play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: all 0.2s ease-in-out;
        }

        .play-btn:hover {
            background: #70bee6;
            color: #fff;
        }

        .card .image-box img {
            width: 100%;
            height: 100%;
        }

        .card .card-content {
            padding: 1.3rem;
        }

        .card .tag {
            border: 1px solid #70bee6;
            padding: 0.3rem 1rem;
            text-transform: capitalize;
            font-size: 0.8rem;
            border-radius: 5px;
        }

        .card .card-title {
            font-size: 1.1rem;
        }

        .card .sub-title {
            color: gray;
        }

        .card .rating {
            margin-top: 0.5rem;
        }

        .card .rating .fas {
            color: gold;
        }

        .card .price-box {
            display: flex;
            margin-top: 0.6rem;
            gap: 1rem;
        }

        .card .price-box p {
            color: black;
            font-weight: bold;
        }

        .card .price-box p::before {
            content: "$";
            margin-right: 2px;
            color: gray;
        }

        .card .price-box .old-price {
            text-decoration: line-through;
            font-weight: normal;
            color: gray;
        }

        .card .btn {
            margin-top: 1rem;
            padding: 0.7rem 1rem;
            width: 100%;
            border-radius: 5px;
            text-transform: capitalize;
            background: none;
            border: 2px solid #70bee6;
            transition: 0.3s ease;
        }

        .card .btn:hover {
            cursor: pointer;
            background: #70bee6;
            color: #fff;
        }
    </style>