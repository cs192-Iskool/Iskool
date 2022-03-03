<?php
    session_start();
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
                <button class="header_links">My Ads</button>
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
                    <a href="Login.html">Log Out</a>
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
            <div class="info_box">
                <div class="all_info">
                    <h1>Basic Info</h1>
                    <table>
                        <tr>
                            <td>Name:</td>
                            <td>
                                <span>
                                    <input type="text" placeholder="First Name" required>
                                </span>
                                <span>
                                    <input type="text" placeholder="Last Name" required>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td>
                                <input type="date" id="birthday" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Campus:</td>
                            <td>
                                <select required>
                                    <option value="" disabled selected hidden>Campus</option>
                                    <option value="upd">UP Diliman</option>
                                    <option value="uplb">UP Los Baños</option>
                                    <option value="upm">UP Manila</option>
                                    <option value="upv">UP Visayas</option>
                                    <option value="upou">UP Open University</option>
                                    <option value="upmin">UP Mindanao</option>
                                    <option value="upb">UP Baguio</option>
                                    <option value="upc">UP Cebu</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Course:</td>
                            <td>
                                <input type="text" placeholder="Course" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Year Standing:</td>
                            <td>
                                <select required>
                                    <option value="" disabled selected hidden>Year Standing</option>
                                    <option value="1">1st Year</option>
                                    <option value="2">2nd Year</option>
                                    <option value="3">3rd Year</option>
                                    <option value="4">4th Year</option>
                                    <option value="5">5th Year and Above</option>
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
                                <input type="email" placeholder="Email Address" required>
                            </td>
                        </tr>
                        <tr>
                            <td>New Password:</td>
                            <td>
                                <input type="password" placeholder="Password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm Password:</td>
                            <td>
                                <input type="password" placeholder="Confirm Password" required>
                            </td>
                        </tr>
                    </table>
                </div>
                <div style="height: 50px;"></div>
                <div class="all_info" style="border-color: white;">
                    <a href="AccountProfile.php">
                        <button>Confirm</button>
                    </a>
                    <a href="AccountProfile.php">
                        <button style="float: right;  margin-right: 30px;">Cancel</button>
                    </a>
                </div>
                
            </div>
        </div>
    </body>
</html>
