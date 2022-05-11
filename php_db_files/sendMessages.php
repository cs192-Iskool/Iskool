<?php
  include_once 'Database.php';
  session_start();

  $user = $_SESSION["userID"];
  $message = $_POST['message'];
  $chat = $_GET['chat'];

  $newMsg = "INSERT INTO messages (chatID, senderID, message) 
              VALUES ('$chat','$user','$message');";
  $insert = mysqli_query($conn, $newMsg);

  header("location: ../Messages.php");
  exit();