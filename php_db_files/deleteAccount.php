<?php
  include_once 'Database.php';
  session_start();

  $userID = $_SESSION["userID"];


  $user = "SELECT * FROM userinfo WHERE userID = '".$userID."';";
  $result = mysqli_query($conn, $user);

  $deleteUser = "DELETE FROM userinfo WHERE userID = $userID";
  $delete = mysqli_query($conn, $deleteUser);

  if($delete) {
    echo '<script>
    alert("Account successfully deleted.");
    </script>';
  }

  session_unset();
  session_destroy();
  
  header("location: ../Login.html");