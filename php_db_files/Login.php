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
    $_SESSION["sort"] = "Newest";
    $_SESSION["campusFilter"] = "";
    $_SESSION["priceFilter"] = "";
    $_SESSION["minPriceFilter"] = "";
    $_SESSION["maxPriceFilter"] = "";
    $_SESSION["searchReview"] = "";

    $chat = "SELECT activechats.chatID, max(timeCreated) FROM activechats LEFT JOIN messages ON activechats.chatID = messages.chatID WHERE tuteeID='".$_SESSION['userID']."' OR tutorID='".$_SESSION['userID']."' GROUP BY activechats.chatID ORDER BY max(timeCreated) DESC";
    $query = mysqli_query($conn, $chat);
    
    if(mysqli_num_rows($query)) {
      $result = mysqli_fetch_assoc($query);
      $_SESSION["chatID"] = $result["chatID"];
    } else {
      $_SESSION["chatID"] = "";
    }

    header("location: ../HomePage.php");
    exit();
  }