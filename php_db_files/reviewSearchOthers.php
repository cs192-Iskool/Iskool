<?php
  include_once 'Database.php';
  session_start();

  $_SESSION["searchOtherReviews"] = $_POST['search'];

  header("location: ../OtherReviews.php");