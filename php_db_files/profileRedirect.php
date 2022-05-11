<?php
  include_once 'Database.php';
  session_start();

  $_SESSION["reviewUserID"] = $_GET["userID"];
  $_SESSION["profileUserID"] = $_GET["userID"];
  $_SESSION["searchOtherReviews"] = "";

  header("location: ../OtherProfiles.php");