<?php
  include_once 'Database.php';
  session_start();

  $_SESSION["sort"] = $_GET['sort'];

  header("location: ../HomePage.php");
  exit();