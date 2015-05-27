<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
<<<<<<< HEAD
include "Config.php";
=======
include "Config_severus.php";
>>>>>>> branch 'master2' of https://github.com/bolitech/ContactMailer.git

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

function show_email_admin($last="",$first= "",$email= "",$group= "")
{
}

// First check if Admin session was created and currently exists.
if (isset($_SESSION['Admin'])) 
{ 
	// Load session user and password information to in case we need to identify admin making changes
	$sessionEmail = $_SESSION['Email']; 
	$sessionPass = $_SESSION['Password'];
	$sessionIP= $_SESSION['IP']; 
	$sessionName = $_SESSION['LogonName'];
	$sessionRegdate = $_SESSION['regdate'];
	
 // This Email insert php script is used to add a new email record by the admin session.
 // Emails row is inserted with post variables from emailAdmin.html.
  if (isset($_POST['emailForm']))
  { 
 		include $secured_php.'email_admin_insert.php';
  }
  else
  {
	  //if the emailForm form was not posted with the Emails variables we return admin to the emailAdmin.html with a message 
  	$MsgTitle = "Emails Insert Page (Admin)";
 		$redirect = "EmailAdmin.php";
 		$MsgType1 = "EmailAdmin.php Warning:";
 		$MsgType = "EmailAdmin.php Warning:";
 		$Msg1 = "To add/insert a new Email address from the Emails Insert page;";
 		$Msg2= "Please enter the information in required (*) fields and press Insert button. ";
 		$button = "Insert";
 		// Select distinct groups to fill the drop down list on the send email form
 		include $mailer_files.'grp-name-qry-01.php';
 		include $html_files.'emailAdmin.html';
 		exit();
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
		$Msg1 = "User sesssion expired, or insufficient security to access script";
		$Msg2= "Please re-establish credentials with Logon.";
		$button = "Logon";
		include $html_files.'logonMsg.html';
		exit();
} 
?> 
