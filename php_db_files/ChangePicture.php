<?php
  include_once 'Database.php';
  session_start();

  $userID = $_SESSION["userID"];
  $profpic = $_FILES['profpic'];

  $filename = explode('.', $profpic['name']);
  $picext = strtolower(end($filename));

  if($picext === "jpg") {
      $savepicas = $userID . "." . $picext;
      $saveto = "../profile_pictures/" . $savepicas;
      move_uploaded_file($profpic['tmp_name'], $saveto);
      $updateProfPic = "UPDATE userinfo SET profPic = 1 WHERE userID = $userID;";
      $insert = mysqli_query($conn, $updateProfPic);
      $_SESSION['profPic'] = 1;
      echo '<script>
            location.href = "../EditProfile.php";
            </script>';
      exit();
  } else {
    echo '<script>
    alert("Please use an image with a .jpg extension.");
    location.href = "../EditProfile.php";
    </script>';
    exit();
  }