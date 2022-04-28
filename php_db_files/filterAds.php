<?php
  include_once 'Database.php';
  session_start();

  $campus = $_GET['campus'];
  $price = $_GET['price'];

  if($campus) {
    if($_SESSION['filters'] == 2 || $_SESSION['filters'] == 3) {
      $_SESSION['filters'] = 3;
    } else {
      $_SESSION['filters'] = 1;
    }

    if($campus == 1) {
      $_SESSION['campusFilter'] = "UP Diliman";
    } else if($campus == 2) {
      $_SESSION['campusFilter'] = "UP Los Baños";
    } else if($campus == 3) {
      $_SESSION['campusFilter'] = "UP Manila";
    } else if($campus == 4) {
      $_SESSION['campusFilter'] = "UP Visayas";
    } else if($campus == 5) {
      $_SESSION['campusFilter'] = "UP Open University";
    } else if($campus == 6) {
      $_SESSION['campusFilter'] = "UP Mindanao";
    } else if($campus == 7) {
      $_SESSION['campusFilter'] = "UP Baguio";
    } else if($campus == 8) {
      $_SESSION['campusFilter'] = "UP Cebu";
    }
  }

  if($price) {
    if($_SESSION['filters'] == 1 || $_SESSION['filters'] == 3) {
      $_SESSION['filters'] = 3;
    } else {
      $_SESSION['filters'] = 2;
    }

    if($price == 1) {
      $_SESSION['priceFilter'] = "< 200";
      $_SESSION['minPriceFilter'] = 1;
      $_SESSION['maxPriceFilter'] = 200;
    } else if($price == 2) {
      $_SESSION['priceFilter'] = "200 - 599";
      $_SESSION['minPriceFilter'] = 200;
      $_SESSION['maxPriceFilter'] = 600;
    } else if($price == 3) {
      $_SESSION['priceFilter'] = "600 - 999";
      $_SESSION['minPriceFilter'] = 600;
      $_SESSION['maxPriceFilter'] = 1000;
    } else if($price == 4) {
      $_SESSION['priceFilter'] = "> 1000";
      $_SESSION['minPriceFilter'] = 1000;
      $_SESSION['maxPriceFilter'] = PHP_FLOAT_MAX;
    }
  }

  header("location: ../HomePage.php");
  exit();