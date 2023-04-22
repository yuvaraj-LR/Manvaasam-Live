<?php
session_start();
include 'Mdb_conn.php';
if ($_SESSION['role'] == "admin") {
    $isError = 1;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "uploads/";
        $DocName = mysqli_real_escape_string($conn, htmlentities($_POST['DocName']));
        $name = uniqid() . htmlentities(basename($_FILES["fileToUpload"]["name"]));
        //  sql string esccape
        $name = mysqli_real_escape_string($conn, $name);
        $target_file = $target_dir . $name;
        $uploadOk = 1;
        // PDF Upload
        $pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size max is 20MB
        if ($_FILES["fileToUpload"]["size"] > 20971520) {
            $error = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($pdfFileType != "pdf") {
            $error = "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $error = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO `docscenter` (
                    `name`,
                    `path`,
                    `type`,
                    `size`,
                    `created_at`
                ) VALUES (
                    '" . $DocName . "',
                    '" . $target_file . "',
                    'pdf',
                    '" . $_FILES["fileToUpload"]["size"] . "',
                    '" . date('Y-m-d H:i:s') . "'
                )";
                if (mysqli_query($conn, $sql)) {
                    $isError = 0;
                    $error = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                } else {
                    $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload Document</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <h1>Upload Document</h1>
                    <hr>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="fileToUpload">Document:</label>
                            <input type="text" class="form-control" name="DocName" placeholder="Document Name">
                        </div>
                        <div class="p-2"></div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                        </div>
                        <div class="p-2"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="documentCenter.php" class="w-100 btn btn-primary">Go Back</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="w-100 btn btn-success">Upload</button>
                            </div>
                        </div>
                    </form>
                    <div class="p-2"></div>
                    <?php if (isset($error) && isset($isError)) { ?>
                        <div class="alert <?php echo ($isError == 1) ? 'alert-danger' : 'alert-success'; ?>">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php } else {
    header('Location: Mindex.php');
} ?>