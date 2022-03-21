import React, { useState, useRef, useCallback } from 'react';
import './css_files/homepage.css'
import DropdownMenu from './DropdownMenu';
import Profilebox from './Profilebox';

import useBookSearch from './useBookSearch';
const Homepage = () =>{
    

    const [query, setQuery] = useState('hello world')
    const [pageNumber, setPageNumber] = useState(1)

    const {
        books,
        hasMore,
        loading,
        error
    } = useBookSearch(query, pageNumber)
    const observer = useRef()
    const lastBookElementRef = useCallback(node => {
        if (loading) return
        if (observer.current) observer.current.disconnect()
        observer.current = new IntersectionObserver(entries => {
            if (entries[0].isInteresecting && hasMore){
                setPageNumber(prevPageNumber => prevPageNumber + 1)
                console.log('Visible')
            }
        })
        if(node) observer.current.observer(node)
        console.log(node)
    }, [loading, hasMore])

    function handleSearch(e) {
        setQuery(e.target.value)
        setPageNumber(1)
    }
    useBookSearch(query, pageNumber)

    
    //console.log(books)
    return (
    <div>

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
            <li class = "sort__item"><input type = "text" value = {query} onChange = {handleSearch}  /></li>
            <DropdownMenu/> <br/>
        </ul>
        
    </div>
    
    <div className = "flexbox-container">
    
    {books.map((book, index) => {
        if(books.length === index + 1){
            return(
                <Profilebox ref = {lastBookElementRef} key = {book} title = {book}/>
            )
        }
        return(
            <Profilebox key = {book} title = {book}/>
        )
    })}
    <div>{loading && 'loading...'}</div>
    <div>{error && 'error'}</div>
    </div>
    
    </div>
    )
}



export default Homepage;