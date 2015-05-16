<?php
//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

function show_profile_admin($changedEmail="",$changedEmail2="",$admin="",$first="", $last="",
                      $addr1= "",$addr2= "",$addr3= "",
                      $city= "", $state="",$zip="", $country="",
                      $phone="", $citystphone="", $group="",$modate="")
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
	
 // This Profile Update php script is used to update all contact information for the user by the admin session.
 // Detail select query by email_key from the Emails table is joined to the profile table with the intent to update profile.
  if (isset($_POST['Profile']))
  { 
 		include $secured_php.'profile_admin_update.php';
  }
  else
  {
	  //if the getMember form was not posted with the Emails table email_key we return admin to the selectMember.html with a message 
    if (!isset ($_POST['emailRadio']))
  	{  
	  	$MsgTitle = "Search Member Page (Admin)";
  		$redirect = "SearchMember.php";
  		$MsgType1 = "ProfileAdmin.php Warning:";
  		$MsgType = "ProfileAdmin.php Warning:";
  		$Msg1 = "To edit a member profile from the Select Member page;";
  		$Msg2= "Please select the radio button next to the member's name on the search result list. ";
  		$button = "Search";
  		// Select distinct groups to fill the drop down list on the send email form
  		include $mailer_files.'grp-name-qry-01.php';
  		include $html_files.'searchMember.html';
  		exit();
    }
    else
    { 
      foreach ($_POST['emailRadio'] as $value)
      {
         $emailKey = $value;
	    }
	    //$email = $_POST['email'];
	    //$first = $_POST['first'];
	    //$last = $_POST['last'];
	    //$group = $_POST['group'];
  		include $secured_php.'profile_admin_insert.php';
  	}
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