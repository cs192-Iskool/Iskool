import React from 'react';
import './css_files/AccountProfile.css';
import profpic from './images/profpic.jpg';

const EditProfile = () =>{
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
                            <td>
                            <span>
                                    <input type="text" placeholder="First Name" required/>
                                </span>
                                <span>
                                    <input type="text" placeholder="Last Name" required/>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Birthday:</td>
                            <td><input type="date" id="birthday" required/></td>
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
                            <td><input type="text" placeholder="Course" required/></td>
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
                <div style={{height: 50}}></div>
                <div className="all_info">
                    <h1>Account Details</h1>
                    <table>
                        <tr>
                            <td>Email Address:</td>
                            <td>
                            <input type="email" placeholder="Email Address" required/>
                            </td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" placeholder="Password" required/></td>
                        </tr>
                        <tr>
                            <td>Confirm Password:</td>
                            <td>
                                <input type="password" placeholder="Confirm Password" required/>
                            </td>
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

export default EditProfile;