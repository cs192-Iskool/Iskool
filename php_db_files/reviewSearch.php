<?php
  include_once 'Database.php';
  session_start();

  $_SESSION["searchReview"] = $_POST['search'];

  header("location: ../Reviews.php");