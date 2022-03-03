<?php
  include_once 'Database.php';

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $campus = $_POST['campus'];
  $course = $_POST['course'];
  $year = $_POST['year'];
  $birthday = $_POST['birthday'];
  $password = $_POST['password'];

  $user = "SELECT * FROM userinfo WHERE emailAddress = '".$email."';";
  $result = mysqli_query($conn, $user);

  if(mysqli_num_rows($result)) {
    echo '<script>
    alert("Email address already in use!");
    location.href = "../Register.html";
    </script>';
    exit();
  }

  $newUser = "INSERT INTO userinfo (firstName, lastName, emailAddress, campus, course, yearStanding, birthday, password) 
              VALUES ('$fname', '$lname', '$email', '$campus', '$course', '$year', DATE '$birthday', '$password');";
  $insert = mysqli_query($conn, $newUser);

  echo '<script>
    alert("Account successfully created!");
    location.href = "../Login.html";
    </script>';
  exit();