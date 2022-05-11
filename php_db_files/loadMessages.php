<!--I think this should just modify the value of $_SESSION["convoID"] then go back to ../Messages.php

<?php
  include_once 'Database.php';
  session_start();

  $chat = $_GET['chat'];

  $_SESSION['chatID'] = $chat;

  header("location: ../Messages.php");
  exit();