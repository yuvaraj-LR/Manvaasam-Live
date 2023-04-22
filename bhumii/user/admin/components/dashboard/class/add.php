<?php
if (!isset($conn)) {
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path . "/api/config.php");
    $db = new Connection();
    $conn = $db->getConnection();
}
?>
<h2>Fill the Following Form To Add Class</h2>
<br />
<div class="row">
    <div class="col-md-6">
        <h6>Class Title</h6>
        <div class="p-2">
            <input type="text" class="form-control" id="name" placeholder="Enter Class name" required>
        </div>
    </div>
    <div class="col-md-6">
        <h6>Class Category</h6>
        <div class="p-2">
            <div id="keywordsInput">
                <input class="form-control" type="text" id="category" value="" placeholder="Add a category" />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h6>Class Author</h6>
        <div class="p-2">
            <input type="text" class="form-control" id="author" placeholder="Author" required list="authors">
        </div>
    </div>
    <div class="col-12">
        <div class="pf-summernote">
            <h6>Content</h6>
            <textarea class="texteditor-content" name="content" id="content"></textarea>
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
        var category = $("#keywordsInput").find("span").map(function() {
            return $(this).text();
        }).get().join(",");
        var content = $(".texteditor-content").val();
        var author = $("#author").val();
        var images = [];
        $(".uploaded-image").each(function() {
            images.push($(this).attr("data-name"));
        });
        if ($(".uploaded-image").length == 0) {
            swal({
                icon: 'error',
                type: 'error',
                title: 'Oops...',
                text: 'Please Upload The Image',
            })
        } else if (name == "" || category == "" || content == "" || author == "") {
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
                    formData.append("mode", "addClass");
                    formData.append("name", name);
                    formData.append("category", category);
                    formData.append("content", content);
                    formData.append("author", author);
                    formData.append("images", images.join(","));
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
                                    text: "Your Class has been saved successfully!",
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