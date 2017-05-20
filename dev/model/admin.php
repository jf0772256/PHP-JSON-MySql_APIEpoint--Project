<?php
  // admin authentication model
  // used to process logins as well as enforcing protected pages.
  // written for php midterm project

  global $loggedIn;

  function processUserLogin($uname,$password){
    //receivs a username and password and does logic to display admin menu:
    global $loggedIn;
    $intPassword = "sesame"; //hardcoded password
    $intUsername = "admin"; //hardcoded username
    if ($uname === $intUsername) {

      if ($password === $intPassword) {
        session_set_cookie_params(600,'/');
        @ session_start();
        $_SESSION['isValidUser'] = true;
        return true;
      }else{
        return false;
      }

    }else{
      return false;
    }
  }

  function checkUserStatus(){
    //returns if the user is currently logged in to teh admin system.
    return $_SESSION['isValidUser'];
  }

?>
