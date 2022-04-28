<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "testdb";

try {
  $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
} catch (Exception $e ) {
  echo '<script type ="text/JavaScript">';  
  echo 'alert("Error! There is no database connection.");';  
  session_start();
  session_unset();
  session_destroy();
  echo 'window.location.href = "../Login.html";';
  echo '</script>'; 
  exit;
}