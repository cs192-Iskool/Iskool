<?php
  include_once 'Database.php';
  session_start();

  $userID = $_SESSION["userID"];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $campus = $_POST['campus'];
  $course = $_POST['course'];
  $year = $_POST['year'];
  $birthday = $_POST['birthday'];
  $password = $_POST['password'];
  $confPassword = $_POST['confPassword'];

  $user = "SELECT * FROM userinfo WHERE userID = '".$userID."';";
  $result = mysqli_query($conn, $user);

  if(!mysqli_num_rows($result)) {
    echo '<script>
    alert("An unexpected error occured.");
    location.href = "../EditProfile.php";
    </script>';
    exit();
  }

  $updateUser = "UPDATE userinfo 
              SET firstName = '$fname', lastName = '$lname', campus = '$campus', course = '$course', yearStanding = '$year', birthday = DATE '$birthday', password = '$password'
              WHERE userID = $userID;";
  $insert = mysqli_query($conn, $updateUser);

  $_SESSION["firstName"] = $fname;
  $_SESSION["lastName"] = $lname;
  $_SESSION["birthday"] = $birthday;
  $_SESSION["campus"] = $campus;
  $_SESSION["course"] = $course;
  $_SESSION["yearStanding"] = $year;
  $_SESSION["password"] = $password;

  echo '<script>
    alert("Account successfully updated!");
    location.href = "../AccountProfile.php";
    </script>';
  exit();