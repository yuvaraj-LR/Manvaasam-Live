<?php

session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
if (isset($_GET['id'])) {
    include "Mdb_conn.php";
    $id = $_GET['id'];
    $sql = "SELECT * FROM `docscenter` WHERE `id` = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $title = $row['name'];
    $path = $row['path'];
?>
    <!doctype html>

    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My PDF Viewer</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>

        <style>
            #canvas_container {
                width: 800px;
                height: 450px;
                overflow: auto;
            }

            #canvas_container {
                background: #333;
                text-align: center;
                border: solid 3px;
            }
        </style>
    </head>
    <body>
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $title ?></h1>
                    <hr>
                    <div id="my_pdf_viewer" style="width: 100%;">
                        <div id="canvas_container" style="width: 100%;height:90vh">
                            <canvas id="pdf_renderer"></canvas>
                        </div>
                        <div id="navigation_controls">
                            <div class="mb-3 input-group" style="width:200px">
                                <button class="input-group-text btn-primary" id="go_previous">Prev</button>
                                <input id="current_page" value="1" type="number" class="form-control" />
                                <button class="input-group-text btn-primary" id="go_next">Next</button>
                            </div>
                            <div class="p-2"></div>
                            <div id="zoom_controls" class="mb-3 input-group" style="width:200px">
                                <button class="input-group-text btn btn-success" id="zoom_in">+</button>
                                <button class="input-group-text btn btn-danger" id="zoom_out">-</button>
                            </div>
                        </div>
                    </div>
                    <style>
                        #navigation_controls {
                            position: fixed;
                            bottom: 0;
                            left: 0;
                            width: 100%;
                            height: 50px;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                    </style>
                    <script>
                        var myState = {
                            pdf: null,
                            currentPage: 1,
                            zoom: 1
                        }

                        pdfjsLib.getDocument('<?= $path ?>').then((pdf) => {

                            myState.pdf = pdf;
                            render();

                        });

                        function render() {
                            myState.pdf.getPage(myState.currentPage).then((page) => {

                                var canvas = document.getElementById("pdf_renderer");
                                var ctx = canvas.getContext('2d');
                                var viewport = page.getViewport(myState.zoom);
                                canvas.width = viewport.width;
                                canvas.height = viewport.height;

                                page.render({
                                    canvasContext: ctx,
                                    viewport: viewport
                                });
                            });
                        }

                        document.getElementById('go_previous').addEventListener('click', (e) => {
                            if (myState.pdf == null || myState.currentPage == 1)
                                return;
                            myState.currentPage -= 1;
                            document.getElementById("current_page").value = myState.currentPage;
                            render();
                        });

                        document.getElementById('go_next').addEventListener('click', (e) => {
                            if (myState.pdf == null || myState.currentPage > myState.pdf._pdfInfo.numPages)
                                return;
                            myState.currentPage += 1;
                            document.getElementById("current_page").value = myState.currentPage;
                            render();
                        });

                        document.getElementById('current_page').addEventListener('keypress', (e) => {
                            if (myState.pdf == null) return;

                            // Get key code
                            var code = (e.keyCode ? e.keyCode : e.which);

                            // If key code matches that of the Enter key
                            if (code == 13) {
                                var desiredPage =
                                    document.getElementById('current_page').valueAsNumber;

                                if (desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
                                    myState.currentPage = desiredPage;
                                    document.getElementById("current_page").value = desiredPage;
                                    render();
                                }
                            }
                        });

                        document.getElementById('zoom_in').addEventListener('click', (e) => {
                            if (myState.pdf == null) return;
                            myState.zoom += 0.5;
                            render();
                        });

                        document.getElementById('zoom_out').addEventListener('click', (e) => {
                            if (myState.pdf == null) return;
                            myState.zoom -= 0.5;
                            render();
                        });
                    </script>
    </body>

    </html>
<?php
} else {
    header("location: documentCenter.php");
}
} else {
  header("Location: /");
  exit();
}
?>