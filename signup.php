<?php
require_once(__DIR__ . '/config/database.php');

session_start();
if (isset($_SESSION['id'])) {
  header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link rel="stylesheet" href="form.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>

<body>
  <div class="container mt-5">

    <form action="signup.php" method="POST">
    <h2>Sign up</h2>

      <?php
      if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];


        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($query);

        if ($num_rows > 0) {
          echo '<div class="alert alert-danger p-1">Email already exists!</div>';
        }
        if ($password !== $confirm_password) {
          echo '<div class="alert alert-danger p-1">Password does not match!</div>';
        } else {
          $sql = "INSERT INTO users(username, email, password) VALUES ('$username','$email','$password')";
          $query = mysqli_query($conn, $sql);

          if ($query) {
            echo '<div class="alert alert-success p-1">Registered successfully!</div>';
          } else {
            echo '<div class="alert alert-danger p-1">Register failed!</div>';
          }
        }
      }
      ?>
      <label for="username">Username:</label><br>
      <input type="text" id="username" name="username" required><br>

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br>

      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required><br>

      <label for="confirm_password">Confirm Password:</label><br>
      <input type="password" id="confirm_password" name="confirm_password" required><br>
      <input type="submit" value="Submit" name="submit">
      <p>Already have account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>

</html>





