<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "setConfig.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

function show_profile($emailKey="",$first="", $last="", $email= "",$group=""){
}

// First check if session was created and currently exists and that it is an 'Admin' session.
if (isset($_SESSION['Email']) || isset($_SESSION['Admin'])) { 
	// Load session user and password information to select specific user
	$sessionEmail = $_SESSION['Email']; 
	$sessionPass = $_SESSION['Password'];
	$sessionIP= $_SESSION['IP']; 
	$sessionName = $_SESSION['LogonName'];
	$sessionRegdate = $_SESSION['regdate'];

	// This php script will now show search fields to find member or if $_POST is received will call the secured script
	// to display member details for selection.
	if (isset($_POST['searchForm'])){
		
		include $secured_php.'select_member.php';

	} else {

		// Select distinct groups to fill the drop down list on the send email form
		include $mailer_files.'grp-name-qry-01.php';
	  	
	  	//if the $_POST was not submitted then we will display initial form with message requesting selection criteria. 
		$MsgTitle = "Search Member Page (Admin)";
		$redirect = "SearchMember.php";
		$MsgType1 = "SearchMember.php Msg";
		$MsgType = "SearchMember.php Msg";
		$Msg1 = "Please enter selection/search criteria";
		$Msg2= "and click on search button below.";
		$button = "Search";
		include $html_files.'searchMember.html';
		exit();
	}
} else {
	//if the session does not exist or is not 'Admin', you are taken to the logon screen 
	$MsgTitle = "Select Member Page";
	$redirect = "Logon.php";
	$MsgType1 = "SelectMember.php Warning";
	$MsgType = "SelectMember.php Warning";
	$Msg1 = "User sesssion expired or not an 'Admin' user session";
	$Msg2= "Please re-establish credentials with Logon.";
	$button = "Logon";
	include $html_files.'logonMsg.html';
	exit();
} 
?> 