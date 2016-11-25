<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "setConfig.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

//  function to intialize form fields in the loop
function show_profile($changedEmail="",$changedEmail2="",$changedPass="",$first="", $last="",
                      $addr1= "",$addr2= "",$addr3= "",
                      $city= "", $state="",$zip="", $country="",
                      $phone="", $citystphone="", $group="",$regdate="",$modate="")
{
}

// First check if session was created and currently exists.
if (isset($_SESSION['Email']) || isset($_SESSION['Password'])) 
{ 
	// Load session user and password information to select specific user
	$sessionEmail = $_SESSION['Email']; 
	$sessionPass = $_SESSION['Password'];
	$sessionIP= $_SESSION['IP']; 
	$sessionName = $_SESSION['LogonName'];
	$sessionRegdate = $_SESSION['regdate'];

	// This MyProfile php script is used to update all contact information for the user that is logged in to this session.
	// Detail select query by email and password and display data on myprofile.html page with the intent to update profile.
	if (isset($_POST['myProfile']))
	{
		include $secured_php.'myprofile_session_found_update.php';
	}
	else
	{
		include $secured_php.'myprofile_session_found_insert.php';
	}
}
else 
{ 
	//if the session does not exist, you are taken to the logon screen 
	//header("Location: Logon.php"); 
	// echo ('Session does not exist: Email:'.$_SESSION['Email'].' PASS: '.$_SESSION['Password'].'\n');
	// echo ('Session does not exist: Email:'.$_POST['myProfile'].'\n');
		$MsgTitle = "MyProfile Update Page";
		$redirect = "Logon.php";
		$MsgType1 = "MyProfile.php Warning:";
		$MsgType = "MyProfile.php Warning:";
		$Msg1 = "User sesssion expired";
		$Msg2= "Please re-establish credentials with Logon.";
		$button = "Logon";
		include $html_files.'logonMsg.html';
		exit();
} 
?> 