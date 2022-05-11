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
  $chat = "SELECT * FROM activechats WHERE (tuteeID='".$sUID."' OR tuteeID='".$tUID."') AND (tutorID='".$sUID."' OR tutorID='".$tUID."');";
  $query = mysqli_query($conn, $chat);

  if(mysqli_num_rows($query)) {
    $result = mysqli_fetch_assoc($query);
    $update = "UPDATE activechats SET tutorID = $tUID, tuteeID = $sUID, subject = '$subject' WHERE chatID = '".$result["chatID"]."';";
    $insert = mysqli_query($conn, $update);
    header("location: ../Bookings.php");
    exit();
  }

  $newChat = "INSERT INTO activechats (tutorID, tuteeID, subject) VALUES ('$tUID', '$sUID', '$subject');";
  $query = mysqli_query($conn, $newChat);

  $chat = "SELECT activechats.chatID, max(timeCreated) FROM activechats LEFT JOIN messages ON activechats.chatID = messages.chatID WHERE tuteeID='".$_SESSION['userID']."' OR tutorID='".$_SESSION['userID']."' GROUP BY activechats.chatID ORDER BY max(timeCreated) DESC";
  $query = mysqli_query($conn, $chat);
  
  if(mysqli_num_rows($query)) {
    $result = mysqli_fetch_assoc($query);
    $_SESSION["chatID"] = $result["chatID"];
  }

  header("location: ../Bookings.php");
  exit();