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
               <img src="logo1.jpg" width="55" height="55" class="rounded-circle mx-auto d-block mt-4">
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

         <div class="col-5 mx-auto d-block mt-5">
            <div class="container bg-light" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
               <div class="row">
                  <?php

                  if (isset($_GET['updateid'])) {
                     $id = $_GET['updateid'];

                     $sql = "SELECT * FROM admins WHERE admin_id = '$id'";
                     $query = mysqli_query($conn, $sql);
                     $num_rows = mysqli_num_rows($query);

                     if (!$query) {
                        echo 'error';
                     } else {
                        $row = mysqli_fetch_assoc($query);
                     }
                  }
                  ?>


                  <?php
                  if (isset($_POST['update'])) {
                     if (isset($_GET['new_id'])) {
                        $new_id = $_GET['new_id'];
                     }
                     $username = $_POST['username'];
                     $email = $_POST['email'];
                     $password = $_POST['password'];
                     $cpassword = $_POST['cpassword'];

                     $sql_select = "SELECT * FROM admins WHERE admin_id = '$new_id'";
                     $result = mysqli_query($conn, $sql_select);
                     $row = mysqli_fetch_assoc($result);
                     $current_username = $row['admin_username'];
                     $current_email = $row['admin_email'];

                     $sql_user = "SELECT * FROM admins WHERE admin_username = '$username'";
                     $user_query = mysqli_query($conn, $sql_user);
                     $user_num_rows = mysqli_num_rows($user_query);
                     if ($user_num_rows > 0 && $username !== $current_username) {
                        $_SESSION['failed'] = "Username is already exists!";
                        header('Location: admin.php');
                     } else {
                        $sql_email = "SELECT * FROM admins WHERE admin_email = '$email'";
                        $email_query = mysqli_query($conn, $sql_email);
                        $email_num_rows = mysqli_num_rows($email_query);
                        if ($email_num_rows > 0 && $email !== $current_email) {
                           $_SESSION['email_exist'] = "Email is already exists!";
                           header('Location: admin.php');
                        } else {
                           if ($password !== $cpassword) {
                              $_SESSION['password_not_match'] = "Password does not match!";
                              header('Location: admin.php');
                           } else {
                              $sql = "UPDATE admins SET admin_username = '$username', admin_email ='$email', admin_password = '$password' WHERE admin_id = '$new_id'";
                              $query = mysqli_query($conn, $sql);
                              if (!$query) {
                                 $_SESSION['failed'] = "Operation failed, please try again.";
                              } else {
                                 $_SESSION['success'] = "Admin updated successfully!";
                                 header('Location: admin.php');
                              }
                           }
                        }
                     }
                  }

                  ?>

                  <form action="adminUpdate.php?new_id=<?php echo $id ?>" method="post" class="p-5">
                     <h1 class="text-center">Update Admin Info</h1>
                     <label class="form-label"><b>Username</b></label>
                     <div class="form-group">
                        <input type="text" class="form-control" name="username" value="<?php echo $row['admin_username'] ?>" required>
                     </div>
                     <label class="form-label"><b>Email</b></label>
                     <div class="form-group">
                        <input type="email" class="form-control" name="email" value="<?php echo $row['admin_email'] ?>" required>
                     </div>
                     <label class="form-label"><b>Password</b></label>
                     <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                     </div>
                     <label class="form-label"><b>Confirm Password</b></label>
                     <div class="form-group">
                        <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" required>
                     </div>
                     <div class="form-btn">
                        <input type="submit" class="btn btn-primary float-end" value="Update" name="update">
                        <button class="btn btn-secondary float-end"><a href="admin.php" class="text-decoration-none text-light">Cancel</a></button>
                     </div>
                  </form>
               </div>
            </div>
         </div>

      </div>
   </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
