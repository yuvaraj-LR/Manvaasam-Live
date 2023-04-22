<?php
session_start();
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];
		if (empty($email)) {
			$error = "Email is required";
		} else if (empty($password)) {
			$error = "Password is required";
		}

		$adminsJson = json_decode(file_get_contents("json/users.json"), true);
		if (isset($adminsJson[$email])) {
			if ($adminsJson[$email]['password'] == $password) {
				$_SESSION['email'] = $adminsJson[$email]['email'];
				$_SESSION['name'] = $adminsJson[$email]['name'];
				$_SESSION['phone'] = $adminsJson[$email]['phone'];
				$_SESSION['password'] = $adminsJson[$email]['password'];
				$_SESSION['course'] = $adminsJson[$email]['course'];
				header("Location: index.php");
			} else {
				$error = "Invalid password";
			}
		} else {
			$error = "Invalid email";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

		*,
		*:before,
		*:after {
			box-sizing: border-box;
		}

		body {
			min-height: 100vh;
			padding: 0;
			margin: 0;
			font-family: 'Raleway', sans-serif;
		}

		.container {
			position: absolute;
			width: 100%;
			height: 100%;
			overflow: hidden;
		}

		.container:hover .top:before,
		.container:active .top:before,
		.container:hover .bottom:before,
		.container:active .bottom:before,
		.container:hover .top:after,
		.container:active .top:after,
		.container:hover .bottom:after,
		.container:active .bottom:after {
			margin-left: 300px;
			transform-origin: -300px 50%;
			transition-delay: 0s;
		}

		.container:hover .center,
		.container:active .center {
			opacity: 1;
			transition-delay: 0.2s;
		}

		.top:before,
		.bottom:before,
		.top:after,
		.bottom:after {
			content: '';
			display: block;
			position: absolute;
			width: 200vmax;
			height: 200vmax;
			top: 50%;
			left: 50%;
			margin-top: -100vmax;
			transform-origin: 0 50%;
			transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
			z-index: 10;
			opacity: 0.65;
			transition-delay: 0.2s;
		}

		.top:before {
			transform: rotate(45deg);
			background: #e46569;
		}

		.top:after {
			transform: rotate(135deg);
			background: #ecaf81;
		}

		.bottom:before {
			transform: rotate(-45deg);
			background: #60b8d4;
		}

		.bottom:after {
			transform: rotate(-135deg);
			background: #3745b5;
		}

		.center {
			position: absolute;
			width: 400px;
			height: 400px;
			top: 50%;
			left: 50%;
			margin-left: -200px;
			margin-top: -200px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			padding: 30px;
			opacity: 0;
			transition: all 0.5s cubic-bezier(0.445, 0.05, 0, 1);
			transition-delay: 0s;
			color: #333;
		}

		.center input {
			width: 100%;
			padding: 15px;
			margin: 5px;
			border-radius: 1px;
			border: 1px solid #ccc;
			font-family: inherit;
		}

		button {
			border-radius: 20px;
			border: 1px solid #FF4B2B;
			background-color: #FF4B2B;
			color: #FFFFFF;
			font-size: 12px;
			font-weight: bold;
			padding: 12px 45px;
			letter-spacing: 1px;
			text-transform: uppercase;
			transition: transform 80ms ease-in;
		}
	</style>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="./user/image/fav_icon.png" type="image/png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Student Login</title>
</head>

<body>
	<div class="container">
		<div class="top"></div>
		<div class="bottom"></div>
		<div class="center">
			<h2>Forgot Password</h2>
			<form action="login.php" method="post">
				<center><img src="img/logo.jpg" height="100px" width="100px"></center>
				<?php
				if ($error != "") {
					echo '<p style="color: red;background-color: #f2dede;padding: 10px;">' . htmlspecialchars($error) . '</p>';
				}
				?>
				<input type="email" placeholder="Email Id" name="email" />
				<button type="submit">Reset My password</button>
				<p> <a href="login.php">Back to Login</a></p>
			</form>
		</div>
	</div>

</body>

</html>