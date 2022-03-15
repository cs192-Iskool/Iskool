<?php
  include_once 'Database.php';
  session_start();

  $userID = $_SESSION['userID'];
  $subject = $_POST['subject'];
  $price = $_POST['price'];
  $img = $_FILES['file'];

  $imgName = $img['name'];
  $imgTmp = $img['tmp_name'];
  $imgSize = $img['size'];
  $imgError = $img['error'];

  $ext = explode('.', $imgName);
  $imgExt = strtolower(end($ext));

  $validType = array('jpg', 'jpeg', 'png');

  if(in_array($imgExt, $validType)) {
    if($imgError === 0) {
      if($imgSize < 2097152) {
        $adImg = addslashes(file_get_contents($imgTmp));

        $newAd = "INSERT INTO adinfo (userID, subject, price, image) 
                    VALUES ('$userID', '$subject', '$price', '$adImg');";
        $insert = mysqli_query($conn, $newAd);

        echo '<script>
        alert("Ad successfully created!");
        location.href = "../MyAds.php";
        </script>';
      } else {
        echo '<script>
        alert("Error! Your file is too big.");
        location.href = "../CreateAds.php";
        </script>';
      }
    } else {
      echo '<script>
      alert("There was an error uploading the file.");
      location.href = "../CreateAds.php";
      </script>';
    }
  } else {
    echo '<script>
    alert("Error! You can only upload .jpg, .jpeg, or .png files.");
    location.href = "../CreateAds.php";
    </script>';
  }