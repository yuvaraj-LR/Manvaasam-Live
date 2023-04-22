<!-- Header -->
<?php  include "header.php" ?>

<?php 

  include "db.php";
  if(isset($_POST['create'])) 
    {
        $Lname = $_POST['Lname'];
        $Uvedio = $_POST['Uvedio'];
        $Content = $_POST['Content'];
      
        // SQL query to insert Lname data into the users table
        $query= "INSERT INTO studyarea(Lname, Uvedio, Content) VALUES('{$Lname}','{$Uvedio}','{$Content}')";
        $add_user = mysqli_query($conn,$query);
    
        // displaying proper message for the Lname to see whether the query executed perfectly or not 
          if (!$add_user) {
              echo "something went wrong ". mysqli_error($conn);
          }

          else { echo "<script type='text/javascript'>alert('User added successfully!')</script>";
              }         
    }
?>

<h1 class="text-center">Add User details </h1>
  <div class="container">
    <form action="" method="post">
      <div class="form-group">
        <label for="Lname" class="form-label">Lesson Name</label>
        <input type="text" name="Lname"  class="form-control">
      </div>

      <div class="form-group">
        <label for="Uvedio" class="form-label">Youtube Link</label>
        <input type="link" name="Uvedio"  class="form-control">
      </div>
    
      <div class="form-group">
        <label for="Content" class="form-label">Content</label>
        <input type="text" name="Content"  class="form-control">
      </div>    

      <div class="form-group">
        <input type="submit"  name="create" class="btn btn-primary mt-2" value="submit">
      </div>
    </form> 
  </div>

   <!-- a BACK button to go to the home page -->
  <div class="container text-center mt-5">
    <a href="home.php" class="btn btn-warning mt-5"> Back </a>
  <div>

<!-- Footer -->
<?php include "footer.php" ?>