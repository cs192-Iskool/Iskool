<?php
  include_once 'Database.php';
  session_start();

  $bookingID = $_POST['bookingID'];

  $deleteBooking = "DELETE FROM bookings WHERE bookingID = $bookingID";
  $delete = mysqli_query($conn, $deleteBooking);

  $getNotif = "SELECT * FROM notifs WHERE bookingID = $bookingID AND status = 1";
  $query = mysqli_query($conn, $getNotif);
  $notif = mysqli_fetch_assoc($query);
  
  $tUID = $notif['targetUserID'];
  $subject = $notif['subject'];
  $sUID = $notif['sourceUserID'];

  $acceptNotif = "INSERT INTO notifs (targetUserID, bookingID, status, subject, sourceUserID) VALUES ('$sUID', '$bookingID', '2', '$subject', '$tUID');";
  $query = mysqli_query($conn, $acceptNotif);

  # Create a chat function for the users

  header("location: ../Bookings.php");
  exit();