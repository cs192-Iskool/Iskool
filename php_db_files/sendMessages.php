<?php
  include_once 'Database.php';
  session_start();

  $user = $_SESSION["userID"];
  $message = $_POST['message'];
  $chat = $_GET['chat'];

  if(!empty($message)) {
    $newMsg = sprintf("INSERT INTO messages (chatID, senderID, message) VALUES ('$chat','$user','%s');", mysqli_real_escape_string($conn, $message));
    $insert = mysqli_query($conn, $newMsg);
  }

  header("location: ../Messages.php");
  exit();