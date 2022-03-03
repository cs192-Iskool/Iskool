<?php
  include_once 'Database.php';

  $email = $_POST['email'];
  $password = $_POST['password'];

  $user = "SELECT * FROM userinfo WHERE emailAddress = '".$email."' AND password = '".$password."';";
  $result = mysqli_query($conn, $user);

  if(!(mysqli_num_rows($result))) {
    echo '<script>
    alert("Invalid login! Please check your email address and password.");
    location.href = "../Login.html";
    </script>';
    exit();
  } else {
    $id = mysqli_fetch_assoc($result);

    session_start();
    $_SESSION["userID"] = $id["userID"];
    $_SESSION["firstName"] = $id["firstName"];

    header("location: ../HomePage.php");
    exit();
  }