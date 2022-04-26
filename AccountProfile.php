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
        <link rel="stylesheet" type="text/css" href="css_files/AccountProfile.css">
        <link rel="stylesheet" href="css_files/header.css">
        <script defer src="js_files/AccountProfile.js"></script>
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
                <button class="header_links" class="header_links">Bookings</button>
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
                            echo "You have received a booking request from (name) for ".$notif['subject'].".";
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
                        echo "test";
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
                        <a href="#">Reviews</a>
                    </div>
                </div>
            </div>
            <div class="vertical" style="float: left;"></div>
            <div class="info_box">
                <div class="all_info">
                    <h1>Basic Info</h1>
                    <table>
                        <tr>
                            <td>Name:</td>
                            <td><?php echo $_SESSION["firstName"] . ' ' . $_SESSION["lastName"]; ?></td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td><?php echo $_SESSION["birthday"]; ?></td>
                        </tr>
                        <tr>
                            <td>Campus:</td>
                            <td><?php echo $_SESSION["campus"]; ?></td>
                        </tr>
                        <tr>
                            <td>Course:</td>
                            <td><?php echo $_SESSION["course"]; ?></td>
                        </tr>
                        <tr>
                            <td>Year Standing:</td>
                            <td><?php echo $_SESSION["yearStanding"]; ?></td>
                        </tr>
                    </table>
                </div>
                <div style="height: 50px;"></div>
                <div class="all_info">
                    <h1>Account Details</h1>
                    <table>
                        <tr>
                            <td>Email Address:</td>
                            <td><?php echo $_SESSION["emailAddress"]; ?></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><?php echo str_repeat("*", strlen($_SESSION["password"])); ?></td>
                        </tr>
                    </table>
                </div>
                <div style="height: 50px;"></div>
                <div class="all_info" style="border-color: white;">
                    <a href="EditProfile.php">
                        <button>Edit Profile</button>
                    </a>
                    
                    <button id="open_delete_message" style="float: right;  margin-right: 30px;">Delete Account</button>
                </div>
                <div id="delete_popup">
                    <div class="message">
                        <div style="padding-top: 10px;">Are you sure you want to delete your account?</div>
                        <div style="padding-bottom: 40px;">This action cannot be undone.</div>
                        <form action="php_db_files/deleteAccount.php" method="POST">
                            <button id="continue_delete" style="float: left;">Yes, delete my account</button>
                        </form>
                        <button id="close_delete_message" style="float: right;">No, don't delete my account</button>
                    </div>
                    
                </div>
                <div id="delete_overlay"></div>
            </div>
        </div>
        
    </body>
</html>
