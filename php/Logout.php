<?php 

//  All our logout page does is destroy the session, and then direct them back to the logon page. 
//  We destroy the session by calling session config file, intializing and destroying current session. 
//  We also clear the $_SESSION array.
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();
session_destroy();
unset($_SESSION);

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

mysqli_close($link);


$MsgTitle = "Logout Page";
$redirect = "Logon.php";
$MsgType1 = "Logout.php";
$MsgType2 = "Message LO-001";
$Msg1 = "Your session was closed successfully.";
$Msg2= "Click the Logon button below to re-establish your session";
$button = "Logon";
include $html_files.'logonMsg.html';
unset($_POST['logon']);
exit();
?> 
