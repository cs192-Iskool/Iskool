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
        <title>Messages - Iskool</title>
        <link rel="stylesheet" type="text/css" href="css_files/Messages.css">
        <link rel="stylesheet" href="css_files/header.css">
        <script defer src="js_files/header.js"></script>
    </head>
    <body>
        <div style="z-index: 2; position: relative;" class="top">
            <div class="home">
                <button class="header_links">
                <a href="php_db_files/clearInputs.php">Iskool</a>
                </button>
            </div>
            <div class="header_navigate">
                <button type="button" class="header_links"><a href="MyAds.php">My Ads</a></button>
                <button type="button" class="header_links"><a href='Bookings.php'>Bookings</a></button>
                <button type="button" class="header_links"><a href='Messages.php'>Messages</a></button>
                <button type="button" class="header_links" id="notifs_list" onclick="show_notifs()">(notif)</button>
                <button type="button" class="header_links" id="dropdown" onclick="show_dropdown()"><?php echo $_SESSION["firstName"]; ?>
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
                    <a href="AccountProfile.php">Profile</a>
                </div>
                <div style="margin-top: 10px; margin-bottom: 10px;"class="horizontal"></div>
                <div>
                    <a href="php_db_files/Logout.php">Log Out</a>
                </div>
            </div>
        </div>
        <div class="horizontal"></div>

        <!-- This part is for testdb.sql and php_db_files/Accept.php

            Ideally, database should have two new tables:
            One for the active chats, with columns convoID (auto-increment?), tutorID, tuteeID, subject
                - Should be created whenever a tutor accepts a booking (see php_db_files/Accept.php)
                - Issue is, there would be a separate chat for every accepted booking even if it's the same people talking
                    - Possible solution, don't create a new chat if it's the same people, but specify in '<div class="account_details">' (see below)
                      the subjects that the two people are involved in

            Another for the messages, with columns convoID, senderID, message, timeCreated

        -->

        <!-- This part is for php_db_files/Login.php

            $_SESSION["convoID"] should be initialized in php_db_files/Login.php
            If there aren't any convos associated to/accessible by this session's user, assign some arbitrary default value to $_SESSION["convoID"].
            Else, assign the convoID of the convo with the most recent message to $_SESSION["convoID"].
            See line 144 for reference of how the query would look like (I think, I could be wrong, though)

        -->

        <div class="main">
            <div class="sidebar">
                <div class="chat_banner">Chats</div>
                <div class="chatboxes">
                    <?php
                        # $chats = select query from convos inner joined with messages where session id is either tutor id or tutee id order by timeCreated DESC
                        $query = mysqli_query($conn, $chats);
                        while($result = mysqli_fetch_assoc($query)) {
                            echo '<form action="php_db_files/loadMessages.php?convoID='.$_SESSION["convoID"].'">';
                            echo '<div class="chats">'; # maybe should be a button so we can submit
                            echo '<div class="chat_details">';
                            # prof pic
                            # name
                            # message preview
                            echo '</div>';
                            echo '<div class="chat_time">';
                            # time
                            echo '</div>';
                            echo '</div>';
                            echo '</form>';
                        }
                    ?>
                </div>
            </div>
            <div class="message_display">
                <!-- if $_SESSION["convoID"] is default value, display some placeholder text that says something like 'accept a booking to get started' or whatever -->
                <!-- else, display the convo specified by $_SESSION["convoID"]
                (refer to invision on what to display); feel free to reorganize or change anything -->
                <div class="chat_banner">Name</div>
            </div>
            <div class="account_details">
                <!-- if $_SESSION["convoID"] is default value, display the div below (for padding purposes, so the whole page is occupied)-->
                <div style="height: 1000px"></div>
                <!-- else, display the acc details of the convo participant 
                (refer to invision on what to display); feel free to reorganize or change anything -->
                <!-- also still add this padding just to be sure the whole page is occupied -->
                <div style="height: 1000px"></div>
            </div>
            
        </div>
        
    </body>
</html>
