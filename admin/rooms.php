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
   <title>Rooms</title>
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
               <h1 class="display-4 text-center">Rooms</h1>
               <?php
               if (isset($_SESSION['success'])) {
                  echo '<div class="alert alert-success p-1 mt-3">' . $_SESSION['success'] . '</div>';
                  unset($_SESSION['success']);
               }
               if (isset($_SESSION['failed'])) {
                  echo '<div class="alert alert-danger p-1 mt-3">' . $_SESSION['failed'] . '</div>';
                  unset($_SESSION['failed']);
               }

               ?>
               <button class="btn btn-primary mt-3" type="button" data-bs-toggle="modal" data-bs-target="#modal">
                  Add new room
               </button>

               <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <?php

                        if (isset($_POST['add_room'])) {
                           $room_name = $_POST['room_name'];
                           $room_description = $_POST['room_description'];
                           $room_price = $_POST['room_price'];
                           $upload_dir = __DIR__ . "/upload_img";

                           if (!is_dir($upload_dir)) {
                              mkdir($upload_dir, 0755, true);
                           }

                           $original_name = basename($_FILES["room_img"]['name']);
                           $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                           $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                           if (!in_array($ext, $allowed)) {
                              $_SESSION['failed'] = "Only JPG, JPEG, PNG, and WEBP are allowed.";
                              header('Location: rooms.php');
                              exit;
                           }

                           $room_img = uniqid("room_", true) . "." . $ext;
                           $target_file = $upload_dir . DIRECTORY_SEPARATOR . $room_img;

                           if (!move_uploaded_file($_FILES["room_img"]["tmp_name"], $target_file)) {
                              $_SESSION['failed'] = "Image upload failed.";
                              header('Location: rooms.php');
                              exit;
                           }

                           $sql = "INSERT INTO rooms (room_name, room_description, room_price, room_img) VALUES('$room_name','$room_description',$room_price,'$room_img')";
                           $query = mysqli_query($conn, $sql);

                           if ($query) {
                              $_SESSION['success'] = "room added successfully!";
                              header('Location: rooms.php');
                           } else {
                              // Cleanup uploaded file if DB insert failed.
                              if (file_exists($target_file)) {
                                 unlink($target_file);
                              }
                              $_SESSION['failed'] = "room not added!";
                              header('Location: rooms.php');
                           }
                           exit;
                        }
                        ?>
                        <div class="modal-header">
                           <h5 class="modal-title">Room form</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                           <form action="rooms.php" method="POST" enctype="multipart/form-data">

                              <div class="mb-1">
                                 <input type="text" class="form-control" name="room_name" placeholder="Room Name" required>
                              </div>

                              <div class="mb-1">
                                 <input type="text" class="form-control" name="room_description" placeholder="Description" required>
                              </div>
                              <div class="mb-1">
                                 <input type="number" class="form-control" name="room_price" placeholder="Price" required>
                              </div>
                              <div class="mb-1">
                                 <input type="file" class="form-control-file" name="room_img" required>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                 <button type="submit" class="btn btn-primary" name="add_room">Add room</button>
                              </div>

                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="table-responsive">
                  <table class="table table-hover table-bordered text-center">
                     <thead>
                        <tr class="table-info table-active">
                           <th scope="col">Id</th>
                           <th scope="col">Name</th>
                           <th scope="col">Description</th>
                           <th scope="col">Price</th>
                           <th scope="col">Image</th>
                           <th scope="col">Operations</th>
                        </tr>
                     </thead>
                     <?php
                     $sql = "SELECT * FROM rooms";
                     $query = mysqli_query($conn, $sql);
                     $num_rows = mysqli_num_rows($query);
                     if ($query) {
                        if ($num_rows == 0) {
                           echo '<tr>
                                 <td class="bg-transparent"><h3>No record</h3></td>
                              </tr>';
                        } else {
                           while ($row = mysqli_fetch_assoc($query)) {
                              $room_id = $row['room_id'];
                              $room_name = $row['room_name'];
                              $room_description = $row['room_description'];
                              $room_price = $row['room_price'];
                              $room_img = $row['room_img'];


                              echo '<tr>
                                    <th scope="row">' . $room_id . '</th>
                                    <td>' . $room_name . '</td>
                                    <td>' . $room_description . '</td>
                                    <td>' . $room_price . '</td>
                                    <td> <img src="upload_img/' . $room_img . '" width="50px" height="50px"></td>
                                    <td>
                                       <button class="btn btn-primary" type="button"><a href="roomUpdate.php?updateid=' . $room_id . '" class="text-light text-decoration-none">Update</a></button>
                                       <button class="btn btn-danger"><a href="roomDelete.php? deleteid=' . $room_id . '" class="text-light text-decoration-none">Delete</a></button>
                                    </td>
                                 </tr>';
                           }
                        }
                     }
                     ?>
               </div>
            </div>
            </table>
         </div>


      </div>
   </div>
</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
