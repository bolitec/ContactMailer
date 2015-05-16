<?php 
//  This code checks our sessions to make sure the user is logged in, the same way the logon page did. 
//  If they are logged in, they are shown the members area. 
//  If they are not logged in they are redirected to the logon page. 
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

// Always check for existing DB session at the top of the script after loading non pulic path and configuration information.
if(isset($_SESSION['Email'])) 
{ 
	include $secured_php.'member_session_found.php';
} 
else 
{ 
	//if the DB session does not exist or expired, they are taken to the logon screen. 
	// echo ('Session does not exist: '.$_SESSION['PlayaLosEmail'].' PASS: '.$_SESSION['PlayaLosPassword'].'');
		$MsgTitle = "MEMBER";
		$redirect = "Logon.php";
		$MsgType = "Member.php Warning:";
		$Msg1 = "Your session timed out due to inactivity or un-authorized access";
		$Msg2= "Please re-establish credentials with Logon.";
		$button = "Logon";
		include $html_files.'logonMsg.html';
		unset($_POST['logon']);
		exit();
} 
?> 
