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

                     $sql = "SELECT * FROM rooms WHERE room_id = '$id'";
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
                     $room_name = $_POST['room_name'];
                     $room_description = $_POST['room_description'];
                     $room_price = $_POST['room_price'];
                     $upload_dir = __DIR__ . "/upload_img";
                     if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                     }

                     $room_img = $row['room_img'];
                     if (!empty($_FILES["room_img"]['name'])) {
                        $original_name = basename($_FILES["room_img"]['name']);
                        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

                        if (!in_array($ext, $allowed)) {
                           $_SESSION['failed'] = "Only JPG, JPEG, PNG, and WEBP are allowed.";
                           header('Location: roomUpdate.php?updateid=' . $new_id);
                           exit;
                        }

                        $new_room_img = uniqid("room_", true) . "." . $ext;
                        $target_file = $upload_dir . DIRECTORY_SEPARATOR . $new_room_img;

                        if (!move_uploaded_file($_FILES["room_img"]["tmp_name"], $target_file)) {
                           $_SESSION['failed'] = "Image upload failed.";
                           header('Location: roomUpdate.php?updateid=' . $new_id);
                           exit;
                        }

                        if (!empty($room_img)) {
                           $old_file = $upload_dir . DIRECTORY_SEPARATOR . $room_img;
                           if (file_exists($old_file)) {
                              unlink($old_file);
                           }
                        }
                        $room_img = $new_room_img;
                     }

                     $sql = "UPDATE rooms SET room_name = '$room_name', room_description ='$room_description', room_price = '$room_price', room_img = '$room_img' WHERE room_id = '$new_id'";
                     $query = mysqli_query($conn, $sql);
                     if (!$query) {
                        $_SESSION['failed'] = "Room info can't update!";
                     } else {
                        $_SESSION['success'] = "Room updated successfully!";
                        header('Location: rooms.php');
                     }
                     exit;
                  }

                  ?>

                  <form action="roomUpdate.php?new_id=<?php echo $id ?>" method="post" class="p-5" enctype="multipart/form-data">
                     <h1 class="text-center">Update Room Info</h1>
                     <label class="form-label"><b>Name</b></label>
                     <div class="form-group">
                        <input type="text" class="form-control" name="room_name" value="<?php echo $row['room_name'] ?>" required>
                     </div>
                     <label class="form-label"><b>Description</b></label>
                     <div class="form-group">
                        <input type="texts" class="form-control" name="room_description" value="<?php echo $row['room_description'] ?>" required>
                     </div>
                     <label class="form-label"><b>Price</b></label>
                     <div class="form-group">
                        <input type="number" class="form-control" name="room_price" value="<?php echo $row['room_price'] ?>" required>
                     </div>
                     <label class="form-label"><b>Image</b></label>
                     <div class="form-group">
                        <input type="file" class="form-control" name="room_img">
                     </div>
                     <div class="form-btn">
                        <input type="submit" class="btn btn-primary float-end" value="Update" name="update">
                        <button class="btn btn-secondary float-end"><a href="rooms.php" class="text-decoration-none text-light">Cancel</a></button>
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
