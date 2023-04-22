<!-- Footer -->
<?php include "header.php"?>

<?php
  include "db.php";

   // checking if the variable is set or not and if set adding the set data value to variable userid
   if(isset($_GET['user_id']))
    {
      $userid = $_GET['user_id']; 
    }
      // SQL query to select all the data from the table where Id = $userid
      $query="SELECT * FROM studyarea WHERE Id = $userid ";
      $view_users= mysqli_query($conn,$query);

      while($row = mysqli_fetch_assoc($view_users))
        {
          $Id = $row['Id'];
          $Lname = $row['Lname'];
          $Uvedio = $row['Uvedio'];
          $Content = $row['Content'];
        }
 
    //Processing form data when form is submitted
    if(isset($_POST['update'])) 
    {
      $Lname = $_POST['Lname'];
      $Uvedio = $_POST['Uvedio'];
      $Content = $_POST['Content'];
      
      // SQL query to update the data in Lname table where the Id = $userid 
      $query = "UPDATE studyarea SET Lname = '{$Lname}' , Uvedio = '{$Uvedio}' , Content = '{$Content}' WHERE Id = $userid";
      $update_user = mysqli_query($conn, $query);
      echo "<script type='text/javascript'>alert('User data updated successfully!')</script>";
    }             
?>

<h1 class="text-center">Update User Details</h1>
  <div class="container ">
    <form action="" method="post">
      <div class="form-group">
        <label for="Lname" >Lesson Name</label>
        <input type="text" name="Lname" class="form-control" value="<?php echo $Lname  ?>">
      </div>

      <div class="form-group">
        <label for="Uvedio" >Youtube Link</label>
        <input type="text" name="Uvedio"  class="form-control" value="<?php echo $Uvedio  ?>">
      </div>
    
      <div class="form-group">
        <label for="Content" >Content</label>
        <input type="text" name="Content"  class="form-control" value="<?php echo $Content  ?>">
      </div>    

      <div class="form-group">
         <input type="submit"  name="update" class="btn btn-primary mt-2" value="update">
      </div>
    </form>    
  </div>

    <!-- a BACK button to go to the home page -->
    <div class="container text-center mt-5">
      <a href="home.php" class="btn btn-warning mt-5"> Back </a>
    <div>

<!-- Footer -->
<?php include "footer.php" ?>