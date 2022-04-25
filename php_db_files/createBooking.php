<?php
  include_once 'Database.php';
  session_start();

  $adID = $_POST["ad"];

  $ad = "SELECT * FROM adinfo WHERE adID = '".$adID."';";
  $query = mysqli_query($conn, $ad);
  $result = mysqli_fetch_assoc($query);

  $tuteeID = $_SESSION["userID"];
  $tutorID = $result["userID"];
  $subject = $result["subject"];

  $createBooking = "INSERT INTO bookings (tuteeID, tutorID, subject) VALUES ('$tuteeID', '$tutorID', '$subject');";
  $insertBooking = mysqli_query($conn, $createBooking);

  $getID = "SELECT bookingID FROM bookings WHERE tuteeID = '".$tuteeID."' AND tutorID = '".$tutorID."' AND subject = '".$subject."';";
  $getIDquery = mysqli_query($conn, $getID);
  $IDvalue = mysqli_fetch_assoc($getIDquery);

  $ID = $IDvalue['bookingID'];

  $createNotif = "INSERT INTO notifs (targetUserID, bookingID, status, subject, sourceUserID) VALUES ('$tutorID', '$ID', '1', '$subject', '$tuteeID');";
  $insertNotif = mysqli_query($conn, $createNotif);

  header("location: ../HomePage.php");
  exit();