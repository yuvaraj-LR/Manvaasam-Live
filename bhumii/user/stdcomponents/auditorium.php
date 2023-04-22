<?php
session_start();
include("./api/config.php");
$db = new Connection();
$conn = $db->getConnection();
?>

<div class="p-3">
    <?php
    $sql = "SELECT * FROM event where status='public' ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
    for ($i = 0; $i < count($result); $i++) {
    ?>
        <div class="event_container">
            <div class="event_bg" style="background-image: url('<?php echo "https://manvaasam.com/admin/uploads/images/" . $result[$i]['images']  ?>')"></div>
            <div class="event_info">
                <div class="event_title">
                    <h4><?php echo $result[$i]['title'];  ?></h4>
                </div>
                <div class="event_desc">
                    <p><?php echo htmlspecialchars_decode($result[$i]['content']); ?></p>
                </div>
                <div class="event_footer">
                    <div class="event_date">
                        <p><?php echo $result[$i]['date'];  ?></p>
                    </div>
                    <div class="event_more">
                        <a href="<?php echo $result[$i]['payment'];  ?>" target="_blank" class="btn btn-success">
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<style>
    .event_container {
        display: flex;
        width: 100%;
        height: 230px;
        background: #FFF;
        border-radius: 2px;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.25), 0 8px 8px 0 rgba(0, 0, 0, 0.15);
        margin: 20px 0;
    }

    .event_container .event_bg {
        width: 40%;
        height: 100%;
        background: #333;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-top-left-radius: 3px;
        border-bottom-left-radius: 3px;
    }

    .event_container .event_info {
        width: 60%;
        height: 100%;
        padding: 10px 20px;
    }

    .event_container .event_info .event_title {
        display: flex;
        width: 100%;
        height: 50px;
        align-items: center;
    }

    .event_container .event_info .event_title h4 {
        font-size: 26px;
        font-family: "Quicksand", sans-serif;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .event_container .event_info .event_desc {
        display: flex;
        width: 100%;
        height: calc(100% - 100px);
    }

    .event_container .event_info .event_desc p {
        font-size: 16px;
        font-weight: 500;
        color: #565861;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event_container .event_info .event_footer {
        display: flex;
        width: 100%;
        height: 50px;
        align-items: center;
        justify-content: space-between;
    }

    .event_container .event_info .event_footer .event_date p {
        font-size: 15px;
        font-weight: 600;
        color: #333;
    }

    .event_container .event_info .event_footer .event_more {
        display: flex;
        width: auto;
        height: 100%;
        align-items: center;
    }

    .event_container .event_info .event_footer .event_more a.btn_more {
        display: flex;
        width: auto;
        height: 40px;
        align-items: center;
        padding: 0 15px;
        text-decoration: none;
        color: #5F5FFC;
        font-size: 16px;
        font-weight: 600;
        border-radius: 2px;
        will-change: background;
        transition: background 0.3s, color 0.2s ease-in;
    }

    .event_container .event_info .event_footer .event_more a.btn_more i.material-icons {
        font-size: 18px;
        font-weight: 500;
        padding: 0 2px;
    }

    .event_container .event_info .event_footer .event_more a.btn_more:hover {
        background: #5F5FFC;
        color: #FFF;
    }

    @media screen and (max-width: 575px) {
        .event_container {
            width: 100%;
            height: 480px;
            background: #FFF;
            flex-direction: column;
        }

        .event_container .event_bg {
            width: 100%;
            height: 250px;
            min-height: 250px;
            border-top-right-radius: 3px;
            border-bottom-left-radius: 0;
        }

        .event_container .event_info {
            width: 100%;
            height: 230px;
        }
    }
</style>