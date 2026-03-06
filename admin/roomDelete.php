<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
   header("Location: login.php");
}
require_once(__DIR__ . '/../config/database.php');
if (isset($_GET['deleteid'])) {
   $id = $_GET['deleteid'];

   $sql = "DELETE FROM rooms WHERE room_id = '$id'";
   $query = mysqli_query($conn, $sql);
   if ($query) {
      $_SESSION['success'] = "Record deleted successfully.";

      header('location: rooms.php');
   } else {
      $_SESSION['failed'] = "Record not deleted! Please try again.";
      header('location: rooms.php');

   }
}
?>
