<?php 
//  This script first checks to see if the logon information is contained in a session on the web server. 
//  If it is, it tries to log them in. If this is successful they are redirected to the members area. 
//  If there is no session, it allows them to logon. 
//  If logon form has not been posted, it shows them the logon form. 

//  Local config allows for dynamic definition of file paths and single point for private paths
include "Config.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";


// Check for an active session using database session handler
if(isset($_SESSION['Email']))
{
	include $secured_php.'logon_session_found.php';
}

// When no session is found check to see if the logon form is posted
if (isset($_POST['logon'])) 
{
	include $secured_php.'logon_session_notfound.php';
} 
else 
{ 
// Initiate, start and store a new session by including dbConfig.php at the top of this script.
// Included in the handler override is a session_start() and concludes below with a commit of the DB session. 
// Reference details related to handler functions in SessionHandler.php'; 

	if(isset($_SESSION['RegEmail'])){
  		$reg_email = $_SESSION['RegEmail'];
  	}
	include $html_files.'logon.html';
	exit();
}

?>