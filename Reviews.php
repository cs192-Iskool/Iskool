<?php
    include_once 'php_db_files/Database.php';
    session_start();

    if (!isset($_SESSION["userID"])) {
        header("location: Login.html");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_SESSION["firstName"] . ' ' . $_SESSION["lastName"]; ?> - Iskool</title>
        <link rel="stylesheet" type="text/css" href="css_files/ReviewsAndOthers.css">
        <link rel="stylesheet" href="css_files/header.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
        <script defer src="js_files/AccountProfile.js"></script>
        <script defer src="js_files/header.js"></script>
    </head>
    <body>
        <div class="top">
            <div class="home">
                <button class="header_links">
                <a href="php_db_files/clearInputs.php">ISKOOL</a>
                </button>
            </div>
            <div class="header_navigate">
                <button type="button" class="header_links"><a href="MyAds.php">My Ads</a></button>
                <button type="button" class="header_links"><a href='Bookings.php'>Bookings</a></button>
                <button type="button" class="header_links"><a href='Messages.php'>Messages</a></button>
                <img style='width: 36px; height: 40px;' class='header_links' id='notifs_list' src='images/notif.png' onclick='show_notifs()' alt='Notifications'>
                <button type="button" class="header_links" id="dropdown" onclick="show_dropdown()"><?php echo $_SESSION["firstName"]; ?>
                    <?php
                        if($_SESSION['profPic']) {
                            echo "<img class='corner_prof_pic' id='corner_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                        } else {
                            echo "<img class='corner_prof_pic' id='corner_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                        }
                    ?>
                </button>
            </div>
            <?php
                echo "<div class='notif_panel' id='notifs'>";
                $getNotifs = "SELECT * FROM notifs WHERE targetUserID=".$_SESSION['userID']." OR (sourceUserID=".$_SESSION['userID']." AND status = 5) ORDER BY timeCreated DESC;";
                $notifsList = mysqli_query($conn, $getNotifs);
                for($i = 0; $i < 6; $i++) {
                    if($notif = mysqli_fetch_assoc($notifsList)){
                        if($notif['status'] == 1){
                            echo "<a style='color: #000000; text-decoration: none;' href='Bookings.php'>";
                        } else {
                            echo "<a style='color: #000000; text-decoration: none;' href='PastBookings.php'>";
                        }
                        echo "<div class='notif'>";
                        echo "<div class='notif_message'>";
                        if($notif['status'] == 1){
                            # new booking
                            $getName = "SELECT firstName, lastName FROM userinfo WHERE userID=".$notif['sourceUserID'].";";
                            $query = mysqli_query($conn, $getName);
                            $name = mysqli_fetch_assoc($query);
                            echo "You have received a booking request from ".$name['firstName']." ".$name['lastName']." for ".$notif['subject'].".";
                        } else if($notif['status'] == 2){
                            # accepted booking
                            $getName = "SELECT firstName, lastName FROM userinfo WHERE userID=".$notif['sourceUserID'].";";
                            $query = mysqli_query($conn, $getName);
                            $name = mysqli_fetch_assoc($query);
                            echo $name['firstName']." ".$name['lastName']." has accepted your booking request for ".$notif['subject'].".";
                        } else if($notif['status'] == 3){
                            # declined booking
                            $getName = "SELECT firstName, lastName FROM userinfo WHERE userID=".$notif['sourceUserID'].";";
                            $query = mysqli_query($conn, $getName);
                            $name = mysqli_fetch_assoc($query);
                            echo $name['firstName']." ".$name['lastName']." has rejected your booking request for ".$notif['subject'].".";
                        } else if($notif['status'] == 4){
                            # canceled booking
                            $getName = "SELECT firstName, lastName FROM userinfo WHERE userID=".$notif['sourceUserID'].";";
                            $query = mysqli_query($conn, $getName);
                            $name = mysqli_fetch_assoc($query);
                            echo "A booking request from ".$name['firstName']." ".$name['lastName']." for your services for ".$notif['subject']." has been cancelled.";
                        } else if($notif['status'] == 5){
                            # expired booking
                            if($notif['sourceUserID'] == $_SESSION['userID']) {
                                $getName = "SELECT firstName, lastName FROM userinfo WHERE userID=".$notif['targetUserID'].";";
                                $query = mysqli_query($conn, $getName);
                                $name = mysqli_fetch_assoc($query);
                                echo "Your booking request for ".$name['firstName']." ".$name['lastName']." for ".$notif['subject']." has expired.";
                            } else {
                                $getName = "SELECT firstName, lastName FROM userinfo WHERE userID=".$notif['sourceUserID'].";";
                                $query = mysqli_query($conn, $getName);
                                $name = mysqli_fetch_assoc($query);
                                echo "A booking request from ".$name['firstName']." ".$name['lastName']." for your services for ".$notif['subject']." has expired.";
                            }
                        }
                        echo "</div>";
                        echo "<div class='time'>";
                        echo substr($notif["timeCreated"], 11, 5);
                        echo "</div>";
                        echo "</div>";
                        echo "</a>";
                    } else {
                        break;
                    }
                }
                echo "</div>";
            ?>
            <div class="dropdown_popup" id="dropdown_elements">
                <div>
                    <a style="color: black;" href="AccountProfile.php">Profile</a>
                </div>
                <div style="margin-top: 10px; margin-bottom: 10px;"class="horizontal"></div>
                <div>
                    <a style="color: black;" href="php_db_files/Logout.php">Log Out</a>
                </div>
            </div>
        </div>
        <div class="horizontal"></div>
        <div class="prof_pic">
            <?php
                if($_SESSION['profPic']) {
                    echo "<img class='main_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                } else {
                    echo "<img class='main_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                }
            ?>
        </div>
        <div class="horizontal"></div>
        <div class="main">
            <div class="sidebar">
                <div class="sidebar_navigate">
                    <div>
                        <a href="AccountProfile.php">Profile</a>
                    </div>
                    <div>
                        <a href="Reviews.php">Reviews</a>
                    </div>
                </div>
            </div>
            <div class="vertical" style="float: left;"></div>
            <div class="info_box">
                <div class="rating">
                    <div class="user_info">
                        <?php
                            $avgRating = "SELECT AVG(IF (subject LIKE '%".$_SESSION['searchReview']."%' AND userID=".$_SESSION['userID'].", rating, NULL)) AS avgRating FROM reviews";
                            $query = mysqli_query($conn, $avgRating);
                            $value = mysqli_fetch_assoc($query);
                            $source = round($value['avgRating'], 1);
                            if(strlen(strval($source)) == 1) {
                                echo "<img class='avg_rating' src='images/".$source.".0".".png' alt='Rating'>";
                            } else {
                                echo "<img class='avg_rating' src='images/".$source.".png' alt='Rating'>";
                            }
                        ?>
                    </div>
                </div>
                <div class="review_header" style="padding-top: 0px;">
                    <?php
                        $getCount = "SELECT COUNT(*) AS total FROM reviews WHERE (userID=".$_SESSION['userID'].") AND (subject LIKE '%".$_SESSION['searchReview']."%');";
                        $query = mysqli_query($conn, $getCount);
                        $count = mysqli_fetch_assoc($query);
                    ?>
                    <div class="review_number">
                        <?php
                            if($count['total'] == 1) {
                                echo $count['total']." review";
                            } else {
                                echo $count['total']." reviews";
                            }
                        ?>
                    </div>
                    <div class="review_search">
                        <form action="php_db_files/reviewSearch.php" method="POST">
                        Enter a subject: 
                        <input type = "text" id = "search" name = "search" value = "">
                        </form>
                    </div>
                </div>
                <div class="reviews">
                    <?php
                        $getReviews = "SELECT * FROM reviews WHERE (userID = ".$_SESSION['userID'].") AND (subject LIKE '%".$_SESSION['searchReview']."%') ORDER BY timeCreated DESC;";
                        $query = mysqli_query($conn, $getReviews);
                        while($review = mysqli_fetch_assoc($query)) {
                            $getReviewerInfo = "SELECT userID, firstName, profPic FROM userInfo WHERE userID=".$review['reviewerID'].";";
                            $query2 = mysqli_query($conn, $getReviewerInfo);
                            $info = mysqli_fetch_assoc($query2);
                            echo "<div class='actual_review'>";
                            echo "<div class='reviewer_info'>";
                            echo "<div class='review_prof_pic_container'>";
                            if($info['profPic']) {
                                echo "<img class='review_prof_pic' src='profile_pictures/" . $info['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                            } else {
                                echo "<img class='review_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                            }
                            echo "</div>";
                            echo "<div class='reviewer_name'>".$info['firstName']."</div>";
                            echo "</div>";
                            echo "<div class='review_details'>";
                            echo "<div class='review_rating'>";
                            echo "<div style='width: 60px; font-size: large; padding-top: 25px;'>Rating:</div>";
                            echo "<img class='review_star' src='images/".$review['rating'].".0".".png' alt='Rating.'>";
                            echo "<div style='padding-left: 25px; width: 65px; font-size: large; padding-top: 25px; margin-right: 10px;'>Subject:</div>";
                            echo "<div style='width: 300px; font-size: large; padding-top: 25px;'>".$review['subject']."</div>";
                            echo "</div>";
                            echo "<div class = 'review_message'>".$review['review']."</div>";
                            echo "</div>";
                            echo "<div class='review_time_container'>";
                            echo "<div class='review_time'>".substr($review['timeCreated'], 0, 10)."</div>";
                            echo "<div class='review_time'>".substr($review['timeCreated'], 11, 5)."</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                        $_SESSION['searchReview'] = "";
                    ?>
                </div>
            </div>
        </div>
        
    </body>
</html>
