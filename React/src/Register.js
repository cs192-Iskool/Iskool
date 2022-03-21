import React, { useState,Component } from 'react';
import Select from 'react-select';
import './css_files/Register.css'

const AccountProfile = () => {
    const schools = [
      { value: 'upd', label: 'UP Diliman'},
      { value: 'uplb', label: 'UP Los Baños'},
      { value: 'upm', label: 'UP Manila'},
      { value: 'upv', label: 'UP Visayas'},
      { value: 'upou', label: 'UP Open University'},
      { value: 'upmin', label: 'UP Mindanao'},
      { value: 'upb', label: 'UP Baguio'},
      { value: 'upc', label: 'UP Cebu'}
    ]
    const [campus,setCampus] = useState('Campus');
    const [year, setYear] = useState('Year Standing');
    const [isDisabledYear,setDisableYear] = useState(true);
    const year_standing = [
      {value: '1', label: '1st Year'},
      {value: '2', label: '2nd Year'},
      {value: '3', label: '3rd Year'},
      {value: '4', label: '4th Year'},
      {value: '5', label: '5th Year and Above'},
    ]

    const bodyStyle = {
      background: 'linear-gradient(to right, #430089, #82ffa1)'
    }
    const background = true;
    return(
    
    <div className='maindiv'>
      
      <h1 className = "regh1">ISKOOL</h1>

      <form > 
        <div className="register">
          <ul className = "register_form">
            <li>
                  <input type="text" id="fname" placeholder="First Name" required/>
                  <input type="text" id="lname" placeholder="Last Name" required/> <br/>
            </li>

            <li>
              <input type="email" id="email" placeholder="Email Address" required/> <br/>
            </li>

            <li>
              <select value = {year} onChange = {e=>setYear(e.target.value)}>
                <option value="" disabled ={isDisabledYear? true: null} selected hidden>Campus</option>
                <option value="upd">UP Diliman</option>
                <option value="uplb">UP Los Baños</option>
                <option value="upm">UP Manila</option>
                <option value="upv">UP Visayas</option>
                <option value="upou">UP Open University</option>
                <option value="upmin">UP Mindanao</option>
                <option value="upb">UP Baguio</option>
                <option value="upc">UP Cebu</option>
              </select>
            </li>

            <li>
              <input type="text" id="course" placeholder="Course" required/> <br/>

            </li>

            <li>
              <select value={campus} id="year" required>
              <option value="" disabled selected hidden>Year Standing</option>
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
              <option value="5">5th Year and Above</option>
              </select> 
            </li>

            <li>
              <label for="birthday" class="label">Birthday:</label>
              <input type="date" id="birthday" required/> 
            </li>

            <li>
              <input type="password" id="password" placeholder="Password" required/>
            </li>

            <li>
              <input type="password" id="password" placeholder="Confirm Password" required/> <br/> <br/> <br/> <br/>  
            </li>

            <li>
            <button type="submit" className='register_button'>Sign Up</button> <br/> <br/>

            </li>
          </ul>
          
         
          
        

          
          
            

          
          

          
          

          
          <h5> Already have an account? <a href="Login.html"> Sign in</a>. </h5>
        </div>
      </form>
      
    
    </div>
    
    );
}

export default AccountProfile