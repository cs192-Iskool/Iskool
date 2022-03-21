import React from 'react';
//import logo from './logo.svg';
import Navbar from './navbar';
import Homepage from './Homepage';
import Register from './Register';
import AccountProfile from './AccountProfile';
//import EditProfile from './EditProfile';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import './App.css';

function App() {
  return (
    <Router>
      <Switch>
      <Route exact path = "/Register" component = {Register}/>
      <div className="App">
        <Navbar/>
        <div className = "content">
      
        <Route exact path = "/Home">
          <Homepage/>
        </Route>
        <Route exact path = "/AccountProfile">
          <AccountProfile/>
        </Route>

        </div>
      </div>
      </Switch>
     
      
     
    </Router>
    
  );
}

export default App;
