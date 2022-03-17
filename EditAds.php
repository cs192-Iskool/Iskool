<?php
    include_once 'php_db_files/Database.php';
    session_start();

    if (!isset($_SESSION["userID"])) {
        header("location: Login.html");
    }

    $adID = $_GET["ad"];
    $ad = "SELECT * FROM adinfo WHERE adID = '".$adID."';";
    $result = mysqli_query($conn, $ad);
    $row = mysqli_fetch_assoc($result);
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
                <div class="sidebar_navigate" style="width: 70%;">
                    <div style="text-align: center;">
                        <a href="#">Edit Ads</a>
                    </div>
                </div>
            </div>
            <form class="info_box" action="php_db_files/EditAds.php?ad=<?php echo $adID ?>" method="POST" enctype="multipart/form-data">
                <div class="all_info">
                    <h1>Basic Info</h1>
                    <table>
                        <tr>
                            <td>Subject:</td>
                            <td><?php echo ''.$row["subject"].''; ?></td>
                        </tr>
                        <tr>
                            <td>Price:</td>
                            <td>
                                <form action="EditAds.php" method="POST"><!--put some validating function in js-->
                                    <span>
                                        <input type="number" name="price" id="price" min="1" value="<?php echo $row["price"]; ?>" required><!--value="php script"-->
                                    </span>
                                    <span>per hour</span>
                                </form>
                                
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
                                Upload up to X photos promoting your service. The first photo will be used as a thumbnail for your ad.
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
