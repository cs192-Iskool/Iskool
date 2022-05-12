<?php
    include_once 'php_db_files/Database.php';
    session_start();

    $userProfile = "SELECT * FROM userinfo WHERE userID = ".$_SESSION['profileUserID'].";";
    $query = mysqli_query($conn, $userProfile);
    $userInfo = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $userInfo["firstName"] . ' ' . $userInfo["lastName"]; ?> - Iskool</title>
        <link rel="stylesheet" type="text/css" href="css_files/ReviewsAndOthers.css">
        <link rel="stylesheet" href="css_files/header.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
        <script defer src="js_files/header.js"></script>
        <script defer src="js_files/selectRating.js"></script>
    </head>
    <body>
        <div class="top">
            <div class="home">
                <button class="header_links">
                <a href="php_db_files/clearInputs.php">ISKOOL</a>
                </button>
            </div>
            <div class="header_navigate">
                <?php
                    if (isset($_SESSION["userID"])) {
                        echo "<button type='button' class='header_links'><a href='MyAds.php'>My Ads</a></button>";
                        echo "<button type='button' class='header_links'><a href='Bookings.php'>Bookings</a></button>";
                        echo "<button type='button' class='header_links'><a href='Messages.php'>Messages</a></button>";
                        echo "<img style='width: 36px; height: 40px;' class='header_links' id='notifs_list' src='images/notif.png' onclick='show_notifs()' alt='Notifications'>";
                        echo "<button type='button' class='header_links' id='dropdown' onclick='show_dropdown()'> " . $_SESSION['firstName'];
                        if($_SESSION['profPic']) {
                            echo "<img class='corner_prof_pic' id='corner_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                        } else {
                            echo "<img class='corner_prof_pic' id='corner_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                        }
                        echo "</button>";
                    } else {
                        echo "<button type='button' class='header_links'><a href='Register.html'>Sign Up</a></button>";
                        echo "<button type='button' class='header_links'><a href='Login.html'>Sign In</a></button>";
                    }
                ?>
            </div>
            <?php
                if (isset($_SESSION["userID"])) {
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
                }
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
                if($userInfo['profPic']) {
                    echo "<img class='main_prof_pic' src='profile_pictures/" . $userInfo['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
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
                        <form action="php_db_files/profileRedirect.php?userID=<?php echo $_SESSION['profileUserID'] ?>" method="POST">
                            <button class="review_btn">Profile</button>
                        </form>
                    </div>
                    <div>
                        <form action="php_db_files/reviewRedirect.php?userID=<?php echo $_SESSION['reviewUserID'] ?>" method="POST">
                            <button class="review_btn">Reviews</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="vertical" style="float: left;"></div>
            <div class="info_box">
                <div class="rating">
                    <div class="user_info">
                        <?php
                            $avgRating = "SELECT AVG(IF (subject LIKE '%".$_SESSION['searchOtherReviews']."%' AND userID=".$_SESSION['profileUserID'].", rating, NULL)) AS avgRating FROM reviews";
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
                <div class="user_info"><?php echo $userInfo['firstName']." ". $userInfo['lastName'] ?></div>
                <div class="user_info"><?php echo $userInfo['course'] ?></div>
                <div class="user_info"><?php echo $userInfo['campus'] ?></div>

                <div class="review_header">
                    <div class="review_number">
                        <?php
                            $getCount = "SELECT COUNT(*) AS total FROM reviews WHERE (userID=".$_SESSION['reviewUserID'].") AND (subject LIKE '%".$_SESSION['searchOtherReviews']."%');";
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
                    </div>
                    <div class="review_search">
                        <form action="php_db_files/reviewSearchOthers.php" method="POST">
                            Enter a subject: 
                            <input type = "text" id = "search" name = "search" value = "">
                        </form> 
                    </div>
                </div>
                <div class="reviews">
                    <?php
                        if(isset($_SESSION["userID"])){
                            $countAccept = "SELECT COUNT(*) AS total FROM notifs WHERE sourceUserID=".$userInfo['userID']." AND targetUserID=".$_SESSION['userID']." AND status=2;";
                            $query = mysqli_query($conn, $countAccept);
                            $total = mysqli_fetch_assoc($query);
                            if($total['total']){
                                $checkBookings = "SELECT * FROM notifs WHERE sourceUserID=".$userInfo['userID']." AND targetUserID=".$_SESSION['userID']." AND status=2;";
                                $query = mysqli_query($conn, $checkBookings);
                                $result = mysqli_fetch_assoc($query);
                                $countReview = "SELECT COUNT(*) AS total FROM reviews WHERE userID=".$result['sourceUserID']." AND reviewerID=".$result['targetUserID'].";";
                                $query2 = mysqli_query($conn, $countReview);
                                $result2 = mysqli_fetch_assoc($query2);
                                if($total['total'] == $result2['total']){}
                                else {
                                    echo "<form action='php_db_files/submitReview.php' method='POST'>";
                                    echo "<input style='display: none;' type = 'number' name = 'userID' value = ".$userInfo['userID'].">";
                                    echo "<input style='display: none;' type = 'number' name = 'reviewerID' value = ".$_SESSION['userID'].">";
                                    echo "<div class='leave_review'>";
                                    echo "<div class='reviewer_info'>";
                                    echo "<div class='review_prof_pic_container'>";
                                    if($_SESSION['profPic']) {
                                        echo "<img class='review_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                                    } else {
                                        echo "<img class='review_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                                    }
                                    echo "</div>";
                                    echo "<div class='reviewer_name'>".$_SESSION['firstName']."</div>";
                                    echo "</div>";
                                    echo "<div class='review_details'>";
                                    echo "<div class='review_rating'>";
                                    echo "<div style='width: 60px; font-size: large; padding-top: 25px;'>Rating:</div>";
                                    echo "<img class='star' id='star1' src='images/emptyStar.png' onclick='choose_rating(this.id)' alt='Rating.'>";
                                    echo "<img class='star' id='star2' src='images/emptyStar.png' onclick='choose_rating(this.id)' alt='Rating.'>";
                                    echo "<img class='star' id='star3' src='images/emptyStar.png' onclick='choose_rating(this.id)' alt='Rating.'>";
                                    echo "<img class='star' id='star4' src='images/emptyStar.png' onclick='choose_rating(this.id)' alt='Rating.'>";
                                    echo "<img class='star' id='star5' src='images/emptyStar.png' onclick='choose_rating(this.id)' alt='Rating.'>";
                                    echo "<div style='padding-left: 25px; width: 65px; font-size: large; padding-top: 25px;'>Subject:</div>";
                                    echo "<input style='display: none;' id='submit_rating' type = 'number' name = 'rating' value=0>";
                                    echo "<select class='select_subject' name='subject' required>";
                                    $checkReview = "SELECT * FROM reviews WHERE subject='".$result['subject']."' AND userID=".$result['sourceUserID']." AND reviewerID=".$result['targetUserID'].";";
                                    $query3 = mysqli_query($conn, $checkReview);
                                    if($result3 = mysqli_fetch_assoc($query3)){}
                                    else {echo "<option value='".$result['subject']."'>".$result['subject']."</option>";}
                                    while($result = mysqli_fetch_assoc($query)) {
                                        $checkReview = "SELECT * FROM reviews WHERE subject='".$result['subject']."' AND userID=".$result['sourceUserID']." AND reviewerID=".$result['targetUserID'].";";
                                        $query4 = mysqli_query($conn, $checkReview);
                                        if($result4 = mysqli_fetch_assoc($query4)){}
                                        else {
                                            echo "<option value='".$result['subject']."'>".$result['subject']."</option>";
                                        }
                                    }
                                    echo "</select>";
                                    echo "</div>";
                                    echo "<textarea maxlength='300' type = 'text' class = 'review_input' name = 'review' placeholder='Click here to leave a review...'></textarea>";
                                    echo "</div>";
                                    echo "<div class='submit_review_container'>";
                                    echo "<button class='submit_review'>Submit</button>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</form>";
                                }
                            }
                        }
                        $getReviews = "SELECT * FROM reviews WHERE (userID = ".$userInfo['userID'].") AND (subject LIKE '%".$_SESSION['searchOtherReviews']."%') ORDER BY timeCreated DESC;";
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
                        $_SESSION['searchOtherReviews'] = "";
                    ?>
                </div>
            </div>
        </div>
        
    </body>
</html>
