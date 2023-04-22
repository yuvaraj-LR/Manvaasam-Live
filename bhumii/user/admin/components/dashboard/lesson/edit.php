<?php
if (!isset($conn)) {
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path . "/api/config.php");
    $db = new Connection();
    $conn = $db->getConnection();
}

if (isset($_REQUEST['lessonid'])) {
    $id = $_REQUEST['lessonid'];
    $sql = "SELECT * FROM lesson WHERE id = $id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $propertyEdit = $stmt->fetch();
    if ($propertyEdit) {
?>
        <h2>Fill the Following Form To Add Lesson</h2>
        <br />
        <div class="row">
            <div class="col-md-12">
                <h6>Parent Class Name</h6>
                <div class="p-2">
                    <select class="form-select" id="classid" name="classid">
                        <?php
                        $sql = "SELECT * FROM class";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $class = $stmt->fetchAll();
                        if (count($class) > 0) {
                            foreach ($class as $key => $value) {
                                echo "<option value='" . $value['id'] . "' " . ($value['id'] == $propertyEdit['classid'] ? "selected" : "") . ">" . $value['title'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br />
            <div class="col-md-6">
                <h6>Lesson Title</h6>
                <div class="p-2">
                    <input type="text" class="form-control" id="name" placeholder="Enter Lesson name" required value="<?php echo $propertyEdit['title']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <h6>Status</h6>
                <div class="p-2">
                    <select class="form-control" id="status" name="status">
                        <option value="public" <?php if ($propertyEdit['status'] == 'public') {
                                                    echo "selected";
                                                } ?>>Public</option>
                        <option value="private" <?php if ($propertyEdit['status'] != 'public') {
                                                    echo "selected";
                                                } ?>>Private</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Youtube video</h6>
                <div class="p-2">
                    <input type="text" class="form-control" id="youtube" placeholder="Demo Video" required placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx" value="<?php echo $propertyEdit['youtube']; ?>">
                </div>
            </div>
            <div class="col-12">
                <div class="pf-summernote">
                    <h6>Content</h6>
                    <textarea class="texteditor-content" name="content" id="content"><?php echo $propertyEdit['content']; ?></textarea>
                </div>
            </div>
        </div>
        <div class="p-2">
            <button type="button" class="w-100 btn btn-primary saveButton">Save changes</button>
        </div>

        <link href="<?= $baseUrl ?>admin/css/image-uploader.min.css" rel="stylesheet" />
        <script src="<?= $baseUrl ?>admin/js/image-uploader.min.js"></script>
        <script>
            let _xUserData = {
                "baseURL": "<?= $baseUrl ?>",
                "auth": "<?= $_SESSION['token'] ?>",
                "username": "<?= $_SESSION['username'] ?>",
            };
            $(document).ready(() => {
                imageUploader.init(".input-images");
            })
            if ($(".texteditor-content").length > 0) {
                $(".texteditor-content").richText();
            }

            $("#keywordsInput input").on({
                focusout: function() {
                    var txt = this.value.replace(/[^a-z0-9\+\-\.\#]/ig, '');
                    if (txt) {
                        $("<span/>", {
                            class: "btn btn-sm btn-success my-1 text-white",
                            text: txt.toLowerCase(),
                            insertBefore: this,
                        });
                    }
                    this.value = "";
                },
                keyup: function(ev) {
                    if (ev.originalEvent.key == "," || ev.originalEvent.key == " " || ev.originalEvent.key == "Enter" || ev.originalEvent.key == "Tab" || ev.originalEvent.key == "Backspace") {
                        var txt = this.value.replace(/[^a-z0-9\+\-\.\#]/ig, '');
                        if (txt) {
                            $("<span/>", {
                                class: "badge bg-primary me-1",
                                text: txt.toLowerCase(),
                                insertBefore: this,
                            });
                        }
                        this.value = "";
                    }
                }
            });
            $('#keywordsInput').on('click', 'span', function() {
                $(this).remove();
            });

            $(".saveButton").click(function() {
                var name = $("#name").val();
                var content = $(".texteditor-content").val();
                var status = $("#status").val();
                var classid = $("#classid").val();
                var youtube = $("#youtube").val();
                if (name == "" || content == "" || status == "" || classid == "" || youtube == "") {
                    swal({
                        icon: 'error',
                        type: 'error',
                        title: 'Oops...',
                        text: 'Please fill all the fields!',
                    })
                } else {
                    swal({
                        title: 'Are you sure to save changes?',
                        text: "The post will be updated and you won't be able to revert this!",
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $(".preloader").show();
                            var formData = new FormData();
                            formData.append("mode", "editlesson");
                            formData.append("name", name);
                            formData.append("content", content);
                            formData.append("status", status);
                            formData.append("youtube", $("#youtube").val());
                            formData.append("classid", classid);
                            formData.append("lessonid", "<?= $_REQUEST['lessonid'] ?>");
                            $.ajax({
                                url: "<?= $apiUrl ?>",
                                type: "POST",
                                data: formData,
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(response) {
                                    $(".preloader").hide();
                                    if (response.error.code == '#200') {
                                        swal({
                                            title: 'Success!',
                                            icon: 'success',
                                            text: "Lesson Updated Successfully",
                                            confirmButtonText: 'Ok'
                                        });
                                    } else {
                                        swal({
                                            title: 'Error!',
                                            text: response.error.description,
                                            icon: 'error',
                                            confirmButtonText: 'Try Again'
                                        })
                                    }
                                }
                            });
                        }
                    });
                }
            });
        </script>
<?php
    }
}
