import React from 'react';
import profpic from './images/profpic.jpg';
import './css_files/Profilebox.css'; 
const Profilebox = (title) =>
{
    
    return(
        <div className = 'ProfileFrame'>
            <div className='Pictureframe' >
                <img src = {profpic} className = "pic"></img>
            </div>
            <div className='Detailbox'>
                <h2 className='firstNameCampusLabel'>{title.title}</h2> <br/>
                <h2 className='campusLabel'>Campus</h2> <h3 className='ratingLabel'>rating</h3> <br/>
                <h2 className = "subjectLabel">Subject</h2> <h2 className = "priceLabel">price</h2> <br/>
                <button className = "bookButton">Book</button> <button className = "reviewButton">Reviews</button>
            </div>
        </div>
    )
}



export default Profilebox;