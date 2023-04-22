<!-- Header -->

<?php  include "header.php" ?>           
<div class="container">
    <h1 class="text-center" >Data to perform CRUD Operations</h1>
              <table class="table table-striped table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th  scope="col">Id</th>
              <th  scope="col">Lesson Name</th>
              <th  scope="col">Youtube Link</th>
              <th  scope="col">Content</th>
                         </tr>  
          </thead>
            <tbody>
              <tr>
 
 
            <?php
              //  first we check using 'isset() function if the variable is set or not'
              //Processing form data when form is submitted
              include "db.php";

              if (isset($_GET['user_id'])) {
                  $userid = $_GET['user_id']; 

                  // SQL query to fetch the data where Id=$userid & storing data in view_user 
                  $query="SELECT * FROM studyarea WHERE Id = {$userid} ";  
                  $view_users= mysqli_query($conn,$query);            

                  while($row = mysqli_fetch_assoc($view_users))
                  {
                      $Id = $row['Id'];
                      $Lname = $row['Lname'];
                      $Uvedio = $row['Uvedio'];
                      $Content = $row['Content'];

                        echo "<tr >";
                        echo " <td >{$Id}</td>";
                        echo " <td > {$Lname}</td>";
                        echo " <td > {$Uvedio}</td>";
                        echo " <td >{$Content} </td>"; 
                        echo " </tr> ";
                  }
                }    

            ?>
          </tr>  
        </tbody>
    </table>
  </div>

   <!-- a BACK Button to go to pervious page -->
  <div class="container text-center mt-5">
    <a href="home.php" class="btn btn-warning mt-5"> Back </a>
  <div>

<!-- Footer -->
<?php include "footer.php" ?>