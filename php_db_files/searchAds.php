<?php
  include_once 'Database.php';
  session_start();

  $search = $_POST['search'];

  $_SESSION['search'] = $search;
  header("location: ../HomePage.php");
  exit();