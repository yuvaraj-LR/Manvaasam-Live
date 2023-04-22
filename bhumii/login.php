<?php
session_start();
if (isset($_REQUEST['isMobile'])) {
    if (isset($_SESSION['email']) || isset($_SESSION['fullname'])) {
        header("Location: index.php");
    }

}
?>
<!Doctype html>
<html>

<head>
	<link rel="icon" href="user/images/bhumitrust.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="user/style/wave.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="user/style/purchaseback.css">
	<title> Bhumi Login </title>
</head>

<body>
	<section class="vh-100 " style="background-color: #9A616D;">
		<div class="container px-5 my-5 h-100">
			<div class="card" style="border-radius: 1rem;">
				<div class="row g-0">
					<div class="col-md-6 col-lg-5 d-none d-md-flex" style="justify-content: center; align-items: center; display: flex;">
						<img src="user/images/bhumitrust.jpeg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
					</div>
					<div class="col-md-6 col-lg-7 d-flex align-items-center">
						<div class="card-body p-4 p-lg-5 text-black">
							<form method="post" class="text-dark" action="./user/admin/api/v1.php">
								<input type="hidden" name="mode" value="login">
								<h5 class="fw-normal mb-3 pb-3 text-dark" style="letter-spacing: 1px;"><strong>Login to your account</strong></h5>
								<div class="form-outline mb-3">
									<label class="form-label" for="email"><strong>Username</strong></label>
									<input required type="text" id="email" name="email" autocomplete="off" class="form-control form-control-lg" />

								</div>

								<div class="form-outline mb-3">
									<label class="form-label" for="password"><strong>Password</strong></label>
									<div class="p-relative" style="position: relative">
										<input required type="password" id="myInput" name="password" autocomplete="off" class="form-control form-control-lg" />
										<div class="showpass mb-3" style="font-size:15px;" onclick="myFunction()"><i class="fa fa-1.5x fa-eye" aria-hidden="true"></i></div>
									</div>
								</div>
								<div class="pt-1 my-3">
									<input type="submit" class="btn btn-dark btn-lg btn-block" value="Login">
								</div>
								<p class="mb-5 pb-lg-2 text-dark" style="color: #393f81;"><strong>Don't have an account? </strong><a href="signup.php">Click to register</a></p </form>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="user/admin/js/jquery.min.js"></script>
	<script src="user/admin/js/sweetalert.js"></script>
	<script>
		$(document).ready(function() {
			$(document).ready(function() {
				$("form").submit(function(e) {
					e.preventDefault();
					var form = $(this);
					var url = form.attr('action');
					var data = form.serialize();
					$.ajax({
						type: "POST",
						url: url,
						data: data,
						success: function(data) {
							if (data.error.code == '#200') {
								swal({
									title: 'Success',
									text: "Login Success",
									icon: 'success',
									confirmButtonText: 'Ok'
								}).then((result) => {
									window.location.href = "index.php";
								});
							} else {
								swal({
									title: 'Error',
									text: data.error.description,
									icon: 'error',
									confirmButtonText: 'Ok'
								});
							}
						}
					});
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