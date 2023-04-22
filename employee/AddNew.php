
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Profile</title>
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,200&display=swap" rel="stylesheet">
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
                    <link rel="stylesheet" href="formstyle.css">
                </head>

                <body class="body">
                    <div class="main">
                        <div class="container" style="overflow-x: auto">
                            <div class="signup-form">
                                <form method="POST" action="addbackend.php" class="leave-form" id="leave-form">
                                    <h2>Add new Profile</h2>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="name">Name :</label>
                                            <input type="text" name="name" id="name" required="" >
                                        </div>
                                        <div class="form-group">
                                            <label for="id">Employee Id :</label>
                                            <input type="text" name="user_name" id="user_name" required="" ="true" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email ID :</label>
                                        <input type="email" name="email" id="email" placeholder="Enter Email"  />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone No :</label>
                                        <input type="number" name="phone" id="phone" placeholder="Enter Phone"  />
                                    </div>
                                    <div class="form-group">
                                        <label for="reason">Password :</label>
                                        <input type="text" name="about" id="password" placeholder="Enter user password"  />
                                    </div>
                                     <div class="form-group">
                                        <label for="reason">About Yourself :</label>
                                        <input type="text" name="about" id="about" placeholder="Enter one liner about yourself"  />
                                    </div>
                                   <div class="form-group">
                                    <label for="role">Role :</label>
                                    <select name="role" id="role" required="">
                                       <option value="admin" selected>Admin</option>
                                        <option value="employee">Employee</option><option value="admin">Admin</option>
                                        <option value="employee" selected>Employee</option>'
                                    </select>
                                </div>
                                    <div class="form-submit">
                                        <input type="reset" value="Reset All" class="submit" name="reset" id="reset">
                                        <input type="submit" value="Submit Form" class="submit" name="submit" id="submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </body>

                </html>
              

