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
   <title>Dashboard</title>
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
            <div class="row justify-content-center gy-3">
               <h1 class="display-4 text-center text-secndary">Dashboard</h1>
               <?php
               $sql = "SELECT * FROM users";
               $query = mysqli_query($conn, $sql);
               $num_rows = mysqli_num_rows($query);
               ?>
               <div class="col-10 col-sm-10 col-md-5 col-lg-3">
                  <div class="card">
                     <div class="card-body">
                        <h1><?php echo $num_rows; ?><i class="fa fa-users float-end mt-4 text-info"></i></h1>
                        <p>Users</p>
                     </div>
                  </div>
               </div>

               <?php
               $sql = "SELECT * FROM booking";
               $query = mysqli_query($conn, $sql);
               $num_rows = mysqli_num_rows($query);
               ?>
               <div class="col-10 col-sm-10 col-md-5 col-lg-3">
                  <div class="card">
                     <div class="card-body">
                        <h1><?php echo $num_rows; ?><i class="fa fa-book float-end mt-4 text-info"></i></h1>
                        <p>Bookings</p>
                     </div>
                  </div>
               </div>
               <?php
               $sql = "SELECT * FROM rooms";
               $query = mysqli_query($conn, $sql);
               $num_rows = mysqli_num_rows($query);
               ?>
               <div class="col-10 col-sm-10 col-md-5 col-lg-3">
                  <div class="card" style="background-image: linear-gradient(to right, #0083b0, #00b4db);">
                     <div class="card-body text-light">
                        <h1><?php echo $num_rows; ?><i class="fa fa-bed float-end mt-4"></i></h1>
                        <p>Rooms</p>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>

</body>

</html>
