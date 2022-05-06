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

  $rejectNotif = "INSERT INTO notifs (targetUserID, bookingID, status, subject, sourceUserID) VALUES ('$tUID', '$bookingID', '4', '$subject', '$sUID');";
  $query = mysqli_query($conn, $rejectNotif);

  header("location: ../Bookings.php");
  exit();