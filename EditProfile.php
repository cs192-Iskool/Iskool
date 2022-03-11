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
        <title><?php echo $_SESSION["firstName"] . ' ' . $_SESSION["lastName"]; ?> - Iskool</title>
        <link rel="stylesheet" href="css_files/AccountProfile.css">
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
        <div class="prof_pic">
            <button class="main_prof_pic" id="prof_pic_display" onclick="change_prof_pic()">
                <img style="height: 200px; border-radius: 50%;" src="images/profpic.jpg" alt="User's current profile picture.">
            </button>
            <div class="change_prof_pic" id="prof_pic_dropdown">
                Change profile picture
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
