<?php
require_once(__DIR__ . '/../config/database.php');
session_start();
if (isset($_SESSION["admin_id"])) {
   header("Location: dashboard.php");
   exit;
}

if (isset($_POST['submit'])) {
   $login = trim($_POST['username'] ?? '');
   $password = trim($_POST['password'] ?? '');

   if ($login === '' || $password === '') {
      $_SESSION['failed'] = "Username/email and password are required.";
      header('Location: login.php');
      exit;
   }

   // Allow login by admin username OR admin email.
   $stmt = mysqli_prepare($conn, "SELECT admin_id, admin_username, admin_password FROM admins WHERE admin_username = ? OR admin_email = ? LIMIT 1");
   if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ss", $login, $login);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = $result ? mysqli_fetch_assoc($result) : null;
      mysqli_stmt_close($stmt);

      if ($row && $password === $row['admin_password']) {
         session_regenerate_id(true);
         $_SESSION['admin_id'] = $row['admin_id'];
         $_SESSION['admin_username'] = $row['admin_username'];
         header('Location: dashboard.php');
         exit;
      }
   }

   $_SESSION['failed'] = "Invalid username/email or password.";
   header('Location: login.php');
   exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href="style.css">
   <title>Admin</title>
</head>
<style>
   body {
      background-color: #f8f9fa;
   }

   .login-container {
      margin-top: 100px;
   }
</style>

<body>
      <div class="container">
         <div class="row justify-content-center login-container">
            <div class="col-4">
               <div class="card" style="box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                  <div class="card-header" style="background-image: linear-gradient(to right, violet, blue, violet);">
                     <h3 class="text-center">Admin Login</h3>
                  </div>
                  <div class="card-body">
                     <form action="login.php" method="POST">
                        <div class="form-group">
                           <?php
                           if (isset($_SESSION['failed'])) {
                              echo '<div class="alert alert-danger p-1 mt-3">' . $_SESSION['failed'] . '</div>';
                              unset($_SESSION['failed']);
                           }

                           ?>
                           <label class="mt-3">Username or Email</label>
                           <input type="text" class="form-control" placeholder="Enter username or email" name="username" required>
                        </div>
                        <div class="form-group">
                           <label for="inputPassword" class="mt-3">Password</label>
                           <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mx-auto d-block mt-2" name="submit">Login</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
</html>
