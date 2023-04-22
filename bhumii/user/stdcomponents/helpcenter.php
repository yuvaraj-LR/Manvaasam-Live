<script src="/user/admin/js/sweetalert.js"></script>
<div class="p-2">
    <h2>Contact Form</h2>
    <br />
    <div class="container-fluid  white-box">
        <div class="row">
            <div class="col-md-6">
                <h6>Type of ticket</h6>
                <div class="p-2">
                    <select class="form-control " id="ticketType" name="ticketType">
                        <option value="Community">Community</option>
                        <option value="Course">Course</option>
                        <option value="Service">Service</option>
                        <option value="Product">Product</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Ticket Priority</h6>
                <div class="p-2">
                    <select class="form-control " id="ticketPriority" name="ticketPriority">
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
            </div>
            <!-- contact mode -->
            <div class="col-md-6">
                <h6>Contact mode</h6>
                <div class="p-2">
                    <select class="form-control " id="contactMode" name="contactMode">
                        <option value="Email">Email</option>
                        <option value="Call">Call</option>
                        <option value="Whatsapp">Whatsapp</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <h6>Phone Number</h6>
                <div class="p-2">
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number" />
                </div>
            </div>
            <!-- description -->
            <div class="col-md-12">
                <h6>Description</h6>
                <div class="p-2">
                    <textarea class="form-control" id="description" name="description" placeholder="Enter your description" rows="4"></textarea>
                </div>
            </div>
        </div>
        <div class="p-2">
            <button type="button" class="w-100 btn btn-primary saveButton">Submit Ticket</button>
        </div>
    </div>
</div>

<script>
    $(".saveButton").click(function() {
        var name = "<?php echo $_SESSION['fullname']; ?>";
        var phone = $("#phoneNumber").val();
        var email = "<?php echo $_SESSION['email']; ?>";
        var message = $("#description").val();
        var type = $("#ticketType").val();
        var contactmode = $("#contactMode").val();
        var priority = $("#ticketPriority").val();
        if (name == "" || phone == "" || email == "" || message == "" || type == "" || contactmode == "" || priority == "") {
            swal({
                icon: 'error',
                type: 'error',
                title: 'Oops...',
                text: 'Please fill all the fields!',
            })
        } else {
            swal({
                title: 'Are you sure to raise ticket?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var formData = new FormData();
                    formData.append("mode", "contactMessage");
                    formData.append("name", name);
                    formData.append("phone", phone);
                    formData.append("email", email);
                    formData.append("message", message);
                    formData.append("type", type);
                    formData.append("contactmode", contactmode);
                    formData.append("priority", priority);
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
                                    text: "Your ticket has been raised successfully!",
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