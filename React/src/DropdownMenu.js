import { useEffect, useRef, useState } from "react";
import './css_files/dropdownMenu.css';
const DropdownMenu = () =>{
    const dropdownRef = useRef(null);
    const [isActive, setIsActive] = useState(false);

    const onClick = () => setIsActive(!isActive);

    useEffect(() =>{
        const pageClickEvent = (e)=>{
            console.log(e);
        };

        if (isActive) {
            window.addEventListener('click', pageClickEvent);
        }

        return () => {
            window.removeEventListener('click', pageClickEvent);
        }
    }, [isActive]);
    return(
        <div className = "menu-container">
            <button onClick ={onClick} className = "menu-trigger">
                <span>Sort By</span>
            </button>
            <nav ref = {dropdownRef} className = {`menu ${isActive? 'active' : 'inactive'}`}>
                <ul>
                    <li><a href = "/messages"></a>Newest</li>
                    <li><a href = "/trips"></a>Lowest Price</li>
                    <li><a href = "/saved"></a>Highest Rating</li>
                </ul>
            </nav>
        </div>
    );

}

export default DropdownMenu;