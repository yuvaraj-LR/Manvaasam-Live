<?php
session_start();
include "Mdb_conn.php";
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document Center</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <h1>Document Center</h1>
                    <hr>
                    <a href="img.php" class="btn btn-primary">Dashboard</a>
                    <?php 
                    if ($_SESSION['role'] == "admin") {
                        echo '<a href="upload.php" class="btn btn-success">Upload</a>';
                    }
                    ?>
                    <a href="Mlogout.php" class="btn btn-danger">Logout</a>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-light table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>File Size</th>
                                <th>File Type</th>
                                <th>Uploaded On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `docscenter`";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['name'] . '</td>';
                                    echo '<td>';
                                    $size = $row['size'];
                                    $size = $size / 1024;
                                    $size = $size / 1024;
                                    echo round($size, 2) . ' MB';
                                    echo '</td>';
                                    echo '<td>' . $row['type'] . '</td>';
                                    echo '<td>' . $row['created_at'] . '</td>';
                                    if ($_SESSION['role'] == "admin") {
                                        echo '<td>';
                                        echo '<a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger">Delete</a>&nbsp;';
                                        echo '<a href="view.php?id=' . $row['id'] . '" class="btn btn-primary">View</a>&nbsp;';
                                        echo '<a href="' . $row['path'] . '" class="btn btn-success">Download</a>';
                                        echo '</td>';
                                    } else {
                                        echo '<td>';
                                        echo '<a href="view.php?id=' . $row['id'] . '" class="btn btn-primary">View</a>&nbsp;';
                                        echo '<a href="' . $row['path'] . '" class="btn btn-success">Download</a>';
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr class="text-center">';
                                echo '<td colspan="6">No Documents Found</td>';
                                echo '</tr>';
                            }
                            ?>
                    </table>
                </div>
    </body>

    </html>
<?php
} else {
    header("location: Mindex.html");
}
?>