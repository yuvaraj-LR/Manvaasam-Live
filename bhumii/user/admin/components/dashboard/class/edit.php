<?php
if (!isset($conn)) {
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path . "/api/config.php");
    $db = new Connection();
    $conn = $db->getConnection();
}

if (isset($_GET['classid'])) {
    $id = $_GET['classid'];
    $sql = "SELECT * FROM class WHERE id = $id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $propertyEdit = $stmt->fetchAll();
    if (count($propertyEdit) > 0) {
?>
        <h2>Fill the Following Form To Add Class</h2>
        <br />
        <div class="row">
            <div class="col-md-6">
                <h6>Class Title</h6>
                <div class="p-2">
                    <input type="text" class="form-control" id="name" placeholder="Enter Class name" required  value="<?php echo $propertyEdit[0]['title']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <h6>Class Category</h6>
                <div class="p-2">
                    <div id="keywordsInput">
                        <?php
                        $keywords = explode(",", $propertyEdit[0]['category']);
                        for ($i = 0; $i < count($keywords); $i++) {
                            echo "<span class='btn btn-sm btn-success me-1 mb-1 text-white'>" . $keywords[$i] . "</span>";
                        }
                        ?>
                        <input class="form-control" type="text" id="category"  placeholder="Add a category" />
                        </div>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Class Author</h6>
                <div class="p-2">
                    <input type="text" class="form-control" id="author" placeholder="Author" required list="authors" value="<?php echo $propertyEdit[0]['author']; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <h6>Status</h6>
                <div class="p-2">
                    <select class="form-control" id="status" name="status">
                        <option value="public" <?php if ($propertyEdit[0]['status'] == 'public') {
                                                    echo "selected";
                                                } ?>>Public</option>
                        <option value="private" <?php if ($propertyEdit[0]['status'] != 'public') {
                                                    echo "selected";
                                                } ?>>Private</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="pf-summernote">
                    <h6>Content</h6>
                    <textarea class="texteditor-content" name="content" id="content"><?php echo $propertyEdit[0]['content']; ?></textarea>
                </div>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="p-2">
                    <label for="images">Class Images</label>
                    <div class="input-images" id="images" style="padding-top: .5rem;"></div>
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
                "alreadyUploaded": "<?php echo ($propertyEdit[0]['images']); ?>",
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
                var category = $("#keywordsInput").find("span").map(function() {
                    return $(this).text();
                }).get().join(",");
                var content = $(".texteditor-content").val();
                var author = $("#author").val();
                var images = [];
                $(".uploaded-image").each(function() {
                    images.push($(this).attr("data-name"));
                });
                var status = $("#status").val();
                if (name == "" || category == "" || content == "" || author == "") {
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
                            formData.append("mode", "editClass");
                            formData.append("name", name);
                            formData.append("category", category);
                            formData.append("content", content);
                            formData.append("status", status);
                            formData.append("author", author);
                            formData.append("images", images.join(","));
                            formData.append("classid", "<?= $_REQUEST['classid'] ?>");
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
                                            text: "Class Updated Successfully",
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
