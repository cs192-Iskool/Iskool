<?php
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
                <button class="header_links">Bookings</button>
                <button class="header_links">Messages</button>
                <button class="header_links">(notif)</button>
                <button class="header_links" id="dropdown" onclick="show_dropdown()"><?php echo $_SESSION["firstName"]; ?>
                    <img class="corner_prof_pic" src="images/profpic.jpg" alt="User's current profile picture.">
                </button>
            </div>
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
                <div class="sidebar_navigate">
                    <div>
                        <a href="MyAds.php">Active Ads</a>
                    </div>
                    <div>
                        <a href="#">Awaiting Response</a>
                    </div>
                    <div>
                        <a href="#">Past Bookings</a>
                    </div>
                </div>
            </div>
            <div class="vertical" style="float: left;"></div>
            <div class="info_box">
                <div class="all_info" style="border-color: white;">
                    <a href="CreateAds.php">
                        <button type="button">Create Ad</button>
                    </a>
                </div>
            </div>
            
        </div>
        
    </body>
</html>
