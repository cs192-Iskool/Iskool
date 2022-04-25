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
        <title>My Ads - Iskool</title>
        <link rel="stylesheet" type="text/css" href="css_files/MyAds.css">
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
        <div class="whitespace">
            <h1 class="label">My Ads</h1>
        </div>
        <div class="horizontal"></div>
        <div class="main">
            <div class="sidebar">
                <div class="sidebar_navigate" style="width: 70%;">
                    <div style="text-align: center;">
                        <a href="#">Create Ads</a>
                    </div>
                </div>
            </div>
            <form class="info_box" action="php_db_files/CreateAds.php" method="POST" enctype="multipart/form-data">
                <div class="all_info">
                    <h1>Basic Info</h1>
                    <table>
                        <tr>
                            <td>Subject:</td>
                            <td><input type="text" name="subject" id="subject" required></td><!--value="php script"-->
                        </tr>
                        <tr>
                            <td>Price:</td>
                            <td>
                                <span>
                                    <input type="number" name="price" id="price" min="1" required><!--value="php script"-->
                                </span>
                                <span>per hour</span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="height: 50px;"></div>
                <div class="all_info">
                    <h1>Gallery</h1>
                    <table>
                        <tr>
                            <td>
                                You can upload a photo promoting your service. This can be used as a thumbnail for your ad.
                            </td>
                        </tr>
                    </table>
                    <input type="file" name="file"> <br><br>
                </div>
                <div style="height: 50px;"></div>
                <div class="all_info" style="border-color: white;">
                    <button type="submit">Confirm</button>
                    <a href="MyAds.php">
                        <button type="button" style="float: right;  margin-right: 30px;">Cancel</button>
                    </a>
                </div>
            </form>
        </div>
        
    </body>
</html>
