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
        <link rel="stylesheet" href="css_files/AccountProfile.css">
        <link rel="stylesheet" href="css_files/header.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
        <script defer src="js_files/AccountProfile.js"></script>
        <script defer src="js_files/header.js"></script>
    </head>
    <body>
        <div class="top">
            <div class="home">
                <button class="header_links">
                    <a href="HomePage.php">ISKOOL</a>
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
        <div class="prof_pic">
            <button class="main_prof_pic" id="prof_pic_display" onclick="change_prof_pic()">
                <?php
                    if($_SESSION['profPic']) {
                        echo "<img style='height: 200px; width: 200px; border-radius: 50%;' src='profile_pictures/" . $_SESSION['userID'] . ".jpg?'" .  mt_rand() . " alt='Your current profile picture.'>";
                    } else {
                        echo "<img style='height: 200px; width: 200px; border-radius: 50%;' src='images/profpic.jpg' alt='Your current profile picture.'>";
                    }
                ?>
            </button>
            <div class="change_prof_pic" id="prof_pic_dropdown">
                <form id="submit_prof_pic" action="php_db_files/ChangePicture.php" method="POST" enctype="multipart/form-data">
                    <label for="upload_pic" class="upload_btn_style">Change profile picture</label>
                    <input id="upload_pic" type="file" name="profpic">
                </form>
                
            </div>
        </div>
        <div class="horizontal"></div>
        <div class="main">
            <div class="sidebar">
                <div class="sidebar_navigate" style="width: 70%;">
                    <div style="text-align: center;">
                        <a href="EditProfile.php">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="vertical" style="float: left;"></div>
            <form class="info_box" action="php_db_files/EditProfile.php" onsubmit="return validate()" method="POST">
                <div>
                    <div class="all_info">
                        <h1>Basic Info</h1>
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td>
                                    <span>
                                        <input type="text" name="fname" id="fname" value="<?php echo $_SESSION["firstName"]; ?>" required>
                                    </span>
                                    <span>
                                        <input type="text" name="lname" id="lname" value="<?php echo $_SESSION["lastName"]; ?>" required>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Birthday:</td>
                                <td>
                                    <input type="date" name="birthday" id="birthday" value="<?php echo $_SESSION["birthday"]; ?>"required>
                                </td>
                            </tr>
                            <tr>
                                <td>Campus:</td>
                                <td>
                                    <select name="campus" required defaultValue = "<?php echo $_SESSION["campus"]; ?>">
                                    <option selected = "selected" hidden><?php echo $_SESSION["campus"]; ?></option>
                                    <option value="UP Diliman">UP Diliman</option>
                                    <option value="UP Los Baños">UP Los Baños</option>
                                    <option value="UP Manila">UP Manila</option>
                                    <option value="UP Visayas">UP Visayas</option>
                                    <option value="UP Open University">UP Open University</option>
                                    <option value="UP Mindanao">UP Mindanao</option>
                                    <option value="UP Baguio">UP Baguio</option>
                                    <option value="UP Cebu">UP Cebu</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Course:</td>
                                <td>
                                    <input type="text" name="course" value="<?php echo $_SESSION["course"]; ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Year Standing:</td>
                                <td>
                                    <select name="year" required>
                                    <option selected = "selected" hidden><?php echo $_SESSION["yearStanding"]; ?></option>
                                        <option value="1st Year">1st Year</option>
                                        <option value="2nd Year">2nd Year</option>
                                        <option value="3rd Year">3rd Year</option>
                                        <option value="4th Year">4th Year</option>
                                        <option value="5th Year and Above">5th Year and Above</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="height: 50px;"></div>
                    <div class="all_info">
                        <h1>Account Details</h1>
                        <table>
                            <tr>
                                <td>Email Address:</td>
                                <td>
                                    <?php echo $_SESSION["emailAddress"]; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>New Password:</td>
                                <td>
                                    <input type="password" name="password" id="password" placeholder="Password" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Confirm Password:</td>
                                <td>
                                    <input type="password" name="confPassword" id="confPassword" placeholder="Confirm Password" required>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="height: 50px;"></div>
                    <div class="all_info" style="border-color: white;">
                        <button type="submit">Confirm</button>
                        <a href="AccountProfile.php">
                            <button type="button" style="float: right;  margin-right: 30px;">Cancel</button>
                        </a>
                    </div>
                    
                </div>
            </form>
            
        </div>
    </body>
</html>
