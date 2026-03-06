<?php
require_once(__DIR__ . '/../config/database.php');
session_start();
if (!isset($_SESSION["admin_id"])) {
   header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkR4j8R+P7M2A5l9fXbR3pVfH+8abtTE1PiQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
   <link rel="stylesheet" href="admin.css">
</head>

<body>
   <div class="container-fluid">
      <div class="row">
         <div class="bg-info col-auto col-sm-3 col-md-3 col-lg-3 min-vh-100 justify-content-center">
            <div class=" p-2">
               <img src="./Bellagio-Hotel-Casino-Las-Vegas.webp" width="55" height="55" class="rounded-circle mx-auto d-block mt-4">
               <ul class="nav nav-pills flex-column mt-4 d-flex justify-content-center">

                  <li class="nav-item py-2 py-sm-0 text-center mb-3">
                     <a href="dashboard.php" class="nav-link text-white">
                        <i class="d-inline fa fa-gauge"></i><span class=" ms-3 d-none d-md-inline">Dashboard</span>
                     </a>
                  </li>
                  <li class="nav-item py-2 py-sm-0 text-center mb-3">
                     <a href="admin.php" class="nav-link text-white">
                        <i class="d-inline fa fa-user-tie"></i><span class="d-inline ms-3 d-none d-md-inline">Admin</span>
                     </a>
                  </li>
                  <li class="nav-item py-2 py-sm-0 text-center mb-3">
                     <a href="users.php" class="nav-link text-white">
                        <i class="d-inline fa fa-users"></i><span class="d-inline ms-3 d-none d-md-inline">User</span>
                     </a>
                  </li>
                  <li class="nav-item py-2 py-sm-0 text-center mb-3">
                     <a href="rooms.php" class="nav-link text-white">
                        <i class="d-inline fa fa-bed"></i><span class="d-inline ms-3 d-none d-md-inline">Rooms</span>
                     </a>
                  </li>
                  <li class="nav-item py-2 py-sm-0 text-center mb-3">
                     <a href="bookings.php" class="nav-link text-white">
                        <i class="d-inline fa fa-book"></i><span class="d-inline ms-3 d-none d-md-inline">Bookings</span>
                     </a>
                  </li>
                  <li class="nav-item py-2 py-sm-0 text-center mb-3">
                     <a href="logout.php" class="nav-link text-white" id="logout-button">
                        <i class="d-inline fa fa-right-from-bracket"></i><span class="d-inline ms-3 d-none d-md-inline">Logout</span>
                     </a>
                  </li>
               </ul>
            </div>
         </div>

         <div class="col-8 col-sm-9 col-md-9 col-lg-9 mx-auto mt-5">
            <div class="container">
               <h1 class="display-4 text-center">Users</h1>
               <?php
               if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
                  echo '<div class="alert alert-success p-1 mt-3">' . $_SESSION['success'] . '</div>';
                  unset($_SESSION['success']);
               }
               if (isset($_SESSION['failed']) && $_SESSION['failed'] != '') {
                  echo '<div class="alert alert-danger p-1 mt-3">' . $_SESSION['failed'] . '</div>';
                  unset($_SESSION['failed']);
               }
               if (isset($_SESSION['email_exist']) && $_SESSION['email_exist'] != '') {
                  echo '<div class="alert alert-danger p-1 mt-3">' . $_SESSION['email_exist'] . '</div>';
                  unset($_SESSION['email_exist']);
               }
               if (isset($_SESSION['password_not_match']) && $_SESSION['password_not_match'] != '') {
                  echo '<div class="alert alert-danger p-1 mt-3">' . $_SESSION['password_not_match'] . '</div>';
                  unset($_SESSION['password_not_match']);
               }
               ?>
               <button class="btn btn-primary mt-3" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                  Add new user
               </button>

               <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <?php
                        if (isset($_POST['submit'])) {
                           $username = $_POST['username'];
                           $email = $_POST['email'];
                           $password = $_POST['password'];
                           $confirm_password = $_POST['cpassword'];

                           $sql_user = "SELECT * FROM users WHERE username = '$username'";
                           $user_query = mysqli_query($conn, $sql_user);
                           $user_num_rows = mysqli_num_rows($user_query);
                           if ($user_num_rows > 0) {
                              $_SESSION['failed'] = "Username is already exists!";
                              header('Location: users.php');
                           } else {
                              $sql_email = "SELECT * FROM users WHERE email = '$email'";
                              $email_query = mysqli_query($conn, $sql_email);
                              $email_num_rows = mysqli_num_rows($email_query);
                              if ($email_num_rows > 0) {
                                 $_SESSION['failed'] = "Email is already exists!";
                                 header('Location: users.php');
                              } else {
                                 if ($password !== $confirm_password) {
                                    $_SESSION['password_not_match'] = "Password does not match!";
                                    header('Location: users.php');
                                 } else {
                                    $sql = "INSERT INTO users(username,email, password) VALUES ('$username','$email', '$password')";
                                    $query = mysqli_query($conn, $sql);
                                    if ($query) {
                                       $_SESSION['success'] = "User added successfully!";
                                       header('Location: users.php');
                                    } else {
                                       $_SESSION['failed'] = "Failed to add user, please try again.";
                                       header('Location: users.php');
                                    }
                                 }
                              }
                           }
                        }
                        ?>
                        <div class="modal-header">
                           <h5 class="modal-title">Admin form</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <form action="users.php" method="POST">
                              <div class="mb-1">
                                 <label class="form-label">Username</label>
                                 <input type="text" class="form-control" name="username">
                              </div>
                              <div class="mb-1">
                                 <label class="form-label">Email</label>
                                 <input type="email" class="form-control" name="email">
                              </div>
                              <div class="mb-1">
                                 <label class="form-label">Password</label>
                                 <input type="password" class="form-control" name="password">
                              </div>
                              <div class="mb-1">
                                 <label class="form-label">Confirm Password</label>
                                 <input type="password" class="form-control" name="cpassword">
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                              </div>

                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="table-responsive overflow-auto">
                  <table class="table table-hover table-bordered text-center">
                     <thead>
                        <tr class="table-info table-active">
                           <th scope="col">Id</th>
                           <th scope="col">Username</th>
                           <th scope="col">Email</th>
                           <th scope="col">Password</th>
                           <th scope="col">Operations</th>
                        </tr>

                     </thead>
                     <tbody>
                        <?php
                        $sql = "SELECT * FROM users";
                        $query = mysqli_query($conn, $sql);
                        $num_rows = mysqli_num_rows($query);
                        if ($query) {
                           if ($num_rows == 0) {
                              echo '<tr>
                                    <td class="bg-transparent"><h3>No record</h3></td>
                                 </tr>';
                           } else {
                              while ($row = mysqli_fetch_assoc($query)) {
                                 $id = $row['id'];
                                 $username = $row['username'];
                                 $email = $row['email'];
                                 $password = $row['password'];

                                 echo '<tr>
                                       <td scope="row">' . $id . '</td>
                                       <td scope="row">' . $username . '</td>
                                       <td>' . $email . '</td>
                                       <td>' . $password . '</td>
                                       <td>
                                          <button class="btn btn-primary" type="button"><a href="userUpdate.php?updateid=' . $id . '" class="text-light text-decoration-none">Update</a></button>
                                          <button class="btn btn-danger"><a href="userDelete.php? deleteid=' . $id . '" class="text-light text-decoration-none">Delete</a></button>
                                       </td>
                                    </tr>';
                              }
                           }
                        }
                        ?>
                     </tbody>

               </div>
            </div>
            </table>
         </div>


      </div>
   </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
