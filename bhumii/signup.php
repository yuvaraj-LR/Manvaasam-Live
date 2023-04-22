<?php
if (isset($_SESSION['email']) || isset($_SESSION['fullname'])) {
  header("Location: index.php");
}
?>



<!Doctype html>
<html>

<head>
  <link rel="icon" href="images/bhumitrust.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="style/wave.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style/purchaseback.css">
  <title> Bhumi Register </title>
</head>

<body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <section class="vh-100 " style="background-color: #9A616D;">
    <div class="container px-5 my-5 h-100">
      <div class="card" style="border-radius: 1rem;">
        <div class="row g-0">
          <div class="col-md-6 col-lg-5 d-none d-md-flex" style="justify-content: center; align-items: center; display: flex;">
            <img src="images/bhumitrust.jpeg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
          </div>
          <div class="col-md-6 col-lg-7 d-flex align-items-center">
            <div class="card-body p-4 p-lg-5 text-black">
              <form method="post" class="text-dark" action="./admin/api/v1.php">
                <input type="hidden" name="mode" value="register">
                <h5 class="fw-normal mb-3 pb-3 text-dark" style="letter-spacing: 1px;"><strong>Create Your account</strong></h5>
                <div class="form-outline mb-3">
                  <label class="form-label text-dark" for="name">Full Name</label>
                  <input type="text" id="name" name="name" class="form-control form-control-lg" />
                </div>
                <!-- email -->
                <div class="form-outline mb-3">
                  <label class="form-label text-dark" for="email">Email</label>
                  <input type="email" id="email" name="email" class="form-control form-control-lg" />
                </div>
                <!-- phone -->
                <div class="form-outline mb-3">
                  <label class="form-label text-dark" for="phone">Phone</label>
                  <input type="text" id="phone" name="phone" class="form-control form-control-lg" />
                </div>
                <div class="form-outline mb-3">
                  <div class="p-relative" style="position: relative">
                    <label class=" form-label text-dark" for="password"><strong>Password</strong></label>
                    <i onclick="myFunction()" class="showpass fa fa-eye" aria-hidden="true"></i>
                    <input type="password" id="myInput" name="password" autocomplete="off" class="form-control form-control-lg" />
                  </div>
                </div>
                <div class="pt-1 mb-3">
                  <input type="submit" class="btn btn-dark btn-lg btn-block" value="Sign Up">
                </div>
                <p class="mb-5 pb-lg-2 text-dark" style="color: #393f81;"><strong>Already have an account? <a href="login.php" style="color: #393f81;">Login</a></strong></p>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="admin/js/jquery.min.js"></script>
  <script src="admin/js/sweetalert.js"></script>
  <script>
    $(document).ready(function() {
      $("form").submit(function(e) {
        e.preventDefault();
        var email = $("#email").val();
        var password = $("#password").val();
        var fullname = $("#fullname").val();
        var phone = $("#phone").val();
        if (email == "") {
          alert("Please enter email");
          return false;
        }
        var regexEmail = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
        if (!regexEmail.test(email)) {
          alert("Please enter valid email");
          return false;
        }
        if (password == "") {
          alert("Please enter password");
          return false;
        }
        if (fullname == "") {
          alert("Please enter fullname");
          return false;
        }
        if (phone == "") {
          alert("Please enter phone");
          return false;
        }
        var regexPhone = /^[0-9]{10}$/;
        if (!regexPhone.test(phone)) {
          alert("Please enter valid phone");
          return false;
        }
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
          type: "POST",
          url: url,
          data: data,
          success: function(data) {
            if (data.error.code == "#200") {
              window.location.href = "index.php";
            } else {
              alert(data.error.description);
            }
          }
        });
      });
    });

    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
  <style>
    .showpass {
      position: absolute;
      right: 0;
      top: 0;
      padding: 0.5rem 1rem;
      color: #393f81;
      cursor: pointer;
    }
  </style>
</body>

</html>