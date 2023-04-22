<?php
    include("config.php");
    $db = new Database();
    $conn = $db->getConnection();
    $name = $_POST['name'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $about = $_POST['about'];
    $role = $_POST['role'];
   

        $sql = "INSERT INTO `employees` (user_name, name, email,password,phone,about,role) VALUES ('$user_name', '$name', '$email','$password','$phone','$about','$role')";
        $stmt = $conn->prepare($sql);
        // $stmt->bindParam(":name", $name);
        // $stmt->bindParam(":email", $email);
        // $stmt->bindParam(":phone", $phone);
        // $stmt->bindParam(":id", $user_name);
        // $stmt->bindParam(":about", $about);
        // $stmt->bindParam(":role", $role);
        
        $stmt->execute();
      
      $count = $stmt->rowCount();
    
    if($count=='1')
    {

          echo "<script>alert('Profil added Successfully');</script>";
        echo "<script>window.location.href='profile.php';</script>";
         
       
    }
?>
