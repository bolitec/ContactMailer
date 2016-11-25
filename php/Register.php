<?php 
// Basically what this does is check to see if the form has been submitted. 
// If it has been submitted it checks to make sure that the data is all OK (passwords match, email isn't in use) as documented in the code. 
// If everything is OK it adds the user to the database, if not it returns the appropriate error. 
// If the form has not been submitted, they are shown the registration form, which collects the email and password. 

//  Local config allows for dynamic definition of file paths and single point for private paths
include "setConfig.php";

// Sets path for files and start session.
require PRIVATE_SESSION."sessionConfig.php";
session_start();

// Connects to member table of contact_mailer Database 
//  Include the db connection script from non public_html location
include PRIVATE_DB."dbConfig.php";

//This code runs if the form has been submitted
if (isset($_POST['register'])) 
{ 
	include $secured_php.'register_user_session.php';
} 
else 
{
	if(isset($_SESSION['RegEmail'])){
  		$reg_email = $_SESSION['RegEmail'];
  	}
	include $html_files.'register.html';
}
?> 

