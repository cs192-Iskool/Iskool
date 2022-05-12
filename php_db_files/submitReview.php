<?php
  include_once 'Database.php';
  session_start();


  $userID = $_POST['userID'];
  $reviewerID = $_POST['reviewerID'];
  $rating = $_POST['rating'];
  $subject = $_POST['subject'];
  $review = $_POST['review'];

  if($rating == 0) {
    echo "<script>
          alert('Please select a rating from 1 star to 5 stars.');
          location.href = '../OtherReviews.php';
          </script>";
    exit();
  }

  if($review == "") {
    echo "<script>
          alert('Please leave a review.');
          location.href = '../OtherReviews.php';
          </script>";
    exit();
  }

  $createReview = sprintf("INSERT INTO reviews (userID, reviewerID, subject, review, rating) VALUES ('$userID', '$reviewerID', '$subject', '%s', '$rating');", mysqli_real_escape_string($conn, $review));
  $insertReview = mysqli_query($conn, $createReview);
  # ^ also currently can't deal with newline characters. saves everything in one line instead.

  $avgRating = "SELECT AVG(IF (userID=".$userID." AND subject='".$subject."', rating, NULL)) AS avgRating FROM reviews";
  $query = mysqli_query($conn, $avgRating);
  $result = mysqli_fetch_assoc($query);
  $value = round($result['avgRating'], 1);
  
  $updateRating = "UPDATE adinfo SET avgRating = ".$value." WHERE subject = '".$subject."' AND userID = ".$userID.";";
  $query = mysqli_query($conn, $updateRating);

  header("location: ../OtherReviews.php");
  exit();