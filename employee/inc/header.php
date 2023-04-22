<?php
$points = 0;
if (!isset($creditsJson[$_SESSION['user_name']])) {
    $creditsJson[$_SESSION['user_name']] = [];
}
for ($j = 0; $j < count($creditsJson[$_SESSION['user_name']]); $j++) {
    $points += $creditsJson[$_SESSION['user_name']][$j]['credits'];
}
?>
<div class="topbar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="full">
            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
            <div class="logo_section">
                <a href="index.php"><img class="img-responsive" src="logo.png" alt="#" /></a>
            </div>

            <div class="right_topbar">
                <div class="icon_info">
                    <ul>
                        <li>
                            <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">
                                <span class="btn btn-outline-light pr-2"> <i class="fa fa-rupee"></i> <?php echo $points; ?></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="user_profile_dd">
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown"><img class="img-responsive rounded-circle" src="images/layout_img/user_img.jpg" alt="#" /><span class="name_user"><?php echo  $_SESSION['name'] ?></span>
                            </a>
                            <div class="dropdown-menu">
                                <a href="EditProfile.php?user_name=<?= $_SESSION['user_name'] ?>" class="btn btn-success  btn-sm dropdown-item">EDIT PROFILE</a>
                                <a class="dropdown-item" href="Mlogout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php
            $creditsJson = json_decode(file_get_contents('credits.json'), true);
            $userName = $_SESSION['user_name'];
            if (!isset($creditsJson[$userName])) {
                $creditsJson[$userName] = [];
            }
            $points = 0;
            for ($j = 0; $j < count($creditsJson[$userName]); $j++) {
                $points += $creditsJson[$userName][$j]['credits'];
            }
            ?>


            <h1 class="text-center">All Credit Details</h1>
            <div class="">
                <table class="table table-bordered table-responsive  p-3" style="height:600px; width:750px!important;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Credit Points</th>
                            <th>Reason</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($j = 0; $j < count($creditsJson[$userName]); $j++) {
                        ?>
                            <tr>
                                <td><?php echo $j + 1; ?></td>
                                <td><?php echo $creditsJson[$userName][$j]['credits']; ?></td>
                                <td><?php echo $creditsJson[$userName][$j]['reason']; ?></td>
                                <td><?php
                                    $date = date_create($creditsJson[$userName][$j]['date']);
                                    echo date_format($date, "d/m/Y");
                                    ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

            </div>


        </div>

    </div>
</div>