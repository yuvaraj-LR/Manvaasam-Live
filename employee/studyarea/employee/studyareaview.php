<!-- Header File -->
<?php include "header.php" ?>

<!-- Body -->
<div class="container">
    <h1 class="text-center">Materials</h1>
      <a href="Admin/login.php" class='btn btn-primary mb-2'> <i class="bi bi-person-plus"></i> Admin Login</a>

        <table class="table table-striped table-bordered table-hover">
          <thead class="table-dark">
            <tr>
              <th  scope="col">Lesson Name</th>
              <th  scope="col">Youtube Link</th>
              <th  scope="col">Details</th>
            </tr>  
          </thead>
            <tbody>
              <tr>
 
          <?php
            include "db.php";

            $query="SELECT * FROM users";               // SQL query to fetch all table data
            $view_users= mysqli_query($conn,$query);    // sending the query to the database

            //  displaying all the data retrieved from the database using while loop
            while($row= mysqli_fetch_assoc($view_users)){              
              $lesson = $row['Lname'];        
              $link = $row['Uvedio'];         
              $content = $row['Content'];        

              echo "<tr >";
              echo " <td > {$lesson}</td>";
              echo " <td > {$link}</td>";
              echo " <td >{$content} </td>";
                  }  
                ?>
              </tr>  
            </tbody>
        </table>
  </div>



<!-- Footer File -->
<?php include "footer.php" ?>