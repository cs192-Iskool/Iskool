import React from 'react';
import './css_files/AccountProfile.css';
import profpic from './images/profpic.jpg';

const AccountProfile = () =>{
    return(
        <div>
        
        
        <div className="prof_pic">
            <img className="main_prof_pic" src={profpic} alt="User's current profile picture."/>
        </div>
        
        <div className="main">
            <div className="sidebar">
                <div className="sidebar_navigate">
                    <div>
                        <a href="AccountProfile.html">Profile</a>
                    </div>
                    <div>
                        <a href="#">Reviews</a>
                    </div>
                </div>
            </div>
            <div className="vertical" style={{float: 'left'}}></div>
            <div className="info_box">
                <div className="all_info">
                    <h1 className = "accProfileh1">Basic Info</h1>
                    <table>
                        <tr>
                            <td>Name:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Campus:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Course:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Year Standing:</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div style={{height: 50}}></div>
                <div className="all_info">
                    <h1>Account Details</h1>
                    <table>
                        <tr>
                            <td>Email Address:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div style={{height: 50}}></div>
                <div className="all_info" style={{bordercolor: 'white'}}>
                    <a href="EditProfile.html">
                        <button>Edit Profile</button>
                    </a>
                    
                    <button id="open_delete_message" style={{float: 'right',  marginRight: 30}}>Delete Account</button>
                </div>
                <div id="delete_popup">
                    <div className="message">
                        <div style={{paddingTop: 10}}>Are you sure you want to delete your account?</div>
                        <div style={{paddingBottom: 40}}>This action cannot be undone.</div>
                        <button id="continue_delete" style={{float: 'left'}}>Yes, delete my account</button>
                        <button id="close_delete_message" style={{float: 'right'}}>No, don't delete my account</button>
                    </div>
                    
                </div>
                <div id="delete_overlay"></div>
            </div>
        </div>
        </div>
    )
}

export default AccountProfile;