<?php
  include_once 'Database.php';
  session_start();

  $_SESSION['search'] = "";
  $_SESSION['filters'] = 0;
  $_SESSION['campusFilter'] = "";
  $_SESSION["priceFilter"] = "";
  $_SESSION['minPriceFilter'] = "";
  $_SESSION['maxPriceFilter'] = "";

  header("location: ../HomePage.php");
  exit();