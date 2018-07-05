<?php
/*
Every time a new User is Logged In a new Session is created and destroyed at Logging Out
*/
 session_start();						//Creates a new Session
 session_unset();						//Free all session variables
 session_destroy();						//Destroys all data registered to a session
 header("location:index.php");			//sends a raw HTTP header index.php to client
?>