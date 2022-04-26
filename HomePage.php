<?php
    include_once 'php_db_files/Database.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iskool</title>
    <link rel = "stylesheet" href = "css_files/homepageAds.css">
    <link rel = "stylesheet" href = "css_files/homepage.css">
    <link rel = "stylesheet" href = "css_files/header.css">
    <script src = "js_files/homepage.js"></script>
    <script src = "js_files/header.js"></script>
</head>
<body>
    <div class="top">
        <div class="home">
            <button type="button" class="header_links">
                <a href="HomePage.php">Iskool</a>
            </button>
        </div>
        <div class="header_navigate">
            <?php
                if (isset($_SESSION["userID"])) {
                    echo "<button type='button' class='header_links'><a href='MyAds.php'>My Ads</a></button>";
                    echo "<button type='button' class='header_links'>Bookings</button>";
                    echo "<button type='button' class='header_links'>Messages</button>";
                    echo "<button type='button' class='header_links' id='notifs_list' onclick='show_notifs()'>(notif)</button>";
                    echo "<button type='button' class='header_links' id='dropdown' onclick='show_dropdown()'> " . $_SESSION['firstName'];
                    if($_SESSION['profPic']) {
                        echo "<img class='corner_prof_pic' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                    } else {
                        echo "<img class='corner_prof_pic' src='images/profpic.jpg' alt='Your current profile picture.'>";
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
            }
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

    <div class = "quirkytagline">
        <h2 id = "tagline">Quirky Tagline</h2>
    </div>

    <div class = "menubar">
        <ul class = "menubar__container">
            <li class = "menubar__item">Campus
                <div class = "menubar__toggle" id = "campus">
                    <span class = "bar"></span>
                    <span class = "bar"></span>
                    <span class = "bar"></span>
                </div>
            </li>
            <li class = "menubar__item">College
                <div class = "menubar__toggle" id = "campus">
                    <span class = "bar"></span>
                    <span class = "bar"></span>
                    <span class = "bar"></span>
                </div>
            </li>
            <li class = "menubar__item">Price
                <div class = "menubar__toggle" id = "campus">
                    <span class = "bar"></span>
                    <span class = "bar"></span>
                    <span class = "bar"></span>
                </div>
            </li>
        </ul>
        <form id="submit_search" class = "sort" action="php_db_files/searchAds.php" method="POST">
        <ul class = "sort">
            <li class = "sort__item"><input type = "text" id = "search" name = "search" placeholder = "Search"></li>
            <button type="submit" style="display: none;" id="search_ad">Submit</button>
            <li class = "sort__item">
                <div class = "dropdown">
                    Sort By:
                </div>
                <div class = "dropbtn" onclick="sortbyClick()">Newest</div>
                <div class = "dropdown-content" id = "dropdownContainer">
                    <a href = "#">Newest</a>
                    <a href = "#">Lowest Price</a>
                    <a href = "#">Highest Rating</a>
                </div>
            </li>
        </ul>
        </form>
    </div>
    <div style="display: flex; flex-wrap: wrap;" class="ads_display">
        <?php
            if (!(isset($_SESSION['userID'])) && !(isset($_SESSION['search']))) {
                $_SESSION['search'] = "";
            }
            $user = "SELECT * FROM adinfo INNER JOIN userinfo USING (userID) WHERE CONCAT(firstName, ' ', lastName) LIKE '%".$_SESSION['search']."%' OR campus LIKE '%".$_SESSION['search']."%' OR course LIKE '%".$_SESSION['search']."%' OR subject LIKE '%".$_SESSION['search']."%' ORDER BY timeCreated DESC;";
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
                echo ''.$row["firstName"].'';
                echo '</div>';
                echo '<div class="secondary_info">';
                echo '<div class="course">';
                echo ''.$row["course"].'';
                echo '</div>';
                echo '<div class="campus">';
                echo ''.$row["campus"].'';
                echo '</div>';
                echo '</div>';
                echo '<div class="ratings">';
                echo '(This is where the ratings will go)';
                echo '</div>';
                echo '<div class="subject">';
                echo ''.$row["subject"].'';
                echo '</div>';
                echo '<div class="price">';
                echo ''.$row["price"].'/hr';
                echo '</div>';
                if (isset($_SESSION['userID']) && $row["userID"] != $_SESSION['userID']) {
                    echo '<form action="php_db_files/createBooking.php" method="POST">';
                    $query = "SELECT * FROM bookings WHERE tuteeID=".$_SESSION['userID']." AND tutorID=".$row["userID"]." AND subject='".$row["subject"]."';";
                    $check = mysqli_query($conn, $query);
                    echo '<input style="display:none" type="number" name="ad" value="'.$row["adID"].'" required>';
                    echo '<div class="book_btn">';
                    $query2 = "SELECT firstName, lastName FROM userinfo WHERE userID=".$row['userID'].";";
                    $getName = mysqli_query($conn, $query2);
                    $name = mysqli_fetch_assoc($getName);
                    if($bookingExists = mysqli_fetch_assoc($check)) {
                        echo '<button class="book disable" id="btn_'.$row["adID"].'" onclick="disable_button(this.id, "'.$row["subject"].'", "'.$name["firstName"].'", "'.$name["lastName"].'")">Book</button>';
                    } else {
                        echo '<button class="book" id="btn_'.$row["adID"].'" onclick="disable_button(this.id, &quot;'.$row["subject"].'&quot;, &quot;'.$name["firstName"].'&quot;, &quot;'.$name["lastName"].'&quot;)">Book</button>';
                    }
                    echo '</div>';
                    echo '</form>';
                }
                echo '<div class="reviews">';
                echo '<a href="#">Reviews<a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            $_SESSION['search'] = "";
        ?>
    </div>
    <div id="pic_overlay"></div>
    <img id="pic">

    
</body>
</script>
</html>