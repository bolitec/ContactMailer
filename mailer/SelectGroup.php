<?php 
//  This script first checks to see if the login information is contained in a session on the web server. 
//  If the email session is identified as an admin session the scripts execute. 
//  If there is no session, it allows them to login to obtain session credentials. 

//  Local config allows for dynamic definition of file paths and single point for private paths
include "../php/Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

// Check for an active session using database session handler
if(isset($_SESSION['Email']) and isset($_SESSION['Admin']))
{
	// load session email in to sender name variable
	$sender_name = $_SESSION['LogonName'];
	$sender_email = $_SESSION['Email'];
	$email_msg = $_POST['Comments'];
	
	if (isset($_POST['emailForm'])){
		// this is option 'PDF Only' from E-Mailer form name is (check_submit)		
		if ($_POST['attach'] == "PDF"){
			include 'emailSend1.php';
			} 
		if ($_POST['attach'] == "Both"){
			include 'emailSend2.php';
			} 
   		if ($_POST['attach'] == "Msg" && !empty($email_msg)){
			include 'emailSend.php';
	  		}
   		if ($_POST['attach'] == "HTML"){
			include 'emailSend3.php';
			}
		else{
			// At least one File Send option must be selected
			include $mailer_files.'grp-name-qry-01.php';
			// Generate the html form to gather email information
			$MsgTitle = "E-Mailer (Admin) Page";
			$MsgType1 = "SelectGroup.php";
			$MsgType2 = " ";
			$Msg1 = "At lease one File Send Option must be selected.";
			$Msg2 = "And a 'Message Only' selection requires content in the 'Email Message' text area.";
			include $mailer_files.'SelectGroupForm.html';
		}
	}
	else
	{
		// Select distinct groups to fill the drop down list on the send email form
		include $mailer_files.'grp-name-qry-01.php';
		// Generate the html form to gather email information
		$MsgTitle = "E-Mailer (Admin) Page";
		$MsgType1 = "SelectGroup.php";
		$MsgType2 = " ";
		$Msg1 = "Enter an email subject; select a group; and enter your message text.";
		$Msg2 = "Selecting File Send options will configure multipart emails.";
		include $mailer_files.'SelectGroupForm.html';
  	}
}
else 
{	
// A login session was not found and the caller is routed to login to the JCLM database; 
	$MsgTitle = "Emailer (Admin) - Select Group";
	$redirect = $url_secure_php."Logon.php";
	$MsgType = "SelectGroup.php Msg";
  	$Msg1 = "Your session timed out due to inactivity or un-authorized access.";
	$Msg2= "Please re-establish credentials with Logon.";
	$button = "Logon";
	include $html_files.'logonMsg.html';
	unset($_POST['logon']);
	exit();
} 
?> 