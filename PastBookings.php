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
        <title>My Ads - Iskool</title>
        <link rel="stylesheet" type="text/css" href="css_files/Bookings.css">
        <link rel="stylesheet" href="css_files/header.css">
        <script defer src="js_files/header.js"></script>
    </head>
    <body>
        <div class="top">
            <div class="home">
                <button class="header_links">
                    <a href="HomePage.php">Iskool</a>
                </button>
            </div>
            <div class="header_navigate">
                <button class="header_links">
                    <a href="MyAds.php">My Ads</a>
                </button>
                <button class="header_links" class="header_links"><a href='Bookings.php'>Bookings</a></button>
                <button class="header_links" class="header_links">Messages</button>
                <button class="header_links" class="header_links" id="notifs_list" onclick="show_notifs()">(notif)</button>
                <button class="header_links" class="header_links" id="dropdown" onclick="show_dropdown()"><?php echo $_SESSION["firstName"]; ?>
                    <?php
                        if($_SESSION['profPic']) {
                            echo "<img class='corner_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                        } else {
                            echo "<img class='corner_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                        }
                    ?>
                </button>
            </div>
            <?php
                echo "<div class='notif_panel' id='notifs'>";
                $getNotifs = "SELECT * FROM notifs WHERE targetUserID=".$_SESSION['userID']." ORDER BY timeCreated DESC;";
                $notifsList = mysqli_query($conn, $getNotifs);
                for($i = 0; $i < 6; $i++) {
                    if($notif = mysqli_fetch_assoc($notifsList)){
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
                            echo "tbd";
                        } else if($notif['status'] == 3){
                            # declined booking
                            echo "tbd";
                        } else if($notif['status'] == 4){
                            # canceled booking
                            echo "tbd";
                        } else if($notif['status'] == 5){
                            # expired booking
                            echo "tbd";
                        }
                        
                        echo "</div>";
                        echo "<div class='time'>";
                        echo substr($notif["timeCreated"], 11, 5);
                        echo "</div>";
                        echo "</div>";
                    } else {
                        break;
                    }
                }
                echo "</div>";
            ?>
            <div class="dropdown_popup" id="dropdown_elements">
                <div>
                    <a href="AccountProfile.php">Profile</a>
                </div>
                <div style="margin-top: 10px; margin-bottom: 10px;"class="horizontal"></div>
                <div>
                    <a href="php_db_files/Logout.php">Log Out</a>
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
                    while($notif = mysqli_fetch_assoc($result)) {
                        echo '<div class="all_info">';
                        if($notif["targetUserID"] == $_SESSION["userID"]) {
                            $getSource = "SELECT userID, firstName, profPic FROM userinfo WHERE userID = '".$notif["sourceUserID"]."';";
                            $query = mysqli_query($conn, $getSource);
                            $pic = mysqli_fetch_assoc($query);
                            echo '<div class="info_left">';
                            if($pic['profPic']) {
                                echo "<img class='info_prof_pic' src='profile_pictures/" . $pic['userID'] . ".jpg?'" .  mt_rand() . " alt='Tutor profile picture.'>";
                            } else {
                                echo "<img class='info_prof_pic' src='images/profpic.jpg' alt='Tutor profile picture.'>";
                            }
                            echo '<div class="info_message"><b>'.$pic["firstName"].'</b> has booked your service for <b>'.$notif["subject"].'</b>.</div>';
                            echo '</div>';
                            echo '<div class="info_time">';
                            echo substr($notif["timeCreated"], 0, 16);
                            echo '</div>';
                            echo '<div class="notif_status">';
                            echo '</div>';
                        } else {
                            $getTarget = "SELECT userID, firstName, profPic FROM userinfo WHERE userID = '".$notif["targetUserID"]."';";
                            $query = mysqli_query($conn, $getTarget);
                            $pic = mysqli_fetch_assoc($query);
                            echo '<div class="info_left">';
                            if($pic['profPic']) {
                                echo "<img class='info_prof_pic' src='profile_pictures/" . $pic['userID'] . ".jpg?'" .  mt_rand() . " alt='Tutor profile picture.'>";
                            } else {
                                echo "<img class='info_prof_pic' src='images/profpic.jpg' alt='Tutor profile picture.'>";
                            }
                            echo '<div class="info_message">You have booked <b>'.$pic["firstName"].'</b>\'s service for <b>'.$notif["subject"].'</b>.</div>';                            echo '</div>';
                            echo '<div class="info_time">';
                            echo substr($notif["timeCreated"], 0, 16);
                            echo '</div>';
                            echo '<div class="notif_status">';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>
            
        </div>
        
    </body>
</html>
