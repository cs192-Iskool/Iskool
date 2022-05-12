<?php
    include_once 'php_db_files/Database.php';
    session_start();

    if (isset($_SESSION["userID"])) {
        date_default_timezone_set("Asia/Manila");
        $getExpired = "SELECT bookingID, timeCreated FROM bookings WHERE tuteeID = '".$_SESSION["userID"]."';";
        $result = mysqli_query($conn, $getExpired);
        while($notif = mysqli_fetch_assoc($result)) {
            $bookingInfo = $notif['bookingID'];
            $expiryDate = new DateTime($notif['timeCreated']);
            date_modify($expiryDate, "+1 minute");      # Change this to 3 days in final product
            $expiryDate = $expiryDate->format('Y-m-d H:i:s');

            if(date("Y-m-d H:i:s") >= $expiryDate) {
                $deleteBooking = "DELETE FROM bookings WHERE bookingID = $bookingInfo";
                $delete = mysqli_query($conn, $deleteBooking);

                $getNotif = "SELECT * FROM notifs WHERE bookingID = $bookingInfo AND status = 1";
                $query = mysqli_query($conn, $getNotif);
                $notif2 = mysqli_fetch_assoc($query);
                
                $tUID = $notif2['targetUserID'];
                $subject = $notif2['subject'];
                $sUID = $notif2['sourceUserID'];

                $expiryNotif = "INSERT INTO notifs (targetUserID, bookingID, status, subject, sourceUserID) VALUES ('$tUID', '$bookingInfo', '5', '$subject', '$sUID');";
                $query = mysqli_query($conn, $expiryNotif);
            }
        }
    }
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <script src = "js_files/homepage.js"></script>
    <script src = "js_files/header.js"></script>
</head>
<body>
    <div class="top">
        <div class="home">
            <button type="button" class="header_links">
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

    <div class = "quirkytagline">
        <h1 id = "tagline">Connect with fellow Iskos.</h1>
    </div>

    <div class = "menubar">
        <ul class = "menubar__container">
            <li class = "menubar__item" id="campusFilter" onclick="showCampus()">
                <?php
                    if(!(isset($_SESSION["campusFilter"])) || ($_SESSION["campusFilter"] == "")) {
                        echo 'Campus';
                    } else {
                        echo $_SESSION['campusFilter'];
                    }
                ?>
                <div class = "menubar__toggle" id = "campus">
                    <a href = "php_db_files/filterAds.php?campus=1">UP Diliman</a>
                    <a href = "php_db_files/filterAds.php?campus=2">UP Los Baños</a>
                    <a href = "php_db_files/filterAds.php?campus=3">UP Manila</a>
                    <a href = "php_db_files/filterAds.php?campus=4">UP Visayas</a>
                    <a href = "php_db_files/filterAds.php?campus=5">UP Open University</a>
                    <a href = "php_db_files/filterAds.php?campus=6">UP Mindanao</a>
                    <a href = "php_db_files/filterAds.php?campus=7">UP Baguio</a>
                    <a href = "php_db_files/filterAds.php?campus=8">UP Cebu</a>
                </div>
            </li>
            <li class = "menubar__item" id="priceFilter" onclick="showPrice()">
                <?php
                    if(!(isset($_SESSION["priceFilter"])) || ($_SESSION["priceFilter"] == "")) {
                        echo 'Price';
                    } else {
                        echo $_SESSION['priceFilter'];
                    }
                ?>
                <div class = "menubar__toggle" id = "price">
                    <a href = "php_db_files/filterAds.php?price=1">< 200</a>
                    <a href = "php_db_files/filterAds.php?price=2">200 - 599</a>
                    <a href = "php_db_files/filterAds.php?price=3">600 - 999</a>
                    <a href = "php_db_files/filterAds.php?price=4">> 1000</a>
                </div>
            </li>
        </ul>
        <ul class = "sort">
            <li class = "sort__item">
                <form id="submit_search" class = "sort" action="php_db_files/searchAds.php" method="POST">
                <?php
                    if(!(isset($_SESSION["search"])) || ($_SESSION["search"] == "")) {
                        echo'<input type = "text" id = "search" name = "search" placeholder = "Search">';
                    } else {
                        echo'<input type = "text" id = "search" name = "search" value = "'.$_SESSION['search'].'">';
                    }
                ?>
                <button type="submit" style="display: none;" id="search_ad">Submit</button>
                </form>
            </li>
            <li class = "sort__item">
                <div class = "dropdown">
                    Sort By:
                </div>
                <div class = "dropbtn" onclick="sortbyClick()">
                    <?php
                        if(isset($_SESSION['sort'])) {
                            echo $_SESSION['sort'];
                        } else {
                            echo 'Newest';
                        }
                    ?>
                </div>
                <div class = "dropdown-content" id = "dropdownContainer">
                    <form action="php_db_files/sortAds.php?sort=Newest" method="POST">
                    <div onclick="submitSort('Newest')">Newest</div>
                    <button type="submit" id="Newest" style="display: none;"></button>
                    </form>
                    <form action="php_db_files/sortAds.php?sort=Lowest Price" method="POST">
                    <div onclick="submitSort('Lowest_Price')">Lowest Price</div>
                    <button type="submit" id="Lowest_Price" style="display: none;"></button>
                    </form>
                    <form action="php_db_files/sortAds.php?sort=Highest Rating" method="POST">
                    <div onclick="submitSort('Highest_Rating')">Highest Rating</div>
                    <button type="submit" id="Highest_Rating" style="display: none;"></button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
    <div style="display: flex; flex-wrap: wrap;" class="ads_display">
        <?php
            if (!(isset($_SESSION['userID'])) && !(isset($_SESSION['search'])) && !(isset($_SESSION['filters'])) && !(isset($_SESSION['sort']))) {
                $_SESSION['search'] = "";
                $_SESSION['filters'] = 0;
                $_SESSION['sort'] = "Newest";
            }
            if($_SESSION['sort'] == "Newest"){
                $user = "SELECT * FROM adinfo INNER JOIN userinfo USING (userID) WHERE CONCAT(firstName, ' ', lastName) LIKE '%".$_SESSION['search']."%' OR campus LIKE '%".$_SESSION['search']."%' OR course LIKE '%".$_SESSION['search']."%' OR subject LIKE '%".$_SESSION['search']."%' ORDER BY timeCreated DESC;";
            } else if($_SESSION['sort'] == "Lowest Price") {
                $user = "SELECT * FROM adinfo INNER JOIN userinfo USING (userID) WHERE CONCAT(firstName, ' ', lastName) LIKE '%".$_SESSION['search']."%' OR campus LIKE '%".$_SESSION['search']."%' OR course LIKE '%".$_SESSION['search']."%' OR subject LIKE '%".$_SESSION['search']."%' ORDER BY price;";
            } else {
                $user = "SELECT * FROM adinfo INNER JOIN userinfo USING (userID) WHERE CONCAT(firstName, ' ', lastName) LIKE '%".$_SESSION['search']."%' OR campus LIKE '%".$_SESSION['search']."%' OR course LIKE '%".$_SESSION['search']."%' OR subject LIKE '%".$_SESSION['search']."%' ORDER BY avgRating DESC;";
            }
            
            $result = mysqli_query($conn, $user);
            $ctr = 0;
            while($row = mysqli_fetch_assoc($result)) {
                if($_SESSION["filters"] == 1 && $row["campus"] != $_SESSION["campusFilter"]) {
                    continue;
                } else if($_SESSION["filters"] == 2 && !(($row["price"] >= $_SESSION["minPriceFilter"]) && ($row["price"] < $_SESSION["maxPriceFilter"]))) {
                    continue;
                } else if(($_SESSION["filters"] == 3) && (($row["campus"] != $_SESSION["campusFilter"]) || !(($row["price"] >= $_SESSION["minPriceFilter"]) && ($row["price"] < $_SESSION["maxPriceFilter"])))) {
                    continue;
                }

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
                if(strlen(strval($row['avgRating'])) == 1) {
                    echo "<img style='width: 100px;' src='images/".$row['avgRating'].".0".".png' alt='Rating'>";
                } else {
                    echo "<img style='width: 100px;' src='images/".$row['avgRating'].".png' alt='Rating'>";
                }
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
                    $query2 = "SELECT * FROM notifs WHERE targetUserID=".$_SESSION['userID']." AND sourceUserID=".$row["userID"]." AND subject='".$row["subject"]."' AND status = 2;";
                    $check2 = mysqli_query($conn, $query2);
                    echo '<input style="display: none;" type="number" name="ad" value="'.$row["adID"].'" required>';
                    echo '<div class="book_btn">';
                    $query3 = "SELECT firstName, lastName FROM userinfo WHERE userID=".$row['userID'].";";
                    $getName = mysqli_query($conn, $query3);
                    $name = mysqli_fetch_assoc($getName);
                    if($bookingExists = mysqli_fetch_assoc($check) || $alreadyAccepted = mysqli_fetch_assoc($check2)) {
                        echo '<button class="book disable" id="btn_'.$row["adID"].'" onclick="disable_button(this.id, "'.$row["subject"].'", "'.$name["firstName"].'", "'.$name["lastName"].'")">Book</button>';
                    } else {
                        echo '<button class="book" id="btn_'.$row["adID"].'" onclick="disable_button(this.id, &quot;'.$row["subject"].'&quot;, &quot;'.$name["firstName"].'&quot;, &quot;'.$name["lastName"].'&quot;)">Book</button>';
                    }
                    echo '</div>';
                    echo '</form>';
                }
                if (!(isset($_SESSION['userID'])) || $row["userID"] != $_SESSION['userID']) {
                    echo '<div class="reviews">';
                    echo '<form action="php_db_files/reviewRedirect.php?userID='.$row["userID"].'" method="POST">';
                    echo '<button class="review_btn">Reviews</button>';
                    echo '</form>';
                    echo '</div>';
                }
                echo '</div>';
                echo '</div>';
                $ctr += 1;
            }
            if(mysqli_num_rows($result) == 0 || $ctr == 0) {
                echo '<div style="font-size: 35px; margin: auto;">No ads have been found.</div>';
            }
            $ctr = 0;
        ?>
    </div>
    <div id="pic_overlay"></div>
    <img id="pic">
    <?php $_SESSION["sort"] = 'Newest'; ?>
</body>
</script>
</html>