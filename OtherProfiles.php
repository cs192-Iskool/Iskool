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
        <link rel="stylesheet" type="text/css" href="css_files/homepageAds.css">
        <link rel="stylesheet" href="css_files/header.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
        <script src = "js_files/homepage.js"></script>
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
                    echo "<img class='main_prof_pic' src='profile_pictures/" . $userInfo['userID'] . ".jpg?'" .  mt_rand() . " alt='Their current profile picture.'>";
                } else {
                    echo "<img class='main_prof_pic' src='images/profpic.jpg' alt='Their current profile picture.'>";
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
                            $avgRating = "SELECT AVG(IF (userID=".$userInfo['userID'].", rating, NULL)) AS avgRating FROM reviews";
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
                <div style="display: flex; flex-wrap: wrap; padding-left: 0px; margin: 0px;" class="ads_display">
                    <?php
                        $user = "SELECT * FROM adinfo WHERE userID=".$_SESSION['profileUserID'].";";
                        $result = mysqli_query($conn, $user);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="ads">';
                            echo '<div class="thumbnail" id="tn_'.$row["adID"].'">';
                            if($row['image'] === NULL) {
                                echo '<img id="img_'.$row["adID"].'" onclick="show_thumbnail(this.id)" style="width: 100%;" src="images/bg.png" alt="Thumbnail for ad."/>';
                            } else {
                                echo '<img id="img_'.$row["adID"].'" onclick="show_thumbnail(this.id)" style="width: 100%;" src="data:image;base64,'.base64_encode($row['image']).'" alt="Thumbnail for ad."/>';
                            }
                            echo '</div>';
                            echo '<div class="sp_horizontal" id="hr_'.$row["adID"].'" style="width: 302px; position: relative; left: -1px;"></div>';
                            echo '<div class="ad_info" id="ai_'.$row["adID"].'">';
                            echo '<div class="primary_info">';
                            echo ''.$userInfo["firstName"].'';
                            echo '</div>';
                            echo '<div class="secondary_info">';
                            echo '<div class="course">';
                            echo ''.$userInfo["course"].'';
                            echo '</div>';
                            echo '<div class="campus">';
                            echo ''.$userInfo["campus"].'';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="ratings">';
                            $avgRating = "SELECT AVG(IF (subject = '".$row['subject']."' AND userID=".$row['userID'].", rating, NULL)) AS avgRating FROM reviews";
                            $query = mysqli_query($conn, $avgRating);
                            $value = mysqli_fetch_assoc($query);
                            $source = round($value['avgRating'], 1);
                            if(strlen(strval($source)) == 1) {
                                echo "<img style='width: 100px;' src='images/".$source.".0".".png' alt='Rating'>";
                            } else {
                                echo "<img style='width: 100px;' src='images/".$source.".png' alt='Rating'>";
                            }
                            echo '</div>';
                            echo '<div class="subject">';
                            echo ''.$row["subject"].'';
                            echo '</div>';
                            echo '<div class="price">';
                            echo ''.$row["price"].'/hr';
                            echo '</div>';
                            if (isset($_SESSION['userID'])) {
                                echo '<form action="php_db_files/createBooking.php" method="POST">';
                                $query = "SELECT * FROM bookings WHERE tuteeID=".$_SESSION['userID']." AND tutorID=".$row["userID"]." AND subject='".$row["subject"]."';";
                                $check = mysqli_query($conn, $query);
                                $query2 = "SELECT * FROM notifs WHERE targetUserID=".$_SESSION['userID']." AND sourceUserID=".$row["userID"]." AND subject='".$row["subject"]."' AND status = 2;";
                                $check2 = mysqli_query($conn, $query2);
                                echo '<input style="display:none" type="number" name="ad" value="'.$row["adID"].'" required>';
                                echo '<div class="book_btn">';
                                if($bookingExists = mysqli_fetch_assoc($check) || $alreadyAccepted = mysqli_fetch_assoc($check2)) {
                                    echo '<button class="book disable" id="btn_'.$row["adID"].'" onclick="disable_button(this.id, "'.$row["subject"].'", "'.$userInfo["firstName"].'", "'.$userInfo["lastName"].'")">Book</button>';
                                } else {
                                    echo '<button class="book" id="btn_'.$row["adID"].'" onclick="disable_button(this.id, &quot;'.$row["subject"].'&quot;, &quot;'.$userInfo["firstName"].'&quot;, &quot;'.$userInfo["lastName"].'&quot;)">Book</button>';
                                }
                                echo '</div>';
                                echo '</form>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
                <div id="pic_overlay"></div>
                <img id="pic">
            </div>
        </div>
        
    </body>
</html>