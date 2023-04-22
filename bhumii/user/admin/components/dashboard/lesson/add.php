<?php
if (!isset($conn)) {
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path . "/api/config.php");
    $db = new Connection();
    $conn = $db->getConnection();
}
?>
<h2 id="header1">Fill the Following Form To Add Lesson</h2>
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
                $propertyEdit = $stmt->fetchAll();
                if (count($propertyEdit) > 0) {
                    foreach ($propertyEdit as $key => $value) {
                        echo "<option value='" . $value['id'] . "'>" . $value['title'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <br/>
    <div class="col-md-6">
        <h6>Lesson Title</h6>
        <div class="p-2">
            <input type="text" class="form-control" id="name" placeholder="Enter Lesson name" required>
        </div>
    </div>
    <div class="col-md-6">
        <h6>Youtube video</h6>
        <div class="p-2">
            <input type="text" class="form-control" id="youtube" placeholder="Youtube Video" required placeholder="https://www.youtube.com/watch?v=xxxxxxxxxxx">
        </div>
    </div>
    <div class="col-12">
        <div class="pf-summernote">
            <h6>Content</h6>
            <textarea class="texteditor-content" name="content" id="content"></textarea>
        </div>
    </div>
</div>
<div class="p-2">
    <button type="button" class="w-100 btn btn-primary saveButton">Save changes</button>
</div>

<link href="<?= $baseUrl ?>admin/css/image-uploader.min.css" rel="stylesheet" />
<script src="<?= $baseUrl ?>admin/js/image-uploader.min.js"></script>
<script>
    $(document).ready(() => {
        imageUploader.init(".input-images");
    })
    let _xUserData = {
        "baseURL": "<?= $baseUrl ?>",
        "auth": "<?= $_SESSION['token'] ?>",
        "username": "<?= $_SESSION['username'] ?>",
    };
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
                        class: "btn btn-sm btn-success me-1 mb-1 text-white",
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
        var youtube = $("#youtube").val();
        var classid = $("#classid").val();
        if (name == "" || content == "" || youtube == "" || classid == "") {
            swal({
                icon: 'error',
                type: 'error',
                title: 'Oops...',
                text: 'Please fill all the fields!',
            })
        }  else {
            swal({
                title: 'Are you sure to publish?',
                text: "The post will be saved and pushed to the server!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var formData = new FormData();
                    formData.append("mode", "addlesson");
                    formData.append("name", name);
                    formData.append("content", content);
                    formData.append("youtube", youtube);
                    formData.append("classid", classid);
                    $(".preloader").show();
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
                                    text: "Your Lesson has been saved successfully!",
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    window.location.reload();
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

<style>
    #keywordsInput {
        width: 100%;
        float: left;
    }

    #keywordsInput>input {
        padding: 7px;
        width: calc(100%);
    }
</style>