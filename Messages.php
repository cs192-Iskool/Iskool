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
        <script defer src="js_files/sendMessage.js"></script>
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
        <div class="main">
            <div class="sidebar">
                <div class="chat_banner">Chats</div>
                <div class="chatboxes">
                    <?php
                        # $chats = select query from convos inner joined with messages where session id is either tutor id or tutee id order by timeCreated DESC
                        $chats = "SELECT activechats.chatID, tutorID, tuteeID, subject, max(timeCreated) FROM activechats LEFT JOIN messages ON activechats.chatID = messages.chatID WHERE tuteeID='".$_SESSION['userID']."' OR tutorID='".$_SESSION['userID']."' GROUP BY activechats.chatID ORDER BY max(timeCreated) DESC";
                        $query = mysqli_query($conn, $chats);
                        $getUser = "";
                        while($result = mysqli_fetch_assoc($query)) {
                            if($result["tuteeID"] == $_SESSION["userID"]) {
                                $getUser = "SELECT userID, firstName, lastName, profPic FROM userinfo WHERE userID = '".$result["tutorID"]."';";
                                $queryUser = mysqli_query($conn, $getUser);
                                $user = mysqli_fetch_assoc($queryUser);
                            } else {
                                $getUser = "SELECT userID, firstName, lastName, profPic FROM userinfo WHERE userID = '".$result["tuteeID"]."';";
                                $queryUser = mysqli_query($conn, $getUser);
                                $user = mysqli_fetch_assoc($queryUser);
                            }
                            $lastMsg = "SELECT * FROM messages WHERE chatID='".$result['chatID']."' ORDER BY timeCreated DESC LIMIT 1";
                            $queryLast = mysqli_query($conn, $lastMsg);
                            echo '<div class="chats" onclick="location.href=\'php_db_files/loadMessages.php?chat='.$result["chatID"].'\';">'; # maybe should be a button so we can submit
                            echo '<div class="chat_details">';
                            if($user['profPic']) {
                                echo "<img class='chat_prof_pic' src='profile_pictures/". $user['userID'].".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                            } else {
                                echo "<img class='chat_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                            }
                            echo '<div class="chat_text">';
                            echo '<p class="chat_name">';
                            echo $user["firstName"].' '.$user["lastName"];
                            echo '</p>';
                            echo '<p class="chat_preview">';
                            if(mysqli_num_rows($queryLast)) {
                                $msg = mysqli_fetch_assoc($queryLast);
                                echo $msg["message"];
                            }
                            echo '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="chat_time">';
                            if(mysqli_num_rows($queryLast)) {
                                echo substr($msg["timeCreated"], 11, 5);
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
            <?php
                echo '<div class="message_display">';
                if($_SESSION["chatID"] == "") {
                    echo '<div class="no_message">';
                    echo 'Accept a booking to start a message.';
                    echo '</div>';
                } else {
                    $chat = "SELECT * FROM activechats WHERE chatID='".$_SESSION['chatID']."'";
                    $query = mysqli_query($conn, $chat);
                    $subject = "";
                    while($result = mysqli_fetch_assoc($query)) {
                        if($result["tuteeID"] == $_SESSION["userID"]) {
                            $getUser = "SELECT userID, firstName, lastName, profPic FROM userinfo WHERE userID = '".$result["tutorID"]."';";
                            $queryUser = mysqli_query($conn, $getUser);
                            $user = mysqli_fetch_assoc($queryUser);
                        } else {
                            $getUser = "SELECT userID, firstName, lastName, profPic FROM userinfo WHERE userID = '".$result["tuteeID"]."';";
                            $queryUser = mysqli_query($conn, $getUser);
                            $user = mysqli_fetch_assoc($queryUser);
                        }
                        $subject = $result["subject"];
                        echo '<div class="chat_banner">';
                        echo $user["firstName"].' '.$user["lastName"];
                        echo '</div>';
                        echo '<div class="message_area">';
                        echo '<div>';
                        $msg = "SELECT * FROM messages WHERE chatID='".$_SESSION['chatID']."'";
                        $queryMsg = mysqli_query($conn, $msg);
                        while($getMsg = mysqli_fetch_assoc($queryMsg)) {
                            if($getMsg["senderID"] == $_SESSION["userID"]) {
                                echo '<div class="message_bubbles" id="sender">';
                            } else {
                                echo '<div class="message_bubbles" id="receiver">';
                            }
                            echo $getMsg["message"];
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<form action="php_db_files/sendMessages.php?chat='.$result["chatID"].'" method="POST">';
                        echo '<div class="message_box">';
                        echo '<textarea class="message_input" id="message" name="message" placeholder="Type a message...">';
                        echo '</textarea>';
                        echo '<button id="send_message" type="submit">Send</button>';
                        echo '</div>';
                        echo '</form>';
                    }
                }
                echo '</div>';
                echo '<div class="account_details">';
                echo '<div style="height: 1000px">';
                if(!($_SESSION["chatID"] == "")) {
                    if($user['profPic']) {
                        echo "<img class='account_prof_pic' src='profile_pictures/".$user['userID'].".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                    } else {
                        echo "<img class='account_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                    }
                    echo '<div class="account_name">';
                    echo $user["firstName"].' '.$user["lastName"];
                    echo '</div>';
                    echo '<div class="booked_subject">';
                    echo 'Booked Subject:'.' '.$subject;
                    echo '</div>';
                    echo '<div class="account_rating">';
                    echo "(rating)";
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
            ?>
            
        </div>
        
    </body>
</html>
