<?php
    include_once 'php_db_files/Database.php';
    session_start();

    if (!isset($_SESSION["userID"])) {
        header("location: Login.html");
    }

    $notifs = "SELECT * FROM notifs WHERE (targetUserID = '".$_SESSION["userID"]."' OR sourceUserID = '".$_SESSION["userID"]."') AND status<>1 ORDER BY timeCreated DESC;";
    $result = mysqli_query($conn, $notifs);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bookings - Iskool</title>
        <link rel="stylesheet" type="text/css" href="css_files/Bookings.css">
        <link rel="stylesheet" href="css_files/header.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
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
                <img style="width: 36px; height: 40px;" class="header_links" id="notifs_list" src="images/notif.png" onclick="show_notifs()" alt="Notifications">
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
        <div class="whitespace">
            <h1 class="label">Bookings</h1>
        </div>
        <div class="horizontal"></div>
        <div class="main">
            <div class="sidebar">
                <div class="sidebar_navigate">
                    <div>
                        <a href="MyAds.php">Active Ads</a>
                    </div>
                    <div>
                        <a href="Bookings.php">Awaiting Response</a>
                    </div>
                    <div>
                        <a href="PastBookings.php">Past Bookings</a>
                    </div>
                </div>
            </div>
            <div class="info_box">
                <?php
                    $notif = mysqli_fetch_assoc($result);
                    if(!($notif)) {
                        echo '<div style="font-size: 30px; margin-left: auto; margin-right: auto;">You have no past bookings.</div>';
                    } else {
                        while($notif) {
                            echo '<div class="all_info">';
                            if($notif["targetUserID"] != $_SESSION["userID"]) {
                                $getSource = "SELECT userID, firstName, profPic FROM userinfo WHERE userID = '".$notif["targetUserID"]."';";
                                $query = mysqli_query($conn, $getSource);
                                $pic = mysqli_fetch_assoc($query);
                                echo '<div class="info_left">';
                                if($pic['profPic']) {
                                    echo "<img class='info_prof_pic' src='profile_pictures/" . $pic['userID'] . ".jpg?'" .  mt_rand() . " alt='Tutor profile picture.'>";
                                } else {
                                    echo "<img class='info_prof_pic' src='images/profpic.jpg' alt='Tutor profile picture.'>";
                                }
                                if($notif["status"] == 5 || $notif["status"] == 4){
                                    echo '<div class="info_message">You have booked <b>'.$pic["firstName"].'</b>\'s service for <b>'.$notif["subject"].'</b>.</div>';
                                } else {
                                    echo '<div class="info_message"><b>'.$pic["firstName"].'</b> has booked your service for <b>'.$notif["subject"].'</b>.</div>';
                                }
                                echo '</div>';
                                echo '<div class="info_time">';
                                echo substr($notif["timeCreated"], 0, 16);
                                echo '</div>';
                                echo '<div class="notif_status">';
                                if($notif['status'] == 2){
                                    # accepted booking
                                    echo "<div style='color: #00ff10; font-size: larger; padding-right: 25px;'>Accepted</div>";
                                } else if($notif['status'] == 3){
                                    # declined booking
                                    echo "<div style='color: red; font-size: larger; padding-right: 25px;'>Rejected</div>";
                                } else if($notif['status'] == 4){
                                    # canceled booking
                                    echo "<div style='color: gray; font-size: larger; padding-right: 25px;'>Cancelled</div>";
                                } else if($notif['status'] == 5){
                                    # expired booking
                                    echo "<div style='color: gray; font-size: larger; padding-right: 25px;'>Expired</div>";
                                }
                                echo '</div>';
                            } else {
                                $getTarget = "SELECT userID, firstName, profPic FROM userinfo WHERE userID = '".$notif["sourceUserID"]."';";
                                $query = mysqli_query($conn, $getTarget);
                                $pic = mysqli_fetch_assoc($query);
                                echo '<div class="info_left">';
                                if($pic['profPic']) {
                                    echo "<img class='info_prof_pic' src='profile_pictures/" . $pic['userID'] . ".jpg?'" .  mt_rand() . " alt='Tutor profile picture.'>";
                                } else {
                                    echo "<img class='info_prof_pic' src='images/profpic.jpg' alt='Tutor profile picture.'>";
                                }
                                if($notif["status"] == 5 || $notif["status"] == 4){
                                    echo '<div class="info_message"><b>'.$pic["firstName"].'</b> has booked your service for <b>'.$notif["subject"].'</b>.</div>';
                                } else {
                                    echo '<div class="info_message">You have booked <b>'.$pic["firstName"].'</b>\'s service for <b>'.$notif["subject"].'</b>.</div>';
                                }
                                echo '</div>';
                                echo '<div class="info_time">';
                                echo substr($notif["timeCreated"], 0, 16);
                                echo '</div>';
                                echo '<div class="notif_status">';
                                if($notif['status'] == 2){
                                    # accepted booking
                                    echo "<div style='color: #00ff10; font-size: larger; padding-right: 25px;'>Accepted</div>";
                                } else if($notif['status'] == 3){
                                    # declined booking
                                    echo "<div style='color: red; font-size: larger; padding-right: 25px;'>Rejected</div>";
                                } else if($notif['status'] == 4){
                                    # canceled booking
                                    echo "<div style='color: gray; font-size: larger; padding-right: 25px;'>Cancelled</div>";
                                } else if($notif['status'] == 5){
                                    # expired booking
                                    echo "<div style='color: gray; font-size: larger; padding-right: 25px;'>Expired</div>";
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                            $notif = mysqli_fetch_assoc($result);
                        }
                    }
                ?>
            </div>
            
        </div>
        
    </body>
</html>
