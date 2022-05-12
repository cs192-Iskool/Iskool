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

  header("location: ../OtherReviews.php");
  exit();