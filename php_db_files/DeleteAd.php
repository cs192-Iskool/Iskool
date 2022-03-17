<?php
    include_once('Database.php');
    session_start();

    $elementID = $_POST['ad'];

    $number = explode('_', $elementID);
    $adID = end($number);
    
    $ad = "SELECT * FROM adinfo WHERE adID = '".$adID."';";
    $result = mysqli_query($conn, $ad);

    $deleteAd = "DELETE FROM adinfo WHERE adID = $adID";
    $delete = mysqli_query($conn, $deleteAd);
    
    header("location: ../MyAds.php");