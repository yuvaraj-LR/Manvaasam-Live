<?php
session_start();
if (isset($_SESSION['user_name'])) {
  header("Location: index.php");
  exit();
}
include("./config.php");

include "Mdb_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $uname = validate($_POST['uname']);
  $pass = validate($_POST['password']);

  if (empty($uname)) {
    header("Location:login.php?error=User Name is required");
    exit();
  } else if (empty($pass)) {
    header("Location: login.php?error=Password is required");
    exit();
  } else {
    $sql = "SELECT * FROM employees WHERE user_name='$uname' AND password='$pass'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION['user_name'] = $row['user_name'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['phone'] = $row['phone'];
      $_SESSION['about'] = $row['about'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['role'] = $row['role'];
      $_SESSION['id'] = $row['id'];
      $dateTime = date("Y-m-d H:i:s");
      // $sql  = "INSERT INTO `time` (emp_id,`name`, time_in) VALUES (:emp_id,:name, :time_in)";
      // $stmt = $conn2->prepare($sql);
      // $stmt->bindParam(':emp_id', $_SESSION['user_name']);
      // $stmt->bindParam(':name', $_SESSION['name']);
      // $stmt->bindParam(':time_in', $dateTime);
      // $stmt->execute();
      header("Location: index.php");
      exit();
    } else {
      header("Location: login.php?error=Incorect User name or password $sql");
      exit();
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
  <link rel="shortcut icon" href="/image/fav_icon.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <title>Manvaasam Login</title>
  <style>
    body {
      background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
      height: 100vh;
    }

    i {
      cursor: pointer;
    }

    @keyframes gradient {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }
  </style>
</head>

<body>
  <?php
  if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger m-4" role="alert">
        <strong>Error!</strong> Invalid Username or Password.
      </div>';
  }
  ?>
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">
                <img src="logo.png" height="100px" width="100px">

                <h2 class="fw-bold mb-2 text-uppercase">Manvaasam Login</h2>
                <p class="text-white-50 mb-5">Please enter your login credentials!</p>

                <div class="form-outline form-white mb-4">
                  <form action="?" method="post">
                    <label class="form-label" for="uname">Username</label>
                    <input required type="text" id="user_name" placeholder="Enter Your Username" class="form-control form-control-lg" name="uname" />

                </div>

                <div class="form-outline form-white mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input required type="password" id="myInput" placeholder="Enter your password" class="form-control form-control-lg" name="password" />
                  <div onclick="myFunction()"><i class="fa fa-eye" aria-hidden="true"></i></div>

                </div>



                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                </form>

              </div>



            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
  <script>
    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>

</html>