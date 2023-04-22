<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['user_name'])) {
        include 'config.php';
        $user_name = $_GET['user_name'];
         
        $db = new Database();
        $conn = $db->getConnection();
        $date = date("Y-m-d");
        
        $sql = "DELETE FROM employees WHERE user_name = :user_name";
        
        $stmt = $conn->prepare($sql);
         $stmt->bindParam(":user_name", $user_name);
          $stmt->execute();
        $count=$stmt->rowCount();
 if($count==1)
 {
 echo "<script>alert('deleted successfully')</script>";
 }
 else
 {
 echo "<script>alert('deleted not successfully')</script>";
  echo "<script>window.location.href='profile.php';</script>";
 }
 echo "<script>alert($stmt )</script>";
    
    }
}
?>
    