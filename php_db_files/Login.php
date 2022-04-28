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
    $_SESSION["lastName"] = $id["lastName"];
    $_SESSION["birthday"] = $id["birthday"];
    $_SESSION["campus"] = $id["campus"];
    $_SESSION["course"] = $id["course"];
    $_SESSION["yearStanding"] = $id["yearStanding"];
    $_SESSION["emailAddress"] = $id["emailAddress"];
    $_SESSION["password"] = $id["password"];
    $_SESSION["profPic"] = $id["profPic"];
    $_SESSION["search"] = "";
    $_SESSION["filters"] = 0;
    $_SESSION["campusFilter"] = "";
    $_SESSION["minPriceFilter"] = "";
    $_SESSION["maxPriceFilter"] = "";

    header("location: ../HomePage.php");
    exit();
  }