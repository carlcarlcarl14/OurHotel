<?php
require_once(__DIR__ . '/config/database.php');
session_start();

if (isset($_SESSION['id'])) {
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Register Form</title>
  <link rel="stylesheet" href="form.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

  <div class="container mt-5">

    <form action="login.php" method="POST">
      <h2>Login</h2>

      <?php
      if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
        echo '<div class="alert alert-success p-1 mt-3">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
      }
      if (isset($_SESSION['failed']) && $_SESSION['failed'] != '') {
        echo '<div class="alert alert-danger p-1 mt-3">' . $_SESSION['failed'] . '</div>';
        unset($_SESSION['failed']);
      }
      ?>

      <?php
      if (isset($_POST['submit'])) {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE email = ? LIMIT 1");
        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $row = $result ? mysqli_fetch_assoc($result) : null;
          mysqli_stmt_close($stmt);

          if ($row && $password === $row['password']) {
            session_regenerate_id(true);
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header('Location: index.php');
            exit;
          }
        }

        $_SESSION['failed'] = "Invalid email or password";
        header('Location: login.php');
        exit;
      }
      ?>
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required><br>
      <input type="submit" value="Login" name="submit">
      <p>Dont have account yet? <a href="signup.php">Sign up</a></p>
    </form>
  </div>

</body>

</html>
