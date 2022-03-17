<?php
    include_once 'php_db_files/Database.php';
    session_start();

    if (!isset($_SESSION["userID"])) {
        header("location: Login.html");
    }

    $user = "SELECT * FROM adinfo WHERE userID = '".$_SESSION["userID"]."';";
    $result = mysqli_query($conn, $user);
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
        <script defer src="js_files/MyAds.js"></script>
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
                    <?php
                        if($_SESSION['profPic']) {
                            echo "<img class='corner_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                        } else {
                            echo "<img class='corner_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
                        }
                    ?>
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
            <div style="display: flex; flex-wrap: wrap;" class="info_box">
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="ads" id="'.$row["adID"].'" onclick="show_ad_options(this.id)">';
                        echo '<img class="options_toggle" src="images/options.png" alt="Delete or edit ad.">';
                        echo '<div class="ad_popup" id="popup_'.$row["adID"].'">
                                    <div>
                                        <a href="php_db_files/EditAds.php">Edit Ad</a>
                                    </div>
                                    <div style="margin-top: 10px; margin-bottom: 10px;"class="horizontal"></div>
                                    <div>
                                        <button class="open_delete_message" id="delete_'.$row["adID"].'" onclick="show_delete_ad(id)">Delete Ad</button>
                                    </div>
                                </div>';
                        echo '<div class="thumbnail" id="tn_'.$row["adID"].'">';
                        if($row['image'] === NULL) {
                            echo '<img style="width: 100%;" src="images/bg.png" alt="Thumbnail for ad."/>';
                        } else {
                            echo '<img style="width: 100%;" src="data:image;base64,'.base64_encode($row['image']).'" alt="Thumbnail for ad."/>';
                        }
                        echo '</div>';
                        echo '<div class="sp_horizontal" id="hr_'.$row["adID"].'" style="width: 302px; position: relative; left: -1px;"></div>';
                        echo '<div class="ad_info" id="ai_'.$row["adID"].'">';
                        echo '<div class="subject">';
                        echo ''.$row["subject"].'';
                        echo '</div>';
                        echo '<div class="price">';
                        echo ''.$row["price"].'/hr';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
                <div class="ads">
                    <a href="CreateAds.php">
                        <img class="add_ad_button" src="images/add_ad.png" alt="Create ad button.">
                    </a>
                </div>
                <div id="delete_popup">
                    <div class="message">
                        <div style="padding-top: 10px;">Are you sure you want to delete this ad?</div>
                        <div style="padding-bottom: 40px;">This action cannot be undone.</div>
                        <form action="php_db_files/DeleteAd.php" method="POST">
                            <input style="display: none;" type="text" name="ad" id="ad" required>
                            <button type="submit" id="continue_delete" style="float: left;">Yes, delete this ad</button>
                        </form>
                        <button id="close_delete_message" style="float: right;">No, don't delete this ad</button>
                    </div>
                    
                </div>
                <div id="delete_overlay"></div>
            </div>
            
        </div>
        
    </body>
</html>
