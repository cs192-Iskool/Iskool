import React from 'react';
import bell from './images/bell.png';
import person from './images/person.jpg';
import './css_files/homepage.css';
const navbar = () =>{
    return(
        <div className="navbar__container">
            <a href="/Home" id = "navbar__logo">ISKOOL</a>
            <div className = "navbar__toggle" id = "mobile-menu">
                <span className = "bar"></span>
                <span className = "bar"></span>
                <span className = "bar"></span>
            </div>
            <ul className = "navbar__menu">
                <li className = "navbar__item">
                    <a href="/" className="navbar__links">My Ads</a>
                </li>
                <li className="navbar__item">
                    <a href="/" className="navbar__links">Bookings</a>
                </li>
                <li className="navbar__item">
                    <a href="/" className="navbar__links">Messages</a>
                </li>
                <li className="navbar__btn">
                    <a href="/AccountProfile" className="navbar__links"><img src = {bell} id = "bell" alt = "Notifications"/>Notifications</a>
                </li>
                <li className="navbar__item">
                    <a href="/AccountProfile" className="navbar__links"><img src = {person} id = "person"/></a>
                </li>
            </ul>
        </div>
    );
}

export default navbar;