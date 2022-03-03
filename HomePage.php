<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iskool</title>
    <link rel = "stylesheet" href = "css_files/homepage.css" />
    <link rel = "stylesheet" href = "css_files/header.css">
    
</head>
<script src = "js_files/homepage.js"></script>
<script src = "js_files/header.js"></script>
<body>
    <div class="top">
        <div class="home">
            <button type="button" class="header_links">
                <a href="HomePage.html">Iskool</a>
            </button>
        </div>
        <div class="header_navigate">
            <button type="button" class="header_links">My Ads</button>
            <button type="button" class="header_links">Bookings</button>
            <button type="button" class="header_links">Messages</button>
            <button type="button" class="header_links">(notif)</button>
            <button type="button" class="header_links" id="dropdown" onclick="show_dropdown()"><?php echo $_SESSION["firstName"]; ?>
                <img class="corner_prof_pic" src="images/profpic.jpg" alt="User's current profile picture.">
            </button>
        </div>
        <div class="dropdown_popup" id="dropdown_elements">
            <div>
                <a href="AccountProfile.html">Profile</a>
            </div>
            <div style="margin-top: 10px; margin-bottom: 10px;"class="horizontal"></div>
            <div>
                <a href="Login.html">Log Out</a>
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
        <ul class = "sort">
            <li class = "sort__item"><input type = "text" id = "search" value = "Search"></li>
            <li class = "sort__item">
                <div class = "dropdown">
                    Sort By:
                </div>
                <button class = "dropbtn" onclick="sortbyClick()">Newest</button>
                
                <div class = "dropdown-content" id = "dropdownContainer">
                    <a href = "#">Newest</a>
                    <a href = "#">Lowest Price</a>
                    <a href = "#">Highest Rating</a>
                </div>
            </li>
        </ul>
        
    </div>

    
</body>
</script>
</html>